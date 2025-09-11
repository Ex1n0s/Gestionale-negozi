<?php
    $router->get("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->getOrdine($numeroOrdine);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->getOrdiniManager();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->postOrdine();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerOrdiniApiController")->putOrdine($numeroOrdine);
    },["Autenticazione::autenticazione","api","manager"]);
?>