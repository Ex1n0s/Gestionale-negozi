<?php
    class Autenticazione{
        private static $connessione;

        public static function setConnessione(PDO $connessione){
            self::$connessione = $connessione;
        }
        
        static private function checkDb($ruolo){
            switch ($ruolo) {
                case "manager":
                    $query = "SELECT * FROM manager WHERE cf_utente = ?";
                    break;
                case "cliente":
                    $query = "SELECT * FROM cliente WHERE cf_utente = ?";
                    break;
                default:
                    return false;
                    break;
            }
            $query = self::$connessione->prepare($query);
            $query -> execute([$_SESSION["cf"]]);
            
            return $query->fetch() !== false; 
        }

        public static function autenticazione($tipo,$ruolo){
            if(!isset($_SESSION["cf"])){
                self::throwErrore($tipo);
            }
            if($ruolo !== "utente"){
                if($_SESSION["ruolo"] !== $ruolo){
                    self::throwErrore($tipo);
                }
                if(!self::checkDb($ruolo)){
                    session_destroy();
                    self::throwErrore($tipo);
                } 
            }
        }
        private static function throwErrore($tipo){
            if($tipo === "api"){
                header("Content-Type:application/json");
                http_response_code(401);
                echo json_encode(["messaggio"=> "Non autorizzato"]);
            } else if ($tipo === "pagine"){
                header("Location: /login");
            }
            exit();
        } 

        public static function checkLogin(){
            $_SESSION["ruolo"] = $_SESSION["ruolo"] ?? null;
            if($_SESSION["ruolo"] === "manager"){
                header("Location: /manager/clienti");
                exit();
            } elseif($_SESSION["ruolo"] === "cliente"){
                header("Location: /cliente/negozi");  
                exit();  
            } 
        }
    }

?>