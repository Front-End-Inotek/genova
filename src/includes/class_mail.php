<?php

include_once("../PHPMailer/class.phpmailer.php");

//$mail = new PHPMailer(true);

class EmailSender {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->mailer->IsSMTP();
        $this->mailer->Host = "smtp.gmail.com";
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = "orware.factura@gmail.com";
        $this->mailer->Password = "wmtitpzizsqnnwcr";
        $this->mailer->SMTPSecure = "ssl";
        $this->mailer->Port = 465;
        $this->mailer->SetFrom("orware.factura@gmail.com", "Plaza Genova");
        $this->mailer->isHTML(true);      
        $this->mailer->CharSet = "UTF-8";
        $this->mailer->Encoding = "base64";
    }

    public function sendEmail($recipent, $subject, $recipientName, $tel ,$reservation_id, $check_in, $check_out, $roomType, $total , $user = false) {
        
        $checkinDate = date('Y-m-d', $check_in);
        $checkoutDate = date('Y-m-d', $check_out);

        try {
            $this->mailer->clearAddresses(); 
            $this->mailer->addAddress($recipent, $recipientName);

            //Emmail content
            $this->mailer->IsHTML(true);
            $this->mailer->Subject = $subject;

            if ($user) {
                $body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Correo Electrónico</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                background-color: #f4f4f4;
                                padding: 20px;
                                margin: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                            }
                            .header {
                                background-color: #007bff;
                                color: #ffffff;
                                padding: 10px;
                                text-align: center;
                                border-radius: 8px 8px 0 0;
                            }
                            .content {
                                padding: 20px;
                            }
                            .footer {
                                text-align: center;
                                padding: 10px;
                                background-color: #f0f0f0;
                                border-radius: 0 0 8px 8px;
                            }
                            .footer a {
                                color: #007bff;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <h2>Confirmación de reserva</h2>
                            </div>
                            <div class="content">
                                <p>Hola ' . htmlspecialchars($recipientName) . ',</p>
                                <p>Nos complace confirmar tu reservación en Hotel Plaza Genova.</p>
                                <p>Detalles de su reservación:</p>
                                <ul>
                                    <li><strong>Número de reserva:</strong> ' . $reservation_id . '</li>
                                    <li><strong>Check in:</strong> ' . $checkinDate . '</li>
                                    <li><strong>Check out :</strong> ' . $checkoutDate . '</li>
                                    <li><strong>Tipo de habitación:</strong> ' . $roomType . '</li>
                                    <li><strong>Precio total:</strong> $' . $total . ' (MXN)</li>
                                </ul>
                                <p>Si tienes alguna pregunta o necesitas ayuda para hacer cambios en tu reservación, por favor contacta con nosotros a ventas@plazagenova.mx</p>
                                <p>Gracias por elegir a Hotel Plaza Genova</p>
                            </div>
                            <div class="footer">
                                <p>Atentamente,<br> Hotel Plaza Genova<br></p>
                                <p> Teléfono: <a href="tel:+52 33 3613 7500">+52 33 3613 7500</a></p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';
            } else {
                $body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Correo Electrónico</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                background-color: #f4f4f4;
                                padding: 20px;
                                margin: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                            }
                            .header {
                                background-color: #007bff;
                                color: #ffffff;
                                padding: 10px;
                                text-align: center;
                                border-radius: 8px 8px 0 0;
                            }
                            .content {
                                padding: 20px;
                            }
                            .footer {
                                text-align: center;
                                padding: 10px;
                                background-color: #f0f0f0;
                                border-radius: 0 0 8px 8px;
                            }
                            .footer a {
                                color: #007bff;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <h2>Nueva reserva recibida</h2>
                            </div>
                            <div class="content">
                                <p>Hola,</p>
                                <p>Se ha recibido una nueva reserva en Hotel Plaza Genova. Los detalles son los siguientes:</p>
                                <ul>
                                    <li><strong>Nombre:</strong> ' . htmlspecialchars($recipientName). '</li>
                                    <li><strong>Número de telefono:</strong> ' . htmlspecialchars($tel) . '</li>
                                    <li><strong>Número de reserva:</strong> ' . $reservation_id . '</li>
                                    <li><strong>Check in:</strong> ' . $checkinDate . '</li>
                                    <li><strong>Check out :</strong> ' . $checkoutDate . '</li>
                                    <li><strong>Tipo de habitación:</strong> ' . $roomType . '</li>
                                    <li><strong>Precio total:</strong> $' . $total . ' (MXN)</li>
                                </ul>
                                <p>Por favor, revisa y confirma la reserva.</p>
                            </div>
                            <div class="footer">
                                <p>Atentamente,<br> Hotel Plaza Genova<br></p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';
            }

            $this->mailer->Body = $body;

            $this->mailer->send();
            return true;
        } catch(Exception $e) {
            echo $e;
            return false;
        }
    }
}



