<?php

require_once "../util/logmanagement.php";

//Ouverture du fichier
session_start();
if (!isset($_SESSION["admin"]) and $_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

$archives = get_all_log_files();
$selected = $log_file_name;

$isarchive = FALSE;
if (isset($_GET["archive"]) and in_array($_GET["archive"], $archives)) {
    $selected = $_GET["archive"];

    if ($selected != "logs.csv") {
        $isarchive = TRUE;
    }
}

?>
<!doctype html>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title>Admin</title>
    <link rel="icon" type="image/png" href="../icones/login.png"/>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/stylePopUp.css">
    <link rel="stylesheet" href="../css/admin.css">

    <script>
        function download(file) {
            const a = document.createElement("a");
            a.setAttribute("download", "");
            a.setAttribute("href", file);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</head>

<body>
<div class="box">
    <form method="get" action="processlog.php">

        <?php if ($isarchive) { ?>
            <button type="button" onclick="download('<?php
            echo "../archives/$selected"; ?>')">Télécharger
            </button>
            <input type="submit" class="button" name="supprimer" value="Supprimer l'archive">
        <?php } else { ?>
            <button type="button" onclick="location.href='#archiverPopUp'" <?php if (is_log_empty()) echo "disabled" ?>>
                Archiver les logs
            </button>
            <input type="submit" class="button" name="vider" value="Vider les logs">
        <?php } ?>

        <button type="button" onclick="location.href='logout.php'">Déconnexion</button>

        <label for="archive"></label>
        <select id="archive" name="archive"
                onchange="window.location.href = window.location.href.split('#')[0].split('?')[0] + '?archive=' + this.value">
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

    <a class="boutonAccueil" href="../" title="Accueil"
       style="display: flex; margin: auto">
        <img src="../icones/accueil.png" width="50" alt="accueil"/>
    </a>
</div>

<?php if (!$isarchive) { ?>
    <div id="archiverPopUp" class="modal">
        <div class="modal_content">

            <h1>Enregistrer Sous :</h1>

            <form method='get' action='processlog.php'>
                <p> Nom du fichier :</p>
                <label for="archiver"></label>
                <input type='text' id="archiver" pattern="[A-Za-z.]{2,20}" name='archiver' autocomplete="false"
                       required>
                <br/>
                <button type="submit">Enregistrer</button>
                <?php
                if (isset($_GET["stat"])) {
                    switch ($_GET["stat"]) {
                        case 1:
                            echo "<p class='error'>Erreur ce nom existe deja</p>";
                            break;
                        case 2:
                            echo "<p class='error'>Erreur</p>";
                            break;
                    }
                }
                ?>
            </form>

            <a href="#" class="modal_close">&times;</a>
        </div>
    </div>

<?php } ?>

<?php print_logs_table($selected); ?>

</body>

</html>