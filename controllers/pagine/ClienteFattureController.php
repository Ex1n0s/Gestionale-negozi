<?php
    class ClienteFattureController{
        private $fatturaModel;
        public function __construct(FatturaModel $fatturaModel){
            $this->fatturaModel = $fatturaModel;
        }

        public function show(){
            $fatture = $this->fatturaModel->selectFatture($_SESSION["cf"]);
            $fileCss = "ordini";
            require("views/cliente/headerCliente.php");
            require("views/cliente/fatture.php");
        }
    }
    
?>