<?php
namespace Zhp\KujPom\Naorbitach;

require  __DIR__ . '/actionsave.php';

$full_debug = false;

if ($full_debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


$kopernik_config = parse_ini_file('kopernik.ini');

$mysqli = kopernik_mysqli($kopernik_config, $full_debug);

$action_saved = false;
if($mysqli->connect_errno == 0)
{
    $json_result = read_total($mysqli);
} else {
    $json_result = '{ "error": "'.$mysqli->connect_errno.' '.$mysqli->connect_error  .'"}';
}

$mysqli->close();

header('Content-type: application/json');

echo $json_result;