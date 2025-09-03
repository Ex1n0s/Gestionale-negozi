<?php
    $router->get("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->getCliente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->getClienti();
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->deleteUtente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->postCliente();
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->putCliente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");
?>