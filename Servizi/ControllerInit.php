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
                case "CarrelloHandler":
                    $vendeModel = new VendeModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new CarrelloHandler($vendeModel,$negozioModel,$utenteModel);

                case "ProdottiNegozioClienteHandler":
                    $negozioModel = new NegozioModel(self::$connessione);
                    $vendeModel = new VendeModel(self::$connessione);
                    return new ProdottiNegozioClienteHandler($negozioModel,$vendeModel);

                case "ProfiloHandler":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ProfiloHandler($utenteModel);

                case "OrdiniHandler":
                    $ordineModel = new OrdineModel(self::$connessione);
                    return new OrdiniHandler($ordineModel);

                case "ClientiHandler":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new ClientiHandler($utenteModel);

                case "GestioneNegozioHandler":
                    $negozioModel = new NegozioModel(self::$connessione);
                    $vendeModel = new VendeModel(self::$connessione);
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new GestioneNegozioHandler($negozioModel,$prodottoModel,$vendeModel);

                case "GestioneFornitoreHandler":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    $fornisceModel = new FornisceModel(self::$connessione);
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new GestioneFornitoreHandler($fornitoreModel,$prodottoModel,$fornisceModel);

                case "ProdottiHandler":
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new ProdottiHandler($prodottoModel);

                case "NegoziHandler":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new NegoziHandler($negozioModel);

                case "NegoziClienteHandler":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new NegoziClienteHandler($negozioModel);

                case "FornitoriHandler":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new FornitoriHandler($fornitoreModel);

                case "Clienti":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new Clienti($utenteModel);

                case "Login":
                    $utenteModel = new UtenteModel(self::$connessione);
                    return new Login($utenteModel);

                case "Prodotti":
                    $prodottoModel = new ProdottoModel(self::$connessione);
                    return new Prodotti($prodottoModel);

                case "Negozi":
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new Negozi($negozioModel);   

                case "ProdottiNegozio":
                    $vendeModel = new VendeModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new ProdottiNegozio($vendeModel,$negozioModel);

                case "ProdottiFornitore":
                    $fornisceModel = new FornisceModel(self::$connessione);
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new ProdottiFornitore($fornisceModel,$fornitoreModel);

                case "Ordini":
                    $ordineModel = new OrdineModel(self::$connessione);
                    $negozioModel = new NegozioModel(self::$connessione);
                    return new Ordini($ordineModel,$negozioModel); 

                case "Fornitori":
                    $fornitoreModel = new FornitoreModel(self::$connessione);
                    return new Fornitori($fornitoreModel);    

                case "Fatture":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    $acquistoModel = new AcquistoModel(self::$connessione);
                    return new Fatture($fatturaModel,$acquistoModel); 
                
                case "FattureHandler":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    return new FattureHadler($fatturaModel);

                case "RigheFatturaHandler":
                    $fatturaModel = new FatturaModel(self::$connessione);
                    return new RigheFatturaHandler($fatturaModel);
                    
                default:
                    break;
            }
        }
    }

?>
