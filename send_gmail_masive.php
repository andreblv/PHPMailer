<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'conexionbd.php'; 

// Consulta para obtener destinatarios
$stmt = $pdo->query("SELECT email, nombre FROM destinatarios WHERE activo = 1");

$destinatarios = $stmt->fetchAll();

if (!$destinatarios) {
    die('No hay destinatarios activos.');
}

$mail = new PHPMailer(true);

try {
    // Configuración SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tu_correo@gmail.com';        // Cambia por tu correo
    $mail->Password   = 'tu_contraseña_o_token';      // Cambia por tu contraseña 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente
    $mail->setFrom('tu_correo@gmail.com', 'Tu Nombre');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Correo masivo con PHPMailer y BD';
    $mail->Body    = '<b>Hola, este es un correo masivo enviado con PHPMailer desde base de datos.</b>';
    $mail->AltBody = 'Hola, este es un correo masivo enviado con PHPMailer desde base de datos.';

    foreach ($destinatarios as $destinatario) {
        $mail->clearAddresses();
        $mail->addAddress($destinatario['email'], $destinatario['nombre']);
        
        try {
            $mail->send();
            echo "Correo enviado a: {$destinatario['email']}\n";
        } catch (Exception $e) {
            echo "Error al enviar a {$destinatario['email']}: {$mail->ErrorInfo}\n";
        }
    }
} catch (Exception $e) {
    echo "Error general: {$mail->ErrorInfo}\n";
}
