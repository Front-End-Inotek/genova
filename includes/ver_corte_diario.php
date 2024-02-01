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
        <div class="main_container_title">
        <h2>CORTE/DIARIO</h2>
        <button type="submit" class="btn btn-primary"  onclick="aceptar_guardar_corte_diario()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                  <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1"/>
                  <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                </svg>
                Hacer reporte
          </button>

        </div>

        <div class="text-dark margen-1"></div>
            
                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Fecha</th>
                    <th>FCasa</th>
                    <th>Hab.</th>
                    <th>Descripción</th>
                    <th>Observación</th>
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
                echo '<tr class="table">';
                foreach ($forma_pago->formas_pagos() as $key => $pago) {
                $consulta= $cuenta->mostrarCuentaUsuario($usuario_id,$pago['id']);
                $contador_row = mysqli_num_rows($consulta);
                if($contador_row!=0){
                    $descripcion = ucwords($pago['descripcion']);
                    echo '<td style="text-align:left;" colspan="">'.$descripcion.'</td>
                    </tr>
                ';
                while ($fila = mysqli_fetch_array($consulta)) {
                    $hab_nombre = $fila['hab_nombre'];
                    if($hab_nombre == null && $fila['fcasa'] == null){
                      $hab_nombre="CM: ". $fila['cm_nombre'];
                    }
                    echo '<tr class="table  text-center">
                    <td>'.date('d-m-Y H:m:s',$fila['fecha']).'</td>
                    <td>'.$fila['fcasa'].'</td>
                    <td>'.$hab_nombre.'</td>
                    <td>'.$fila['descripcion'].'</td>
                    <td>'.$fila['observacion'].'</td>
                    <td>'.$fila['cargo'].'</td>
                    <td>'.$fila['abono'].'</td>
                    <td>'.$fila['usuario'].'</td>
                    </tr>
                    ';
                    $total_abonos+=$fila['abono'];
                }
                echo '<tr class="table  text-center">
                <td></td>
                <td></td>
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
            echo '<tr class="table  text-center">
            <td></td>
            <td></td>
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
  
  ';

 

  echo '';
?>

