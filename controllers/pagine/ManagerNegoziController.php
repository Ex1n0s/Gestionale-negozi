<?php
    class ManagerNegoziController{
        private $negozioModel;

        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi($_SESSION["cf"]);
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/negozi.php");
        }
    }
    
?>