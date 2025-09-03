<?php
    $router->get("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->getFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->putFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->getFornitoriManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->postFornitore();
    },"Autenticazione::autenticazioneApiManager");
?>