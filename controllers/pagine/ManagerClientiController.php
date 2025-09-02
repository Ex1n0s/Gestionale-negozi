<?php
    class ManagerClientiController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function show(){
            $clienti = $this->utenteModel->selectUtenti("cliente");
            require("views/manager/header.php");
            require("views/manager/clienti.php");
        }
    }
    
?>