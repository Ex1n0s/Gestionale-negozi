<?php
    class VendeModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertVende($valori){
            try {
                $risultato = $this->creaInsert($valori);
                $attributi = $risultato["attributi"];
                $placeHolder = $risultato["placeHolder"];
                $query = "INSERT INTO vende($attributi) VALUES ($placeHolder)";
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Prodotto gia' presente";
                    return false;
                } else if ($e->getCode() === "P0001"){
                    $this->messaggio = "Il negozio e' chiuso";
                    return false;
                } else if ($e->getCode() === "23514"){
                    $this->messaggio = "E' stato inserito un valore non valido";
                    return false;
                } else {
                    throw new RuntimeException($e->getCode());
                }
            }
        }

        public function selectProdottoNegozio($codiceProdotto,$codiceNegozio){
            $query = $this->connessione->prepare("
                SELECT 
                    p.nome,
                    p.descrizione,
                    v.quantita_disponibile,
                    v.prezzo_prodotto,
                    v.sconto_percentuale,
                    v.codice_prodotto,
                    v.codice_negozio
                FROM vende v JOIN prodotto p  ON p.codice = v.codice_prodotto 
                WHERE v.codice_prodotto = ? AND v.codice_negozio = ?");
            $query->execute([$codiceProdotto,$codiceNegozio]);
            $record = $query->fetch();
            if(!$record){
                $this->messaggio = "Prodotto in vendita selezionato non trovato";
                return false;
            }
            return $record;
        }

        public function selectProdottiNegozio($codiceNegozio){
            $query = $this->connessione->prepare(" 
                SELECT 
                    p.nome,
                    p.descrizione,
                    v.quantita_disponibile,
                    v.prezzo_prodotto,
                    v.sconto_percentuale,
                    v.codice_prodotto,
                    v.codice_negozio
                FROM vende v JOIN prodotto p  ON p.codice = v.codice_prodotto 
                WHERE v.codice_negozio = ?");
            $query->execute([$codiceNegozio]);
            return $query->fetchAll();
        }

        public function deleteVende($codiceNegozio,$codiceProdotto){
            $query = $this->connessione->prepare("DELETE FROM vende WHERE codice_prodotto = ? AND codice_negozio = ?");
            $query->execute([$codiceProdotto,$codiceNegozio]);
            if($query->rowCount() === 0){
                $this->messaggio = "Il prodotto in vendita selezionato non esiste";
                return false;
            }
            return true;
        }


        public function updateVende($codiceNegozio,$codiceProdotto,$valori){
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE vende SET $set WHERE codice_negozio = :codiceNegozio AND codice_prodotto = :codiceProdotto";
                $valori["codiceNegozio"] = $codiceNegozio;
                $valori["codiceProdotto"] = $codiceProdotto;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "Prodotto in vendita selezionato non trovato";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Il negozio vende gia' questo prodotto";
                    return false;
                } else if ($e->getCode() === "23514"){
                    $this->messaggio = "E' stato inserito un valore non valido";
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }
    }

?>