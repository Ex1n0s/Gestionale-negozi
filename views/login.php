<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/login.css">
</head>
<body>
    <form class="form">
        <button class="form-button" id="ruolo">Cliente</button>
        <div class="form-group">
            <label for="cf">Codice fiscale</label>
            <input type="text" class="form-input" id="cf">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-input" id="password" >
        </div>
        <button class="form-button" id="login">Login</button>
    </form>
    <div id="result"></div>
    <script src="/public/js/login.js"></script>
</body>
</html>
