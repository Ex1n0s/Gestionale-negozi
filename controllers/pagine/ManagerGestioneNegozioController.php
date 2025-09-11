<?php
    class ManagerGestioneNegozioController{
        private $negozioModel;
        private $prodottoModel;
        private $vendeModel;
        public function __construct(NegozioModel $negozioModel,ProdottoModel $prodottoModel,VendeModel $vendeModel){
            $this->negozioModel = $negozioModel;
            $this->prodottoModel = $prodottoModel;
            $this->vendeModel = $vendeModel;
        }


        public function show($codiceNegozio){
            if(!$this->negozioModel->isManagerNegozio($codiceNegozio,$_SESSION["cf"])){
                header("Location: /manager/negozi");
                exit();
            }
            $negozio = $this->negozioModel->selectNegozio($codiceNegozio);
            $prodotti = $this->prodottoModel->selectProdotti();
            $prodottiNegozio = $this->vendeModel->selectProdottiNegozio($codiceNegozio);
            $fileCss = "gestione";
            require(__DIR__ . "/../../views/manager/header.php");
            require(__DIR__ . "/../../views/manager/gestioneNegozio.php");
        }
    }
    
?>