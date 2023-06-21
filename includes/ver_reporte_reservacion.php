<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $correo = $_GET['correo'];
  $ruta = $_GET['ruta'];
  echo ' <div class="container blanco">
         <div class="row">
         <div class="col-sm-11 blanco_margen">

            <div class="row">

              <div class="col-sm-7 d-flex justify-content-end "><h2 class="text-dark">'.$_GET['titulo'].' '.$_GET['id'].'</h2></div>

              <div class="col-sm-4  ">
              <div class=" d-flex justify-content-between">
                <div  id="boton_reservacion">
                  <input type="submit" class="btn btn-success btn-block margen-1" value="Imprimir" onclick="reporte_reservacion('.$_GET['id'].')">
                </div>
                <div  id="boton_reservacion">
                <input type="submit" class="btn btn-success btn-block margen-1" value="Reenviar" onclick="enviar_reserva_correo('.$_GET['id'].',\''.$correo.'\',true)">
                </div>
                <div ><button class="btn btn-info btn-block" onclick="'.$ruta.'"> ←</button></div>
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
                    $cantidad_hospedaje= $fila['cantidad_hospedaje'];
                    $extra_adulto= $fila['extra_adulto'];
                    $extra_junior= $fila['extra_junior'];
                    $extra_infantil= $fila['extra_infantil'];
                    $extra_menor= $fila['extra_menor'];
                    $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
                    $quien_reserva= $fila['nombre_reserva'];
                    $acompanante= $fila['acompanante'];
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
                            $precio_hospedaje = "tarifa forzada:" . $fila['forzar_tarifa'];
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
              <div class="col-sm-6">Fecha Entrada: '.$fecha_entrada.'</div>
              <div class="col-sm-5">Fecha Salida: '.$fecha_salida.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Usuario que la hizo: '.$usuario_reservacion.'</div>
              <div class="col-sm-5">Cantidad habitaciones: '.$numero_hab.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Noches: '.$noches.'</div>
              <div class="col-sm-5">Tarifa: '.$tarifa.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Nombre Huesped: '.$nombre_huesped.'</div>
              <div class="col-sm-5">Quién Reserva: '.$quien_reserva.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Acompañante: '.$acompanante.'</div>
              <div class="col-sm-5">Cantidad Hospedaje: '.$cantidad_hospedaje.'</div>
            </div>
            <div class="row">';
              if($extra_adulto>0){
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6">Extra Adulto: '.$extra_adulto.'</div>';
              }else{
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6"></div>'; 
              }

              if($extra_junior>0){
                echo '<div class="col-sm-5">Extra Junior: '.$extra_junior.'</div>';
              }else{
                echo '<div class="col-sm-5"></div>'; 
              }
            echo '</div>
            <div class="row">';
              if($extra_infantil>0){
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6">Extra Infantil: '.$extra_infantil.'</div>';
              }else{
                echo '<div class="col-sm-1"></div>';
                echo '<div class="col-sm-6"></div>'; 
              }

              if($extra_menor>0){
                echo '<div class="col-sm-5">Extra Menor: '.$extra_menor.'</div>';
              }else{
                echo '<div class="col-sm-5"></div>'; 
              }
            echo '</div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Número Cuenta: '.$id_cuenta.'</div>
              <div class="col-sm-5">Precio Hospedaje: '.$precio_hospedaje.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Suplementos: '.$suplementos.'</div>
              <div class="col-sm-5">Total suplementos: '.$total_suplementos.'</div>'; 
            echo '</div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Forma Pago: '.$forma_pago.'</div>
              <div class="col-sm-5">Limite Pago: '.$limite_pago.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Total Habitacion: '.$total_habitacion.'</div>
              <div class="col-sm-5">Descuento: '.$descuento.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Total Estancia: '.$total_estancia.'</div>
              <div class="col-sm-5">Total Pago: '.$total_pago.'</div>
            </div><hr> 
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-11 text-left"><h4 class="text-dark">DATOS HUÉSPED</h4></div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Nombre: '.$huesped->nombre.'</div>
              <div class="col-sm-5">Apellido: '.$huesped->apellido.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Direccion: '.$huesped->direccion.'</div>
              <div class="col-sm-5">Ciudad: '.$huesped->ciudad.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Estado: '.$huesped->estado.'</div>
              <div class="col-sm-5">Codigo postal: '.$huesped->codigo_postal.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Telefono: '.$huesped->telefono.'</div>
              <div class="col-sm-5">Correo: '.$huesped->correo.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Contrato Socio: '.$huesped->contrato.'</div>
              <div class="col-sm-5">Cupón: '.$huesped->cupon.'</div>
            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-6">Preferencias del huésped: '.$huesped->preferencias.'</div>
              <div class="col-sm-5">Comentarios adicionales: '.$huesped->comentarios.'</div>
            </div>
        </div>'; 
  echo '
         </div><div class="col-sm-1"></div>
         </div></div>';
?>
