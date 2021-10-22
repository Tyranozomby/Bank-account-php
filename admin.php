<?php

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}


?>

<html lang="fr">
<meta charset="utf-8">

<head>
    <link rel="stylesheet" href="style.css"/>
    <style>
        button{
            width:200px;
        }
        table{
            color: white;
            border-radius: 20px;
            border-collapse: separate;
            overflow: hidden;
            border-spacing: 0;
        }
        

        </style>
    <title></title>
</head>

<body>

    <?php
if (file_exists("logs.csv") &&($file = fopen("logs.csv", "r")) !== FALSE) {
    echo "<table border ='1' cellpading='4' cellspacing ='4'>";
    echo "<tr><th>Ip</th> <th>Date</th><th>Montant</th><th>Capital</th><th>Nombre De Mois</th><th>Taux</th></tr>";

    fgetcsv($file, 1000, ";");
    echo "<tr>";
    while ($data = fgetcsv($file, 1000, ";")) {
        $date = date_create();
        date_timestamp_set($date, intval($data[1]));
        echo "<td>$data[0]</td>";
        echo "<td>" . date_format($date, 'Y-m-d H:i:s') . "</td>";
        echo "<td>$data[2]</td>
        <td>$data[3]</td>
        <td>$data[4]</td>";
        echo "<td>" . number_format($data[5], 2) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    fclose($file);
}

//Création des boutons
?>
<br/>
<div class="listeboutons" style="margin: 5;">
    <div class="inputs">
    <a href='processlog.php?archiver'><button >Archiver les logs</button></a> <br/>
    <a href='processlog.php?vider'><button>Vider les logs</button></a><br/>
    <a href='logout.php'><button>Déconnexion</button></a><br/>
    </div>
</div>

</body>

</html>