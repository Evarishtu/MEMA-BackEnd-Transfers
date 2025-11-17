<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class EmailHelper{
    public static function enviarConfirmacionReserva($emailCliente, $nombreCliente, $localizador, $tipoReserva, $hotelNombre){
        try{
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 25;
            $mail->SMTPAuth = false;

            $mail->setFrom('reserva@tuempresa.com', 'Reservas Transfer');
            $mail->addAddress($emailCliente, $nombreCliente);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de reserva ' . $localizador;
            $mail->Body = "
                <h2>Confirmación de su reserva</h2> 
                <p>Estimado/a {$nombreCliente},</p>
                <p>Su reserva ha sido creada correctamente</p>
                <ul>
                    <li><b>Localizador:</b> {$localizador}</li>
                    <li><b>Tipo de reserva:</b> {$tipoReserva}</li>
                    <li><b>Hotel:</b> {$hotelNombre}</li>
                </ul>
                <p>Gracias por confiar en nosotros.</p>
            ";
                        $mail->send();
            return true;
        } catch (Exception $e){
            error_log("Error al enviar email: " . $e->getMessage());
            return false;
        }
    }
}

?>