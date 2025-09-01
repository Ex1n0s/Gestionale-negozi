<div id="container">
    
    <div class="header">
        <h1 class="title">Dettagli fattura</h1>
    </div>
    <div class="card-deck"> 
        <div class="card">
            <h3 class="card-header"><?php echo $fattura["codice"]?></h3>
            <div class="card-body">
                <h3 class="card-title">Totale</h3>
                <p class="card-text"><?php echo $fattura["totale"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Sconto</h3>
                <p class="card-text"><?php echo $fattura["sconto_percentuale"] . " %"?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Data</h3>
                <p class="card-text"><?php echo $fattura["data"]?></p>
            </div>
        </div>
        <?php foreach ($righeFattura as $rigaFattura):?>
        <div class="card">
            <h3 class="card-header"><?php echo $rigaFattura["nome_prodotto"]?></h3>
            <div class="card-body">
                <h3 class="card-title">Subtotale</h3>
                <p class="card-text"><?php echo $rigaFattura["subtotale"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Indirizzo negozio</h3>
                <p class="card-text"><?php echo $rigaFattura["indirizzo_negozio"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Prezzo</h3>
                <p class="card-text"><?php echo $rigaFattura["prezzo_prodotto"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Quantità</h3>
                <p class="card-text"><?php echo $rigaFattura["quantita_prodotto"]?></p>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
</body>
</html>