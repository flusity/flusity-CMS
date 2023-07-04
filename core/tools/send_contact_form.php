<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/functions/functions.php';
require_once ROOT_PATH . 'security/config.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$settings = getContactFormSettings($db, $prefix);

$email_subject = !empty($settings['email_subject']) ? $settings['email_subject'] : 'New message from Contact Form';
$email_body = !empty($settings['email_body']) ? $settings['email_body'] : 'We received a message from:';
$email_success_message = !empty($settings['email_success_message']) ? $settings['email_success_message'] : 'Email has been sent successfully';
$email_error_message = !empty($settings['email_error_message']) ? $settings['email_error_message'] : 'Failed to send the email';


require_once ROOT_PATH . 'core/phpmailer/src/PHPMailer.php';
require_once ROOT_PATH . 'core/phpmailer/src/SMTP.php';
require_once ROOT_PATH . 'core/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 require_once ROOT_PATH . 'security/mail_config.php';

$mail_config = include(ROOT_PATH . 'security/mail_config.php');
 
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = $mail_config['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_config['username'];
    $mail->Password   = $mail_config['password'];
    $mail->SMTPSecure = $mail_config['secure'];
    $mail->Port       = $mail_config['port'];
    
    $mail->setFrom($mail_config['setFrom'], 'Flusity'); //'Flusity' galimybė keisti tekstą formoje
    $mail->addAddress($mail_config['addAddress'], 'Admin');   // 'Admin' galimybė keisti tekstą formoje
    
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail->Subject = $email_subject . ' ' . $name;
    $mail->Body    = $email_body . '<br><br>' . $message . "<br><br> Sent by: " . $email;
    
    $mail->send();

    $response = [
        'status' => 'success',
        'message' => $email_success_message
    ];
    echo json_encode($response);

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $email_error_message
    ];
    echo json_encode($response);
}
