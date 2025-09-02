<div id="container">
    
    <div class="header">
        <h1 class="title">Fatture acquisti</h1>
    </div>
    <div class="card-deck"> 
        <?php foreach ($fatture as $fattura):?>
        <div class="card" id="<?php echo $fattura["codice"]?>">
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
            <button type="button" class="card-button" azione="dettagli">Dettagli</button>
        </div>
        <?php endforeach;?>
    </div>
</div>
</body>
<script src="/public/js/fatture.js"></script>
</html>