<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '/home3/blinlara/public_html/phpmailer/PHPMailerAutoload.php';

if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['message']) && isset($_POST['telefono'])) {

    if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['message']) || empty($_POST['telefono'])) {
        $data = array('success' => false, 'message' => 'Por favor llenar todas las casillas');
        echo json_encode($data);
        exit;
    }

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';

    $mail->IsSMTP();
    $mail->Host = "mail.blinlara.com";
    $mail->Port = 25;
    $mail->SMTPAuth = true;
    $mail->Username = "contacto@blinlara.com";
    $mail->Password = "blincode";

    $mail->SetFrom($_POST['email'], $_POST['nombre']);

    $mail->AddAddress('contacto@blinlara.com');
    $mail->Subject = 'Contacto blinlara.com';
    $mail->Body = "Nombre: " . $_POST['nombre'] . "\r\n\r\nTeléfono: " . $_POST['telefono'] . "\r\n\r\nEmail: " . $_POST['email'] . "\r\n\r\nMensaje: " . stripslashes($_POST['message']);
    
    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    $data = array('success' => true, 'message' => 'enviado');
    echo json_encode($data);

} else {
    $data = array('success' => false, 'message' => 'Por favor, termine de llenar el formulario.');
    echo json_encode($data);
}