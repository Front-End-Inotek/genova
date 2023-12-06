<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $correo = $_GET['correo'];
  $ruta = $_GET['ruta'];
  $titulo = $_GET['titulo'];

  echo ' <div class="main_container">

            <header class="main_container_title">

              <h2>'.$titulo.' '.$_GET['id'].'</h2>

              <div class="btn_resumen_reservacion">
                  <div  id="boton_reservacion">
                    <button type="submit" class="btn btn-primary" value="Imprimir" onclick="reporte_reservacion('.$_GET['id'].',\''.$titulo.'\')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                      </svg>
                      Imprimir
                    </button>
                  </div>';
                  if($titulo=="RESERVACIÓN"){
                    echo '
                    <div  id="boton_reservacion">
                    <button type="submit" class="btn btn-primary" value="Reenviar" onclick="enviar_reserva_correo('.$_GET['id'].',\''.$correo.'\',true)">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                      </svg>
                      Reenviar
                    </button>
                    </div>';
                  }
                  //<div ><button class="btn btn-info btn-block" onclick="'.$ruta.'">⬅</button></div>
                  echo '
                    <button class="btn btn-link" onclick="'.$ruta.'">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"></path>
                      </svg>
                    </button>
              </div>
            </header>';
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
            <div class="contenedor_reporte_reservacion">
            <ul class="list-group list-group-flush list_group_perzonalizado " >
              <li class="list-group-item">
                <h5 class="texto_reporte ">Fecha Entrada:</h5>
                <h4>'.($fecha_entrada ? $fecha_entrada : "-").'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Usuario que la hizo:</h5>
                <h4>'.($usuario_reservacion ? $usuario_reservacion : "-").'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Noches:</h5>
                <h4>'.($noches ? $noches : "-").'</h4>
              </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Nombre Huesped:</h5>
                <h4>'.($nombre_huesped ? $nombre_huesped : "-").'</h4>
                </li>
              <li class="list-group-item">
                <h5 class="texto_reporte ">Tarifa:</h5>
                <h4>'.' $'.( $costo_tarifa ? number_format($costo_tarifa,2) : "-").'</h4>
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
             
              <ul class="list-group list-group-flush list_group_perzonalizado ">
                <li class="list-group-item">
                <h5 class="texto_reporte ">Fecha Salida:</h5>
                  <h4>'.($fecha_salida ? $fecha_salida : "-" ).'</h4>
                  </li>
                <li class="list-group-item">
                <h5 class="texto_reporte ">Cantidad habitaciones</h5>
                  <h4>'.($numero_hab ? $numero_hab : "-").'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Nombre Tarifa:</h5>
                  <h4>'.($nombre_tarifa ? $nombre_tarifa : "-" ).'</h4>
                </li>
                <li class="list-group-item">';
                  if($quien_reserva  != "checkin"){
                    echo '
                      <h5 class="texto_reporte ">Quién Reserva:</h5>
                      <h4>'.$quien_reserva.'</h4>
                    ';
                  }else {
                    echo '
                    <h5 class="texto_reporte ">Quién Reserva:</h5>
                    <h4>CHECK-IN</h4>
                    ';
                  }
                  echo '
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte">Cantidad Hospedaje:</h5>
                  <h4>'.($cantidad_hospedaje ? $cantidad_hospedaje : "-" ).'</h4>
                </li>
              </ul>
 
              <ul class="list-group list-group-flush list_group_perzonalizado ">
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Número Cuenta:</h5>
                  <h4>'.($id_cuenta ? $id_cuenta : "-").'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Suplementos:</h5>
                  <h4>'.($nombre_plan ? $nombre_plan : "-" ).'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Forma Pago:</h5>
                  <h4>'.($forma_pago ? $forma_pago : "-" ).'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Total Habitación:</h5>
                  <h4>'.($total_habitacion ? $total_habitacion : "-").'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Total Estancia:</h5>
                  <h4>'.($total_estancia ? $total_estancia : "-" ).'</h4>
                </li>
              </ul>

              <ul class="list-group list-group-flush list_group_perzonalizado ">
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Precio Hospedaje:</h5>
                  <h4>'.($precio_hospedaje ? $precio_hospedaje : "-" ).'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Plan Alimentos:</h5>
                  <h4>'.($total_alimentos ? $total_alimentos : "-" ).'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Pax Extra:</h5>
                  <h4>'.($pax_extra ? $pax_extra : "-").'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Descuento:</h5>
                  <h4>'.($descuento ? $descuento : "-" ).'</h4>
                </li>
                <li class="list-group-item">
                  <h5 class="texto_reporte ">Total Pago:</h5>
                  <h4>'.($total_pago ? $total_pago : "-").'</h4>
                </li>
              </ul>
            </div>

            <div class="main_container_title">
              <h2>DATOS HUÉSPED</h2>
            </div>

            <div class="contenedor_reporte_reservacion">
                <ul class="list-group list-group-flush list_group_perzonalizado ">
                  <li class="list-group-item">
                    <h5 class="texto_reporte" >Nombre</h5>
                    <h4>'.($huesped->nombre ? $huesped->nombre : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Dirección:</h5>
                    <h4>'.($huesped->direccion ? $huesped->direccion : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Estado</h5>
                    <h4>'.($huesped->estado ? $huesped->estado : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Telefono:</h5>
                    <h4>'.($huesped->telefono ? $huesped->telefono : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Contrato Socio:</h5>
                    <h4>'.($huesped->contrato ? $huesped->contrato : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Preferencias del huésped</h5>
                    <h4>'.($huesped->preferencias ? $huesped->preferencias : "-").'</h4>
                  </li>
                </ul>

                <ul class="list-group list-group-flush list_group_perzonalizado ">
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Apellido:</h5>
                    <h4>'.($huesped->apellido ? $huesped->apellido : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Dirección:</h5>
                    <h4>'.($huesped->direccion ? $huesped->direccion : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Codigo postal:</h5>
                    <h4>'.($huesped->codigo_postal ? $huesped->codigo_postal : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Correo</h5>
                    <h4>'.($huesped->correo ? $huesped->correo : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Cupón</h5>
                    <h4>'.($huesped->cupon ? $huesped->cupon : "-").'</h4>
                  </li>
                  <li class="list-group-item">
                    <h5 class="texto_reporte">Comentarios adicionales:</h5>
                    <h4>'.($huesped->comentarios ? $huesped->comentarios : "-").'</h4>
                  </li>
                </ul>
            </div>
          </div>
            ';
?>
