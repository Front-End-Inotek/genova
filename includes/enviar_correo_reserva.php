<?php
    require_once('../PHPMailer/class.phpmailer.php');
    include_once("clase_correo.php");
    $correo=NEW Email();
    $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.
  
    $mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP
    
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'orware.factura@gmail.com';                   //SMTP username
        $mail->Password   = 'wmtitpzizsqnnwcr';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('orware.factura@gmail.com', utf8_decode('Carlos Garcia'));
        $mail->addAddress('carlosramongarcia@gmail.com', utf8_decode('Carlos Garcia'));     
        /*$mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/
    
        //Attachments
       /* $mail->addAttachment('../facturas/'. $folio .'_Factura.pdf'); 
        $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.xml');
        $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.png');*/
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = utf8_decode('Reserva Visit');
        $mail->Body    = 'Se adjuntan los siguientes documentos, por favor de no contestar este correo ya que es generado de manera automatica';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Messagehasbeensent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>