<?php
    class FatturaModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertFattura($datiFattura,$righeFattura){
            $this->connessione->beginTransaction();
            $query = $this->connessione->prepare("
                INSERT INTO fattura(totale,sconto_percentuale,cf_cliente)
                VALUES(:totale,:sconto_percentuale,:cf_cliente)
                RETURNING codice                
            ");
            $query->execute($datiFattura);
            $codice = $query->fetch()["codice"];
            foreach($righeFattura as $rigaFattura){
                $rigaFattura["codice_fattura"] = $codice; 
                $query = $this->connessione->prepare("
                    INSERT INTO riga_fattura(codice_fattura,quantita_prodotto,prezzo_prodotto,codice_prodotto,codice_negozio)
                    VALUES(:codice_fattura,:quantita_prodotto,:prezzo_prodotto,:codice_prodotto,:codice_negozio)               
                ");
                $query->execute($rigaFattura);
            }
            $this->connessione->commit();
            return true;
        }

        public function selectFatture($cf_cliente = null){
            $query = "SELECT * FROM fattura";
            if($cf_cliente !== null){
                $query = $query . " WHERE cf_cliente = ?";
            }
            $query = $this->connessione->prepare($query);
            if($cf_cliente !== null){
                $query->execute([$cf_cliente]);
            } else {
                $query->execute();
            }
            
            return $query->fetchAll();
        }

        public function selectFattura($codice_fattura){
            $query = $this->connessione->prepare("SELECT * FROM fattura WHERE codice = ?");
            $query->execute([$codice_fattura]);
            $fattura = $query->fetch();
            if(!$fattura){
                $this->messaggio = "La fattura selezionata non esiste";
                return false;
            }
            return $fattura;
        }

        public function selectRigheFattura($codice_fattura){
            $query = $this->connessione->prepare("
                SELECT 
                    p.nome as nome_prodotto,
                    n.indirizzo as indirizzo_negozio,
                    rf.quantita_prodotto,
                    rf.prezzo_prodotto,
                    (rf.quantita_prodotto * rf.prezzo_prodotto) as subtotale
                FROM riga_fattura rf JOIN prodotto p ON rf.codice_prodotto = p.codice
                    JOIN negozio n ON rf.codice_negozio = n.codice
                WHERE rf.codice_fattura = ?
            ");
            $query->execute([$codice_fattura]);
            return $query->fetchAll();
        }
    }
?>