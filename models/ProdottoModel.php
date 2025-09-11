<?php
    class ProdottoModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }
        public function insertProdotto($valori){
            try {
                $query = $this->connessione->prepare("INSERT INTO prodotto(codice,nome,descrizione) VALUES (:codice,:nome,:descrizione)");
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Codice prodotto gia' presente";
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function selectProdotto($codice){
            $query = $this->connessione->prepare(" SELECT * FROM prodotto WHERE codice = ?");
            $query->execute([$codice]);
            $prodotto = $query->fetch();
            if(!$prodotto){
                $this->messaggio = "Il prodotto selezionato non esiste";
                return false;
            }
            return $prodotto;
        }

        public function selectProdotti(){
            $query = $this->connessione->prepare("SELECT * FROM prodotto");
            $query->execute();
            $prodotti = $query->fetchAll();
            return $prodotti;
        }

        public function deleteProdotto($codice){
            try {
                $query = $this->connessione->prepare("DELETE FROM prodotto WHERE codice = ?");
                $query->execute([$codice]);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il prodotto selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23503"){
                    $this->messaggio = "Un proddotto utilizzato non puo' essere eliminato";
                    return false;
                } else{
                    throw new RuntimeException();
                }
            }
        }  

        public function updateProdotto($codice,$valori){
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE prodotto SET $set WHERE codice = :codiceProdotto";
                $valori["codiceProdotto"] = $codice;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il prodotto selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    $this->messaggio = "Codice gia' presente";
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }
    }

?>