<?php

require_once "logmanagement.php";

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

$archives = get_all_log_files();
$selected = $log_file_name;

$disable = FALSE;
if (isset($_GET["archive"]) and in_array($_GET["archive"], $archives)) {
    $selected = $_GET["archive"];

    if ($selected != "logs.csv") {
        $disable = TRUE;
    }
}

//BONJOUR
?>
<!doctype html>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylePopUp.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
<div class="box">

    <?php
    if ($disable == TRUE) { ?>
        <button onclick="location.href='#archiverPopUp'" disabled>Archiver</button>
        <button onclick="location.href='processlog.php?vider'" disabled>Vider les logs</button>
        <?php
    } else { ?>
        <button onclick="location.href='#archiverPopUp'">Archiver</button>
        <button onclick="location.href='processlog.php?vider'">Vider les logs</button>
    <?php }
    ?>
    <button onclick="location.href='logout.php'">Déconnexion</button>

    <form>
        <select id="archive" name="archive" onchange="this.form.submit()">
            <?php
            foreach ($archives as $k => $v) {
                if ($selected == $v) {
                    echo "<option selected>$v</option>";
                } else {
                    echo "<option>$v</option>";
                }
            }
            ?>
        </select>
    </form>
</div>

<div id="archiverPopUp" class="modal">
    <div class="modal_content">
        <h1>Enregistrer Sous:</h1>
        <P> Nom du fichier : </p>
        <form method='get' action='processlog.php'>
            <label for="archiver"></label>
            <input style="margin: 15px 50px;" type='text' id="archiver" name='archiver' autocomplete="false" required>
            <br/>
            <button type="submit">Enregistrer</button>
        </form>
        <a href="#" class="modal_close">&times;</a>
    </div>
</div>


<?php print_logs_table($selected); ?>

</body>

</html>