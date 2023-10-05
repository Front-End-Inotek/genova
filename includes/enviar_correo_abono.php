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

    $imagenEncabezado = "../images/hotelexpoabastos.png";
    $imagenID = $mail->AddEmbeddedImage($imagenEncabezado, 'imagen_encabezado', "hotelexpoabastos.png");


    $correo = $huesped->correo;


    $nombreHotel = $conf->nombre;



    if(!empty($correo)){

        $descripcion = $_POST['descripcion'];
        $descripcion = urldecode($descripcion);
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');

        $abono =$_POST['abono'];
        $forma_pago = $_POST['forma_pago'];

        $forma_pago = urldecode($forma_pago);
        $forma_pago = htmlspecialchars($forma_pago, ENT_QUOTES, 'UTF-8');

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
            $mail->CharSet = 'UTF-8'; 
            //Recipients
            $mail->setFrom('orware.factura@gmail.com', $nombreHotel);
            $mail->addAddress($correo, $nombreHotel);  
    
            $contenido_pie="
            <div style='background-color: #2D3F54; text-align: center; padding: 8px; color: #fff; ' >
              <div style='text-align:center'>
                  <p>Le invitamos a visitar nuestra página web: <a style='color: #A0C3FF !important;'>$conf->credencial_auto</a>. <br/>
                  <p> donde encontrará mayor información acerca de nuestras instalaciones y servicios.</p>
                  <span>$conf->domicilio</span>
              </div>
            </div>";


    
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            $mail->Subject = ('Abono Visit');
            $mail->msgHTML('
            <div style="padding: 0px 35px;
            margin-bottom: 30px;
            max-width: 900px;
            text-align: initial;
            background-color: #F7F7F7;
            color: black;
            font-family:Arial">

            <div style="background-color: #2D3F54; text-align: center; padding: 8px; " >
              <h2 style="font-weight: bold; font-size: 24px; color: #ffffff;"> Confirmación de abono realizado correctamente </h2>
              <img style="background-color: #F7F7F7; border-radius: 15px; height: 7rem;"  src="cid:imagen_encabezado" alt="Encabezado" />
            </div>
    
            <p>Estimado(A) Sr (Srita) <span style="color: #2D3F54; font-weight: 700;">'. str_repeat('&nbsp;', 1). $nombre_huesped. str_repeat('&nbsp;', 1).' </span> </p>
    
            <p>Su abono ha sido procesado con éxito con fecha '.$fecha_actual.'</p>
    
            <table style="vertical-align:top;   border-collapse: collapse; margin: 2rem 0 ;">
            <thead>
              <tr style="border: 1px solid #2D3F54 !important;
              font-size: 13px;
              font-family: sans-serif;
              font-weight: bolder;
              ">
              <th style="border: 1px solid #2D3F54; background: #2D3F54; color: white; padding: 5px 10px;" >Descripción</th>
              <th style="border: 1px solid #2D3F54; background: #2D3F54; color: white; padding: 5px 10px;" >Fecha</th>
              <th style="border: 1px solid #2D3F54; background: #2D3F54; color: white; padding: 5px 10px;" >Abono</th>
              <th style="border: 1px solid #2D3F54; background: #2D3F54; color: white; padding: 5px 10px;" >Forma Pago</th>
           
              </tr>
            </thead>
            <tbody>
    
            <tr>
            <td style="border: 1px solid #2D3F54; padding: 5px 10px;" >'.(($descripcion)).'</td>
            <td style="border: 1px solid #2D3F54; padding: 5px 10px;" >'.$f_h.'</td>
            <td style="border: 1px solid #2D3F54; padding: 5px 10px;" >$'.number_format($abono,2).'</td>
            <td style="border: 1px solid #2D3F54; padding: 5px 10px;" >'.$forma_pago.'</td>
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