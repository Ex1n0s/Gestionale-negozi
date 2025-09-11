<?php
    class FornitoreModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        public function insertFornitore($valori){
            try {
                $query = $this->connessione->prepare("INSERT INTO fornitore(iva,indirizzo,cf_manager) 
                VALUES (:iva,:indirizzo,:cf_manager)");
                $query->execute($valori);
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["iva"])){
                        $this->messaggio = "Iva fornitore gia' presente";
                    } else {
                        $this->messaggio = "Indirizzo gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function selectFornitore($iva){
            $query = $this->connessione->prepare(" SELECT * FROM fornitore WHERE iva = ?");
            $query->execute([$iva]);
            $fornitore = $query->fetch();
            if(!$fornitore){
                $this->messaggio = "Il fornitore selezionato non esiste";
                return false;
            }
            return $fornitore;
        }

        public function selectFornitori($cf_manager = null){
            $query = "SELECT * FROM fornitore";
            if($cf_manager !== null){
                $query = $query . " WHERE cf_manager = ?";
            }
            $query = $this->connessione->prepare($query);
            if($cf_manager !== null){
                $query->execute([$cf_manager]);
            } else {
                $query->execute();
            }
            $fornitori = $query->fetchAll();
            return $fornitori;
        }

        public function updateFornitore($iva,$valori){
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE fornitore SET $set WHERE iva = :ivaFornitore";
                $valori["ivaFornitore"] = $iva;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "Il fornitore selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["iva"])){
                        $this->messaggio = "Iva gia' presente";
                    } else {
                        $this->messaggio = "Indirizzo gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function isManagerFornitore($ivaFornitore,$cfManager){
            $fornitore = $this->selectFornitore($ivaFornitore);
            if($fornitore !== false && $fornitore["cf_manager"] === $cfManager){
                return true;
            } 
            return false;
        }
    }

?>