<?php
include_once("clase_hab.php");

$hab= NEW Hab(0);
$habitaciones=$hab->obtener_habitaciones();
echo '<h1>reporte ama de llaves</h1>
<table border="1">
    <tr >
        <th>Revision fisica</th>
        <th>Habitacion</th>
        <th>Tipo de habitacion</th>
        <th>Estatus de la habitacion</th>
        <th>Estatus en inspección</th>
        <th>Estatus de reserva</th>
        <th>Nombre del huésped</th>
        <th>Fecha de llegada</th>
        <th>Fechade salida</th>
        <th>Discrepancia</th>
        <th>Observaciones</th>
    </tr>';
    while ($fila = mysqli_fetch_array($habitaciones))
        {
        echo'
        <tr>
            <td><input type="checkbox" id="miCheckbox" name="miCheckbox"></td>
            <td>'."Habitacion ".$fila['nombre'].'</td>
            <td>'.$hab->consultar_tipo($fila['id']).'</td>';
            $nombre="";
            $fecha_entrada="";
            $fecha_salida="";
            $status="";
            if ($fila['estado']==0){
                $estado="Disponible limpia";
                $status="No reservada";
                $id_reservacion=$hab->obtener_estado_reservacion($fila['id']);
                if($id_reservacion!=""){
                    $garantia=$hab->obtener_garantia_reservacion($id_reservacion);
                    while ($fila1 = mysqli_fetch_array($garantia))
                        {
                            $estado_interno=$fila1['estado_interno'];
                            if($estado_interno=='garantizada'){
                                $estado="Reservada pagada";
                                $nombre=$fila1['nombre_reserva'];
                                $fecha_entrada=$fila1['fecha_entrada'];
                                $fecha_salida=$fila1['fecha_salida'];
                                $status="No show";
                            }elseif($estado_interno=='pendiente'){
                                $estado="Reserva pendiente";
                                $nombre=$fila1['nombre_reserva'];
                                $fecha_entrada=$fila1['fecha_entrada'];
                                $fecha_salida=$fila1['fecha_salida'];
                                $status="Preasignada";
                            }
                        }
                }
                
            }elseif($fila['estado']==1){
                $estado_interno=$hab->obtener_estado_interno($fila['mov']);
                $fechas=$hab->obtener_fecha_entrada_salida($fila['mov']);
                while ($fila2 = mysqli_fetch_array($fechas))
                    {
                    $entrada=$fila2['inicio_hospedaje'];
                    $salida=$fila2['fin_hospedaje'];
                    $idname=$fila2 ['id_huesped'];
                    }
                if($estado_interno=="sin estado"){
					$estado= 'Ocupado';
                    $nombre=$hab->obtener_huesped($idname);
                    $fecha_entrada=$entrada;
                    $fecha_salida=$salida;
                    $tiempoInicioDia = strtotime('today midnight');
                    if ($fecha_salida>=$tiempoInicioDia){
                        $status="Salida probable";
                    }else{
                        $status="Stayover";
                    }
				}else{
					if($estado_interno=="limpieza"){
						$estado= "Ocupada limpieza";
                        $nombre=$hab->obtener_huesped($fila['id']);
                        $fecha_entrada=$entrada;
                        $fecha_salida=$salida;
                        $tiempoInicioDia = strtotime('today midnight');
                        if ($fecha_salida>=$tiempoInicioDia){
                            $status="Salida probable";
                        }else{
                            $status="Stayover";
                        }
					}
					if($estado_interno=="sucia"){
						$estado= "Sucia ocupada";
                        $nombre=$hab->obtener_huesped($fila['id']);
                        $fecha_entrada=$entrada;
                        $fecha_salida=$salida;
                        $tiempoInicioDia = strtotime('today midnight');
                        if ($fecha_salida>=$tiempoInicioDia){
                            $status="Salida probable";
                        }else{
                            $status="Stayover";
                        }
					}
				}
            }elseif($fila['estado']==2){
                $estado="Vacia sucia";
            }elseif($fila['estado']==3){
                $estado="Vacia limpieza";
            }elseif($fila['estado']==4){
                $estado="Mantenimiento";
            }elseif($fila['estado']==5){
                $estado="Bloqueo";
            }elseif($fila['estado']==6){
                $estado="Reservada pagada";
                $nombre=$hab->obtener_huesped($fila['id']);
            }elseif($fila['estado']==7){
                $estado="Reserva pendiente";
                $nombre=$hab->obtener_huesped($fila['id']);
            }elseif($fila['estado']==8){
                $estado="Uso casa";
                $fechas=$hab->obtener_fecha_entrada_salida($fila['mov']);
                while ($fila2 = mysqli_fetch_array($fechas))
                    {
                    $entrada=$fila2['inicio_hospedaje'];
                    $salida=$fila2['fin_hospedaje'];
                    }
                $fecha_entrada=$entrada;
                $fecha_salida=$salida;
            }elseif($fila['estado']==9){
                $estado="Mantenimientos";
            }elseif($fila['estado']==10){
                $estado="Bloqueo";
            }
            echo '
            <td>'.$estado.'</td>
            <td>
                <select id="miSelect" name="miSelect">
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="0">Disponible limpia</option>
                    <option value="1">Ocupado</option>
                    <option value="2">Ocupada limpieza</option>
                    <option value="3">Sucia ocupada</option>
                    <option value="4">Vacia sucia</option>
                    <option value="5">Vacia limpieza</option>
                    <option value="6">Mantenimiento</option>
                    <option value="7">Bloqueo</option>
                    <option value="8">Reservada pagada</option>
                    <option value="9">Reserva pendiente</option>
                    <option value="10">Uso casa</option>
                    <option value="11">Mantenimientos</option>
                    <option value="12">Bloqueo</option>
                    
                    </select>
            </td>
            <td>'.$status.'</td>
            <td>'.$nombre.'</td>';
            echo'
            <td>'.$fecha_entrada.'</td>
            <td>'.$fecha_salida.'</td>
            <td>discrepancia</td>
            <td><textarea id="miTextarea" name="miTextarea" rows="4" cols="50"></textarea></td>
        </tr>';
        }
echo'
</table>';
?>