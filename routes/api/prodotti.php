<?php
    $router->get("/api/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiApiController")->getProdotto($codice);
    });

    $router->get("/api/prodotti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiApiController")->getProdotti();
    });

    $router->delete("/api/manager/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiApiController")->deleteProdotto($codice);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/prodotti",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiApiController")->postProdotto();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiApiController")->putProdotto($codice);
    },["Autenticazione::autenticazione","api","manager"]);
?>