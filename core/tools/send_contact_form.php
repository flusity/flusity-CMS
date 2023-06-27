<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/functions/functions.php';
require_once ROOT_PATH . 'security/config.php';

require_once ROOT_PATH . 'core/PHPMailer/src/PHPMailer.php';
require_once ROOT_PATH . 'core/PHPMailer/src/SMTP.php';
require_once ROOT_PATH . 'core/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 $db = getDBConnection($config);
 require_once ROOT_PATH . '../../security/mail_config.php';

$mail_config = include(ROOT_PATH . '../../security/mail_config.php');
 
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = $mail_config['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_config['username'];
    $mail->Password   = $mail_config['password'];
    $mail->SMTPSecure = $mail_config['secure'] === 'tls' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = $mail_config['port'];
    
    $mail->setFrom($mail_config['setFrom'], 'Mailer');
    $mail->addAddress($mail_config['addAddress'], 'Admin');   
    
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
