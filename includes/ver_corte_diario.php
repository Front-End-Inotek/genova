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
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">DIARIO/CORTE</h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <button type="submit" class="btn btn-danger btn-block"  onclick="aceptar_guardar_corte_diario()">Hacer reporte</button>
          </div>
          </div>
        </div>
        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col-sm-12">
            <div  class="card bg-light text-dark">';
              
              echo '
              
              <div class="card-body">
                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Fecha</th>
                    <th>FCasa</th>
                    <th>Hab.</th>
                    <th>Descripción</th>
                    <th>Cargos</th>
                    <th>Abonos</th>
                    <th>Usuario</th>
                    </tr>
                  </thead>
                <tbody>';
                //obtenemos los cargos por habitacion
               
             
                $fila_atras="";
                $total_cargos=0;
                $total_abonos=0;
                $total_general=0;

                echo '<tr class="table-secondary">';
                foreach ($forma_pago->formas_pagos() as $key => $pago) {
                    
                $consulta= $cuenta->mostrarCuentaUsuario($usuario_id,$pago['id']);

                $contador_row = mysqli_num_rows($consulta);

                if($contador_row!=0){
                    $descripcion = ucwords($pago['descripcion']);
                    echo '<td style="text-align:left;" colspan="">'.$descripcion.'</td>
                    </tr>
                ';
             
                while ($fila = mysqli_fetch_array($consulta)) {
                    echo '<tr class="table-primary  text-center">
                    <td>'.date('d-m-Y H:m:s',$fila['fecha']).'</td>
                    <td>'.$fila['fcasa'].'</td>
                    <td>'.$fila['hab_nombre'].'</td>
                    <td>'.$fila['descripcion'].'</td>
                    <td>'.$fila['cargo'].'</td>
                    <td>'.$fila['abono'].'</td>
                    <td>'.$fila['usuario'].'</td>
                    </tr>
                    ';
                    $total_abonos+=$fila['abono'];
                }
                echo '<tr class="table-primary  text-center">
                <td></td>
                <td></td>
                <td></td>
                <td>Total posteo:</td>
                <td>$0.00</td>
                <td>$'.number_format($total_abonos,2).'</td>
                <td></td>
                </tr>
                ';
                $total_general+=$total_abonos;
                $total_abonos=0;
                }
               
            }
            echo '<tr class="table-primary  text-center">
            <td></td>
            <td></td>
            <td></td>
            <td>Total:</td>
            <td>$0.00</td>
            <td>$'.number_format($total_general,2).'</td>
            <td></td>
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

