<?php
    $router->get("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->getFornitore($ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->putFornitore($ivaFornitore);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->getFornitoriManager();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerFornitoriApiController")->postFornitore();
    },["Autenticazione::autenticazione","api","manager"]);
?>