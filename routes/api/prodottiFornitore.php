<?php
    $router->get("/api/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->getProdottiFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->getProdottoFornitore($codiceProdotto,$ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->postProdottoFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->putProdottoFornitore($ivaFornitore,$codiceProdotto);
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->deleteProdottoFornitore($codiceProdotto,$ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");
?>