<?php
    class ClienteNegoziController{
        private $negozioModel;
        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi();
            require("pagine/cliente/headerCliente.php");
            require("pagine/cliente/negozi.php");
        }
    }
    
?>