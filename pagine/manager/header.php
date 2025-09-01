<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
    <?php if(!isset($fileCss)):?>
        <link rel="stylesheet" href="/public/css/base.css">
    <?php else:?>
        <link rel="stylesheet" href="/public/css/<?php echo $fileCss?>.css">
    <?php endif;?> 
</head>
<body>
    <nav>
        <a href="/manager/negozi">Negozi</a>
  
        <a href="/manager/clienti">Clienti</a>
            
        <a href="/manager/fornitori">Fornitori</a>
            
        <a href="/manager/prodotti">Prodotti</a>
            
        <a href="/manager/ordini">Ordini</a>
          
        <a href="/utente/profilo">Profilo</a>
    </nav>