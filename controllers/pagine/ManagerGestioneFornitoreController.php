<?php
    class ManagerGestioneFornitoreController{
        private $fornitoreModel;
        private $prodottoModel;
        private $fornisceModel;
        public function __construct(FornitoreModel $fornitoreModel,ProdottoModel $prodottoModel,FornisceModel $fornisceModel){
            $this->fornitoreModel = $fornitoreModel;
            $this->prodottoModel = $prodottoModel;
            $this->fornisceModel = $fornisceModel;
        }


        public function show($ivaFornitore){
            if(!$this->fornitoreModel->isManagerFornitore($ivaFornitore,$_SESSION["cf"])){
                header("Location: /manager/negozi");
                exit();
            }
            $fornitore = $this->fornitoreModel->selectFornitore($ivaFornitore);
            $prodotti = $this->prodottoModel->selectProdotti();
            $prodottiFornitore = $this->fornisceModel->selectProdottiFornitore($ivaFornitore);
            $fileCss = "gestione";
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/gestioneFornitore.php");
        }
    }
    
?>