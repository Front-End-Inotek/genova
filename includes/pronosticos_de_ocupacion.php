<?php
include_once("clase_hab.php");
$hab= NEW Hab(0);
$mes = '11';
$año = '2023';
$n = cal_days_in_month(CAL_GREGORIAN, $mes, $año);
$id_hab=array();

//se obtiene el id de los tipos de habitaciones que estan registradas en la bd
$tipo=$hab->consultar_tipos();
while ($fila = mysqli_fetch_array($tipo)){
        array_push($id_hab,$fila['id']);
    }

// se crean un numero de matrices para cada uno de los tipos de habitaciones, se crean de un tamaño dinamico dependiendo el numero de dias que tiene cada mes guardando este dato en la variable $n
$matriz = array();
$lista_matrices=array();
for ($k = 0; $k < count($id_hab); $k++) {
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $matriz[$i][$j] = "0        ";
        }
    }
    array_push($lista_matrices,$matriz);
}

//se llena el primer renglon de cada una de las matrices con el numero total de habitacions de cada tipo
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=$lista_matrices[$k];
    $numero_hab=$hab->id_tipos_habitacion($id_hab[$k]);
    for ($j = 0; $j < $n; $j++) {
        $matriz[0][$j] = $numero_hab;
    }
    $lista_matrices[$k]=$matriz;
}
$listaAdultos=array();
$listaInfantiles=array();
for ($j = 0; $j < $n; $j++) {
    array_push($listaAdultos,0);
    array_push($listaInfantiles,0);
}

//se obtiene las habitaciones reservadas por dia
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=$lista_matrices[$k];
    $tiempounix=0;
    for ($j = 0; $j < $n; $j++) {
        $dia=$j+1;
        $fecha = $año."-".$mes."-".$dia." ". "00:00:00";
        $fecha=new DateTime($fecha);
        $tiempounix = $fecha->getTimestamp();
        $tiempofin=$tiempounix+86400;
        $hab_ocupadas=$hab->habitaciones_reservadas($id_hab[$k]);
        $contador=0;
        $adultos=0;
        $infantiles=0;
        while ($fila = mysqli_fetch_array($hab_ocupadas))
        {
            if ($tiempounix>=$fila["fecha_entrada"] && $tiempofin<=$fila["fecha_entrada"]+($fila["noches"]*86400)){
                $contador=$contador+1;
                $adultos=$adultos+$fila["adultos"];
                $infantiles=$infantiles+$fila["infantiles"];
            }
        }
        $matriz[1][$j] = $contador;
        //var_dump($hab_ocupadas);
        $listaAdultos[$j]=$listaAdultos[$j]+$adultos;
        $listaInfantiles[$j]=$listaInfantiles[$j]+$infantiles;
    }
    $lista_matrices[$k]=$matriz;
}

//se obtiene las habitaciones reservadas por dia en web
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=$lista_matrices[$k];
    $tiempounix=0;
    for ($j = 0; $j < $n; $j++) {
        $dia=$j+1;
        $fecha = $año."-".$mes."-".$dia." ". "00:00:00";
        $fecha=new DateTime($fecha);
        $tiempounix = $fecha->getTimestamp();
        $tiempofin=$tiempounix+86400;
        $hab_ocupadas=$hab->habitaciones_reservadas_web($id_hab[$k]);
        $contador=0;
        $adultos=0;
        $infantiles=0;
        while ($fila = mysqli_fetch_array($hab_ocupadas))
        {
            if ($tiempounix>=$fila["fecha_entrada"] && $tiempofin<=$fila["fecha_entrada"]+($fila["noches"]*86400)){
                $contador=$contador+1;
                $adultos=$adultos+$fila["adultos"];
                $infantiles=$infantiles+$fila["infantiles"];
            }
        }
        $matriz[2][$j] = $contador;
        //var_dump($hab_ocupadas);
        $listaAdultos[$j]=$listaAdultos[$j]+$adultos;
        $listaInfantiles[$j]=$listaInfantiles[$j]+$infantiles;
    }
    $lista_matrices[$k]=$matriz;
}

//se obtiene las habitaciones ocupadas por dia
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=$lista_matrices[$k];
    $tiempounix=0;
    for ($j = 0; $j < $n; $j++) {
        $dia=$j+1;
        $fecha = $año."-".$mes."-".$dia." ". "00:00:00";
        $fecha=new DateTime($fecha);
        $tiempounix = $fecha->getTimestamp();
        $tiempofin=$tiempounix+86400;
        $hab_ocupadas=$hab->habitaciones_ocupadas_checkin($tiempounix,$id_hab[$k]);
        $contador=0;
        $adultos=0;
        $infantiles=0;
        while ($fila = mysqli_fetch_array($hab_ocupadas))
        {
            if ($tiempounix>=$fila["fecha_entrada"] && $tiempofin<=$fila["fecha_entrada"]+($fila["noches"]*86400)){
                $contador=$contador+1;
                $adultos=$adultos+$fila["adultos"];
                $infantiles=$infantiles+$fila["infantiles"];
            }
        }
        $matriz[3][$j] = $contador;
        //var_dump($hab_ocupadas);
        $listaAdultos[$j]=$listaAdultos[$j]+$adultos;
        $listaInfantiles[$j]=$listaInfantiles[$j]+$infantiles;
    }
    $lista_matrices[$k]=$matriz;
}

