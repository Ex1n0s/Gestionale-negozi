<?php
    class ManagerNegoziApiController{
        private $negozioModel;

        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function putNegozio($codice){
            if(!$this->negozioModel->isManagerNegozio($codice,$_SESSION["cf"])){
                $this->throwErrore(401,"Non autorizzato a modificare questo negozio");
            }
            
            $attributiModificabili = ["codice","indirizzo","responsabile","attivo"];
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
            $stato = $this->negozioModel->updateNegozio($codice,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->negozioModel->getMessaggio());
            } 
            echo json_encode(["messaggio"=> "Negozio modificato con successo"]);
        }

        public function postNegozio(){
            $attributiNecessari = ["codice","indirizzo","responsabile"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $this->verificaCampo($attributo,$req_body[$attributo]);
                $valori[$attributo] = $req_body[$attributo];
            }
            $valori["cf_manager"] = $_SESSION["cf"];
            $stato = $this->negozioModel->insertNegozio($valori);
            if(!$stato){
                $this->throwErrore(400,$this->negozioModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Negozio creato con successo"]);
        }
        
        public function getNegoziManager(){
            $negozi = $this->negozioModel->selectNegozi($_SESSION["cf"]);
            echo json_encode($negozi);
        }

        public function getNegozio($codice){
            $negozio = $this->negozioModel->selectNegozio($codice);
            if(!$negozio){
                $this->throwErrore(400,$this->negozioModel->getMessaggio());
            } 
            echo json_encode($negozio);
        }
        
        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "codice":
                    if(strlen(trim($valore)) < 8 || strlen(trim($valore)) > 10){
                        $this->throwErrore(400,"Codice negozio non valido");
                    }
                    break;
                case "indirizzo":
                    if(strlen(trim($valore)) < 2){
                        $this->throwErrore(400,"Indirizzo non valido");
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