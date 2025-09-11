<?php
    abstract class AbstractModel{
        protected $connessione;
        protected $messaggio;

        public function __construct(PDO $connessione){
            $this->connessione = $connessione;
            $this->messaggio = "";
        }

        public function getMessaggio(){
            return $this->messaggio;
        }

        protected function creaInsert($valori){
            $placeHolder = [];
            $nomiAttributi = array_keys($valori);
            foreach ($nomiAttributi as $nomeAttributo) {
                $placeHolder[] = ":$nomeAttributo";
                $attributi[] = $nomeAttributo;
            }
            $risultato["attributi"] = implode(",",$attributi);
            $risultato["placeHolder"] = implode(",",$placeHolder);
            return $risultato;
        }

        protected function creaSetUpdate($valori){
            $set = [];
            $nomiAttributi = array_keys($valori);
            foreach ($nomiAttributi as $nomeAttributo) {
                $set[] = "$nomeAttributo = :$nomeAttributo";
            }
            return implode(",",$set);
        }
    }
?>