//se hace el calculo de habitaciones disponibles
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=$lista_matrices[$k];
    for ($j = 0; $j < $n; $j++) {
        $matriz[4][$j] = $matriz[0][$j]-($matriz[1][$j]+$matriz[2][$j]+$matriz[3][$j]);
    }
    $lista_matrices[$k]=$matriz;
}

echo '<div class="contenedor__pronosticos">';

//imprimie las matrices
for ($k = 0; $k < count($id_hab); $k++) {
    echo'
    <table class="table table-bordered">
        <tr>';
    $matriz=$lista_matrices[$k];
    for ($i = 0; $i < 5; $i++) {
        if ($i==0){
            echo'<td>Cuartos Noche</td>';
        }else if ($i==1){
            echo'<td>Reservadas</td>';
        }else if ($i==2){
            echo'<td>Reservadas Web</td>';
        }else if ($i==3){
            echo'<td>Walk-in</td>';
        }else if ($i==4){
            echo'<td>Dispobles</td>';
        }
        for ($j = 0; $j < $n; $j++) {
            //echo $matriz[$i][$j]."      ";
            echo'<td>'.$matriz[$i][$j].'</td>';
        }
        echo'<td>'." ".'</td>';
        echo'<td>'." ".'</td>';
        echo '</tr>';
    }

    echo'
    </table>
    ';
    echo '<br>';
}


// se crea una matriz vacia para tel total de cuartos por noche
$total_cuartos_noche= array();
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < $n; $j++) {
        $total_cuartos_noche[$i][$j] = "0";
    }
}

//se llena la matriz de total cuartos noche con la suma de los datos de las matrices de todos los cuartos
for ($k = 0; $k < count($id_hab); $k++) {
    for ($j = 0; $j < $n; $j++) {
        $total_cuartos_noche[0][$j]=$total_cuartos_noche[0][$j]+$lista_matrices[$k][0][$j];
        $total_cuartos_noche[1][$j]=$total_cuartos_noche[1][$j]+$lista_matrices[$k][1][$j];
        $total_cuartos_noche[2][$j]=$total_cuartos_noche[2][$j]+$lista_matrices[$k][2][$j];
        $total_cuartos_noche[3][$j]=$total_cuartos_noche[3][$j]+$lista_matrices[$k][3][$j];
        $total_cuartos_noche[4][$j]=$total_cuartos_noche[4][$j]+$lista_matrices[$k][4][$j];
    }
}

//se imprime el calculo de totales por noche de todas las habitaciones
echo'
<table class="table table-bordered">';
echo "<caption>Total cuartos noche:</caption>";
echo '
    <tr>';
echo '<br>';
for ($i = 0; $i < 5; $i++) {
    if ($i==0){
        echo'<td>Cuartos Noche</td>';
    }else if ($i==1){
        echo'<td>Reservadas</td>';
    }else if ($i==2){
        echo'<td>Reservadas Web</td>';
    }else if ($i==3){
        echo'<td>Walk-in</td>';
    }else if ($i==4){
        echo'<td>Dispobles</td>';
    }
    for ($j = 0; $j < $n; $j++) {
        //echo $total_cuartos_noche[$i][$j]."      ";
        echo'<td>'.$total_cuartos_noche[$i][$j].'</td>';
    }
    echo '</tr>';
}
echo'
</table>
';
echo '<br>';

//se saca el promedio de ocupacion de todas las habitaciones por dia


$ocupacion=array();
for ($j = 0; $j < $n; $j++) {
    if($total_cuartos_noche[1][$j]+$total_cuartos_noche[2][$j]+$total_cuartos_noche[3][$j]>0){
        $promedio=(($total_cuartos_noche[1][$j]+$total_cuartos_noche[2][$j]+$total_cuartos_noche[3][$j])/($total_cuartos_noche[0][$j]/100));
        array_push($ocupacion,number_format($promedio,2));
    }else{
        array_push($ocupacion,0.00);
    }
    
}
echo'
<table class="table table-bordered">
    <caption>Ocupacion</caption>
    <tr>';
    echo'<td>Ocupacion Bruta(%)</td>';
