<?php
    class ProfiloController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function show(){
            $utente = $this->utenteModel->selectUtente($_SESSION["cf"],$_SESSION["ruolo"]);
            $tessera = $this->utenteModel->selectTesseraCliente($_SESSION["cf"]);
            $fileCss = "profilo";
            if($_SESSION["ruolo"] === "manager"){
                require(__DIR__ . "/../../views/manager/header.php");
            } else {
                require(__DIR__ . "/../../views/cliente/headerCliente.php");
            }
            require(__DIR__ . "/../../views/profilo.php");
        }
    }
    
?>