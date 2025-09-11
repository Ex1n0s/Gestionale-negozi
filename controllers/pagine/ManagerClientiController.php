<?php
    class ManagerClientiController{
        private $utenteModel;

        public function __construct(UtenteModel $utenteModel){
            $this->utenteModel = $utenteModel;
        }

        public function show(){
            $clienti = $this->utenteModel->selectUtenti("cliente");
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/clienti.php");
        }
    }
    
?>