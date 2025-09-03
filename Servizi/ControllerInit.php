<?php
    class ControllerInit{
        static private $connessione;
        
        public static function setConnessione(PDO $connessione){
            self::$connessione = $connessione;
        }

        public static function getConnessione(){
            return self::$connessione;
        }

        public static function getIstanza($nomeClasse){
            $reflection = new ReflectionClass($nomeClasse);
            
            $costruttore = $reflection->getConstructor();

            //if null la classe non ha parametri nel costruttore
            if($costruttore === null){
                return new $nomeClasse();
            }

            $parametriClasse = $costruttore->getParameters();
            $argomentiClasse = [];

            foreach ($parametriClasse as $parametroClasse) {
                $tipo = $parametroClasse -> getType();

                if ($tipo->getName() === "PDO"){
                    $argomentiClasse[] = self::$connessione; 
                } else {
                    $argomentiClasse[] = self::getIstanza($tipo->getName());
                }
            }
            return new $nomeClasse(...$argomentiClasse);
        }
    }
?>
