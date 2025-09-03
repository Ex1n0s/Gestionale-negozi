<?php
    $router->get("/api/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->getProdottiNegozio($codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->getProdottoNegozio($codiceProdotto,$codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->postProdottoNegozio($codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->putProdottoNegozio($codiceNegozio,$codiceProdotto);
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiNegozioApiController")->deleteProdottoNegozio($codiceProdotto,$codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");
?>