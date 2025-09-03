<?php
    $router->delete("/api/cliente/carrello/{numeroProdotto}",function($numeroProdotto){
        header("Content-Type:application/json");
        new ClienteCarrelloApiController()->deleteElementoCarrello($numeroProdotto);
    },"Autenticazione::autenticazioneApiCliente");

    $router->post("/api/cliente/carrello",function(){
        header("Content-Type:application/json");
        new ClienteCarrelloApiController()->postElementoCarrello();
    },"Autenticazione::autenticazioneApiCliente");

    $router->put("/api/cliente/carrello/{numeroProdotto}",function($numeroProdotto){
        header("Content-Type:application/json");
        new ClienteCarrelloApiController()->putElementoCarrello($numeroProdotto);
    },"Autenticazione::autenticazioneApiCliente");
?>