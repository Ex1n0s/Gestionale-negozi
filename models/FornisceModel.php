<?php
    class FornisceModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertFornisce($valori){
            try {
                $risultato = $this->creaInsert($valori);
                $attributi = $risultato["attributi"];
                $placeHolder = $risultato["placeHolder"];
                $query = "INSERT INTO fornisce($attributi) VALUES ($placeHolder)";
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Prodotto gia' presente";
                    return false;
                } else if ($e->getCode() === "P0001"){
                    $this->messaggio = "Il fornitore e' chiuso";
                    return false;
                } else if ($e->getCode() === "23514"){
                    $this->messaggio = "E' stato inserito un valore non valido";
                    return false;
                }else {
                    throw new RuntimeException($e->getCode());
                }
            }
        }

        public function selectProdottoFornitore($codiceProdotto,$ivaFornitore){
            $query = $this->connessione->prepare("
                SELECT 
                    p.nome,
                    p.descrizione,
                    f.quantita_disponibile,
                    f.prezzo_prodotto,
                    f.codice_prodotto,
                    f.iva_fornitore
                FROM fornisce f JOIN prodotto p  ON p.codice = f.codice_prodotto 
                WHERE f.codice_prodotto = ? AND f.iva_fornitore = ?");
            $query->execute([$codiceProdotto,$ivaFornitore]);
            $record = $query->fetch();
            if(!$record){
                $this->messaggio = "Prodotto selezionato non trovato dal fornitore";
                return false;
            }
            return $record;
        }

        public function selectProdottiFornitore($ivaFornitore){
            $query = $this->connessione->prepare(" 
                SELECT 
                    p.nome,
                    p.descrizione,
                    f.quantita_disponibile,
                    f.prezzo_prodotto,
                    f.codice_prodotto,
                    f.iva_fornitore
                FROM fornisce f JOIN prodotto p  ON p.codice = f.codice_prodotto 
                WHERE f.iva_fornitore = ?");
            $query->execute([$ivaFornitore]);
            return $query->fetchAll();
        }

        public function deleteFornisce($ivaFornitore,$codiceProdotto){
            $query = $this->connessione->prepare("DELETE FROM fornisce WHERE codice_prodotto = ? AND iva_fornitore = ?");
            $query->execute([$codiceProdotto,$ivaFornitore]);
            if($query->rowCount() === 0){
                $this->messaggio = "Il prodotto selezionato non esiste dal fornitore";
                return false;
            }
            return true;
        }

        public function updateFornisce($ivaFornitore,$codiceProdotto,$valori){
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE fornisce SET $set WHERE iva_fornitore = :ivaFornitore AND codice_prodotto = :codiceProdotto";
                $valori["ivaFornitore"] = $ivaFornitore;
                $valori["codiceProdotto"] = $codiceProdotto;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il prodotto selezionato non esiste dal fornitore";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Il fornitore fornisce gia' questo prodotto";
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