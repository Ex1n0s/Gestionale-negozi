<?php
    class FattureHadler{
        private $fatturaModel;
        public function __construct(FatturaModel $fatturaModel){
            $this->fatturaModel = $fatturaModel;
        }

        public function show(){
            $fatture = $this->fatturaModel->selectFatture($_SESSION["cf"]);
            $fileCss = "ordini";
            require("pagine/cliente/headerCliente.php");
            require("pagine/cliente/fatture.php");
        }
    }
    
?>