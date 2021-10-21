<?php

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

$row = 1;
if (($file = fopen("logs.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
        for ($c = 0; $c < count($data); $c++) {
            echo $data[$c] . "<br />\n";
        }
        $row++;
    }
    fclose($file);
}

//Création des boutons
?>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title></title>
</head>

<body>
<a href='processlog.php?archiver'><input type='button' name='archive' value='archiver'></a>
<a href='processlog.php?vider'><input type='button' name='Vider_logs' value='vider_log'></a>
<a href='logout.php'><input type='submit' name='Déconnexion' value='Logout'></a>

</body>
</html>