for ($j = 0; $j < $n; $j++) {
    //echo $ocupacion[$j]."      ";
    echo'<td>'.$ocupacion[$j].'</td>';
}
echo '</tr>';
echo'
</table>
';
echo "<br>";

//se llena la columna de los totales de las tablas
$totales=array();
for ($k = 0; $k < count($id_hab); $k++) {
    $matriz=[0,0,0,0];
    for ($i = 0; $i < 5; $i++) {
        $sum=0;
        
        for ($j = 0; $j < $n; $j++) {
            $sum=$sum+$lista_matrices[$k][$i][$j];
        }
        $matriz[$i]=$sum;
    }
    array_push($totales,$matriz);
}
$matriz=[0,0,0,0,0];
for ($i = 0; $i < 5; $i++) {
    $sum=0;
    
    for ($j = 0; $j < $n; $j++) {
        $sum=$sum+$total_cuartos_noche[$i][$j];
    }
    $matriz[$i]=$sum;
}
array_push($totales,$matriz);
$matriz=[0,0,0,0,0];
$sum=0;

for ($j = 0; $j < $n; $j++) {
    $sum=$sum+$ocupacion[$j];
}
$matriz[0]=number_format($sum/$n,2);
array_push($totales,$matriz);


echo "totales";
echo "<br>";
for ($k = 0; $k < count($id_hab)+2; $k++) {
    for ($j = 0; $j < 5; $j++) {
        echo $totales[$k][$j] . "      ";
    }
}
echo "<br>";

echo'
<table class="table table-bordered">
    <tr>';
    echo'<td>Adultos</td>';
for ($j = 0; $j < $n; $j++) {
    //echo $listaAdultos[$j] . "      ";
    echo'<td>'.$listaAdultos[$j].'</td>';
}
echo '<tr>';

echo'<td>niños</td>';
for ($j = 0; $j < $n; $j++) {
    //echo $listaInfantiles[$j] . "      ";
    echo'<td>'.$listaInfantiles[$j].'</td>';
}
echo '</tr>';
echo'
</table>
';
echo "<br>";

echo "Llegadas:";
echo "<br>";
$listaLlegadasAdultos=array();
$listaLlegadasInfantiles=array();
for ($i=1; $i<=$n; $i++){
    $adultos=0;
    $infantiles=0;
    $fecha=$año."-".$mes."-".$i." "."00:00:00";
    $tUnix=strtotime($fecha);
    $consulta=$hab->llegadas_huespedes_dia($tUnix);
    while ($fila = mysqli_fetch_array($consulta))
        {
          $adultos=$adultos+$fila["adultos"];
          $infantiles=$infantiles+$fila["infantiles"];
        }
    array_push($listaLlegadasAdultos,$adultos);
    array_push($listaLlegadasInfantiles,$infantiles);
    
}
echo "<br>";
echo'
<table class="table table-bordered">
    <tr>';
    echo'<td>Adultos</td>';
for ($i=0; $i<$n; $i++){
    //echo $listaLlegadasAdultos[$i]."     ";
    echo'<td>'.$listaLlegadasAdultos[$i].'</td>';
}
echo '<tr>';
echo'<td>niños</td>';

for ($i=0; $i<$n; $i++){
    //echo $listaLlegadasInfantiles[$i]."     ";
    echo'<td>'.$listaLlegadasInfantiles[$i].'</td>';
}
echo '</tr>';
echo'
</table>
';
echo "<br>";


echo "Salidas:";
echo "<br>";
$listaSalidasAdultos=array();
$listaSalidasInfantiles=array();
for ($i=1; $i<=$n; $i++){
    $adultos=0;
    $infantiles=0;
    $fecha=$año."-".$mes."-".$i." "."00:00:00";
    $tUnix=strtotime($fecha);
    $consulta=$hab->salidas_huespedes_dia($tUnix);
    while ($fila = mysqli_fetch_array($consulta))
        {
          $adultos=$adultos+$fila["adultos"];
          $infantiles=$infantiles+$fila["infantiles"];
        }
    array_push($listaSalidasAdultos,$adultos);
    array_push($listaSalidasInfantiles,$infantiles);
    
}
echo "<br>";
echo'
<table class="table table-bordered">
    <tr>';
    echo'<td>Adultos</td>';
for ($i=0; $i<$n; $i++){
    //echo $listaLlegadasAdultos[$i]."     ";
    echo'<td>'.$listaSalidasAdultos[$i].'</td>';
}
echo '<tr>';
echo'<td>niños</td>';
for ($i=0; $i<$n; $i++){
    //echo $listaSalidasInfantiles[$i]."     ";
    echo'<td>'.$listaSalidasInfantiles[$i].'</td>';
}
echo '</tr>';
echo'
</table>
';

echo '</div>'
?>