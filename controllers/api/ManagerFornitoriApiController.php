<?php
    class ManagerFornitoriApiController{
        private $fornitoreModel;

        public function __construct(FornitoreModel $fornitoreModel){
            $this->fornitoreModel = $fornitoreModel;
        }

        public function putFornitore($ivaFornitore){
            if(!$this->fornitoreModel->isManagerFornitore($ivaFornitore,$_SESSION["cf"])){
                $this->throwErrore(401,"Non autorizzato a modificare questo fornitore");
            }
            
            $attributiModificabili = ["iva","indirizzo","attivo"];
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
            $stato = $this->fornitoreModel->updateFornitore($ivaFornitore,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->fornitoreModel->getMessaggio());
            } 
            echo json_encode(["messaggio"=> "Fornitore modificato con successo"]);
        }

        public function postFornitore(){
            $attributiNecessari = ["iva","indirizzo"];
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
            $stato = $this->fornitoreModel->insertFornitore($valori);
            if(!$stato){
                $this->throwErrore(400,$this->fornitoreModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Fornitore creato con successo"]);
        }
        
        public function getFornitoriManager(){
            $fornitori = $this->fornitoreModel->selectFornitori($_SESSION["cf"]);
            echo json_encode($fornitori);
        }

        public function getFornitore($ivaFornitore){
            $fornitore = $this->fornitoreModel->selectFornitore($ivaFornitore);
            if(!$fornitore){
                $this->throwErrore(400,$this->fornitoreModel->getMessaggio());
            } 
            echo json_encode($fornitore);
        }

        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "iva":
                    if(strlen(trim($valore)) !== 11){
                        $this->throwErrore(400,"Numero di partita Iva non valido");
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