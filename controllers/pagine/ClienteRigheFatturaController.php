<?php
    class ClienteRigheFatturaController{
        private $fatturaModel;
        public function __construct(FatturaModel $fatturaModel){
            $this->fatturaModel = $fatturaModel;
        }


        public function show($codiceFattura){
            $fattura = $this->fatturaModel->selectFattura($codiceFattura);
            if(!$fattura || $fattura["cf_cliente"] !== $_SESSION["cf"]){
                header("Location: /cliente/fatture");
                exit();
            }
            $righeFattura = $this->fatturaModel->selectRigheFattura($codiceFattura);
            $fileCss = "ordini";
            require("views/cliente/headerCliente.php");
            require("views/cliente/righeFattura.php");
        }
    }
    
?>