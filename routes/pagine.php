<?php
    $router->get("/login",function(){
        require("views/login.php");
    },"Autenticazione::checkLogin");

    $router->get("/manager/clienti",function(){
        ControllerInit::getIstanza("ManagerClientiController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/prodotti",function(){
        ControllerInit::getIstanza("ManagerProdottiController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/negozi",function(){
        ControllerInit::getIstanza("ManagerNegoziController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/fornitori",function(){
        ControllerInit::getIstanza("ManagerFornitoriController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/ordini",function(){
        ControllerInit::getIstanza("ManagerOrdiniController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/fornitore/{ivaFornitore}",function($ivaFornitore){
        ControllerInit::getIstanza("ManagerGestioneFornitoreController")->show($ivaFornitore);
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getIstanza("ManagerGestioneNegozioController")->show($codiceNegozio);
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/utente/profilo",function(){
        ControllerInit::getIstanza("ProfiloController")->show();
    },"Autenticazione::autenticazionePagineUtente");

    $router->get("/cliente/negozi",function(){
        ControllerInit::getIstanza("ClienteNegoziController")->show();
    },"Autenticazione::autenticazionePagineCliente");
    
    $router->get("/cliente/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getIstanza("ClienteProdottiNegozioController")->show($codiceNegozio);
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/carrello",function(){
        ControllerInit::getIstanza("ClienteCarrelloController")->show();
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/fatture",function(){
        ControllerInit::getIstanza("ClienteFattureController")->show();
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/fatture/{codiceFattura}",function($codiceFattura){
        ControllerInit::getIstanza("ClienteRigheFatturaController")->show($codiceFattura);
    },"Autenticazione::autenticazionePagineCliente");
?>