<?php
    class ControllerInit{
        static private $connessione;

        public static function setConnessione(PDO $connessione){
            self::$connessione = $connessione;
        }
        public static function getConnessione(){
            return self::$connessione;
        }
        public static function getController($nomeClasse){
            switch ($nomeClasse) {
                case "ClienteCarrelloController":
                    $vendeModel = new VendeModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ClienteCarrelloController($vendeModel,$negozioModel,$utenteModel);

                case "ClienteProdottiNegozioController":
                    $negozioModel = new NegozioModel(self::$connessione);
                    $vendeModel = new VendeModel(self::$connessione);
                    return new ClienteProdottiNegozioController($negozioModel,$vendeModel);

                case "ProfiloController":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ProfiloController($utenteModel);

                case "ManagerOrdiniController":
                    $ordineModel = new OrdineModel(self::$connessione);
                    return new ManagerOrdiniController($ordineModel);

                case "ManagerClientiController":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ManagerClientiController($utenteModel);

                case "ManagerGestioneNegozioController":
                    $negozioModel = new NegozioModel(self::$connessione);
                    $vendeModel = new VendeModel(self::$connessione);
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new ManagerGestioneNegozioController($negozioModel,$prodottoModel,$vendeModel);

                case "ManagerGestioneFornitoreController":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    $fornisceModel = new FornisceModel(self::$connessione);
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new ManagerGestioneFornitoreController($fornitoreModel,$prodottoModel,$fornisceModel);

                case "ManagerProdottiController":
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new ManagerProdottiController($prodottoModel);

                case "ManagerNegoziController":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ManagerNegoziController($negozioModel);

                case "ClienteNegoziController":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ClienteNegoziController($negozioModel);

                case "ManagerFornitoriController":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new ManagerFornitoriController($fornitoreModel);

                case "Clienti":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ManagerClientiApiController($utenteModel);

                case "Login":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new LoginApiController($utenteModel);

                case "Prodotti":
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new ManagerProdottiApiController($prodottoModel);

                case "Negozi":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ManagerNegoziApiController($negozioModel);   

                case "ProdottiNegozio":
                    $vendeModel = new VendeModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ManagerProdottiNegozioApiController($vendeModel,$negozioModel);

                case "ProdottiFornitore":
                    $fornisceModel = new FornisceModel(self::$connessione);
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new ManagerProdottiFornitoreApiController($fornisceModel,$fornitoreModel);

                case "Ordini":
                    $ordineModel = new OrdineModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ManagerOrdiniApiController($ordineModel,$negozioModel); 

                case "Fornitori":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new ManagerFornitoriApiController($fornitoreModel);    

                case "Fatture":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    $acquistoModel = new AcquistoModel(self::$connessione);
                    return new ClienteFattureApiController($fatturaModel,$acquistoModel); 
                
                case "ClienteFattureController":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    return new ClienteFattureController($fatturaModel);

                case "ClienteRigheFatturaController":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    return new ClienteRigheFatturaController($fatturaModel);
                    
                default:
                    break;
            }
        }
    }

?>
