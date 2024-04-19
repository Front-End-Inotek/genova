<?php
// Vars
$name = $_GET["name"];
$phone = $_GET["phone"];
$guests = $_GET["guests"];
$initialDate = $_GET["initial"];
$endDate = $_GET["end"];


require_once('../PHPMailer/class.phpmailer.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


//Load Composer's autoloader

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$nombreHotel = "Plaza Genova";
$imagenEncabezado = "";
$imagenID = $mail->AddEmbeddedImage($imagenEncabezado, 'imagen_encabezado', "hotelexpoabastos.png");
$correo="pinedoerick76@gmail.com";
$nombre="Erick";
//$resultado2=$facturacion->obtener_folio();
//$row2=mysqli_fetch_array($resultado2);

$folio = "0";
try {
    //Server settings                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'orware.factura@gmail.com';                   //SMTP username
    $mail->Password   = 'wmtitpzizsqnnwcr';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('orware.factura@gmail.com', $nombreHotel);
    $mail->addAddress($correo, $nombreHotel);

    //Attachments
    /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */  //Optional name

    $fecha = date("d-m-Y");
    $f_h = date('d-m-Y');
    $dia = substr($fecha, 0, 2);
    $mes = substr($fecha, 3, 2);
    $anio = substr($fecha, 6, 4);

    $fecha_actual = $dia . " de " . $mes . " de " . $anio;

    //Pie de pagina
    $contenido_pie="
      <div style='background-color: #2D3F54; text-align: center; padding: 8px; color: #fff; ' >
        <div style='text-align:center'>
          <p>Le invitamos a visitar nuestra página web: <a style='color: #A0C3FF !important;'>dbdbd</a>. </p>
          <p> donde encontrará mayor información acerca de nuestras instalaciones y servicios.</p>
        </div>
      </div>";
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->Subject = ('Envio de factura');
    $mail->MsgHTML('
    <div style="background-color: #2D3F54; text-align: center; padding: 8px; " >
    <h2 style="font-weight: bold; font-size: 24px; color: #ffffff;"> Factura </h2>
    <img style="background-color: #F7F7F7; border-radius: 15px; height: 7rem;"  src="cid:imagen_encabezado" alt="Encabezado" />
    </div>
    <p>Estimado(A) Sr (Srita) <span style="color: #2D3F54; font-weight: 700;"> '.$nombre.' </span> </p>
    <p>Su factura ha sido procesado con éxito con fecha '.$fecha_actual.'</p>
    '.$contenido_pie.'
    ');
    $mail->AltBody = 'Factura procesada con éxito';

    $mail->send();
    echo 'Messagehasbeensent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
