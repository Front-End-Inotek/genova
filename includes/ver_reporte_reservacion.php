<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $correo = $_GET['correo'];
  $ruta = $_GET['ruta'];
  $titulo = $_GET['titulo'];

  echo ' <div class="container blanco">
         <div class="row">
         <div class="col-sm-11 blanco_margen">

            <div class="row">

              <div class="col-sm-7 d-flex justify-content-end "><h2 class="text-dark">'.$titulo.' '.$_GET['id'].'</h2></div>

              <div class="col-sm-4  ">
              <div class=" d-flex justify-content-between">
                <div  id="boton_reservacion">
                  <button type="submit" class="btn btn-success btn-block margen-1" value="Imprimir" onclick="reporte_reservacion('.$_GET['id'].',\''.$titulo.'\')">Imprimir</button>
                </div>';
                if($titulo=="RESERVACIÓN"){
                  echo '<div  id="boton_reservacion">
                  <button type="submit" class="btn btn-success btn-block margen-1" value="Reenviar" onclick="enviar_reserva_correo('.$_GET['id'].',\''.$correo.'\',true)">Reenviar</button>
                  </div>';
                }
                //<div ><button class="btn btn-info btn-block" onclick="'.$ruta.'">⬅</button></div>
                echo '
                <div >
                  <button class="btn btn-info btn-block" onclick="'.$ruta.'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                  </button>
                </div>
              </div>
              </div>
            </div>';
            $consulta= $reservacion->datos_reservacion($_GET['id']);
            while ($fila = mysqli_fetch_array($consulta))
            {
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
                    $cantidad_hospedaje= $fila['reserva_cantidad'];
                    $extra_adulto= $fila['extra_adulto'];
                    $precio_adulto =  '$'.number_format($fila['precio_adulto'], 2);
                    $extra_junior= $fila['extra_junior'];
                    $extra_infantil= $fila['extra_infantil'];
                    $precio_infantil =  '$'.number_format($fila['precio_infantil'], 2);
                    $extra_menor= $fila['extra_menor'];
                    $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
                    $quien_reserva= $fila['nombre_reserva'];
                    $acompanante= $fila['acompanante'];
                    $pax_extra ='$'.number_format($fila['pax_extra'],2);
                    $nombre_plan = $fila['nombre_plan'];
                    // Checar si suplementos esta vacio o no
                    if (empty($fila['suplementos'])){
                            //echo 'La variable esta vacia';
                            $suplementos= 'Ninguno';
                    }else{
                            $suplementos= $fila['suplementos'];
                    }
                    $total_suplementos= '$'.number_format($fila['total_suplementos'], 2);
                    $total_alimentos= '$'.number_format($fila['costo_plan'], 2);
                    $total_habitacion= '$'.number_format($fila['total_hab'], 2);
                    if($fila['descuento']>0){
                            $descuento= $fila['descuento'].'%'; 
                    }else{
                            $descuento= 'Ninguno'; 
                    }
                    if($fila['forzar_tarifa']>0){
                            $costo_tarifa = $fila['forzar_tarifa'];
                            $total_estancia= '$'.number_format($fila['total'], 2);
                            $nombre_tarifa ="Forzada";
                            $precio_hospedaje = "tarifa forzada: " . number_format($fila['forzar_tarifa'],2);
                    }else{
                            $costo_tarifa = $fila['precio_hospedaje'];
                            $nombre_tarifa=$fila['nombre_tarifa'];
                            $total_estancia= '$'.number_format($fila['total'], 2);
                    }
                    if($fila['total_pago']>0){
                            $total_pago= '$'.number_format($fila['total_pago'], 2);
                    }else{
                            $total_pago= 'Ninguno';
                    }
                    $forma_pago= $fila['descripcion'];
                    $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
            }
            $huesped= NEW Huesped($id_huesped);
            echo '
            <div class="container row">
            <ul class="list-group list-group-flush col-6">
              <li class="list-group-item">
                <h5 class="texto_reporte ">Fecha Entrada:</h5>
                <h4>'.$fecha_entrada.'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Usuario que la hizo:</h5>
                <h4>'.$usuario_reservacion.'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Noches:</h5>
                <h4>'.$noches.'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Nombre Huesped:</h5>
                <h4>'.$nombre_huesped.'</h4>
                </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Tarifa:</h5>
                <h4>'.' $'.number_format($costo_tarifa,2).'</h4>
              </li>';
              if($extra_infantil > 0 ){
                echo '
                <li class="list-group-item">
                  <h5 class="texto-reporte ">Extra infantil:</h5>
                  <h4>'.$extra_infantil.' ('.$precio_infantil.')</h4>
                </li>
                ';
              } else {
                echo '
                ';
              }
              if($extra_menor > 0 ){
                echo'
                  <li class="list-group-item">
                    <h5 class="texto-reporte ">Extra menor:</h5>
                    <h4>'.$extra_menor.'</h4>
                  </li>
                ';
              } else {
                echo '
                ';
              }
              echo '
              </ul>

              <ul class="list-group list-group-flush col-6">
              <li class="list-group-item">
              <h5 class="texto_reporte ">Fecha Salida:</h5>
                <h4>'.$fecha_salida.'</h4>
                </li>
              <li class="list-group-item">
              <h5 class="texto_reporte ">Cantidad habitaciones</h5>
                <h4>'.$numero_hab.'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Nombre Tarifa:</h5>
                <h4>'.$nombre_tarifa.'</h4>
              </li>
              <li class="list-group-item">';
                if($quien_reserva   !="checkin"){
                  echo '
                    <h5 class="texto_reporte ">Quién Reserva:</h5>
                    <h4>'.$quien_reserva.'</h4>
                  ';
                }else {
                  echo '
                  ';
                }
                echo '
                </li>
                <li class="list-group-item">
                <h5 class="texto_reporte">Cantidad Hospedaje:</h5> 
                <h4>'.$cantidad_hospedaje.'</h4>
                </li>
              </ul>
            </div>


            <!-- -------------------------------------------------------------------------------- -->


            <div class="container row">
              <ul class="list-group list-group-flush col-6">
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Número Cuenta:</h5>
                  <h4>'.$id_cuenta.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Suplementos:</h5>
                  <h4>'.$nombre_plan.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Forma Pago:</h5>
                  <h4>'.$forma_pago.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Total Habitación:</h5>
                  <h4>'.$total_habitacion.'</h4>
                </li>
                <li>
                  <h5 class="texto_reporte ">Total Estancia:</h5>
                  <h4>'.$total_estancia.'</h4>
                </li>
              </ul>
              <ul class="list-group list-group-flush col-6">
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Precio Hospedaje:</h5>
                  <h4>'.$precio_hospedaje.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Plan Alimentos:</h5>
                  <h4>'.$total_alimentos.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Pax Extra:</h5>
                  <h4>'.$pax_extra.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Descuento:</h5>
                  <h4>'.$descuento.'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Total Pago:</h5>
                  <h4>'.$total_pago.'</h4>
                </li>
              </ul>
            </div>

            <div class="row">
              <div class="col-sm-12 text-left"><h4 class="text-dark">DATOS HUÉSPED</h4></div>
            </div>

            <div class="container row">
                <ul class="list-group list-group-flush col-6">
                  <li class="list-group-item">
                    <h5 class="texto_reporte" >Nombre</h5>
                    <h4>'.$huesped->nombre.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Dirección:</h5>
                    <h4>'.$huesped->direccion.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Estado</h5>
                    <h4>'.$huesped->estado.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Telefono:</h5>
                    <h4>'.$huesped->telefono.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Contrato Socio:</h5>
                    <h4>'.$huesped->contrato.'</h4>
                  </li>
                  <li>
                    <h5 class="texto_reporte">Preferencias del huésped</h5>
                    <h4>'.$huesped->preferencias.'</h4>
                  </li>
                </ul>
                <ul class="list-group list-group-flush col-6">
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Apellido:</h5>
                    <h4>'.$huesped->apellido.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Dirección:</h5>
                    <h4>'.$huesped->direccion.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Codigo postal:</h5>
                    <h4>'.($huesped->codigo_postal ? $huesped->codigo_postal : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Correo</h5>
                    <h4>'.$huesped->correo.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Cupón</h5>
                    <h4>'.$huesped->cupon.'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Comentarios adicionales:</h5>
                    <h4>'.$huesped->comentarios.'</h4>
                  </li>
                </ul>
            </div>
        </div>';
  echo '
         </div><div class="col-sm-1"></div>
         </div></div>';
?>
