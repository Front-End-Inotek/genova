<?php
    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);        

    
//Agregar filtros de busqueda

$sentencia = "SELECT h.nombre AS nombre_habitacion, th.nombre AS tipo_habitacion
FROM hab h
JOIN tipo_hab th ON h.tipo = th.id
WHERE h.id NOT IN (
    SELECT m.id_hab
    FROM movimiento m
    WHERE m.fin_hospedaje > $initialDate
    AND m.inicio_hospedaje < $endDate
);";

$resultado = $conexion->realizaConsulta($sentencia, "");

while ($fila = mysqli_fetch_array($resultado)) {
    echo $fila['nombre_habitacion']. " tipo: ". $fila["tipo_habitacion"]. ", " ;
}