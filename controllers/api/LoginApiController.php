<?php
    class LoginApiController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function login(){
            $req_body = json_decode(file_get_contents("php://input"), true);
            if(empty($req_body["cf"]) || empty($req_body["password"])){
                $this->throwErrore(400,"Codice fiscale o password mancati");
            }
            $codiceFiscale = $req_body["cf"];
            $password = $req_body["password"];
            $ruolo = $req_body["ruolo"] ?? "cliente";
            if($ruolo === "cliente"){
                $stato = $this->loginCliente($codiceFiscale,$password);
                $destinazione = "/cliente/negozi";
            } else if ($ruolo === "manager"){
                $stato = $this->loginManager($codiceFiscale,$password);
                $destinazione = "/manager/clienti";
            } else {
                $this->throwErrore(400,"Ruolo non valido");
            }

            if($stato){
                echo json_encode(["destinazione" => $destinazione]); 
            } else {
                http_response_code(401);
                echo json_encode(["messaggio" => "Codice fiscale o password errati"]); 
            }
        }

        private function loginCliente($codiceFiscale,$password){
            $record = $this->utenteModel->selectUtente($codiceFiscale,"cliente",true);
            if($record !== false && password_verify($password,$record["password"])){
                $_SESSION["cf"] = $codiceFiscale;
                $_SESSION["ruolo"] = "cliente";
                $_SESSION["carrello"] = [];
                return true;
            }
            return false;
        }

        private function loginManager($codiceFiscale,$password){
            $record = $record = $this->utenteModel->selectUtente($codiceFiscale,"manager",true);
            if($record !== false && password_verify($password,$record["password"])){
                $_SESSION["cf"] = $codiceFiscale;
                $_SESSION["ruolo"] = "manager";
                return true;
            }
            return false;
        }

        public function logout(){
            session_destroy();
            echo json_encode(["messaggio" => "Logout effettuato con successo"]);
        }

        public function cambioPassword(){
            $req_body = json_decode(file_get_contents("php://input"), true);
            if(!isset($req_body["password_nuova"]) || strlen(trim($req_body["password_nuova"])) < 8){
                $this->throwErrore(400,"Password troppo corta");
            }

            if(empty($req_body["password_corrente"])){
                $this->throwErrore(400,"Password corrente mancante");
            }

            $record = $this->utenteModel->selectUtente($_SESSION["cf"],"",true);
            if($record !== false && password_verify($req_body["password_corrente"],$record["password"])){
                $stato = $this->utenteModel->updateUtente($_SESSION["cf"],["password" => $req_body["password_nuova"]]);
                if(!$stato){
                    $this->throwErrore(400,$this->utenteModel->getMessaggio());
                }
                echo json_encode(["messaggio"=>"Password modificata con successo"]);
            } else {
                $this->throwErrore(400,"Password errata");
            }
        }
        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>