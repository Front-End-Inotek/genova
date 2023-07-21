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
                  <button type="submit" class="btn btn-success btn-block margen-1" value="Imprimir" onclick="reporte_reservacion('.$_GET['id'].')">Imprimir</button>
                </div>';
                if($titulo=="RESERVACIÓN"){
                  echo '<div  id="boton_reservacion">
                  <button type="submit" class="btn btn-success btn-block margen-1" value="Reenviar" onclick="enviar_reserva_correo('.$_GET['id'].',\''.$correo.'\',true)">Reenviar</button>
                  </div>';
                }
                echo '
                <div ><button class="btn btn-info btn-block" onclick="'.$ruta.'">⬅</button></div>
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
                    $costo_tarifa = $fila['total'];
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
                            $total_estancia= '$'.number_format($fila['forzar_tarifa'], 2);
                            $precio_hospedaje = "tarifa forzada: " . number_format($fila['forzar_tarifa'],2);
                    }else{
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
            echo '<div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Fecha Entrada:</span> '.$fecha_entrada.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Fecha Salida:</span> '.$fecha_salida.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Usuario que la hizo:</span> '.$usuario_reservacion.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Cantidad habitaciones:</span> '.$numero_hab.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Noches:</span> '.$noches.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Tarifa:</span> '.$tarifa.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Nombre Huesped:</span> '.$nombre_huesped.'</div>';
              if($quien_reserva!="checkin"){
                echo '<div class="col-sm-5"><span class="texto_reporte">Quién Reserva:</span> '.$quien_reserva.'</div>';
              }else{
                echo '<div class="col-sm-5"></div>';
              }
              echo '
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Tarifa:</span> '.' $'.number_format($costo_tarifa,2).'</div>
              <div class="col-sm-5"><span class="texto_reporte">Cantidad Hospedaje:</span> '.$cantidad_hospedaje.'</div>
            </div>
            <div class="row">';
              if($extra_adulto>0){
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6"><span class="texto_reporte">Extra Adulto:</span> '.$extra_adulto.' ('.$precio_adulto.')</div>';
              }else{
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6"></div>'; 
              }

              if($extra_junior>0){
                echo '<div class="col-sm-5"><span class="texto_reporte">Extra Junior:</span> '.$extra_junior.'</div>';
              }else{
                echo '<div class="col-sm-5"></div>'; 
              }
            echo '</div>
            <div class="row">';
              if($extra_infantil>0){
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6"><span class="texto_reporte">Extra Infantil:</span> '.$extra_infantil.' ('.$precio_infantil.')</div>';
              }else{
                echo '<div></div>';
                echo '<div class="col-sm-6"></div>'; 
              }

              if($extra_menor>0){
                echo '<div class="col-sm-5"><span class="texto_reporte">Extra Menor:</span> '.$extra_menor.'</div>';
              }else{
                echo '<div class="col-sm-5"></div>'; 
              }
            echo '</div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Número Cuenta:</span> '.$id_cuenta.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Precio Hospedaje:</span> '.$precio_hospedaje.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Suplementos:</span> '.$suplementos.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Plan Alimentos:</span> '.$total_alimentos.'</div>'; 
            echo '</div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Forma Pago:</span> '.$forma_pago.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Pax Extra:</span> '.$pax_extra.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Total Habitacion:</span> '.$total_habitacion.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Descuento:</span> '.$descuento.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Total Estancia:</span> '.$total_estancia.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Total Pago:</span> '.$total_pago.'</div>
            </div><hr> 
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-11 text-left"><h4 class="text-dark">DATOS HUÉSPED</h4></div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Nombre:</span> '.$huesped->nombre.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Apellido:</span> '.$huesped->apellido.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Direccion:</span> '.$huesped->direccion.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Ciudad:</span> '.$huesped->ciudad.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Estado:</span> '.$huesped->estado.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Codigo postal:</span> '.$huesped->codigo_postal.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Telefono:</span> '.$huesped->telefono.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Correo:</span> '.$huesped->correo.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Contrato Socio:</span> '.$huesped->contrato.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Cupón:</span> '.$huesped->cupon.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6"><span class="texto_reporte">Preferencias del huésped:</span> '.$huesped->preferencias.'</div>
              <div class="col-sm-5"><span class="texto_reporte">Comentarios adicionales:</span> '.$huesped->comentarios.'</div>
            </div>
        </div>'; 
  echo '
         </div><div class="col-sm-1"></div>
         </div></div>';
?>
