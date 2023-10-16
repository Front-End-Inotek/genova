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
    var_dump($lista_tipo_cargo);
   /* $lista_hospedaje=array();
    $lista_restaurante=array();
    foreach ($Concepto as $filas) {
        var_dump($filas);
        //echo $filas['tipo_cargo'];
        /*if ($filas['tipo_cargo']==3){
            array_push($lista_hospedaje,$filas['total']);
        }else{
            array_push($lista_restaurante,$filas['total']);
        }*/
    //}
    //var_dump($lista_hospedaje)

?>