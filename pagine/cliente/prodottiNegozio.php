    <div id="container" codice="<?php echo $codiceNegozio?>">
        <div class="header">
            <h1 class="title"><?php echo $negozio["indirizzo"]?></h1>
        </div>
        <div class="card-deck"> 
            <?php foreach($prodottiNegozio as $prodottoNegozio):?>
            <div class="card" id="<?php echo $prodottoNegozio["codice_prodotto"]?>">
                <h3 class="card-header"><?php echo $prodottoNegozio["nome"]?></h3>
                <div class="card-body">
                    <h3 class="card-title">Descrizione</h3>
                    <p class="card-text"><?php echo $prodottoNegozio["descrizione"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Prezzo</h3>
                    <p class="card-text"><?php echo $prodottoNegozio["prezzo_prodotto"] . " €"?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Sconto</h3>
                    <p class="card-text"><?php echo $prodottoNegozio["sconto_percentuale"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Quantità disponibile</h3>
                    <p class="card-text"><?php echo $prodottoNegozio["quantita_disponibile"]?></p>
                </div>
                
                <button type="button" class="card-button" azione="aggiungi">Aggiungi al carrello</button>
                <input type="number" step="1" min ="1" class="card-input" value = "1">
                
            </div>
            <?php endforeach;?>
        </div>
    </div>
</body>
<script src="/public/js/prodottiNegozio.js"></script>
</html>