<?php
    class ClienteCarrelloController{
        private $vendeModel;
        private $negozioModel;
        private $utenteModel;
        public function __construct(VendeModel $vendeModel,NegozioModel $negozioModel,UtenteModel $utenteModel){
            $this->vendeModel = $vendeModel;
            $this->negozioModel = $negozioModel;
            $this->utenteModel = $utenteModel;
        }


        public function show(){
            $totale = 0;
            $prodotti = [];
            foreach($_SESSION["carrello"] as $indice => $elementoCarrello){
                $prodottoNegozio = $this->vendeModel->selectProdottoNegozio($elementoCarrello["codice_prodotto"],$elementoCarrello["codice_negozio"]);
                $negozio = $this->negozioModel->selectNegozio($elementoCarrello["codice_negozio"]);
                if(!$prodottoNegozio){
                    unset($_SESSION["carrello"][$indice]);
                } else {
                    $prezzoProdotto = $prodottoNegozio["prezzo_prodotto"];
                    $prezzoProdotto -= $prezzoProdotto * ($prodottoNegozio["sconto_percentuale"]/100);
                    $totale += round($prezzoProdotto * $elementoCarrello["quantita"],2);
                    $prodotti[] = [
                        "prezzo" => round($prezzoProdotto,2),
                        "sconto" => $prodottoNegozio["sconto_percentuale"],
                        "descrizione" => $prodottoNegozio["descrizione"],
                        "nome" => $prodottoNegozio["nome"],
                        "quantita" => $elementoCarrello["quantita"],
                        "indirizzo_negozio" => $negozio["indirizzo"]
                    ];
                }
            }
            $sconti = $this->utenteModel->scontiDisponibiliCliente($_SESSION["cf"]);
            require(__DIR__ . "/../../views/cliente/headerCliente.php");
            require(__DIR__ . "/../../views/cliente/carrello.php");
        }
    }
    