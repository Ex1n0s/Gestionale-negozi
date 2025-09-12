<?php
    class ClienteCarrelloApiController{

        public function deleteElementoCarrello($numero){
            if(!isset($_SESSION["carrello"][$numero])){
                $this->throwErrore(404,"Prodotto non trovato");
            }
            unset($_SESSION["carrello"][$numero]);
            $_SESSION["carrello"] = array_values($_SESSION['carrello']); 
            json_encode(["messaggio"=>"Prodotto rimosso dal carrello"]);
        }

        public function putElementoCarrello($numero){
            if(!isset($_SESSION["carrello"][$numero])){
                $this->throwErrore(404,"Prodotto non trovato");
            }
            $req_body = json_decode(file_get_contents("php://input"), true);
            
            if(!isset($req_body["quantita"])){
                $this->throwErrore(400,"Nessuna modifica inserita");
            }
            $quantita = (int)$req_body["quantita"];
            if($quantita === 0){
                $this->throwErrore(400,"Quantità non valida");
            }
            $_SESSION["carrello"][$numero]["quantita"] += $quantita;
            if($_SESSION["carrello"][$numero]["quantita"] <= 0){
               unset($_SESSION["carrello"][$numero]);
               $_SESSION["carrello"] = array_values($_SESSION['carrello']);
            } 
            json_encode(["messaggio"=>"Prodotto aggiornato"]);
        }

        public function postElementoCarrello(){
            $attributiNecessari = ["codice_negozio","codice_prodotto","quantita"];
            $req_body = json_decode(file_get_contents("php://input"), true);
            foreach ($attributiNecessari as $attributo) {
                if(empty($req_body[$attributo])){
                    $this->throwErrore(400,"Il campo $attributo e' vuoto");
                }
            }
            
            //se $req_body["quantita"] contiene un valore non valido a quantita viene assegnato 0
            $quantita = (int)$req_body["quantita"];
            if($quantita < 1){
                $this->throwErrore(400,"Quantità non valida");
            }
            foreach($_SESSION["carrello"] as $chiave => $elementoCarrello){
                if($elementoCarrello["codice_negozio"] === $req_body["codice_negozio"] && $elementoCarrello["codice_prodotto"] === $req_body["codice_prodotto"]){
                    $_SESSION["carrello"][$chiave]["quantita"] += $quantita;
                    echo json_encode(["messaggio"=> "Prodotto aggiunto al carrello"]);
                    exit;
                }
            }
            $_SESSION["carrello"][] = [
                "codice_negozio" => $req_body["codice_negozio"],
                "codice_prodotto" => $req_body["codice_prodotto"],
                "quantita" => $quantita
            ];
            echo json_encode(["messaggio"=> "Prodotto aggiunto al carrello"]);
        }
        
        private function throwErrore($codiceErrore,$messaggio){
            http_response_code($codiceErrore);
            echo json_encode(["messaggio"=> $messaggio]);
            exit();
        }
    }
?>