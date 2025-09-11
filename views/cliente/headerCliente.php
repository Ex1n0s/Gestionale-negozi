<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
    <?php if(!isset($fileCss)):?>
        <link rel="stylesheet" href="/public/css/base.css">
    <?php else:?>
        <link rel="stylesheet" href="/public/css/<?php echo $fileCss?>.css">
    <?php endif;?> 
</head>
<body>
    <nav>
        <a href="/cliente/negozi">Negozi</a>
  
        <a href="/cliente/carrello">Carrello</a>

        <a href="/cliente/fatture">Fatture</a>
          
        <a href="/utente/profilo">Profilo</a>
    </nav>