<?php
    class ManagerNegoziController{
        private $negozioModel;

        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi($_SESSION["cf"]);
            require("views/manager/header.php");
            require("views/manager/negozi.php");
        }
    }
    
?>