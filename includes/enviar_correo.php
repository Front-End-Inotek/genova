<?php
require_once('../class.phpmailer.php');

$mail = new PHPMailer(); // defaults to using php "mail()"

$body = file_get_contents('contents.html');

$mail->AddReplyTo("name@yourdomain.com","First Last");

$mail->SetFrom('name@yourdomain.com', 'First Last');

$mail->AddReplyTo("name@yourdomain.com","First Last");

$address = "whoto@otherdomain.com";
$mail->AddAddress($address, "John Doe");

$mail->Subject    = "PHPMailer Test Subject via mail(), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
/* use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

include 'datos_servidor.php'; //conexion con la base de datos
include ("clase_factura.php");
$facturacion = NEW factura();
//$consulta="SELECT * FROM rfc WHERE id = '1' ";
//$resultado=mysqli_query($con,$consulta);
$resultado=$facturacion->obtener_primer_rfc();
$row=mysqli_fetch_array($resultado);

//$consulta2="SELECT folio FROM facturas ORDER BY id DESC LIMIT 1 ";
//$resultado2=mysqli_query($con,$consulta2);
$resultado2=$facturacion->obtener_folio();
$row2=mysqli_fetch_array($resultado2);

$folio = $row2[0];

$mail = new PHPMailer(true);

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
    $mail->setFrom('orware.factura@gmail.com', $row['nombre']);
    $mail->addAddress($_GET['correo'], utf8_decode($_GET['nombre']));     
    /*$mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('../facturas/'. $folio .'_Factura.pdf'); 
    $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.xml');
    $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.png');
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode('FACTURACIÓN CFDI - VERSIÓN 4.0');
    $mail->Body    = 'Se adjuntan los siguientes documentos, por favor de no contestar este correo ya que es generado de manera automatica';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Messagehasbeensent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} */
?>