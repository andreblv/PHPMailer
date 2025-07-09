<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tu_correo@gmail.com';        // Tu correo de Gmail
    $mail->Password   = 'tu_contraseña_o_token';      // Tu contraseña o token de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('tu_correo@gmail.com', 'Tu Nombre'); // Correo del remitente
    $mail->addAddress('destinatario@ejemplo.com', 'Destinatario'); // Correo del destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Correo de prueba con PHPMailer';
    $mail->Body    = '<b>Hola!</b> Este es un correo enviado con PHPMailer usando Gmail SMTP.';
    $mail->AltBody = 'Hola! Este es un correo enviado con PHPMailer usando Gmail SMTP.';

    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
