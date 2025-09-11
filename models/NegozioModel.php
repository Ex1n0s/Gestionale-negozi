<?php
    class NegozioModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertNegozio($valori){
            try {
                $query = $this->connessione->prepare("INSERT INTO negozio(codice,indirizzo,responsabile,cf_manager) 
                VALUES (:codice,:indirizzo,:responsabile,:cf_manager)");
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["codice"])){
                        $this->messaggio = "Codice negozio gia' presente";
                    } else {
                        $this->messaggio = "Indirizzo gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function selectNegozio($codice){
            $query = $this->connessione->prepare(" SELECT * FROM negozio WHERE codice = ?");
            $query->execute([$codice]);
            $negozio = $query->fetch();
            if(!$negozio){
                $this->messaggio = "Il negozio selezionato non esiste";
                return false;
            }
            return $negozio;
        }

        public function selectNegozi($cf_manager = null){
            $query = "SELECT * FROM negozio";
            if($cf_manager !== null){
                $query = $query . " WHERE cf_manager = ?";
            }
            $query = $this->connessione->prepare($query);
            if($cf_manager !== null){
                $query->execute([$cf_manager]);
            } else {
                $query->execute();
            }
            $negozi = $query->fetchAll();
            return $negozi;
        }

        public function updateNegozio($codice,$valori){
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE negozio SET $set WHERE codice = :codiceNegozio";
                $valori["codiceNegozio"] = $codice;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il negozio selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["codice"])){
                        $this->messaggio = "Codice gia' presente";
                    } else {
                        $this->messaggio = "Indirizzo gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function isManagerNegozio($codiceNegozio,$cfManager){
            $negozio = $this->selectNegozio($codiceNegozio);
            if($negozio !== false && $negozio["cf_manager"] === $cfManager){
                return true;
            } 
            return false;
        }
    }

?>