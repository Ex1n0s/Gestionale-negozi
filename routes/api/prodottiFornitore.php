<?php
    $router->get("/api/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->getProdottiFornitore($ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->getProdottoFornitore($codiceProdotto,$ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->postProdottoFornitore($ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->putProdottoFornitore($ivaFornitore,$codiceProdotto);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->delete("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerProdottiFornitoreApiController")->deleteProdottoFornitore($codiceProdotto,$ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);
?>