<?php
    class Router{
        private $routes = [];

        public function get($percorso,$funzione,$funzioneAutenticazione = null){
            $metodo = "GET";
            $this->addRoute($metodo,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function post($percorso,$funzione,$funzioneAutenticazione = null){
            $metodo = "POST";
            $this->addRoute($metodo,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function put($percorso,$funzione,$funzioneAutenticazione = null){
            $metodo = "PUT";
            $this->addRoute($metodo,$percorso,$funzione,$funzioneAutenticazione);
        }

        public function delete($percorso,$funzione,$funzioneAutenticazione = null){
            $metodo = "DELETE";
            $this->addRoute($metodo,$percorso,$funzione,$funzioneAutenticazione);
        }

        private function addRoute($metodo,$percorso,$funzione,$funzioneAutenticazione = null){
            // controlla se la route definita ha argomenti obbligatori {arg}
            $regex = preg_replace("#\{[^/]+\}#","([^/]+)",$percorso);
            $regex = "#^{$regex}$#";
            $this->routes[] = [
                "metodo" => $metodo,
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
                if($metodo === $route["metodo"]){
                    if(preg_match($route["regex"],$richiesta,$parametri) || str_contains($route["regex"],"404")){
                        if($route["funzioneAutenticazione"] !== null){
                            $funzioneAutenticazione = array_shift($route["funzioneAutenticazione"]);
                            $funzioneAutenticazione(...$route["funzioneAutenticazione"]);
                        }
                        $parametri = array_slice($parametri,1);
                        $funzione = $route["funzione"];
                        $funzione(...$parametri);
                        exit();
                    }
                }
            }
        }
    }

?>