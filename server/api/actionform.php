<?php
namespace Zhp\KujPom\Naorbitach;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;   
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

$full_debug = false;

if ($full_debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require  __DIR__ . '/sanitization.php';
require  __DIR__ . '/dictkujpom.php';
require  __DIR__ . '/actionsave.php';


$kopernik_config = parse_ini_file('kopernik.ini');

function prepare_new_name($old_name){

    $fileNameCmps = explode(".", $old_name);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = md5(time() . $old_name) . '.' . $fileExtension;
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        return $newFileName;
    }
    return '';
}

$uploaded_image = $_FILES['image']['tmp_name'];
$uploaded_image_name_old = basename($_FILES["image"]["name"]);
$uploaded_image_name_new = prepare_new_name($uploaded_image_name_old);
$uploaded_image_size = $_FILES['image']['size'];
// extra checks https://www.php.net/manual/en/features.file-upload.php


function cleanup(){
    global $uploaded_image;

    if (file_exists($uploaded_image)) {
        unlink($uploaded_image);
     }
}

function redirect_to_index()
{   
    cleanup();
    header('Location: ../index.html');
}
function redirect_to_result()
{   
    cleanup();
    header('Location: ../result.html');
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
    'image' => $uploaded_image_name_new,
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

echo "image size=". $uploaded_image_size . PHP_EOL;
echo "image path=". $uploaded_image . PHP_EOL;
echo "image name=". $uploaded_image_name_old . PHP_EOL;
echo "image new name=". $uploaded_image_name_new . PHP_EOL;



if($uploaded_image_size==0 || $uploaded_image_size>8000000 || !$uploaded_image_name_new ||  !is_uploaded_file($uploaded_image)) 
{
    array_push($errors, 'image');   
}

if($errors)
{
    redirect_to_result();
    return;
}

redirect_to_result();

$mysqli = kopernik_mysqli($kopernik_config, $full_debug);

$action_saved = false;
if($mysqli->connect_errno == 0)
{
    $err = save_action($mysqli, $data);

    if (!$err) {
        $action_saved = true;
    }
} else {
    // if (mysqli_connect_errno()) {
    //     throw new RuntimeException('mysqli connection error: ' . mysqli_connect_error());
    // }
}


$mail_to = $kopernik_config['service_email'];
$mail_subject = $kopernik_config['service_email_subject'];
$mail_from =  $kopernik_config['service_email_from'];
$mail_from_name =  $kopernik_config['service_email_from_name'];

$mail_body = "";
foreach($data as $key=>$value)
{
    $mail_body .= $key . '=' . $value . PHP_EOL;
}
$mail_body .= 'image_old' . '=' . $uploaded_image_name_old . PHP_EOL;
if($action_saved)
{
    $mail_body .= 'action_saved' . '=' . 'true' . PHP_EOL;
} else {
    $mail_body .= 'action_saved' . '=' . 'false' . PHP_EOL;

}

//var_dump($mail_body);
// Send by PHP mail function
//var_dump($mail_subject);
// $mail_headers[] = 'From: ' . $mail_from;
// $mail_accepted = mail($mail_to, $mail_subject, $mail_body,implode("\r\n", $mail_headers));
// var_dump($mail_accepted);

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    if ($full_debug) {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                              //Enable verbose debug output
    }
    $mail->isSMTP();                                                    //Send using SMTP
    $mail->Host       = $kopernik_config['service_smtp_server'];        //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                           //Enable SMTP authentication
    $mail->Username   = $kopernik_config['service_smtp_user'];          //SMTP username
    $mail->Password   = $kopernik_config['service_smtp_password'];      //SMTP password
    $mail->SMTPSecure = $kopernik_config['service_smtp_encryption'];    //Enable implicit TLS encryption
    $mail->Port       = $kopernik_config['service_smtp_port'];          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($mail_from, 'Na orbbitach');
    $mail->addAddress($mail_to);                                        //Add a recipient
    //$mail->addAddress('ellen@example.com');                           //Name is optional
    $mail->addReplyTo($mail_from);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');                     //Add attachments
    $mail->addAttachment($uploaded_image, $uploaded_image_name_new);        //Optional name

    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = $mail_subject;
    $mail->Body    = $mail_body;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


$mysqli->close();

cleanup();
