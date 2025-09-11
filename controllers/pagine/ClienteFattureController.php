<?php
    class ClienteFattureController{
        private $fatturaModel;
        public function __construct(FatturaModel $fatturaModel){
            $this->fatturaModel = $fatturaModel;
        }

        public function show(){
            $fatture = $this->fatturaModel->selectFatture($_SESSION["cf"]);
            $fileCss = "ordini";
            require(__DIR__ . "/../../views/cliente/headerCliente.php");
            require(__DIR__ . "/../../views/cliente/fatture.php");
        }
    }
    
?>