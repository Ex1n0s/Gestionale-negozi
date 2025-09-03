<?php
    $router->get("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->getOrdine($numeroOrdine);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->getOrdiniManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->postOrdine();
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->putOrdine($numeroOrdine);
    },"Autenticazione::autenticazioneApiManager");
?>