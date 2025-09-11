<div id="container">
    <div class="header">
        <h1 class="title">Clienti</h1>
        <button class="header-button" id="aggiungi">Aggiungi</button>
    </div>
    <div class="blur nascosto" ></div>
    <form class="form nascosto">
        <svg id="x" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-input" id="nome">
        </div>
        <div class="form-group ">
            <label for="cognome">Cognome</label>
            <input type="text" class="form-input" id="cognome" >
        </div>
        <div class="form-group">
            <label for="cf">Codice fiscale</label>
            <input type="text" class="form-input" id="cf">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-input" id="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-input" id="password">
        </div>
        <button class="form-button" id="inserisci">Inserisci</button>
        <button class="form-button" id="salva">Salva</button>
    </form>
    <div class="card-deck"> 
        <?php foreach ($clienti as $cliente):?>
        <div class="card" id="<?php echo $cliente["cf"]?>">
            <h3 class="card-header"><?php echo $cliente["nome"]. " " . $cliente["cognome"]?></h3>
            <div class="card-body">
                <h3 class="card-title">Codice fiscale</h3>
                <p class="card-text"><?php echo $cliente["cf"]?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Email</h3>
                <p class="card-text"><?php echo $cliente["email"]?></p>
            </div>
            <div class="card-body">
                <button type="button" class="card-button" azione="modifica">Modifica</button>
                <button type="button" class="card-button elimina" azione="elimina" >Elimina</button>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<script src="/public/js/clienti.js"></script>
<script src="/public/js/gestioneForm.js"></script>
</body>
</html>
