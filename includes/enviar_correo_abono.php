<?php
    require_once('../PHPMailer/class.phpmailer.php');
    include_once("clase_correo.php");
    include_once("clase_movimiento.php");
    include_once("clase_huesped.php");
    include_once("clase_configuracion.php");
    include_once('clase_log.php');

    $conf = NEW Configuracion(0);
    $logs = NEW Log(0);
    $correo=NEW Email();
    $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.

    $movimiento = new Movimiento(0);

    $id_huesped= $movimiento->saber_id_huesped($_POST['mov']);
      // Datos de reservacion
    $huesped= NEW Huesped($id_huesped);  
    $nombre_huesped =$huesped->nombre ." ".$huesped->apellido;

    $correo = $huesped->correo;




    if(!empty($correo)){

        $descripcion = $_POST['descripcion'];
        $abono =$_POST['abono'];
        $forma_pago = $_POST['forma_pago'];

        $fecha = date("d-m-Y");
        $f_h = date('d-m-Y');
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $mes= $logs->formato_fecha($mes);
        $anio = substr($fecha, 6, 4);

        $fecha_actual = $dia . " de " . $mes . " de " . $anio;

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
            $mail->addAddress($correo, utf8_decode('Carlos Garcia'));  
    
            $contenido_pie="<div style='text-align:center'><p>Le invitamos a visitar nuestra página web:$conf->credencial_auto donde encontrará mayor información acerca de nuestras instalaciones y servicios.</p>
            <span>$conf->domicilio</span>
            </div>";
    
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = utf8_decode('Abono Visit');
            $mail->msgHTML('
            <div style="padding: 35px 35px;
            margin-bottom: 30px;
            margin-top: 30px;
            margin-left: 45px;
            text-align: initial;
            margin-left: 40px;
            border: 2px solid #3f51b5;
            font-family:Arial">
    
            <h2 style="font-weight: bold;"> Confirmación de abono realizado correctamente </h2>
    
            <p>Estimado(A) Sr (Srita) <span style="text-decoration:underline;">'. str_repeat('&nbsp;', 5). $nombre_huesped. str_repeat('&nbsp;', 5).' </span> </p>
    
            <p>Su abono ha sido procesado con éxito con fecha  '.$fecha_actual.'</p>
    
            <table style="vertical-align:top;   border-collapse: collapse; ">
            <thead>
              <tr style=" border: 2px solid #3f51b5 !important;
              color: #fff;
              font-size: 13px;
              font-family: sans-serif;
              font-weight: bolder;
              background: linear-gradient(180deg, #2d31ae 0%, #4e4ef0 50%, #1f238a 100%);
              ">
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Abono</th>
              <th>Forma Pago</th>
           
              </tr>
            </thead>
            <tbody>
    
            <tr>
            <td>'.urlencode($descripcion).'</td>
            <td>'.$f_h.'</td>
            <td>$'.number_format($abono,2).'</td>
            <td>'.$forma_pago.'</td>
            </tr>
    
            </tbody>
            </table>
            <hr>
         
            '.$contenido_pie.'
            </div>');
    
    
    
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            echo 'Messagehasbeensent';
            // $logs->guardar_log($_POST['usuario_id'], "Enviar confirmación: ". $_POST['info']);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>