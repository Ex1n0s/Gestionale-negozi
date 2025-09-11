<?php
    class ManagerClientiApiController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function getClienti(){
            $clienti = $this->utenteModel->selectUtenti("cliente");
            echo json_encode($clienti);
        }

        public function deleteUtente($codiceFiscale){
            $stato = $this->utenteModel->deleteUtente($codiceFiscale);
            if($stato){
                http_response_code(204);
            } else {
                $this->throwErrore(400,$this->utenteModel->getMessaggio());
            }
        }

        public function getCliente($codiceFiscale){
            $cliente = $this->utenteModel->selectUtente($codiceFiscale);
            if(!$cliente){
                $this->throwErrore(400,$this->utenteModel->getMessaggio());
            } 
            echo json_encode($cliente);
        }

        public function putCliente($codiceFiscale){
            $attributiModificabili = ["cf","nome","cognome","email"];
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
            $stato = $this->utenteModel->updateUtente($codiceFiscale,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->utenteModel->getMessaggio());
            }
            echo json_encode(["messaggio"=> "Cliente modificato con successo"]);
            
        }

        public function postCliente(){
            $attributiNecessari = ["cf","nome","cognome","email","password"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $this->verificaCampo($attributo,$req_body[$attributo]);
                $valori[$attributo] = $req_body[$attributo];
            }
            $stato = $this->utenteModel->insertUtente($valori);
            if(!$stato){
                $this->throwErrore(400,$this->utenteModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Cliente creato con successo"]);
        }
        
        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "cf":
                    if(strlen($valore) !== 16){
                        $this->throwErrore(400,"Codice fiscale non valido");
                    }
                    break;
                case "nome":
                    if(strlen(trim($valore)) < 2){
                        $this->throwErrore(400,"Nome troppo corto");
                    }
                    break;
                case "cognome":
                    if(strlen(trim($valore)) < 2){
                        $this->throwErrore(400,"Cognome troppo corto");
                    }
                    break;
                case "email":
                    if(!filter_var($valore, FILTER_VALIDATE_EMAIL)) {
                        $this->throwErrore(400, "Email non valida");
                    }
                    break;
                case "password":
                    if(strlen(trim($valore)) < 8){
                        $this->throwErrore(400, "Password troppo corta");
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