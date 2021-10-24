<?php

require_once "logmanagement.php";

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

$archives = array_diff(scandir("archives"), array('.', '..'));
$selected = "logs.csv";

if (isset($_GET["archive"])) {
    $selected = $_GET["archive"];
}


?>
<!doctype html>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        body{
            padding: 0;
            flex-direction: column;
            align-items: center;
        }
        button {
            width: 200px;
            margin: 5px;
        }

        .box {
            padding: 1%;
            width: fit-content;
            display: flex;
            flex-direction: row;

            height: fit-content;
            margin: 2% 2% 5%;

        }
        table{
            background-color: rgba(0, 0, 0, 0.35);
        }
    </style>
</head>

<body style="padding: 9rem 0 3rem 0">
<?php
if (!file_exists("archives") and !is_dir("archives")) {
    mkdir("archives");
    $f = fopen("archives/logs.csv", 'w');
    $titres = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");
    fputcsv($f, $titres, ";");
    fclose($f);
}

if (file_exists("archives/$selected") && ($file = fopen("archives/$selected", "r")) !== FALSE) {

    echo "<table>";
    echo "<thead><tr><th>Ip</th><th>Date</th><th>Montant</th><th>Capital</th><th>Nombre De Mois</th><th>Taux</th></thead></tr>";

    fgetcsv($file, 1024, ";");
    echo "<tr>";
    while ($data = fgetcsv($file, 1000, ";")) {
        $date = date_create();
        date_timestamp_set($date, intval($data[1]));
        echo "<td>$data[0]</td>";
        echo "<td>" . date_format($date, 'Y-m-d H:i:s') . "</td>";
        echo "<td>$data[2]</td>";
        echo "<td>$data[3]</td>";
        echo "<td>$data[4]</td>";
        echo "<td>" . number_format($data[5], 2) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    fclose($file);
}

//Création des boutons
?>
<div class="listeBoutons">
    <div>
        <button onclick="location.href='processlog.php?archiver'">Archiver les logs</button>
        <button onclick="location.href='processlog.php?vider'">Vider les logs</button>
        <button onclick="location.href='logout.php'">Déconnexion</button>
    </div>
    <div>
        <form method="get" action="admin.php">
            <label for="archive"></label>
            <select id="archive" name="archive">
                <?php
                foreach ($archives as $k => $v) {
                    if ($selected == $v) {
                        echo "<option hidden selected>$v</option>";
                    } else {
                        echo "<option>$v</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Valider</button>
        </form>
<body>

<div class="box">

    <button onclick="location.href='processlog.php?archiver'">Archiver les logs</button>
    <button onclick="location.href='processlog.php?vider'">Vider les logs</button>
    <button onclick="location.href='logout.php'">Déconnexion</button>

    </div>
</div>

<?php print_logs_table(); ?>

</body>
</html>