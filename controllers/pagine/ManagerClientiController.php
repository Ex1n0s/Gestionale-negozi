<?php
    class ManagerClientiController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function show(){
            $clienti = $this->utenteModel->selectUtenti("cliente");
            require("pagine/manager/header.php");
            require("pagine/manager/clienti.php");
        }
    }
    
?>