<?php
    
    $uriRichiesta = $_SERVER['REQUEST_URI'];
    
    // Se la richiesta e' di un file dentro la cartella public il fine viene servito direttamente
    // Tutte le altre richieste vengono gestite da index.php
    if(strpos($uriRichiesta,"/public/") === 0){//Controlla che l'uri della richiesta inizi con /public/
        if(file_exists(__DIR__ . $uriRichiesta)){//se il file esiste viene servito
            return false;
        }
    }

    spl_autoload_register(function($nomeFile){
        $percorsi = [
            "servizi",
            "models",
            "controllers/api",
            "controllers/pagine",
        ];
        foreach ($percorsi as $percorso) {
            $percorso ="{$percorso}/{$nomeFile}.php";
            if(file_exists($percorso)){
                require($percorso);
                return;
            }
        }
    });

    session_start();
    
    require("database.php");
    require("Router.php");
    $router = new Router();
    ControllerInit::setConnessione($connessione);
    Autenticazione::setConnessione($connessione);
    
    //Pagine
    require("routes/pagine.php");
    
    //Api utente e login
    $router->post("/api/login",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("LoginApiController")->login();
    });

    $router->put("/api/utente/password",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("LoginApiController")->cambioPassword();
    },["Autenticazione::autenticazione","api","utente"]);

    $router->post("/api/utente/logout",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("LoginApiController")->logout();
    },["Autenticazione::autenticazione","api","utente"]);

    //Api clienti
    require("routes/api/clienti.php");

    //Api prodotti
    require("routes/api/prodotti.php");

    //Api negozi
    require("routes/api/negozi.php");
    
    //Api prodotti negozio
    require("routes/api/prodottiNegozio.php");

    //Api ordini
    require("routes/api/ordini.php");
    
    //Api fornitori
    require("routes/api/fornitori.php");

    //Api prodotti fornitore
    require("routes/api/prodottiFornitore.php");

    //Api carrello
    require("routes/api/carrello.php");
    
    //Api fatture
    $router->post("/api/cliente/acquista",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("ClienteFattureApiController")->acquista();
    },["Autenticazione::autenticazione","api","cliente"]);

    //Pagina 404, va messa come ultima route
    $router->get("/404",function(){
        if($_SESSION["ruolo"] === "manager"){
            require("views/manager/header.php");
        } else {
            require("views/cliente/headerCliente.php");
        }
        require("views/404.php");
    },["Autenticazione::autenticazione","pagine","utente"]);

    $router->eseguiFunzione();
?>
