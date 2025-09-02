<?php
    class ClienteNegoziController{
        private $negozioModel;
        public function __construct(NegozioModel $negozioModel){
            $this->negozioModel = $negozioModel;
        }

        public function show(){
            $negozi = $this->negozioModel->selectNegozi();
            require("views/cliente/headerCliente.php");
            require("views/cliente/negozi.php");
        }
    }
    
?>