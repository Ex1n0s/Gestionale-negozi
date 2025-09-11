    <div id="container">
        
        <div class="header">
            <h1 class="title">Fornitori</h1>
            <button class="header-button" id="aggiungi">Aggiungi</button>
        </div>
        
        <div class="blur nascosto" ></div>
        <form class="form nascosto">
            <svg id="x" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="form-group">
                <label for="iva">Iva</label>
                <input type="text" class="form-input" id="iva">
            </div>
            <div class="form-group">
                <label for="indirizzo">Indirizzo</label>
                <input type="text" class="form-input" id="indirizzo" >
            </div>
            <button class="form-button" id="inserisci">Inserisci</button>
            <button class="form-button" id="salva">Salva</button>
        </form>
        <div class="card-deck"> 
            <?php 
            foreach ($fornitori as $fornitore): 
                $stato = "Aperto";
                if(!$fornitore["attivo"]){
                    $stato = "Chiuso";
                }
            ?>
            <div class="card" id="<?php echo $fornitore["iva"]?>">
                <h3 class="card-header"><?php echo $fornitore["indirizzo"]?></h3>
                <div class="card-body">
                    <h3 class="card-title">Iva</h3>
                    <p class="card-text"><?php echo $fornitore["iva"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Stato</h3>
                    <p class="card-text"><?php echo $stato?></p>
                </div>
                <div class="card-body">
                    <button type="button" class="card-button" azione="gestisci">Gestisci</button>
                    <button type="button" class="card-button" azione="modifica">Modifica</button>
                    <?php if($fornitore["attivo"]):?>
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
<script src="/public/js/fornitori.js"></script>
<script src="/public/js/gestioneForm.js"></script>
</html>