<?php
    require_once('../PHPMailer/class.phpmailer.php');
    include_once("clase_correo.php");
    include_once("clase_reservacion.php");
    include_once("clase_huesped.php");
    include_once('clase_politicas_reservacion.php');
    include_once("clase_configuracion.php");
    include_once('clase_log.php');
    date_default_timezone_set('America/Mexico_City');
    $reservacion= NEW Reservacion(0);
    $conf = NEW Configuracion(0);
    $logs = NEW Log(0);
    $correo=NEW Email();
    $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.
    //Nombre del hotel
    $nombreHotel = $conf->nombre;
    $imagenEncabezado = "../images/hotelexpoabastos.png";

    $imagenID = $mail->AddEmbeddedImage($imagenEncabezado, 'imagen_encabezado', "hotelexpoabastos.png");
    //Consulta datos de la reserva

    $consulta= $reservacion->datos_cancelacion($_POST['info']);

    while ($fila = mysqli_fetch_array($consulta)){
        $id_hab= $fila['ID'];
        $id_usuario= $fila['id_usuario'];
        $usuario_reservacion= $fila['usuario'];
        $id_huesped= $fila['id_huesped'];
        $id_cuenta= $fila['id_cuenta'];
        $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
        $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
        $noches= $fila['noches'];
        $numero_hab= $fila['numero_hab'];
        $tarifa= $fila['habitacion'];
        $precio_hospedaje= '$'.number_format($fila['precio_hospedaje'], 2);
        $cantidad_hospedaje= $fila['cantidad_hospedaje'];
        $extra_adulto= $fila['extra_adulto'];
        $extra_junior= $fila['extra_junior'];
        $extra_infantil= $fila['extra_infantil'];
        $extra_menor= $fila['extra_menor'];
        $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
        $quien_reserva= $fila['nombre_reserva'];
        $acompanante= $fila['acompanante'];
        $tarifa_noche = $fila['precio_hospe'];
        $nombre_cancela=$fila['nombre_cancela'];
        $motivo_cancela=$fila['motivo_cancela'];
        $fecha_cancelacion = $fila['fecha_cancelacion'];
        $habitaciones=$fila['numero_hab'];
        $tipohab=$fila['tipohab'];
        $nombre_alimentos=$fila['nombre_alimentos'];
        $costo_plan = $fila['costo_plan'];
        $costo_plan= '$'.number_format($costo_plan, 2);
        if($tarifa_noche>0){
          $tarifa_noche= '$'.number_format($tarifa_noche, 2);
        }
        // Checar si suplementos esta vacio o no
        if (empty($fila['suplementos'])){
            //echo 'La variable esta vacia';
            $suplementos= 'Ninguno';
        }else{
            $suplementos= $fila['suplementos'];
        }
        $total_suplementos= '$'.number_format($fila['total_suplementos'], 2);
        $total_habitacion= '$'.number_format($fila['total_hab'], 2);
        if($fila['descuento']>0){
            $descuento= $fila['descuento'].'%';
        }else{
            $descuento= 'Ninguno';
        }
        if($fila['forzar_tarifa']>0){
            $total_estancia= '$'.number_format($fila['forzar_tarifa'], 2);
        }else{
            $total_estancia= '$'.number_format($fila['total'], 2);
        }
        $total_estancia= '$'.number_format($fila['total'], 2);
        if($fila['total_pago']>0){
            $total_pago= '$'.number_format($fila['total_pago'], 2);
        }else{
            $total_pago= 'Ninguno';
        }
        $forma_pago= $fila['descripcion'];
        $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
    }

      // Datos de reservacion
  $huesped= NEW Huesped($id_huesped);
  $vencimiento_tarjeta = $huesped->vencimiento_mes . " / " . $huesped->vencimiento_ano;
  //
  include_once('clase_forma_pago.php');

  if($huesped->estado_tarjeta==0 || $huesped->estado_tarjeta==null ){
    $forma_pago = new Forma_pago(0);
  }else{
    $forma_pago = new Forma_pago($huesped->estado_tarjeta);
  }
  $politicas="";
  $pr = new PoliticasReservacion(0);
  $consulta= $pr->datos_politicas();

  while ($politica = mysqli_fetch_array($consulta)) {
    $nombre = $politica['nombre'];
    $descripcion = $politica['descripcion'];
    $politicas.="<p style='font-weight: bold;'>$nombre<p>
    <p>$descripcion</p>
    ";
  }

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
        $mail->setFrom('orware.factura@gmail.com', $nombreHotel);
        $mail->addAddress($_POST['correo'], $nombreHotel);
        //$mail->addAddress('carlosramongarcia@gmail.com', utf8_decode('Carlos Garcia'));
        /*$mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/
        //Attachments
       /* $mail->addAttachment('../facturas/'. $folio .'_Factura.pdf');
        $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.xml');
        $mail->addAttachment('../facturas/'. $folio .'_cfdi_factura.png');*/
        //Content
        $contenido_voucher="";
        $contenido_tarjeta="";
        $contenido_efectivo="";
        $contenido_pie="
        <div style='background-color: #2D3F54; text-align: center; padding: 8px; color: #fff;'>
            <div style='text-align: center'>
                <p>Le invitamos a visitar nuestra página web: <a style='color: #A0C3FF !important; '>$conf->credencial_auto</a>. </p>
                <p>donde encontrará mayor información acerca de nuestras instalaciones y servicios.</p>
                <span>$conf->domicilio</span>
            </div>
        </div>"
        ;

        $pr = new PoliticasReservacion(0);

        if($huesped->estado_tarjeta==2) {
            if($huesped->voucher!="") {
                $contenido_voucher="<p style='font-weight: bold;'>Garantía:</p>
                <span>Voucher</span></br>
                <p>Esta reserva está confirmada y garantizada con un voucher con el  código: '$huesped->voucher'. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos.</p>";
            } else {
                $contenido_tarjeta="<p style='font-weight: bold;'>Garantía:</p>
                <span>$huesped->nombre_tarjeta</span></br>
                <p>Esta reserva está confirmada y garantizada por la tarjeta con el número '$huesped->numero_tarjeta', que caduca el '$vencimiento_tarjeta'. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos.</p>";
            }
        }
        if(strtoupper($forma_pago->descripcion=="EFECTIVO") || strtoupper($huesped->tipo_tarjeta)=="EFECTVIO"){
            $contenido_tarjeta="<p style='font-weight: bold;'>Garantía:</p>
            <p>Esta reserva está confirmada y garantizada por un pago en efectivo. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos.</p>";
        }
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        $mail->Subject = 'Cancelacion Visit';
        $mail->msgHTML('
        <div style="padding: 0px 35px;
        margin-bottom: 30px;
        max-width: 900px;
        text-align: initial;
        background-color: #F7F7F7;
        color: black;
        font-family:Arial">

        <div style=" background-color: #2d3f54; text-align: center; padding: 8px;">
            <h2 style="font-weight: bold; font-size: 24px; color: #ffffff"> Confirmación de cancelación </h2>
            <img style="background-color: #F7F7F7; border-radius: 15px; height: 7rem;"  src="cid:imagen_encabezado" alt="Encabezado" />
        </div>

        <p>Estimado(A) Sr (Srita) <span style="color: #2D3F54; font-weight: 700;">'. str_repeat('&nbsp;', 1). $nombre_huesped. str_repeat('&nbsp;', 1).' </span> </p>
        <p>Su reservación ha sido cancelada con éxito  de acuerdo con los siguientes datos:</p>
        <p style="font-weight: bold; color: #2D3F54;">Datos de cancelación:</p>
        <span style="font-weight: bold; color: #2D3F54;">Usuario que cancela: </span> <span>'.$nombre_cancela.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Motivo de cancelación: </span> <span>'.$motivo_cancela.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Fecha de cancelación: </span> <span>'.date('Y-m-d H:m:s',$fecha_cancelacion).'</span><br><br>
        <span style="font-weight: bold; color: #2D3F54;">Nombre: </span> <span>'.$nombre_huesped.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Empresa/agencia: </span><span>'.$huesped->empresa.' </span><br>
        <span style="font-weight: bold; color: #2D3F54;">Fecha de llegada: </span><span>'.$fecha_entrada.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Fecha de salida: </span><span>'.$fecha_salida.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Número de noches: </span><span> ' .$noches.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Número de habitaciones: </span><span>' .$habitaciones.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Adultos: </span><span> '.$extra_adulto.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Niños: </span><span> '.$extra_infantil.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Tipo de habitación: </span><span> '.$tipohab.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Plan de alimentos: </span><span> '.$nombre_alimentos . " ". $costo_plan.'</span><br>
        <p style="font-weight: bold; color: #2D3F54;">Clave de confirmación: '.$_POST['info'].'</p>
        <span style="font-weight: bold; color: #2D3F54;">Tarifa por noche: </span><span>' .$tarifa_noche.'</span><br>
        <span style="font-weight: bold; color: #2D3F54;">Total estancia: </span><span> ' .$total_estancia.'</span>
        <p style="font-style: italic; font-size: 13px; color: #2D3F54; font-weight: bold;">Precio en Pesos Mexicanos por habitación, por noche 19% impuestos incluidos. Todas nuestras habitaciones son de NO FUMAR<p>
        '.$contenido_voucher.'
        '.$contenido_tarjeta.'
        '.$politicas.'
        '.$contenido_pie.'

        </div>');

        $mail->AltBody = 'Cancelación de reserva';
        $mail->send();
        echo 'Messagehasbeensent';
        $logs->guardar_log($_POST['usuario_id'], "Enviar confirmación: ". $_POST['info']);
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>