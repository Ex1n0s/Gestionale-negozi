<?php
    class ClienteFattureApiController{
        private $fatturaModel;
        private $acquistoModel;

        public function __construct(FatturaModel $fatturaModel,AcquistoModel $acquistoModel){
            $this->fatturaModel = $fatturaModel;
            $this->acquistoModel = $acquistoModel;
        }

        public function acquista(){
            $req_body = json_decode(file_get_contents("php://input"), true);
            $sconto_percentuale = $req_body["sconto_percentuale"] ?? 0;
            $dati = $this->acquistoModel->acquistoCarrello($_SESSION["carrello"]);
            if(!$dati){
                $this->throwErrore(400,$this->acquistoModel->getMessaggio());
            }
            $datiFattura = [
                "totale" => $dati["totale"],
                "sconto_percentuale" => $sconto_percentuale,
                "cf_cliente" => $_SESSION["cf"]
            ];
            $this->fatturaModel->insertFattura($datiFattura,$dati["prodotti"]);
            echo json_encode(["messaggio" => "Acquisto effettuato con successo"]);
        }

        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>