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
    $router->get("/login",function(){
        require("views/login.php");
    },"Autenticazione::checkLogin");

    $router->get("/manager/clienti",function(){
        ControllerInit::getController("ManagerClientiController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/prodotti",function(){
        ControllerInit::getController("ManagerProdottiController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/negozi",function(){
        ControllerInit::getController("ManagerNegoziController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/fornitori",function(){
        ControllerInit::getController("ManagerFornitoriController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/ordini",function(){
        ControllerInit::getController("ManagerOrdiniController")->show();
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/manager/fornitore/{ivaFornitore}",function($ivaFornitore){
        ControllerInit::getController("ManagerGestioneFornitoreController")->show($ivaFornitore);
    },"Autenticazione::autenticazionePagineManager");


    $router->get("/manager/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getController("ManagerGestioneNegozioController")->show($codiceNegozio);
    },"Autenticazione::autenticazionePagineManager");

    $router->get("/utente/profilo",function(){
        ControllerInit::getController("ProfiloController")->show();
    },"Autenticazione::autenticazionePagineUtente");

    $router->get("/cliente/negozi",function(){
        ControllerInit::getController("ClienteNegoziController")->show();
    },"Autenticazione::autenticazionePagineCliente");
    
    $router->get("/cliente/negozio/{codiceNegozio}",function($codiceNegozio){
        ControllerInit::getController("ClienteProdottiNegozioController")->show($codiceNegozio);
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/carrello",function(){
        ControllerInit::getController("ClienteCarrelloController")->show();
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/fatture",function(){
        ControllerInit::getController("ClienteFattureController")->show();
    },"Autenticazione::autenticazionePagineCliente");

    $router->get("/cliente/fatture/{codiceFattura}",function($codiceFattura){
        ControllerInit::getController("ClienteRigheFatturaController")->show($codiceFattura);
    },"Autenticazione::autenticazionePagineCliente");

    //Login
    $router->post("/api/login",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Login")->login();
    });

    //Utente
    $router->put("/api/utente/password",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Login")->cambioPassword();
    },"Autenticazione::autenticazioneApiUtente");

    $router->post("/api/utente/logout",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Login")->logout();
    },"Autenticazione::autenticazioneApiUtente");

    //Clienti
    $router->get("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getController("Clienti")->getCliente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Clienti")->getClienti();
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getController("Clienti")->deleteUtente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/clienti",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Clienti")->postCliente();
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/clienti/{codiceFiscale}",function($codiceFiscale){
        header("Content-Type:application/json");
        ControllerInit::getController("Clienti")->putCliente($codiceFiscale);
    },"Autenticazione::autenticazioneApiManager");

    //Prodotti
    $router->get("/api/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getController("Prodotti")->getProdotto($codice);
    });

    $router->get("/api/prodotti",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Prodotti")->getProdotti();
    });

    $router->delete("/api/manager/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getController("Prodotti")->deleteProdotto($codice);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/prodotti",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Prodotti")->postProdotto();
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/prodotti/{codiceProdotto}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getController("Prodotti")->putProdotto($codice);
    },"Autenticazione::autenticazioneApiManager");


    //Negozi
    
    $router->get("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getController("Negozi")->getNegozio($codice);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/negozi/{codiceNegozio}",function($codice){
        header("Content-Type:application/json");
        ControllerInit::getController("Negozi")->putNegozio($codice);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Negozi")->getNegoziManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/negozi",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Negozi")->postNegozio();
    },"Autenticazione::autenticazioneApiManager");

    //Prodotti negozio
    $router->get("/api/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiNegozio")->getProdottiNegozio($codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiNegozio")->getProdottoNegozio($codiceProdotto,$codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/negozi/{codiceNegozio}/prodotti",function($codiceNegozio){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiNegozio")->postProdottoNegozio($codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiNegozio")->putProdottoNegozio($codiceNegozio,$codiceProdotto);
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/negozi/{codiceNegozio}/prodotti/{codiceProdotto}",function($codiceNegozio,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiNegozio")->deleteProdottoNegozio($codiceProdotto,$codiceNegozio);
    },"Autenticazione::autenticazioneApiManager");

    //Ordini

    $router->get("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getController("Ordini")->getOrdine($numeroOrdine);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Ordini")->getOrdiniManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/ordini",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Ordini")->postOrdine();
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/ordini/{numeroOrdine}",function($numeroOrdine){
        header("Content-Type:application/json");
        ControllerInit::getController("Ordini")->putOrdine($numeroOrdine);
    },"Autenticazione::autenticazioneApiManager");

    //Fornitori
    $router->get("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getController("Fornitori")->getFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/fornitori/{ivaFornitore}",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getController("Fornitori")->putFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Fornitori")->getFornitoriManager();
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/fornitori",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Fornitori")->postFornitore();
    },"Autenticazione::autenticazioneApiManager");

    //Prodotti fornitore
    $router->get("/api/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiFornitore")->getProdottiFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->get("/api/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiFornitore")->getProdottoFornitore($codiceProdotto,$ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->post("/api/manager/fornitore/{ivaFornitore}/prodotti",function($ivaFornitore){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiFornitore")->postProdottoFornitore($ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    $router->put("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiFornitore")->putProdottoFornitore($ivaFornitore,$codiceProdotto);
    },"Autenticazione::autenticazioneApiManager");

    $router->delete("/api/manager/fornitore/{ivaFornitore}/prodotti/{codiceProdotto}",function($ivaFornitore,$codiceProdotto){
        header("Content-Type:application/json");
        ControllerInit::getController("ProdottiFornitore")->deleteProdottoFornitore($codiceProdotto,$ivaFornitore);
    },"Autenticazione::autenticazioneApiManager");

    //CARRELLO
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

    //Fatture
    $router->post("/api/cliente/acquista",function(){
        header("Content-Type:application/json");
        ControllerInit::getController("Fatture")->acquista();
    },"Autenticazione::autenticazioneApiCliente");

    $router->eseguiFunzione();

?>
