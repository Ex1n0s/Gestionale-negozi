<?php
    class ManagerFornitoriController{
        private $fornitoreModel;

        public function __construct(FornitoreModel $fornitoreModel){
            $this->fornitoreModel = $fornitoreModel;
        }

        public function show(){
            $fornitori = $this->fornitoreModel->selectFornitori($_SESSION["cf"]);
            require("pagine/manager/header.php");
            require("pagine/manager/fornitori.php");
        }
    }
    
?>