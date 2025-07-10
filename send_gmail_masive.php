<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($subject) || empty($message)) {
        die('Asunto y mensaje son obligatorios.');
    }

    // Obtener archivo del formulario
    $archivoTemporal = $_FILES['archivo']['tmp_name'];
    $nombreArchivo = $_FILES['archivo']['name'];

    // Consulta
    $stmt = $pdo->query("SELECT email, nombre FROM destinatarios");
    $destinatarios = $stmt->fetchAll();

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'correo';        // Tu correo
        $mail->Password   = 'contra de app';               // Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente
        $mail->setFrom('correo', 'nombre');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($message));

        foreach ($destinatarios as $destinatario) {
            $mail->clearAddresses();
            $mail->clearAttachments();

            $mail->addAddress($destinatario['email'], $destinatario['nombre']);
            $mail->addAttachment($archivoTemporal, $nombreArchivo); // Adjuntar archivo

            try {
                $mail->send();
                echo "Correo enviado a: {$destinatario['email']}<br>";
            } catch (Exception $e) {
                echo "Error al enviar a {$destinatario['email']}: {$mail->ErrorInfo}<br>";
            }
        }
    } catch (Exception $e) {
        echo "Error general: {$mail->ErrorInfo}";
    }
} else {
    echo "Método no permitido.";
}
?>
