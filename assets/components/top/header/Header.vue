<template>
    <div class="container-fluid c-header">
        <a class="navbar-brand"></a>
        <div>
            <h5 id="versionPopover" style="" >
                {{version}}
            </h5>
            <b-popover target="versionPopover" triggers="hover" placement="left">
                <template #title>Roadmap</template>
                <div v-for="milestone in roadmap" :key="milestone.version">
                    <p>
                        <span class="current" v-if="milestone.version == version">{{milestone.version}}</span>
                        <span v-else>{{milestone.version}}</span>
                        <ul>
                            <li v-for="step in milestone.features" :key="step.feature">
                                <span :class="step.state">{{step.feature}}</span>
                            </li>
                        </ul>
                    </p>
                </div>
            </b-popover>
        </div>
    </div>
</template>

<script>
import { BPopover } from 'bootstrap-vue';

export default {
    components: {
        BPopover
    },
    data(){
        return {
            version: "0.1.5",
            roadmap: [
                {
                    version: "0.1.5",
                    features: [
                        { feature: "Ulubione listy", state: "done"},
                        { feature: "Ważne prezenty", state: "done" },
                        { feature: "Priorytetowe cechy", state: "done" },
                        { feature: "Stronnicowanie", state: "done" },
                        { feature: "Oznaczanie życzeń jako wypełnione", state: "done" }
                    ]
                },
                {
                    version: "0.2",
                    features: [
                        { feature: "Suskrybowanie bez konta", state: "to-do" },
                        { feature: "Wypełnianie życzeń bez konta", state: "to-do" },
                        { feature: "Zapraszanie osób do aplikacji przez mail", state: "to-do" },
                        { feature: "Resposnywny frontend w Vue", state: "in-progress" },
                    ]
                },
                {
                    version: "0.3",
                    features: [
                        { feature: "Proponowanie prezentów", state: "to-do" },
                        { feature: "Profil użytkownika", state: "to-do" },
                        { feature: "Sortowanie", state: "to-do" },
                    ]
                },
                {
                    version: "0.4",
                    features: [
                        { feature: "Tworzenie życzeń bezpośrednio z linków", state: "to-do" },
                        { feature: "Dzielenie życzeń z wieloma linkami na pojedyncze", state: "to-do" }
                    ]
                },
                {
                    version: "1.0",
                    features: [
                        { feature: "Czat", state: "to-do" },
                        { feature: "HTTPS", state: "to-do" },
                        { feature: "Powiadomienia", state: "to-do" },
                        { feature: "Moduł loterii prezentowej", state: "to-do" },
                        { feature: "Tłumaczenia", state: "to-do" },
                        { feature: "Plugin do przeglądarki", state: "to-do" }
                    ]
                }
            ]
        }
    }
}
</script>

<style scoped>
    #versionPopover{
        cursor:pointer; 
        color: white;
    }
    .current{
        font-weight: 700;
        color: red;
    }
    ul{
        font-size: 10px;
    }
    .done{
        color: darkgreen;
    }
    .to-do{
        color: darkgrey;
    }
    .in-progress{
        color: black;
    }
</style>