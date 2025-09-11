<?php
    class UtenteModel extends AbstractModel{

        public function __construct(PDO $connessione){
            parent::__construct($connessione);
        }

        //Tutti gli utenti inseriti di base hanno il ruolo di cliente
        public function insertUtente($valori){
            $valori["password"] = password_hash($valori["password"],PASSWORD_DEFAULT);
            try {
                if(!$this->selectUtente($valori["cf"])){
                    $query = $this->connessione->prepare("INSERT INTO utente(cf,nome,cognome,email,password) 
                        VALUES (:cf,:nome,:cognome,:email,:password)");
                    $query->execute($valori);
                }
                $query = $this->connessione->prepare("INSERT INTO cliente(cf_utente) VALUES (:cf)");
                $query->bindValue(":cf",$valori["cf"]);
                $query->execute();
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["cf"])){
                        $this->messaggio = "Codice fiscale gia' presente";
                    } else {
                        $this->messaggio = "Email gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }

        public function updateUtente($codiceFiscale,$valori){
            if(!empty($valori["password"])){
                $valori["password"] = password_hash($valori["password"],PASSWORD_DEFAULT);
            }
            try{  
                $set = $this->creaSetUpdate($valori);
                $query = "UPDATE utente SET $set WHERE cf = :utente";
                $valori["utente"] = $codiceFiscale;
                $query = $this->connessione->prepare($query);
                $query->execute($valori);
                if($query->rowCount() === 0){
                    $this->messaggio = "L'utente selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23505"){
                    if(str_contains($e->getMessage(),$valori["cf"])){
                        $this->messaggio = "Codice fiscale gia' presente";
                    } else {
                        $this->messaggio = "Email gia' presente";
                    }
                    return false;
                } else {
                    throw new RuntimeException();
                }
            }
        }
        
        // Non e' necessario selezionare un ruolo.
        // Se non viene inserito un ruolo o un ruolo non esistente la select viene fatta solo nella tabella utente.
        public function selectUtente($codiceFiscale,$ruolo = "",$includiPassword = false){
            $attributi = $this->creaAttributiSelect($ruolo,$includiPassword);
            $join = $this->creaJoin($ruolo);
            $queryRuolo = " SELECT $attributi FROM utente u $join WHERE cf = ?";
            $query = $this->connessione->prepare($queryRuolo);
            $query->execute([$codiceFiscale]);
            $cliente = $query->fetch();
            if(!$cliente){
                $this->messaggio = "L'utente selezionato non esiste";
                return false;
            }
            return $cliente;
        }
        
        private function creaAttributiSelect($ruolo,$includiPassword){
            $attributi = "u.nome,u.cognome,u.cf,u.email";
            if($includiPassword){
                $attributi = $attributi . ",u.password";
            }
            if($ruolo === "manager"){
                $attributi = $attributi . ",m.data_assunzione";
            }
            return $attributi;
        }

        private function creaJoin($ruolo){
            switch($ruolo){
                case "cliente":
                    return "JOIN cliente c ON u.cf = c.cf_utente";
                case "manager":
                    return "JOIN manager m ON u.cf = m.cf_utente";
                default:
                    return "";
            }
        }

        // Non e' necessario selezionare un ruolo.
        // Se non viene inserito un ruolo o un ruolo non esistente la select viene fatta solo nella tabella utente.
        public function selectUtenti($ruolo = "",$includiPassword = false){
            $attributi = $this->creaAttributiSelect($ruolo,$includiPassword);
            $join = $this->creaJoin($ruolo);
            $queryRuolo = "SELECT $attributi FROM utente u $join";
            $query = $this->connessione->prepare($queryRuolo);
            $query->execute();
            $clienti = $query->fetchAll();
            return $clienti;
        }

        public function deleteUtente($codiceFiscale){
            try {
                $query = $this->connessione->prepare("DELETE FROM utente WHERE cf = ?");
                $query->execute([$codiceFiscale]);
                if($query->rowCount() === 0){
                    $this->messaggio = "L'utente selezionato non esiste";
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                if($e->getCode() === "23503"){
                    $this->messaggio = "Un utente che e' un manager attivo non puo' essere eliminato";
                    return false;
                } else{
                    throw new RuntimeException();
                }
            }
        }  

        public function selectTesseraCliente($cf_cliente){
            $query = $this->connessione->prepare("SELECT * FROM tessera_fedelta WHERE cf_cliente = ?");
            $query->execute([$cf_cliente]);
            $tessera = $query->fetch();
            if(!$tessera){
                $this->messaggio = "L'utente selezionato non possiede una tessera";
                return false;
            }
            return $tessera;
        }

        public function scontiDisponibiliCliente($codiceFiscale){
            $query = $this->connessione->prepare("SELECT * FROM sconti_disponibili(?)");
            $query->execute([$codiceFiscale]);
            $sconti = $query->fetchAll();
            return $sconti;
        }
    }

?>