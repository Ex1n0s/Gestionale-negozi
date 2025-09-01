<div id="container">
    
     <div class="header">
        <h1 class="title">Ordini per i tuoi negozi</h1>
    </div>
    <div class="card-deck"> 
        <?php foreach ($ordini as $ordine):?>
        <div class="card" id="<?php echo $ordine["numero"]?>">
            <h3 class="card-header">N. <?php echo $ordine["numero"]?></h3>
            <div class="card-body">
                <h3 class="card-title">Prodotto</h3>
                <p class="card-text"><?php echo $ordine["nome"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Quantità</h3>
                <p class="card-text"><?php echo $ordine["quantita_prodotto"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Prezzo prodotto</h3>
                <p class="card-text"><?php echo $ordine["prezzo_prodotto"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Indirizzo negozio</h3>
                <p class="card-text"><?php echo $ordine["indirizzo"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Iva fornitore</h3>
                <p class="card-text"><?php echo $ordine["iva_fornitore"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Stato</h3>
                <p class="card-text"><?php echo $ordine["stato"]?></p>
            </div>
            <?php if($ordine["stato"] === "consegnato"):?>
            <div class="card-body">
                <h3 class="card-title">Data consegna</h3>
                <p class="card-text"><?php echo $ordine["data_consegna"]?></p>
            </div>
            <?php elseif($ordine["stato"] === "confermato"):?>
            <div class="card-body">
                <button type="button" class="card-button" azione="consegna">Conferma consegna</button>
                <button type="button" class="card-button elimina" azione="annulla" >Annulla ordine</button>
            </div>
            <?php endif;?>
        </div>
        <?php endforeach;?>
    </div>
</div>
</body>

<script src="/public/js/ordini.js"></script>
</html>