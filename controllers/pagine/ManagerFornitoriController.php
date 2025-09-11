<?php
    class ManagerFornitoriController{
        private $fornitoreModel;

        public function __construct(FornitoreModel $fornitoreModel){
            $this->fornitoreModel = $fornitoreModel;
        }

        public function show(){
            $fornitori = $this->fornitoreModel->selectFornitori($_SESSION["cf"]);
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/fornitori.php");
        }
    }
    
?>