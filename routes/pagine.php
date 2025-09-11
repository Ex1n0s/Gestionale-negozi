<?php
    $router->get("/login",function(){
        require("views/login.php");
    },["Autenticazione::checkLogin"]);

    $router->get("/manager/clienti",function(){
        ControllerInit::getIstanza("ManagerClientiController")->show();
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/prodotti",function(){
        ControllerInit::getIstanza("ManagerProdottiController")->show();
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/negozi",function(){
        ControllerInit::getIstanza("ManagerNegoziController")->show();
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/fornitori",function(){
        ControllerInit::getIstanza("ManagerFornitoriController")->show();
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/ordini",function(){
        ControllerInit::getIstanza("ManagerOrdiniController")->show();
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/fornitore/{ivaFornitore}",function($ivaFornitore){
        ControllerInit::getIstanza("ManagerGestioneFornitoreController")->show($ivaFornitore);
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/manager/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getIstanza("ManagerGestioneNegozioController")->show($codiceNegozio);
    },["Autenticazione::autenticazione","pagine","manager"]);

    $router->get("/utente/profilo",function(){
        ControllerInit::getIstanza("ProfiloController")->show();
    },["Autenticazione::autenticazione","pagine","utente"]);

    $router->get("/cliente/negozi",function(){
        ControllerInit::getIstanza("ClienteNegoziController")->show();
    },["Autenticazione::autenticazione","pagine","cliente"]);
    
    $router->get("/cliente/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getIstanza("ClienteProdottiNegozioController")->show($codiceNegozio);
    },["Autenticazione::autenticazione","pagine","cliente"]);

    $router->get("/cliente/carrello",function(){
        ControllerInit::getIstanza("ClienteCarrelloController")->show();
    },["Autenticazione::autenticazione","pagine","cliente"]);

    $router->get("/cliente/fatture",function(){
        ControllerInit::getIstanza("ClienteFattureController")->show();
    },["Autenticazione::autenticazione","pagine","cliente"]);

    $router->get("/cliente/fatture/{codiceFattura}",function($codiceFattura){
        ControllerInit::getIstanza("ClienteRigheFatturaController")->show($codiceFattura);
    },["Autenticazione::autenticazione","pagine","cliente"]);
?>