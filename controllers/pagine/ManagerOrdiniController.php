<?php
    class ManagerOrdiniController{
        private $ordineModel;

        public function __construct(OrdineModel $ordineModel){
            $this->ordineModel = $ordineModel;
        }

        public function show(){
            $ordini = $this->ordineModel->selectOrdini($_SESSION["cf"]);
            $fileCss = "ordini";
            require("views/manager/header.php");
            require("views/manager/ordini.php");
        }
    }
    
?>