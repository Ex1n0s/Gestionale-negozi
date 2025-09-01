    <div id="container">
        
        <div class="header">
            <h1 class="title">Seleziona negozio</h1>
        </div>
        <div class="card-deck"> 
            <?php foreach ($negozi as $negozio): ?>
            <?php if($negozio["attivo"]):?>
            <div class="card" id="<?php echo $negozio["codice"]?>">
                <h3 class="card-header"><?php echo $negozio["indirizzo"]?></h3>
                <div class="card-body">
                    <h3 class="card-title">Responsabile</h3>
                    <p class="card-text"><?php echo $negozio["responsabile"]?></p>
                </div>
                <div class="card-body">
                    <button type="button" class="card-button" azione="apri">Apri</button>
                </div>
            </div>
            <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</body>
<script src="/public/js/negoziCliente.js"></script>
</html>