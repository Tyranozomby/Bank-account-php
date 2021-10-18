<!doctype html>
<html lang="fr">
<meta charset="utf-8"/>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<div>
    <h1>Bienvenue</h1>

    <?php
    if (isset($_GET['id'])) {
        switch ($_GET['id']) {
            case "1":
                echo "<p class='info' style='color: red'>Erreur identifiant</p>";
                break;
            case "2":
                echo "<p class='info' style='color: blue'>Connectez-vous</p>";
                break;
            case "3":
                echo "<p class='info' style='color: green'>Déconnecté</p>";
                break;
            case "4":
                echo "<p class='info' style='color: black'>Impossible de se reconnecter sur cette page </p>";
                break;
        }
    }
    ?>

    <form action='dologin.php' method='post'>
        <div class="form-group">
            <div class="labels">
                <label for="login">Login</label>
                <label for="password">Password</label>
            </div>

            <div class="inputs">
                <input type='text' id="login" name='login' required>
                <input type='password' id="password" name='password' required>
            </div>
        </div>
        <br/>
        <button type='submit'>Connexion</button>
    </form>

</div>
</body>

</html>


