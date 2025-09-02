<?php
    class ManagerProdottiController{
        private $prodottoModel;

        public function __construct(ProdottoModel $prodottoModel){
            $this->prodottoModel = $prodottoModel;
        }

        public function show(){
            $prodotti = $this->prodottoModel->selectProdotti();
            require("views/manager/header.php");
            require("views/manager/prodotti.php");
        }
    }
    
?>