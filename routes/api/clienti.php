<?php
    $router->get("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->getCliente($codiceFiscale);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->getClienti();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->delete("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->deleteUtente($codiceFiscale);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->postCliente();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerClientiApiController")->putCliente($codiceFiscale);
    },["Autenticazione::autenticazione","api","manager"]);
?>