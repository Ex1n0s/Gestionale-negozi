<?php
    class ManagerOrdiniApiController{
        private $ordineModel;
        private $negozioModel;
        public function __construct(OrdineModel $ordineModel,NegozioModel $negozioModel){
            $this->ordineModel = $ordineModel;
            $this->negozioModel = $negozioModel;
        }

        private function checkAutorizzazioneNegozio($codiceNegozio){
            if(!$this->negozioModel->isManagerNegozio($codiceNegozio,$_SESSION["cf"])){
                $this->throwErrore(401,"Non autorizzato a modificare questo negozio");
            }
        }

        public function putOrdine($numero){
            $ordine = $this->ordineModel->selectOrdine($numero);
            if(!$ordine){
                $this->throwErrore(400,$this->ordineModel->getMessaggio());
            }
            $this->checkAutorizzazioneNegozio($ordine["codice_negozio"]);
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
        
            if(isset($req_body["stato"])){
                $valori["stato"] = $req_body["stato"];
            } else {
                $this->throwErrore(400,"Nessuna modifica inserita");
            }
            $this->ordineModel->updateOrdine($numero,$valori);
        
            echo json_encode(["messaggio"=> "Ordine modificato con successo"]);
        }

        public function postOrdine(){
            $attributiNecessari = ["codice_negozio","codice_prodotto","quantita_prodotto"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $valori[$attributo] = $req_body[$attributo];
            }
            $this->checkAutorizzazioneNegozio($valori["codice_negozio"]);
            $stato = $this->ordineModel->insertOrdine($valori);
            if(!$stato){
                $this->throwErrore(400,$this->ordineModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Ordine inserito con successo"]);
        }
        
        public function getOrdiniManager(){
            $ordini = $this->ordineModel->selectOrdini($_SESSION["cf"]);
            echo json_encode($ordini);
        }

        public function getOrdine($numero){
            $ordine = $this->ordineModel->selectOrdine($numero);
            if(!$ordine){
                $this->throwErrore(400,$this->ordineModel->getMessaggio());
            } 
            echo json_encode($ordine);
        }

        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>