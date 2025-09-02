<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
    <link rel="stylesheet" href="/public/css/gestione.css">
</head>
<body>
    <div id="container" codice="<?php echo $codiceNegozio?>">
        <div class="header">
            <h1 class="title"><?php echo $negozio["indirizzo"]?></h1>
            <select id="prodotti">
            <?php foreach($prodotti as $prodotto):?>
                <option value="<?php echo $prodotto["codice"]?>"><?php echo $prodotto["nome"]?></option>
            <?php endforeach;?>
            </select>
            <button class="header-button" id="aggiungi">Aggiungi</button>
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
                    <input type="text" class="card-input" value="<?php echo $prodottoNegozio["prezzo_prodotto"]?>">
                </div>
                <div class="card-body">
                    <h3 class="card-title">Sconto</h3>
                    <input type="text" class="card-input" value="<?php echo $prodottoNegozio["sconto_percentuale"]?>">
                </div>
                <div class="card-body">
                    <h3 class="card-title">Quantità</h3>
                    <input type="text" class="card-input" value="<?php echo $prodottoNegozio["quantita_disponibile"]?>">
                </div>
                <div class="card-body">
                    <button type="button" class="card-button" azione="ordina">Ordina</button>
                    <input type="number" step="1" min ="1" class="card-input" >
                </div>
                <div class="card-body">
                    <button type="button" class="card-button" azione="salva">Salva</button>
                    <button type="button" class="card-button elimina" azione="elimina">Elimina</button>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</body>
<script src="/public/js/gestioneNegozio.js"></script>
</html>