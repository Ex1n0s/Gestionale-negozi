<?php
    class ManagerProdottiController{
        private $prodottoModel;

        public function __construct(ProdottoModel $prodottoModel){
            $this->prodottoModel = $prodottoModel;
        }

        public function show(){
            $prodotti = $this->prodottoModel->selectProdotti();
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/prodotti.php");
        }
    }
    
?>