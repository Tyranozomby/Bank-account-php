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
<div class="box">

    <button onclick="location.href='processlog.php?archiver'">Archiver les logs</button>
    <button onclick="location.href='processlog.php?vider'">Vider les logs</button>
    <button onclick="location.href='logout.php'">Déconnexion</button>
    <form method="get" action="admin.php" >
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

<?php print_logs_table($selected); ?>

</body>
</html>