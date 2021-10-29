<?php

namespace App\Security\Authenticator;

use App\Entity\User\UserToken;
use App\Repository\User\UserTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class UserTokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private UserTokenRepository $userTokenRepository
    )
    {}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-USER-TOKEN');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $token = $request->headers->get('X-USER-TOKEN');

        /** @var UserToken $userToken */
        if ($userToken = $this->userTokenRepository->findOneByToken($token))
            return new SelfValidatingPassport(
                new UserBadge(
                    $userToken->getUser()->getEmail()
                )
            );

        throw new CustomUserMessageAuthenticationException('Wrong user token provided');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}