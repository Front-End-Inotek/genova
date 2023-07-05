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
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">Auditoria</h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-danger btn-block" value="Cerrar la noche" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_guardar_corte_nuevo()">
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
                    <th>Hab. <input type="checkbox"  /></th>
                    <th>Cargos </th>
                    <th>Descripción</th>
                    </tr>
                  </thead>
                <tbody>';
                //obtenemos los cargos por habitacion
                $consulta= $cuenta->estadoCargosHabs();
                $fila_atras="";
                $total_cargos=0;
                $total_=0;
                $c=0;

                while ($fila = mysqli_fetch_array($consulta)) {
                    echo '<tr class="text-center">';
                    if($fila_atras!= $fila['hab_nombre']) {
                        echo '<td>
                        <span>'.$fila['hab_nombre'].'</span>
                        <input type="checkbox"  />
                        </td>';
                    }else{
                        echo '<td></td>';
                    }
                $campo = "campo".$c;
                echo '<td>
                        <p>'.number_format($fila['cargo'],2).'</p>
                        <input type="number" class="color_black campos_cargos" style="width:30%" id="'.$campo.'"
                        data-cuentaid ="'.$fila['cuenta_id'].'"
                        />
                </td>';

                echo '<td>'.$fila['descripcion'].'</td>';
                echo '</tr>';

                $fila_atras = $fila['hab_nombre'];

                $c++;

                }


                // while ($fila = mysqli_fetch_array($consulta)) {

                //     $saldo = $cuenta->mostrar_faltante($fila['mov']);
                //     $estado_credito = $cuenta->mostrarLimiteCredito($fila['mov']);
                //     $opc_credito = $estado_credito[0];
                //     $limite_credito = $estado_credito[1];

                //     echo '<tr class="text-center">';
                //     if($fila_atras!= $fila['hab_nombre']) {

                       

                //         echo '<td>'.$fila['hab_nombre'].'</td>';
                //         echo '<td>'.$fila['descripcion'].'</td>';
                //         echo '<td>'.$fila['cargo'].'</td>';
                //         echo '<td>'.$fila['abono'].'</td>';
                //         echo '<td>'.$saldo.'</td>';
                //         echo '<td>'.$fila['tarifa'].'</td>';

                //     }else{
                //         echo '<td></td>';
                //         echo '<td>'.$fila['descripcion'].'</td>';
                //         echo '<td>'.$fila['cargo'].'</td>';
                //         echo '<td>'.$fila['abono'].'</td>';
                //         echo '<td></td>';
                //         echo '<td></td>';

                        
                //             echo '<tr>
                //             <td></td>
                //             <td></td>
                //             <td></td>
                //             <td></td>
                //             <td>Estado credito: '.$opc_credito.'</td>
                //             <td>Límite de crédito: '.number_format($limite_credito,2).'</td>
                //             </tr>
                //             ';
                       
                //     }

                //     echo '</tr>';
                //     $fila_atras = $fila['hab_nombre'];
                //     $c++;
                  
                // }


            
    echo ' </tbody>
    </table>
    </div>
  </div>
  ';


echo ' </tbody>
</table>
</div>
<div class="d-flex justify-content-end">
<button type="button" class="btn btn-success" onclick="confirmar_cambiar_cargos()"> Aceptar</button>
</div>


</div>
</div>
</div>
';


  echo '</div>';
?>

