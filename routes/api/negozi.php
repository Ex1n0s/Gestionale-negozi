<?php
    $router->get("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->getNegozio($codice);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->putNegozio($codice);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->getNegoziManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->postNegozio();
    },"Autenticazione::autenticazioneApiManager");

?>