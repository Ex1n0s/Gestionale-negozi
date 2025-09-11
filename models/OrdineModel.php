<?php
    class OrdineModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertOrdine($valori){
            try {
                $query = $this->connessione->prepare("INSERT INTO ordine(codice_negozio,codice_prodotto,quantita_prodotto) 
                VALUES (:codice_negozio,:codice_prodotto,:quantita_prodotto)");
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "P0001"){
                    $this->messaggio = "Prodotto non disponibile da nessun fornitore";
                    return false;
                } else if ($e->getCode() === "23514"){
                    $this->messaggio = "La quantità minima per un ordine e' 1";
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
            
        }

        public function selectOrdine($numero){
            $query = $this->connessione->prepare("
                SELECT 
                    o.numero,
                    o.quantita_prodotto,
                    o.prezzo_prodotto,
                    o.stato,
                    o.data_consegna,
                    o.iva_fornitore,
                    o.codice_negozio,
                    p.nome,
                    n.indirizzo
                FROM ordine o JOIN prodotto p ON o.codice_prodotto = p.codice
                    JOIN negozio n ON o.codice_negozio = n.codice
                WHERE o.numero = ?
            ");
            $query->execute([$numero]);
            $negozio = $query->fetch();
            if(!$negozio){
                $this->messaggio = "L'ordine selezionato non esiste";
                return false;
            }
            return $negozio;
        }

        public function selectOrdini($cf_manager = null){
            $query = "
                SELECT 
                    o.numero,
                    o.quantita_prodotto,
                    o.prezzo_prodotto,
                    o.stato,
                    o.data_consegna,
                    o.iva_fornitore,
                    o.codice_negozio,
                    p.nome,
                    n.indirizzo
                FROM ordine o JOIN prodotto p ON o.codice_prodotto = p.codice
                    JOIN negozio n ON o.codice_negozio = n.codice";
            if($cf_manager !== null){
                $query = $query . " WHERE n.cf_manager = ?";
            }
            $query = $this->connessione->prepare($query);
            if($cf_manager === null){
                $query->execute();
            } else {
                $query->execute([$cf_manager]);
            }
            
            $ordini = $query->fetchAll();
            return $ordini;
        }

        public function updateOrdine($numeroOrdine,$valori){ 
            $set = $this->creaSetUpdate($valori);
            $query = "UPDATE ordine SET $set WHERE numero = :numeroOrdine";
            $valori["numeroOrdine"] = $numeroOrdine;
            $query = $this->connessione->prepare($query);
            $query->execute($valori);
            if($query->rowCount() === 0){
                $this->messaggio = "L'ordine selezionato non esiste";
                return false;
            }
            return true;
        }
    }

?>