<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'villabenjamin14@gmail.com';  // Tu correo de Gmail
    $mail->Password = 'efye ndtd yzfw nizm';  // Contraseña de Aplicación generada
    $mail->SMTPSecure = 'tls';  // Usar 'tls' para el puerto 587
    $mail->Port = 587;  // Usar 587 para 'tls'

    $mail->setFrom('villabenjamin14@gmail.com', 'Tu Nombre');
    $mail->addAddress('nicolasalurralde39@gmail.com');  // Cambia por un correo de prueba

    $mail->isHTML(true);
    $mail->Subject = 'Prueba de Correo';
    $mail->Body    = 'Este es un correo de prueba desde PHPMailer.';

    $mail->send();
    echo 'Correo enviado con éxito.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
