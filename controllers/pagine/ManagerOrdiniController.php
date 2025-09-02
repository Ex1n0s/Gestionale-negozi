<?php
    class ManagerOrdiniController{
        private $ordineModel;

        public function __construct(OrdineModel $ordineModel){
            $this->ordineModel = $ordineModel;
        }

        public function show(){
            $ordini = $this->ordineModel->selectOrdini($_SESSION["cf"]);
            $fileCss = "ordini";
            require("pagine/manager/header.php");
            require("pagine/manager/ordini.php");
        }
    }
    
?>