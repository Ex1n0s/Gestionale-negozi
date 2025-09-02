<?php
    class ManagerFornitoriController{
        private $fornitoreModel;

        public function __construct(FornitoreModel $fornitoreModel){
            $this->fornitoreModel = $fornitoreModel;
        }

        public function show(){
            $fornitori = $this->fornitoreModel->selectFornitori($_SESSION["cf"]);
            require("views/manager/header.php");
            require("views/manager/fornitori.php");
        }
    }
    
?>