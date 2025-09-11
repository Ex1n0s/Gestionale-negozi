<?php
    class ManagerProdottiApiController{
        private $prodottoModel;

        public function __construct(ProdottoModel $prodottoModel){
            $this->prodottoModel = $prodottoModel;
        }

        public function deleteProdotto($codice){
            $stato = $this->prodottoModel->deleteProdotto($codice);
            if(!$stato){
                $this->throwErrore(400,$this->prodottoModel->getMessaggio());
            } 
            http_response_code(204);
            echo json_encode(["messaggio"=> "Prodotto eliminato"]);
        }

        public function putProdotto($codice){
            $attributiModificabili = ["codice","nome","descrizione"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiModificabili as $nomeAttributo) {
                if(isset($req_body[$nomeAttributo])){
                    $this->verificaCampo($nomeAttributo,$req_body[$nomeAttributo]);
                    $valori[$nomeAttributo] = $req_body[$nomeAttributo];
                }
            }
            if(sizeof($valori) === 0){
                http_response_code(400);
                echo json_encode(["messaggio"=> "Nessuna modifica inserita"]);
                exit();
            }
            $stato = $this->prodottoModel->updateProdotto($codice,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->prodottoModel->getMessaggio());
            } 
            echo json_encode(["messaggio"=> "Prodotto modificato con successo"]);
            
        }

        public function postProdotto(){
            $attributiNecessari = ["codice","nome","descrizione"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $this->verificaCampo($attributo,$req_body[$attributo]);
                $valori[$attributo] = $req_body[$attributo];
            }
            $stato = $this->prodottoModel->insertProdotto($valori);
            if(!$stato){
                $this->throwErrore(400,$this->prodottoModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Prodotto creato con successo"]);
        }
        
        public function getProdotti(){
            $prodotti = $this->prodottoModel->selectProdotti();
            echo json_encode($prodotti);
        }

        public function getProdotto($codice){
            $prodotto = $this->prodottoModel->selectProdotto($codice);
            if(!$prodotto){
                $this->throwErrore(400,$this->prodottoModel->getMessaggio());
            }
            echo json_encode($prodotto);
        }

        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "codice":
                    if(strlen(trim($valore)) < 7 || strlen(trim($valore)) > 10){
                        $this->throwErrore(400,"Codice prodotto non valido");
                    }
                    break;
                case "nome":
                    if(strlen(trim($valore)) < 2){
                        $this->throwErrore(400,"Nome prodotto non valido");
                    }
                    break;
                default:
                    break;
            }
        }
        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>