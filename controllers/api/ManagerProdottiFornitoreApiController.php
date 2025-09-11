<?php
    class ManagerProdottiFornitoreApiController{
        private $fornisceModel;
        private $fornitoreModel;

        public function __construct(FornisceModel $fornisceModel,FornitoreModel $fornitoreModel){
            $this->fornisceModel = $fornisceModel;
            $this->fornitoreModel = $fornitoreModel;
        }

        private function checkAutorizzazioneFornitore($ivaFornitore){
            if(!$this->fornitoreModel->isManagerFornitore($ivaFornitore,$_SESSION["cf"])){
                $this->throwErrore(401,"Non autorizzato a modificare questo Fornitore");
            }
        }

        public function putProdottoFornitore($ivaFornitore,$codiceProdotto){
            $this->checkAutorizzazioneFornitore($ivaFornitore);
            $attributiModificabili = ["quantita_disponibile","prezzo_prodotto"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiModificabili as $nomeAttributo) {
                if(isset($req_body[$nomeAttributo])){
                    $this->verificaCampo($nomeAttributo,$req_body[$nomeAttributo]);
                    $valori[$nomeAttributo] = $req_body[$nomeAttributo];
                }
            }
            if(sizeof($valori) === 0){
                $this->throwErrore(400,"Nessuna modifica inserita");
            }
            $stato = $this->fornisceModel->updateFornisce($ivaFornitore,$codiceProdotto,$valori);
            if(!$stato){
                $this->throwErrore(400,$this->fornisceModel->getMessaggio());
            } 
            echo json_encode(["messaggio"=> "Prodotto del fornitore modificato con successo"]);
        }

        public function postProdottoFornitore($ivaFornitore){
            $this->checkAutorizzazioneFornitore($ivaFornitore);
            $attributiNecessari = ["codice_prodotto"];
            $attributiOpzionali = ["quantita_disponibile","prezzo_prodotto"];
            $valori = [];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
                $valori[$attributo] = $req_body[$attributo];
            }
            foreach ($attributiOpzionali as $attributo) {
                if(!empty($req_body[$attributo])){
                    $this->verificaCampo($attributo,$req_body[$attributo]);
                    $valori[$attributo] = $req_body[$attributo];
                }
            }
            $valori["iva_fornitore"] = $ivaFornitore;
            $stato = $this->fornisceModel->insertFornisce($valori);
            if(!$stato){
                $this->throwErrore(400,$this->fornisceModel->getMessaggio());
            } 
            http_response_code(201);
            echo json_encode(["messaggio"=> "Prodotto aggiunto con successo"]);
        }
        
        public function getProdottiFornitore($ivaFornitore){
            $prodotti = $this->fornisceModel->selectProdottiFornitore($ivaFornitore);
            echo json_encode($prodotti);
        }

        public function getProdottoFornitore($codiceProdotto,$ivaFornitore){
            $prodotto = $this->fornisceModel->selectProdottoFornitore($codiceProdotto,$ivaFornitore);
            if(!$prodotto){
                $this->throwErrore(400,$this->fornisceModel->getMessaggio());
            } 
            echo json_encode($prodotto);
        }

        public function deleteProdottoFornitore($codiceProdotto,$ivaFornitore){
            $this->checkAutorizzazioneFornitore($ivaFornitore);
            $stato = $this->fornisceModel->deleteFornisce($ivaFornitore,$codiceProdotto);
            if(!$stato){
                $this->throwErrore(400,$this->fornisceModel->getMessaggio());
            } 
            http_response_code(204);
        }

        private function verificaCampo($attributo,$valore){
            switch ($attributo) {
                case "quantita_disponibile":
                    if(!is_numeric($valore)){
                        $this->throwErrore(400,"La quantità deve essere un numero");
                    }
                    break;
                case "prezzo_prodotto":
                    if(!is_numeric($valore)){
                        $this->throwErrore(400,"Il prezzo deve essere un numero");
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