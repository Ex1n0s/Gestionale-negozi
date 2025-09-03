<?php
    class Autenticazione{
        public static function checkSessioneManager(){
            return isset($_SESSION["cf"]) && $_SESSION["ruolo"] === "manager";
        }

        public static function checkSessioneCliente(){
            return isset($_SESSION["cf"]) && $_SESSION["ruolo"] === "cliente";
        }

        public static function autenticazionePagineManager(){
            if(!self::checkSessioneManager()){
                header("Location: /login");
                exit();
            }
        }

        public static function autenticazionePagineCliente(){
            if(!self::checkSessioneCliente()){
                header("Location: /login");
                exit();
            }
        }

        public static function autenticazionePagineUtente(){
            if(!self::checkSessioneManager() && !self::checkSessioneCliente()){
                header("Location: /login");
                exit();
            }
        }

        public static function autenticazioneApiUtente(){
            if(!self::checkSessioneManager() && !self::checkSessioneCliente()){
                header("Content-Type:application/json");
                http_response_code(401);
                echo json_encode(["messaggio"=> "Non autorizzato"]);
                exit();
            }
        }


        public static function autenticazioneApiManager(){
            if(!self::checkSessioneManager()){
                header("Content-Type:application/json");
                http_response_code(401);
                echo json_encode(["messaggio"=> "Non autorizzato"]);
                exit();
            }
        }

        public static function autenticazioneApiCliente(){
            if(!self::checkSessioneCliente()){
                header("Content-Type:application/json");
                http_response_code(401);
                echo json_encode(["messaggio"=> "Non autorizzato"]);
                exit();
            }
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