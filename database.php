<?php
    define("HOST","localhost");
    define("PORT","5432");
    define("DBNAME","negozi");
    define("USER","simone");
    define("PASSWORD","204810");
    $stringa = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s",
        HOST,
        PORT,
        DBNAME,
        USER,
        PASSWORD
    );
    try {
        $connessione = new PDO($stringa);
        $connessione->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $connessione->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        http_response_code(500);
        exit();
    }
?>