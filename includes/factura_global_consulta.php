<?php
    include_once('clase_ticket.php');
    $Tickets= NEW Ticket(0);
    $fechaInicio = $_POST['fechaInio'];
    $fechaFin=$_POST['fechaFin'];
    $fechaInicioUnix=strtotime($fechaInicio);
    $fechaFinUnix=strtotime($fechaFin);
    $lista_tickets=$Tickets->tickets_por_fecha($fechaInicioUnix,$fechaFinUnix);
    //$lista_tickets=$ticket->obtener_tickets_rango_de_fechas($fechaInicioUnix,$fechaFinUnix);
    $lista_Id_tickets=array();
    foreach ($lista_tickets as $fila) {
        array_push($lista_Id_tickets, $fila['id']);
    }
    var_dump($lista_Id_tickets);

    echo '
    <table class="table table-bordered" style="max-width: 1500px; margin: auto;">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Concepto</th>
        <th scope="col">Costo Unitario</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row"><input type="checkbox"/> </th>
        <td>Suite Junior</td>
        <td>$1000</td>
      </tr>
    </tbody>
    </table>
    ';

?>