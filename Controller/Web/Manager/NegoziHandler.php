<?php
    class NegoziHandler{
        private $negozioModel;

        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi($_SESSION["cf"]);
            require("pagine/manager/header.php");
            require("pagine/manager/negozi.php");
        }
    }
    
?>