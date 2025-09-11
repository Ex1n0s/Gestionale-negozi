    <div id="container">
        
        <div class="header">
            <h1 class="title">Negozi</h1>
            <button class="header-button" id="aggiungi">Aggiungi</button>
        </div>
        
        <div class="blur nascosto" ></div>
        <form class="form nascosto">
            <svg id="x" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="form-group">
                <label for="codice">Codice</label>
                <input type="text" class="form-input" id="codice">
            </div>
            <div class="form-group">
                <label for="nome">Indirizzo</label>
                <input type="text" class="form-input" id="indirizzo" >
            </div>
            <div class="form-group">
                <label for="descrizione">Responsabile</label>
                <input type="text" class="form-input" id="responsabile">
            </div>
            <button class="form-button" id="inserisci">Inserisci</button>
            <button class="form-button" id="salva">Salva</button>
        </form>
        <div class="card-deck"> 
            <?php 
            foreach ($negozi as $negozio): 
                $stato = "Aperto";
                if(!$negozio["attivo"]){
                    $stato = "Chiuso";
                }
            ?>
            <div class="card" id="<?php echo $negozio["codice"]?>">
                <h3 class="card-header"><?php echo $negozio["indirizzo"]?></h3>
                <div class="card-body">
                    <h3 class="card-title">Responsabile</h3>
                    <p class="card-text"><?php echo $negozio["responsabile"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Codice</h3>
                    <p class="card-text"><?php echo $negozio["codice"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Stato</h3>
                    <p class="card-text"><?php echo $stato?></p>
                </div>
                <div class="card-body">
                    <button type="button" class="card-button" azione="gestisci">Gestisci</button>
                    <button type="button" class="card-button" azione="modifica">Modifica</button>
                    <?php if($negozio["attivo"]):?>
                    <button type="button" class="card-button elimina" azione="chiudi" >Chiudi</button>
                    <?php else:?>
                    <button type="button" class="card-button" azione="apri" >Apri</button>
                    <?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</body>
<script src="/public/js/negozi.js"></script>
<script src="/public/js/gestioneForm.js"></script>
</html>