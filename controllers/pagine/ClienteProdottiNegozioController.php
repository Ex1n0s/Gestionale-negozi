<?php
    class ClienteProdottiNegozioController{
        private $negozioModel;
        private $vendeModel;
        public function __construct(NegozioModel $negozioModel,VendeModel $vendeModel){
            $this->negozioModel = $negozioModel;
            $this->vendeModel = $vendeModel;
        }


        public function show($codiceNegozio){
            $negozio = $this->negozioModel->selectNegozio($codiceNegozio);
            $prodottiNegozio = $this->vendeModel->selectProdottiNegozio($codiceNegozio);
            require("views/cliente/headerCliente.php");
            require("views/cliente/prodottiNegozio.php");
        }
    }
    
?>