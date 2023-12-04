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
      <div class="main_container">
        <header class="main_container_title">
          <h2>Saldo de huéspedes - en casa </h2>
          <button type="submit" class="btn btn-primary" value="Reporte"  onclick="aceptar_ver_saldo_huspedes()">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
              </svg>
              Reporte
          </button>
        </header>

        ';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
              echo '

                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table">
                  <thead>
                    <tr class="text-center">
                      <th>Número de hab.</th>
                      <th>Nombre del húesped</th>
                      <th>Abonos</th>
                      <th>Cargos</th>
                      <th>Saldo</th>
                      <th>Tarifa xnx</th>
                      <th>Estado crédito</th>
                      <th>Límite de crédito</th>
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

                        echo '<td>'.$estado_credito.'</td>';
                        echo '<td>'.$limite_credito.'</td>';

                    }else{
                        echo '<td></td>';
                        echo '<td>'.$nombre_huesped.'</td>';
                        echo '<td>'.$abonos.'</td>';
                        echo '<td>'.$cargos.'</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                       
                    }

                    // echo '<tr>
                    // <td></td>
                    // <td></td>
                    // <td></td>
                    // <td></td>
                    // <td>Estado credito: '.$estado_credito.'</td>
                    // <td>Límite de crédito: '.number_format($limite_credito,2).'</td>
                    // </tr>
                    // ';

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



