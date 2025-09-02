<div id="container">
    
     <div class="header">
        <h1 class="title">Prodotti</h1>
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
            <label for="nome">Nome</label>
            <input type="text" class="form-input" id="nome" >
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea  class="form-input" id="descrizione"></textarea>
        </div>
        <button class="form-button" id="inserisci">Inserisci</button>
        <button class="form-button" id="salva">Salva</button>
    </form>
    <div class="card-deck"> 
        <?php foreach ($prodotti as $prodotto):?>
        <div class="card" id="<?php echo $prodotto["codice"]?>">
            <h3 class="card-header"><?php echo $prodotto["nome"]?></h3>
            <div class="card-body">
                <h3 class="card-title">Codice</h3>
                <p class="card-text"><?php echo $prodotto["codice"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Descrizione</h3>
                <p class="card-text"><?php echo $prodotto["descrizione"]?></p>
            </div>
            <div class="card-body">
                <button type="button" class="card-button" azione="modifica">Modifica</button>
                <button type="button" class="card-button elimina" azione="elimina" >Elimina</button>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
</body>
<script src="/public/js/prodotti.js"></script>
<script src="/public/js/gestioneForm.js"></script>
</html>
