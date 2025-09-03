<?php
    spl_autoload_register(function($nomeFile){
        $percorsi = [
            "servizi",
            "models",
            "controllers/api",
            "controllers/pagine",
        ];
        foreach ($percorsi as $percorso) {
            $percorso = "{$percorso}/{$nomeFile}.php";
            if(file_exists($percorso)){
                require($percorso);
                return;
            }
        }
    });
    
    session_start();

    /*
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = strtok($uri, "?"); // Rimuovi query parameters

    // Se è un file statico che esiste, lascia che PHP lo serva normalmente
    if (file_exists(__DIR__ . $uri) && (str_ends_with($uri,".js") || str_ends_with($uri,".css"))) {
        return false; // Comunica al server PHP di servire il file
    } 
    */
    
    require("database.php");
    require("Router.php");
    $router = new Router();
    ControllerInit::setConnessione($connessione);

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
    },"Autenticazione::autenticazioneApiUtente");

    $router->post("/api/utente/logout",function(){
        header("Content-Type:application/json");
        ControllerInit::getIstanza("LoginApiController")->logout();
    },"Autenticazione::autenticazioneApiUtente");

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
    },"Autenticazione::autenticazioneApiCliente");

    $router->eseguiFunzione();
?>
