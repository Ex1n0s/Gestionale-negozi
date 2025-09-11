<?php
    class ManagerProdottiNegozioApiController{
        private $vendeModel;
        private $negozioModel;

        public function __construct(VendeModel $vendeModel,NegozioModel $negozioModel){
            $this->vendeModel = $vendeModel;
            $this->negozioModel = $negozioModel;
        }

        private function checkAutorizzazioneNegozio($codiceNegozio){
            if(!$this->negozioModel->isManagerNegozio($codiceNegozio,$_SESSION["cf"])){
                $this->throwErrore(401,"Non autorizzato a modificare questo negozio");
            }
        }

        public function putProdottoNegozio($codiceNegozio,$codiceProdotto){
            $this->checkAutorizzazioneNegozio($codiceNegozio);
            $attributiModificabili = ["quantita_disponibile","prezzo_prodotto","sconto_percentuale"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiModificabili as $nomeAttributo) {
                if(isset($req_body[$nomeAttributo])){
                    $this->verificaCampo($nomeAttributo,$req_body[$nomeAttributo]);
                    $valori[$nomeAttributo] = $req_body[$nomeAttributo];
                }
            }
            if(sizeof($valori) === 0){
                $this->throwErrore(400,"Nessuna modifica inserita");
            }
            $stato = $this->vendeModel->updateVende($codiceNegozio,$codiceProdotto,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->vendeModel->getMessaggio());
            } 
            echo json_encode(["messaggio"=> "Prodotto in vendita modificato con successo"]);
        }

        public function postProdottoNegozio($codiceNegozio){
            $this->checkAutorizzazioneNegozio($codiceNegozio);
            $attributiNecessari = ["codice_prodotto"];
            $attributiOpzionali = ["quantita_disponibile","prezzo_prodotto","sconto_percentuale"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $valori[$attributo] = $req_body[$attributo];
            }
            foreach ($attributiOpzionali as $attributo) {
                if(!empty($req_body[$attributo])){
                    $this->verificaCampo($attributo,$req_body[$attributo]);
                    $valori[$attributo] = $req_body[$attributo];
                }
            }
            $valori["codice_negozio"] = $codiceNegozio;
            $stato = $this->vendeModel->insertVende($valori);
            if(!$stato){
                $this->throwErrore(400,$this->vendeModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Prodotto aggiunto con successo"]);
        }
        
        public function getProdottiNegozio($codiceNegozio){
            $prodotti = $this->vendeModel->selectProdottiNegozio($codiceNegozio);
            echo json_encode($prodotti);
        }

        public function getProdottoNegozio($codiceProdotto,$codiceNegozio){
            $prodotto = $this->vendeModel->selectProdottoNegozio($codiceProdotto,$codiceNegozio);
            if(!$prodotto){
                $this->throwErrore(400,$this->vendeModel->getMessaggio());
            } 
            echo json_encode($prodotto);
        }

        public function deleteProdottoNegozio($codiceProdotto,$codiceNegozio){
            $this->checkAutorizzazioneNegozio($codiceNegozio);
            $stato = $this->vendeModel->deleteVende($codiceNegozio,$codiceProdotto);
            if(!$stato){
                $this->throwErrore(400,$this->vendeModel->getMessaggio());
            } 
            http_response_code(204);
        }

        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "quantita_disponibile":
                    if(!is_numeric($valore)){
                        $this->throwErrore(400,"La quantità deve essere un numero");
                    }
                    break;
                case "prezzo_prodotto":
                    if(!is_numeric($valore)){
                        $this->throwErrore(400,"Il prezzo deve essere un numero");
                    }
                    break;
                case "sconto_percentuale":
                    if(!is_numeric($valore)){
                        $this->throwErrore(400,"Lo sconto deve essere un numero");
                    }
                    break;
                default:
                    break;
            }
        }

        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>