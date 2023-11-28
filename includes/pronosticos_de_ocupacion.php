<?php
session_start();
include_once("clase_hab.php");
$hab= NEW Hab(0);
$obtenerfecha=$_POST["fecha"];
//echo $obtenerfecha;
$mes = '';
$año = '';
$aux="";
for($i=0; $i<strlen($obtenerfecha); $i++){
    if($obtenerfecha[$i]!="-"){
        $aux=$aux.$obtenerfecha[$i];
    }else{
        $año=$aux;
        $aux="";
    }
}
$mes=$aux;
$_SESSION["mes"]=$mes;
$_SESSION["año"]=$año;
//echo $año;
//echo $mes;
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
$tipo_de_habitacion=$hab->mostrar_tipoHab();
//var_dump($tipo_de_habitacion);
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

echo '<div class="table-responsive table-hover">
    
';

//imprimie las matrices
for ($k = 0; $k < count($id_hab); $k++) {
    echo $tipo_de_habitacion[$k];
    echo'
    <table class="table table-bordered table-hover text-center table-sm">
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
echo "<caption>Total cuartos noche:</caption>";
echo'
<table class="table table-bordered table-hover text-center table-sm">';

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
<caption>Ocupacion</caption>

<table class="table table-bordered table-hover text-center table-sm">
    
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
<table class="table table-bordered table-hover text-center table-sm ">
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
<table class="table table-bordered table-hover text-center table-sm">
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
<table class="table table-bordered table-hover text-center table-sm">
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
$_SESSION["lista_matrices"]=$lista_matrices;
$_SESSION["total_cuartos_noche"]=$total_cuartos_noche;
$_SESSION["totales"]=$totales;
$_SESSION["ocupacion"]=$ocupacion;
$_SESSION["listaAdultos"]=$listaAdultos;
$_SESSION["listaInfantiles"]=$listaInfantiles;
$_SESSION["listaLlegadasAdultos"]=$listaLlegadasAdultos;
$_SESSION["listaLlegadasInfantiles"]=$listaLlegadasInfantiles;
$_SESSION["listaSalidasAdultos"]=$listaSalidasAdultos;
$_SESSION["listaSalidasInfantiles"]=$listaSalidasInfantiles;
$_SESSION["tipo_de_habitacion"]=$tipo_de_habitacion;



echo '
    <a href="#" class="btn btn-primary fabReporte" onclick="ver_reporte_pronostico()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
        </svg>
        Ver reporte
    </a>
</div>';
?>