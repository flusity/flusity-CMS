<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/functions/functions.php';
require_once ROOT_PATH . 'security/config.php';

require_once ROOT_PATH . 'core/PHPMailer/src/PHPMailer.php';
require_once ROOT_PATH . 'core/PHPMailer/src/SMTP.php';
require_once ROOT_PATH . 'core/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = getDBConnection($config);

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.example.com';// smtp.gmail.com
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-email@gmail.com'; // Įveskite savo Gmail el. pašto adresą
    $mail->Password   = 'your-email-password'; // Įveskite savo Gmail el. pašto slaptažodį
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('your-email@example.com', 'Mailer');
    $mail->addAddress('recipient@example.com', 'Recipient Name');

    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

    $mail->send();

    $response = [
        'status' => 'success',
        'message' => 'Laiškas sėkmingai išsiųstas'
    ];
    echo json_encode($response);

} catch (Exception $e) {
    // Jei el. pašto išsiuntimas nepavyko
    $response = [
        'status' => 'error',
        'message' => 'Nepavyko išsiųsti laiško'
    ];
    echo json_encode($response);
}
