<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte_info.php");
  include_once("clase_cuenta.php");
  include_once("clase_usuario.php");

  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $forma_pago= NEW Forma_pago(0);
  $cuenta = new Cuenta(0);
  $usuario_id = $_GET['usuario_id'];
  $usuario = new Usuario($usuario_id);


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
        <div class="main_container_title">
          <h2>Auditoria</h2>
          <button type="submit" class="btn btn-primary btn-block" value="Cerrar la noche"   onclick="confirmar_cambiar_cargos()">
            Cerrar la noche
          </button>
        </div>

        
        
        <div class="text-dark margen-1"></div>

          <div class="col-sm-12">
           ';
              echo '
            
                <div class="table-responsive" id="tabla_tipo">
                <table class="table  table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>
                      <div>
                        <input type="checkbox" id="cajas" class="form-check-input"  onclick="cajasAuditoria()"  checked />
                        <label class="form-check-label" for="cajas" >Hab.</label>
                      </div>
                      </th>
                    <th>Cargos </th>
                    <th>Descripción</th>
                    </tr>
                  </thead>
                <tbody>';
                $editar_auditoria = $usuario->auditoria_editar;

                //obtenemos los cargos por habitacion
                $consulta= $cuenta->estadoCargosHabs($editar_auditoria);
                $fila_atras="";
                $total_cargos=0;
                $total_=0;
                $c=0;
                $tarifa=0;
             
                $i = 0;
                while ($fila = mysqli_fetch_array($consulta)) {
                    echo '<tr class="text-center">';
                    if($fila_atras!= $fila['hab_nombre']) {
                        echo '
                        <td>
                        <div cass="form-check">
                          <input type="checkbox"  class="form-check-input campos_habs" id="'.$i.'"  checked />
                          <label class="form-check-label" for="'.$i.'" >'.$fila['hab_nombre'].'</label>
                        </div>
                        </td>';
                        $i++;
                    }else{
                        echo '<td></td>';
                    }
                    $campo = "campo".$c;
                    echo '<td>';
                    if($fila['forzar_tarifa'] != 0){
                      $tarifa = $fila['tarifa'];
                    }else{
                      $tarifa = $fila['tarifa'];
                    }
                    if($editar_auditoria){
                      echo '
                      <div class="form-floating">
                        <input type="number" class="form-control campos_cargos"  id="'.$campo.'" data-oldvalue="'.$tarifa.'" data-reservaid ="'.$fila['reserva_id'].'" placeholder="numero"/>
                        <label for="'.$campo.'" >'.number_format($tarifa,2).'</label>
                      </div>
                      ';
                    }
                    echo '
                    </td>';

                    echo '<td>Cargo por noche</td>';
                    echo '</tr>';

                    $fila_atras = $fila['hab_nombre'];

                    $c++;

                }

            
    echo ' </tbody>
    </table>
    </div>
  </div>
  ';


echo ' </tbody>
</table>

<!---
<div class="d-flex justify-content-end">
<button type="button" class="btn btn-success" onclick="confirmar_cambiar_cargos()"> Aceptar</button>
</div>

--->

</div>
</div>
</div>
';


  echo '</div>';
?>

