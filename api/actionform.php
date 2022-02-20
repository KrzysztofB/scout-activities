<?php
namespace Zhp\KujPom\Naorbitach;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require  __DIR__ . '/sanitization.php';
require  __DIR__ . '/dictkujpom.php';

$kopernik_config = parse_ini_file('kopernik.ini');


function redirect_to_index()
{
    header('Location: ../index.html');
}

function clean_field($input)
{
    $sanitized = trim( htmlentities( $input, ENT_QUOTES, 'UTF-8') );
    return (str_contains($sanitized,';') ? '' : $sanitized);
}


// $inputs = [
//     'scoutunit' => 'chelmza',
//     'participants' => '4',
//     'activity' => 'running',
//     'distance' => '23443',
//     'image' => 'file',
//     'notes' => 'my notes'
// ];
$inputs = [
    'scoutunit' => $_POST['scoutunit'],
    'participants' => $_POST['participants'],
    'activity' => $_POST['activity'],
    'distance' => $_POST['distance'],
    'image' => $_POST['image'],
    'notes' => 'my notes'
];

$fields = [
    'scoutunit' => 'string',
    'participants' => 'intvalidate',
    'activity' => 'string',
    'distance' => 'intvalidate',
    'image' => 'string',
    'notes' => 'string'
];

$required_fields = [
    'scoutunit',
    'participants',
    'activity',
    'distance',
    'image'
];

$data = sanitize($inputs,$fields);

$data = sanitize_by_dict($data, 'scoutunit', scoutunit_dict());

$data = sanitize_by_dict($data, 'activity', activity_dict());

$errors = [];

foreach ($data as $key => $value)
{
    if(in_array($key, $required_fields) && !($value))
    {
        array_push($errors, $key);
    }
}

if($errors)
{
    redirect_to_index();
    return;
}

$mail_to = $kopernik_config['service_email'];
$mail_subject = $kopernik_config['service_email_subject'];
$mail_from =  $kopernik_config['service_email_from'];
$mail_body = "";
foreach($data as $key=>$value)
{
    $mail_body .= $key . '=' . $value . '\r\n';
}

var_dump($mail_body);

var_dump($mail_subject);
$mail_headers[] = 'From: ' . $mail_from;
mail($mail_to, $mail_subject, $mail_body,implode("\r\n", $mail_headers));

 
var_dump($data);
