<?php
    $router->get("/api/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->getProdottiNegozio($codiceNegozio);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->getProdottoNegozio($codiceProdotto,$codiceNegozio);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->postProdottoNegozio($codiceNegozio);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->putProdottoNegozio($codiceNegozio,$codiceProdotto);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->delete("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->deleteProdottoNegozio($codiceProdotto,$codiceNegozio);
    },["Autenticazione::autenticazione","api","manager"]);
?>