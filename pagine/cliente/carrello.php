    <div id="container">
        <div class="header">
            <h1 class="title">Totale</h1>
            <p><?php echo $totale . " €"?></p>
            <select id="sconti">
                <option value="0">0%</option>
                <?php foreach($sconti as $sconto):?>
                    <option value="<?php echo $sconto["sconto_percentuale"]?>"><?php echo $sconto["sconto_percentuale"] . "%"?></option>
                <?php endforeach;?>
            </select>
            <button class="header-button" id="acquista">Acquista</button>
        </div>
        <div class="card-deck"> 
            <?php foreach($prodotti as $indice => $prodotto):?>
            <div class="card" id="<?php echo $indice?>">
                <h3 class="card-header"><?php echo $prodotto["nome"]?></h3>
                <div class="card-body">
                    <h3 class="card-title">Descrizione</h3>
                    <p class="card-text"><?php echo $prodotto["descrizione"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Negozio</h3>
                    <p class="card-text"><?php echo $prodotto["indirizzo_negozio"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Prezzo</h3>
                    <p class="card-text prezzo"><?php echo $prodotto["prezzo"] . " €"?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Sconto</h3>
                    <p class="card-text"><?php echo $prodotto["sconto"]?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Quantità</h3>
                    <p class="card-text quantita"><?php echo $prodotto["quantita"]?></p>
                </div>
                <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="icona" azione="decrementa">
                        <line x1="6" y1="12" x2="18" y2="12" stroke="#292929" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="icona" azione="elimina">
                        <line x1="7" y1="8" x2="17" y2="8" stroke="#292929" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="9" y1="6" x2="15" y2="6" stroke="#292929" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M8 8 L9 18 L15 18 L16 8" fill="none" stroke="#292929" stroke-width="1.5" stroke-linejoin="round"/>
                        <line x1="10" y1="10" x2="10" y2="16" stroke="#292929" stroke-width="1" stroke-linecap="round"/>
                        <line x1="14" y1="10" x2="14" y2="16" stroke="#292929" stroke-width="1" stroke-linecap="round"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="icona" azione="incrementa">
                        <line x1="6" y1="12" x2="18" y2="12" stroke="#292929" stroke-width="2" stroke-linecap="round"/>
                        <line x1="12" y1="6" x2="12" y2="18" stroke="#292929" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                
            </div>
            <?php endforeach;?>

        </div>
    </div>
</body>
<script src="/public/js/carrello.js"></script>
</html>