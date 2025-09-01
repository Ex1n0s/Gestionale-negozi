<?php
    class ProfiloHandler{
        private $utenteModel;

        public function __construct(utenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function show(){
            $utente = $this->utenteModel->selectUtente($_SESSION["cf"],$_SESSION["ruolo"]);
            $tessera = $this->utenteModel->selectTesseraCliente($_SESSION["cf"]);
            $fileCss = "profilo";
            if($_SESSION["ruolo"] === "manager"){
                require("pagine/manager/header.php");
            } else {
                require("pagine/cliente/headerCliente.php");
            }
            require("pagine/profilo.php");
        }
    }
    
?>