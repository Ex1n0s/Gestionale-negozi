<?php
    class ManagerOrdiniController{
        private $ordineModel;

        public function __construct(OrdineModel $ordineModel){
            $this->ordineModel = $ordineModel;
        }

        public function show(){
            $ordini = $this->ordineModel->selectOrdini($_SESSION["cf"]);
            $fileCss = "ordini";
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/ordini.php");
        }
    }
    
?>