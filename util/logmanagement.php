<?php
// 404 si accédé directement
if (count(get_included_files()) == 1) {
    http_response_code(404);
    exit();
}

$web_log_folder = "/archives";
$app_log_folder = __DIR__ . "/../archives";

$log_file_name = "logs.csv";

$log_header = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");


function get_full_log_file_path(): string
{
    global $log_file_name, $app_log_folder;
    return $app_log_folder . "/" . $log_file_name;
}

function ensure_log_file_exists(string $filename = null): string
{
    global $log_file_name, $app_log_folder, $log_header;
    $file = $app_log_folder . "/" . ($filename ?? $log_file_name);

    if (!file_exists($app_log_folder)) {
        mkdir($app_log_folder);
    } else if (!is_dir($app_log_folder)) {
        return false;
    }
    if (!file_exists($file)) {
        $f = fopen($file, 'w');
        flock($f, LOCK_EX);
        fputcsv($f, $log_header, ";");
        flock($f, LOCK_UN);
        fclose($f);
        return $file;
    }
    return $file;
}

/**
 * @param string | null
 * @param bool $read
 * @return false|resource
 * @noinspection PhpMissingReturnTypeInspection
 */
function open_log_file(string $file_name = null, bool $read = false)
{
    $file = ensure_log_file_exists($file_name);

    return fopen($file, 'a' . ($read ? '+' : ''));
}

function get_all_log_files(): array
{
    global $app_log_folder;
    return array_diff(scandir($app_log_folder), array('.', '..'));
}


function get_logs_data(string $filename = null): false|array
{
    $logfile = open_log_file($filename, true);

    if ($logfile == false) return false;

    flock($logfile, LOCK_SH);

    fgets($logfile); // on saute la ligne header

    $data = array();
    while ($ligne = fgetcsv($logfile, separator: ';')) {
        array_push($data, $ligne);
    }

    fclose($logfile);

    return $data;
}


/**
 * @param string|null $filename
 * @param int $limit_from_last
 * @param int[]| null $columns
 * @param array $col_callbacks
 */
function print_logs_table(string $filename = null, int $limit_from_last = 0, array $columns = null, array $col_callbacks = [])
{
    $data = get_logs_data($filename);
    if ($data == false) return;
    $data = array_splice($data, -$limit_from_last);
    $dataSize = count($data);

    $header_display = array("IP", "Date", "Montant (€/mois)", "Capital", "Mois", "Taux");


    $columns ??= range(0, count($header_display) - 1);


    $to_show = array_map(fn($colnum) => $header_display[$colnum], $columns);


    echo "
<table>
    <thead>
        <tr>";
    foreach ($to_show as $value) {
        echo "<td>$value</td>";
    }
    echo "
        </tr>
    </thead>";


    for ($i = 0; $i < $dataSize; $i++) {
        $ligne = $data[$i];

        echo "<tr>";
        foreach ($columns as $colnum) {
            $coldata = $ligne[$colnum];
            if ($colnum == 5) $coldata = number_format($coldata, 2) . " %";
            if ($colnum == 2) $coldata = $coldata . " €";
            if ($colnum == 1) {
                $datetime = date_create_from_format("U", $coldata);
                date_timezone_set($datetime, timezone_open("Europe/Paris"));
                $coldata = date_format($datetime, 'Y-m-d H:i:s');
            }

            if (isset($col_callbacks[$colnum])) {
                $coldata = $col_callbacks[$colnum]($coldata);
            }
            echo "<td>$coldata</td>";
        }
        echo "</tr>";
    }
    echo "
</table>";
}

/**
 * @return bool is there is at least one line of data in the log file
 */
function is_log_empty(): bool
{
    global $log_file_name, $app_log_folder;

    $file = fopen($app_log_folder . "/" . $log_file_name, "r");
    $count = 0;
    $empty = true;
    while (!feof($file) and $empty) {
        fgetcsv($file);
        $count++;
        if ($count > 2)
            $empty = false;
    }

    fclose($file);
    return $empty;
}