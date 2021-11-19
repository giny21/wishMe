<?php

namespace App\Controller\Lottery;

use App\Controller\Controller;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LotteryController extends Controller
{
    public function __construct()
    {   
    }

    #[Route('/lottery/create', name: 'lottery_create')]
    public function create(Request $request): Response
    {
        if($request->getMethod() === "POST"){
            $lotteryArray = $request->toArray();

            $lotterySize = sizeof($lotteryArray);
            $lotteryKey = rand(1, 100);

            for($i = 0; $i < $lotterySize; $i++){
                $giver = &$lotteryArray[$i];
                $taker = &$lotteryArray[($i + $lotteryKey) % $lotterySize];
                if(in_array($taker["id"], $giver["excluded"]) || (key_exists("taken", $taker) && $taker["taken"])){
                    $lotteryKey++;
                    $i--;
                }
                else{
                    $taker["taken"] = true;
                    $giver["taker"] = $taker["id"];
                }
            }

            return new JsonResponse($lotteryArray);
        }
            
        return $this->render('lottery/parts/create/create-form.html.twig', [
            'controller_name' => 'LotteryController'
        ]);
    }

    #[Route('/lottery/send', name: 'lottery_send')]
    public function send(Request $request): Response
    {
        $sendArray = $request->toArray();
        $giverName = $sendArray["giverName"];
        $giverEmail = $sendArray["giverEmail"];
        $takerName = $sendArray["takerName"];

        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername('wozniakroger21@gmail.com')
            ->setPassword('regor3600');

        
        $mailer = new Swift_Mailer($transport);
        
        $message = (new Swift_Message('Loteria prezentowa'))
          ->setFrom(['wish@me.com' => "Cześć {$giverName}! Ktoś czeka na prezent od Ciebie!"])
          ->setTo([$giverEmail])
          ->setBody("<b>{$takerName}</b> będzie czekał(a) na prezent od Ciebie w te świeta, nie zawiedź go(jej)!", 'text/html')
          ;
        
        if($mailer->send($message));
            return new Response();
        
        return new Response(status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}