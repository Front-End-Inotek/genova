<?php
    include_once('clase_ticket.php');
    $Tickets= NEW Ticket(0);

    $Concepto=NEW Concepto(0);
    $fechaInicio = $_POST['fechaInio'];
    $fechaFin=$_POST['fechaFin'];
    $fechaInicioUnix=strtotime($fechaInicio);
    $fechaFinUnix=strtotime($fechaFin)+(60*24);
    $lista_tickets=$Tickets->tickets_por_fecha($fechaInicioUnix,$fechaFinUnix);
    //$lista_tickets=$ticket->obtener_tickets_rango_de_fechas($fechaInicioUnix,$fechaFinUnix);
    $lista_Id_tickets=array();
    $total=0.0;
    $lista_ID_Hospedaje=array();
    $lista_Nombre_Hospedaje=array();
    $lista_Total_Hospedaje=array();
    $lista_ID_Restaurante=array();
    $lista_Nombre_Restaurante=array();
    $lista_Total_Restaurante=array();
    foreach ($lista_tickets as $fila) {
        array_push($lista_Id_tickets, $fila['id']);
        $result=$Concepto->info_concepto($fila['id']);
        //var_dump($result);
        //var_dump($result);
        if (isset($result["tipo_cargo"])){
            if($result["tipo_cargo"]==3){
                array_push($lista_ID_Hospedaje,$result["id"]);
                array_push($lista_Nombre_Hospedaje,$result["nombre"]);
                array_push($lista_Total_Hospedaje,$result["total"]);
            }else{
                array_push($lista_ID_Restaurante,$result["id"]);
                array_push($lista_Nombre_Restaurante,$result["nombre"]);
                array_push($lista_Total_Restaurante,$result["total"]);
            }
        }
    }
    echo '
    <table class="table table-bordered" style="max-width: 850px; margin: auto;">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Fecha</th>
        <th scope="col">Nombre de habitación</th>
        <th scope="col">Concepto</th>
        <th scope="col">Costo Unitario</th>
      </tr>
    </thead>
    <tbody>
    ';
    $contador = 1;
    $totalHospedaje = 0.0;
    foreach( $lista_Nombre_Hospedaje as $concepto){
      $index = array_search($concepto, $lista_Nombre_Hospedaje);
      $id = $lista_Id_tickets[$index];
      $total = $lista_Total_Hospedaje[$index];
      echo '
      <tr>
        <td scope="row"> <input type="checkbox" checked /> </td>
        <td>' . $concepto. '</td>
        <td>' . $id . '</td>
        <td>' . $concepto . '</td>
        <td>$' . $total. '</td>
      </tr>
      ';
      $contador++;
      $totalHospedaje += floatval($lista_Total_Hospedaje[$index]);
    }
    echo'
      <tr>
        <td scope="row" colspan="3"></td>
        <td>Total: </td>
        <td>$' . $totalHospedaje . '</td>
      </tr>
      </tbody>
    </table>
    ';
?>