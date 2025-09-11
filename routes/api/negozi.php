<?php
    $router->get("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->getNegozio($codice);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->put("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->putNegozio($codice);
    },["Autenticazione::autenticazione","api","manager"]);

    $router->get("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->getNegoziManager();
    },["Autenticazione::autenticazione","api","manager"]);

    $router->post("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ManagerNegoziApiController")->postNegozio();
    },["Autenticazione::autenticazione","api","manager"]);

?>