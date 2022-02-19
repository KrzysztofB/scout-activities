<?php
namespace Zhp\KujPom\Naorbitach;

require  __DIR__ . '/sanitization.php';
require  __DIR__ . '/dictkujpom.php';

$kopernik_config = parse_ini_file('kopernik.ini');

var_dump($kopernik_config);


function redirect_to_index()
{
    header('Location: ../index.html');
}

function clean_field($input)
{
    $sanitized = trim( htmlentities( $input, ENT_QUOTES, 'UTF-8') );
    return (str_contains($sanitized,';') ? '' : $sanitized);
}


$inputs = [
    'scoutunit' => 'chelmza',
    'participants' => '4',
    'activity' => 'running',
    'distance' => '23443',
    'image' => 'file',
    'notes' => 'my notes'
];

$fields = [
    'scoutunit' => 'string',
    'participants' => 'intvalidate',
    'activity' => 'string',
    'distance' => 'intvalidate',
    'image' => 'file',
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

 
var_dump($data);

$a1 = filter_var('-1234565', FILTER_VALIDATE_INT);
//print("\n");
var_dump($a1);