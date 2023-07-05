<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte_info.php");
  include_once("clase_cuenta.php");
  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $forma_pago= NEW Forma_pago(0);
  $cuenta = new Cuenta(0);
  $usuario_id = $_GET['usuario_id'];
  /*$ticket_inicial= $ticket->ticket_ini();
  $ticket_final= $ticket->ticket_fin();
  $inf= NEW Corte_info($ticket_inicial,$ticket_final);*/
  $inf= NEW Corte_info($usuario_id);
  $total_cuartos_hospedaje= 0;
  $suma_cuartos_hospedaje= 0; 
  $total_cuartos= 0;
  $total_productos= 0;
  $total_restaurante= 0;
  $total_productos_hab= 0;
  $total_productos_rest= 0;
  echo '
      <div class="container-fluid blanco">
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">SALDO DE HUÉSPEDES - EN CASA </h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-danger btn-block" value="Reporte"  onclick="aceptar_ver_saldo_huspedes()">
          </div>
          </div>
        </div>
        
        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col-sm-12">
           ';
              echo '
              
                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Número de hab.</th>
                    <th>Nombre del húesped</th>
                    <th>Abonos</th>
                    <th>Cargos</th>
                    <th>Saldo</th>
                    <th>Tarifa xnx</th>
                    </tr>
                  </thead>
                <tbody>';
                //obtenemos los cargos por habitacion
                $consulta= $cuenta->hab_ocupadas();
                $fila_atras="";
                $c=0;

                while ($fila = mysqli_fetch_array($consulta)) {

                    $abonos = $cuenta->obtner_abonos($fila['mov']);
                    $cargos = $cuenta->mostrar_total_cargos($fila['mov']);
                    $saldo = $cuenta->mostrar_faltante($fila['mov']);
                  
                    $nombre_huesped = $fila['nombre'] . ' ' . $fila['apellido'];
                    // $datos_credito = $cuenta->mostrarLimiteCredito($fila['mov']); esto es para obtenerlo de la tabla huesped
                    //$estado_credito = $datos_credito[0];
                    //$limite_credito = $datos_credito[1];

                    $estado_credito = $fila['estado_credito'];
                    $limite_credito = $fila['limite_credito'];

                    echo '<tr class="text-center">';
                    if($fila_atras!= $fila['hab_nombre']) {


                        echo '<td>'.$fila['hab_nombre'].'</td>';
                        echo '<td>'.$nombre_huesped.'</td>';
                        echo '<td>'.$abonos.'</td>';
                        echo '<td>'.$cargos.'</td>';
                        echo '<td>'.$saldo.'</td>';
                        echo '<td>'.$fila['tarifa'].'</td>';

                    }else{
                        echo '<td></td>';
                        echo '<td>'.$nombre_huesped.'</td>';
                        echo '<td>'.$abonos.'</td>';
                        echo '<td>'.$cargos.'</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                       
                    }

                    echo '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Estado credito: '.$estado_credito.'</td>
                    <td>Límite de crédito: '.number_format($limite_credito,2).'</td>
                    </tr>
                    ';

                    echo '</tr>';
                    $fila_atras = $fila['hab_nombre'];
                    $c++;
                  
                }


            
    echo ' </tbody>
    </table>
    </div>
  </div>
  ';

  //todos los abonos

  
 
echo ' </tbody>
</table>
</div>
</div>
</div>
</div>
';


  echo '</div>';
?>

