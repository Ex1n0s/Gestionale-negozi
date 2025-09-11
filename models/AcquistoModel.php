<?php
    class AcquistoModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function acquistoCarrello($elementiCarrello){
            if(sizeof($elementiCarrello) === 0 ){
                $this->messaggio = "Carrello vuoto";
                return false;
            }
            $this->connessione->beginTransaction();
            $dati["totale"] = 0;
            $dati["prodotti"] = [];
            foreach($elementiCarrello as $indice => $elementoCarrello){
                $query = $this->connessione->prepare("
                    UPDATE vende
                    SET quantita_disponibile = quantita_disponibile - :quantita
                    WHERE codice_negozio = :codice_negozio AND codice_prodotto = :codice_prodotto
                        AND quantita_disponibile >= :quantita
                    RETURNING
                        prezzo_prodotto,
                        sconto_percentuale
                ");
                $query->execute($elementoCarrello);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il prodotto n. " .$indice+1 ." del tuo carrello non e' disponibile";
                    $this->connessione->rollBack();
                    return false;
                }
                $infoProdotto = $query->fetch();
                $prezzoProdotto = $infoProdotto["prezzo_prodotto"] - ($infoProdotto["prezzo_prodotto"] * ($infoProdotto["sconto_percentuale"]/100));
                $dati["totale"] += ($prezzoProdotto * $elementoCarrello["quantita"]);
                $dati["prodotti"][] = [
                    "codice_prodotto" => $elementoCarrello["codice_prodotto"],
                    "codice_negozio" => $elementoCarrello["codice_negozio"],
                    "prezzo_prodotto" => $prezzoProdotto,
                    "quantita_prodotto" => $elementoCarrello["quantita"]
                ];
            }
            $this->connessione->commit();
            return $dati;
        }
    }

?>