<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require 'vendor/autoload.php'; // Asegúrate de tener la librería PHPMailer instalada

require_once 'server.php'; // Incluir el archivo con la conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    try {
        // 2. Verificar si el correo existe en la base de datos
        $sql = "SELECT * FROM Usuarios WHERE Correo = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $contraseñaHash = $row["Contraseña"]; 

            // 3. Enviar correo electrónico (recuerda configurar los datos de tu servidor SMTP)
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_OFF; 
            $mail->isSMTP();
            $mail->Host       = 'smtp.gamil.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ecom11.faustino.sanchez@gmail.com';
            $mail->Password   = 'nxzubbwuzxwtqmqr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($email);  
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';

            // Enviar la contraseña actual al usuario
            $mail->Body    = "Tu contraseña es: <b>$contraseñaHash</b>"; // Se envía la contraseña hasheada
            $mail->send();

            echo json_encode(['status' => 'success', 'message' => 'Se ha enviado un correo electrónico con tu contraseña.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no está registrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Error en la base de datos: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Error al enviar el correo electrónico: {$mail->ErrorInfo}"]);
    }
}
?>