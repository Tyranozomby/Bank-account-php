<?php

require_once "logmanagement.php";

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

$archives = get_all_log_files();
$selected = $log_file_name;

if (isset($_GET["archive"])) {
    $selected = $_GET["archive"];
}

//BONJOUR
?>
<!doctype html>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="stylePopUp.css">
    <style>
        body {
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
        .modal_content {
            width: 600px;
            height: 450px;
            background: rgba(235, 160, 0, 0.9);
        }
        .nomFichier{
            margin: 15px 50px;

        }
        table {
            background-color: rgba(0, 0, 0, 0.35);
        }
    </style>
</head>

<body style="padding: 9rem 0 3rem 0">
<div class="box">
    <button onclick="location.href='#archiverPopUp'">Archiver</button>
    <button onclick="location.href='processlog.php?vider'">Vider les logs</button>
    <button onclick="location.href='logout.php'">Déconnexion</button>

    <form method="get" action="admin.php">
        <label for="archive"></label>
        <select id="archive" name="archive">
            <?php
            foreach ($archives as $k => $v) {
                if ($selected == $v) {
                    echo "<option hidden selected>$v</option>";
                    $setsel = true;
                } else {
                    echo "<option>$v</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Valider</button>
    </form>

</div>

<div id="archiverPopUp" class="modal">
    <div class="modal_content">
        <h1>Enregistrer Sous:</h1>

        <P> Nom du fichier : </p>
        <form method='get' action='processlog.php?archiver' >
            <input class='nomFichier' type='text' id="archiver" name='archiver' autocomplete="false" required>
            <br></br>
            <button type="submit">Enregistrer</button>
        </form>
        <a href="#" class="modal_close">&times;</a>
    </div>
</div>


<?php print_logs_table($selected); ?>

</body>

</html>