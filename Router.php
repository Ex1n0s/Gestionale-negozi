<?php
    class Router{
        private $routes = [];

        public function all($percorso,$funzione,$funzioneAutenticazione = null){
            $metodi = ["GET","POST","PUT","DELETE"];
            $this->addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function get($percorso,$funzione,$funzioneAutenticazione = null){
            $metodi = ["GET"];
            $this->addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function post($percorso,$funzione,$funzioneAutenticazione = null){
            $metodi = ["POST"];
            $this->addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function put($percorso,$funzione,$funzioneAutenticazione = null){
            $metodi = ["PUT"];
            $this->addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function delete($percorso,$funzione,$funzioneAutenticazione = null){
            $metodi = ["DELETE"];
            $this->addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione);
        }

        private function addRoute($metodi,$percorso,$funzione,$funzioneAutenticazione = null){
            // controlla se la route definita accetta argomenti opzionali {arg?}
            $regex = preg_replace("#\{([^/]+)\?\}#","?([^/]+)?",$percorso);
            // controlla se la route definita ha argomenti obbligatori {arg}
            $regex = preg_replace("#\{[^/]+\}#","([^/]+)",$regex);
            $regex = "#^{$regex}$#";
            $this->routes[] = [
                "metodi" => $metodi,
                "regex" => $regex,
                "funzione" => $funzione,
                "funzioneAutenticazione" => $funzioneAutenticazione
            ];
        }

        public function eseguiFunzione(){
            $richiesta = $_SERVER["REQUEST_URI"];
            $richiesta = strtok($richiesta ,"?");
            $richiesta = str_replace("/index.php","",$richiesta);
            $richiesta = rtrim($richiesta,"/");
            $richiesta = empty($richiesta) ? "/" : $richiesta;

            $metodo = $_SERVER["REQUEST_METHOD"];
            foreach ($this->routes as $route) {
                if(in_array($metodo,$route["metodi"])){
                    if(preg_match($route["regex"],$richiesta,$parametri)){
                        if($route["funzioneAutenticazione"] !== null){
                            $funzioneAutenticazione = $route["funzioneAutenticazione"];
                            $funzioneAutenticazione();
                        }
                        $parametri = array_slice($parametri,1);
                        if(sizeof($route["metodi"]) !== 1){
                            $parametri = [$metodo,...$parametri];
                        }
                        $funzione = $route["funzione"];
                        $funzione(...$parametri);
                        exit();
                    }
                }
            }
        }
    }

?>