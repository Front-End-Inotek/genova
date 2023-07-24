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
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">RESUMEN TRANSACCIONES </h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <button type="submit" class="btn btn-danger btn-block" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_guardar_corte_nuevo()">Hacer reporte</button>
          </div>
          </div>
        </div>
        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col-sm-12">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header"><h5>Cargos</h5></div>
              
              <div class="card-body">
                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Habitación/Folio Maestra</th>
                    <th>Descripción</th>
                    <th>Cargo</th>
                    <th>Abono</th>
                    
                    </tr>
                  </thead>
                <tbody>';
                //obtenemos los cargos por habitacion
                $consulta= $cuenta->mostrarCargos($usuario_id);
             
                $fila_atras="";
                $total_cargos=0;
                $total_=0;

                echo '<tr class="table-secondary" style="text-align:left">';

                echo '<td>Cargos</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                ';
                echo '<tr class="table-secondary">';
                $c=0;
                while ($fila = mysqli_fetch_array($consulta)) {
                  if($fila_atras!= $fila['hab_nombre']){
                    if($c!=0){
                      echo '<tr class="table-primary  text-center">
                      <td></td>
                      <td></td>
                      <td>Total:</td>
                      <td>$'.number_format($total_cargos, 2).'</td>
                      </tr>';
                      $total_cargos=0;
                    }
                    echo '<td>Habitación '.$fila['hab_nombre'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    ';
                  
                  }
                  echo '<td></td>
                    <td>'.$fila['descripcion'].'</td>
                    <td>'.$fila['cargo'].'</td>
                    <td>0</td>
                    </tr>
                      ';
                  
                     

                  $fila_atras=$fila['hab_nombre'];
                  $total_cargos+=$fila['cargo'];
                  $total_+=$fila['cargo'];
                  $c++;
                 
                  
                }
                $total_maestra=0;
                $fila_atras="";
                //cargos cuentas maestras.
                $consulta= $cuenta->mostrarCargosMaestra($usuario_id);
                while ($fila = mysqli_fetch_array($consulta)) {
                  if($fila_atras!= $fila['maestra_id']){
                    if($c!=0){
                      echo '<tr class="table-primary  text-center">
                      <td></td>
                      <td></td>
                      <td>Total:</td>
                      <td>$'.number_format($total_cargos, 2).'</td>
                      </tr>';
                      $total_cargos=0;
                    }
                    echo '<td>Cuenta maestra: '.$fila['maestra_nombre'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    ';

                  }
                  echo '<td></td>
                    <td>'.$fila['descripcion'].'</td>
                    <td>'.$fila['cargo'].'</td>
                    <td>0</td>
                    </tr>
                      ';


                  $fila_atras=$fila['maestra_id'];
                  $total_cargos+=$fila['cargo'];
                  $total_maestra+=$fila['cargo'];
                  $c++;

                }
                echo '<td></td>
                <td></td>
                <td>Total:</td>
                <td>'.$total_cargos.'</td>
                </tr>
                ';

                $total_cargo_general = $total_+ $total_maestra;

                echo '<td></td>
                <td>Total cargos:</td>
                <td></td>
                <td>$'.number_format($total_cargo_general, 2).'</td>
                </tr>
                      ';

  ;
    echo ' </tbody>
    </table>
    </div>
  </div>
  </div>
  </div>
  ';

  //todos los abonos

  
  echo '   <div class="col-sm-12">
  <div  class="card bg-light text-dark">';
    
    echo '<div class="card-header"><h5>Abonos</h5></div>
    
    <div class="card-body">
      <div class="table-responsive" style="height:100%" id="tabla_tipo">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Habitación/Folio Maestra</th>
          <th>Descripción</th>
          <th>Cargo</th>
          <th>Abono</th>
          
          </tr>
        </thead>
      <tbody>';
      //obtenemos los abonos por habitacion
      $consulta= $cuenta->mostrarAbonos($usuario_id);
   
      $fila_atras="";
      $total_abonos=0;
      $total_=0;

      echo '<tr class="table-secondary" style="text-align:left">';
      echo '<td>Abonos</td>
          <td></td>
          <td></td>
          <td></td>
          </tr>
      ';
      echo '<tr class="table-secondary">';
      $c=0;
      while ($fila = mysqli_fetch_array($consulta)) {
        if($fila_atras!= $fila['hab_nombre']){
          if($c!=0){
            echo '<tr class="table-primary  text-center">
            <td></td>
            <td></td>
            <td>Total:</td>
            <td>$'.number_format($total_abonos, 2).'</td>
            </tr>';
            $total_abonos=0;
          }
          echo '<td>Habitación '.$fila['hab_nombre'].'</td>
          <td></td>
          <td></td>
          <td></td>
          </tr>
          ';

        }
        echo '<td></td>
          <td>'.$fila['descripcion'].'</td>
          <td>0</td>
          <td>'.$fila['abono'].'</td>
          </tr>
            ';

        $fila_atras=$fila['hab_nombre'];
        $total_abonos+=$fila['abono'];
        $total_+=$fila['abono'];
        $c++;

      }
      $total_maestra=0;

      //abonos cuentas maestras.
      $consulta= $cuenta->mostrarAbonosMaestra($usuario_id);
      while ($fila = mysqli_fetch_array($consulta)) {
        if($fila_atras!= $fila['maestra_id']){
          if($c!=0){
            echo '<tr class="table-primary  text-center">
            <td></td>
            <td></td>
            <td>Total:</td>
            <td>$'.number_format($total_abonos, 2).'</td>
            </tr>';
            $total_abonos=0;
          }
          echo '<td>Cuenta maestra: '.$fila['maestra_nombre'].'</td>
          <td></td>
          <td></td>
          <td></td>
          </tr>
          ';

        }
        echo '<td></td>
          <td>'.$fila['descripcion'].'</td>
          <td>0</td>
          <td>'.$fila['abono'].'</td>
          </tr>
            ';


        $fila_atras=$fila['maestra_id'];
        $total_abonos+=$fila['abono'];
        $total_maestra+=$fila['abono'];
        $c++;

      }
      echo '<td></td>
      <td></td>
      <td>Total:</td>
      <td>'.$total_abonos.'</td>
      </tr>
      ';

      $total_abono_general = $total_+ $total_maestra;

      echo '<td></td>
      <td>Total abonos:</td>
      <td></td>
      <td>$'.number_format($total_abono_general, 2).'</td>
      </tr>
            ';

;
echo ' </tbody>
</table>
</div>
</div>
</div>
</div>
';


  echo '</div>';
?>

