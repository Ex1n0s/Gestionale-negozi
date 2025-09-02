<?php
    class ClienteNegoziController{
        private $negozioModel;
        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi();
            require(__DIR__ . "/../../views/cliente/headerCliente.php");
            require(__DIR__ . "/../../views/cliente/negozi.php");
        }
    }
    
?>