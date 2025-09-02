<div id="container">

    <div class="header">
        <h1 class="title">Profilo utente</h1>
    </div>
    <div class="card-deck">
        <div class="card">
            <h2 class="card-header">Informazioni personali</h3>
            <div class="card-body">
                <h3 class="card-title">Codice fiscale</h3>
                <p class="card-text"><?php echo $utente["cf"] ?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Nome</h3>
                <p class="card-text"><?php echo $utente["nome"] ?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Cognome</h3>
                <p class="card-text"><?php echo $utente["cognome"] ?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Email</h3>
                <p class="card-text"><?php echo $utente["email"] ?></p>
            </div>
            <?php if($_SESSION["ruolo"] === "manager"):?>
            <div class="card-body">
                <h3 class="card-title">Data assunzione</h3>
                <p class="card-text"><?php echo $utente["data_assunzione"] ?></p>
            </div>
            <?php endif;?>
            <button class="card-button" id="logout">Logout</button>
        </div>
        <?php if($_SESSION["ruolo"] === "cliente" && $tessera !== false):?>
        <div class="card">
            <h2 class="card-header">Tessera fedeltà</h3>
            <div class="card-body">
                <h3 class="card-title">Numero</h3>
                <p class="card-text"><?php echo $tessera["numero"] ?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Punti</h3>
                <p class="card-text"><?php echo $tessera["punti"] ?></p>
            </div>
        </div>  
        <?php endif;?>
        <div class="card">
            <h2 class="card-header">Credenziali</h3>
            <div class="card-body">
                <h3 class="card-title">Password corrente</h3>
                <input type="password" class="card-input" id="old">
            </div>
            <div class="card-body">
                <h3 class="card-title">Password nuova</h3>
                <input type="password" class="card-input" id="new" >
            </div>
            <button class="card-button" id="salva">Salva modifiche</button>
        </div>
    </div>
</div>
</body>
<script src="/public/js/profilo.js"></script>
</html>