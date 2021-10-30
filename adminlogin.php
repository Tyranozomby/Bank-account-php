<!doctype html>
<html lang="fr">
<meta charset="utf-8"/>
<link rel="icon" type="image/png" href="icones/login.png" />
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<div>
    <h1>Bienvenue</h1>

    <?php

    switch ($_GET['stat'] ?? "0") {

        case "1":
            echo "<p class='info error'>Erreur identifiant</p>";
            break;
        case "2":
            echo "<p class='info success'>Déconnecté</p>";
            break;
    }
    ?>

    <form action='dologin.php' method='post' class="box">
        <div class="form-group">
            <div class="labels">
                <label for="login">Login</label>
                <label for="password">Password</label>
            </div>

            <div class="inputs">
                <input type='text' id="login" name='login' autocomplete="false" required>
                <input type='password' id="password" name='password' required>
            </div>
        </div>
        <br/>
        <button type='submit'>Connexion</button>
    </form>
</div>
</body>
</html>


