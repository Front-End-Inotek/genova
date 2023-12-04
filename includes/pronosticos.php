<?php
include_once('clase_hab.php');

$hab = new Hab(0);

$info_habs=$hab->obtener_todas();

$total_habs =mysqli_num_rows($info_habs);

$etiquetas = 
[ 
"Fuera de servicio",
"En libros (vendidas, reservadas)",
"Tarifa promedio",
"Llegadas del dia",
"Salidas del dia",
"Disponibles (a la venta)",
"% de disponibilidad",
"% de Ocupacion",
];

$tiempo = time();
$mes_largo = date('t');
$primer_dia = strtotime("first day of");



$fuera_servicio = $hab->fuera_servicio($primer_dia);

$en_libros = $hab->en_libros($primer_dia);

$llegadas_dia = $hab->llegadas_dia($primer_dia);
$salidas_dia =$hab->salidas_dia($primer_dia);


function imprimir_fuera_servicio($fuera_servicio,$primer_dia){
    $mes_largo = date('t');
    for ($i = 1; $i <= $mes_largo; $i++) {
        $s=0;
        mysqli_data_seek($fuera_servicio, 0);
        while($fila = mysqli_fetch_array($fuera_servicio)){
        if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['detalle_inicio']) ||  date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['inicio_limpieza'])) {
            $s++;
        }

    }
    echo $s;
  
    $primer_dia+=86400;

}
}

function imprimir_en_libros($en_libros,$primer_dia){
    $mes_largo = date('t');
    for ($i = 1; $i <= $mes_largo; $i++) {
        $s=0;
        mysqli_data_seek($en_libros, 0);
        while($fila = mysqli_fetch_array($en_libros)){
        if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
            $s++;
        }

    }
    $primer_dia+=86400;
    echo '<td>'.$s.'</td>';
    

}
}
function imprimir_tarifa_promedio(){
    $mes_largo = date('t');
    for ($i = 1; $i <= $mes_largo; $i++) {
    //     $s=0;
    //     mysqli_data_seek($en_libros, 0);
    //     while($fila = mysqli_fetch_array($en_libros)){
    //     if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
    //         $s++;
    //     }

    // }
    echo '<td>0</td>';
    // $primer_dia+=86400;

}
}

function imprimir_llegadas_dia($llegadas_dia,$primer_dia){
    $mes_largo = date('t');
    for ($i = 1; $i <= $mes_largo; $i++) {
        $s=0;
        mysqli_data_seek($llegadas_dia, 0);
        while($fila = mysqli_fetch_array($llegadas_dia)){
        if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
            $s++;
        }

    }
    echo '<td>'.$s.'</td>';
    $primer_dia+=86400;

}
}

function imprimir_salidas_dia($salidas_dia,$primer_dia){
    $mes_largo = date('t');
    for ($i = 1; $i <= $mes_largo; $i++) {
        $s=0;
        mysqli_data_seek($salidas_dia, 0);
        while($fila = mysqli_fetch_array($salidas_dia)){
        if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
            $s++;
        }

    }
    echo '<td>'.$s.'</td>';
    $primer_dia+=86400;

}
}

function imprimir_disponibles($en_libros,$fuera_servicio, $primer_dia,$total_habs){
    $mes_largo = date('t');
   
    for ($i = 1; $i <= $mes_largo; $i++) {
        $cant_libros=0;
        $cant_fuera=0;
        $disponibles=0;
        mysqli_data_seek($en_libros, 0);
        while($fila = mysqli_fetch_array($en_libros)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
                $cant_libros++;
            }
        }
        mysqli_data_seek($fuera_servicio, 0);
        while($fila = mysqli_fetch_array($fuera_servicio)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['detalle_inicio']) ||  date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['inicio_limpieza'])) {
                $cant_fuera++;
            }
        }
        $disponibles = $total_habs - $cant_libros - $cant_fuera;
        echo '<td>'.$disponibles.'</td>';
        $primer_dia+=86400;
}
}


function imprimir_disponibilidad($en_libros,$fuera_servicio, $primer_dia,$total_habs){
    $mes_largo = date('t');
   
    for ($i = 1; $i <= $mes_largo; $i++) {
        $cant_libros=0;
        $cant_fuera=0;
        $disponibles=0;
        mysqli_data_seek($en_libros, 0);
        while($fila = mysqli_fetch_array($en_libros)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
                $cant_libros++;
            }
        }
        mysqli_data_seek($fuera_servicio, 0);
        while($fila = mysqli_fetch_array($fuera_servicio)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['detalle_inicio']) ||  date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['inicio_limpieza'])) {
                $cant_fuera++;
            }
        }
        $disponibles = $total_habs - $cant_libros - $cant_fuera;
        $d = (100*$disponibles) / $total_habs;
        $d =round($d,2);
        echo '<td>'.$d.'</td>';
        $primer_dia+=86400;
}
}

function imprimir_ocupacion($en_libros,$fuera_servicio, $primer_dia,$total_habs){
    $mes_largo = date('t');
   
    for ($i = 1; $i <= $mes_largo; $i++) {
        $cant_libros=0;
        $cant_fuera=0;
        $disponibles=0;
        mysqli_data_seek($en_libros, 0);
        while($fila = mysqli_fetch_array($en_libros)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['fecha_entrada'])) {
                $cant_libros++;
            }
        }
        mysqli_data_seek($fuera_servicio, 0);
        while($fila = mysqli_fetch_array($fuera_servicio)) {
            if(date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['detalle_inicio']) ||  date('Y-m-d', $primer_dia) == date('Y-m-d', $fila['inicio_limpieza'])) {
                $cant_fuera++;
            }
        }
        $disponibles = $total_habs - $cant_libros - $cant_fuera;
        $d = (100*$disponibles) / $total_habs;
        $d =round($d,2);
        echo '<td>'.$d.'</td>';
        $primer_dia+=86400;
}
}


echo '
    <div class="contenedor__pronosticos">
        <table class="table table-bordered table-sm ">
            <thead>
            <tr>
                <th >Mes</th>
                <th colspan="31">Agosto</th>
                <th rowspan="2" scope="col">Mensual</th>
            </tr>
            <tr>
            <th scope="col">Dia</th>
            ';

            for ($i = 1; $i <= $mes_largo; $i++) {
                echo "
                <th scope='col'>$i</th>
                ";
            }

            echo '
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <tr>
            <th scope="row">Inventario total de habitaciones</th>';

            for ($i = 1; $i <= $mes_largo; $i++) {
                echo '
                <td>'.$total_habs.'</td>';
            }

            echo '
                <td>3410</td>
            </tr>
            ';
           
            echo '<tr><th> Fuera servicio</th>';
            imprimir_fuera_servicio($fuera_servicio,$primer_dia);
              
            echo '</tr>';

            echo '<tr><th> En libros (vendidas, reservadas)</th>';
            imprimir_en_libros($en_libros,$primer_dia);
              
            echo '</tr>';

            echo '<tr><th> Tarifa promedio</th>';
            imprimir_tarifa_promedio($en_libros,$primer_dia);
              
            echo '</tr>';

            echo '<tr><th> Llegadas del dia</th>';
            imprimir_llegadas_dia($llegadas_dia,$primer_dia);
              
            echo '</tr>';

            echo '<tr><th> Salidas del dia</th>';
            imprimir_salidas_dia($salidas_dia,$primer_dia);
              
            echo '</tr>';

            echo '<tr><th>Disponibles (a la venta)</th>';
            imprimir_disponibles($en_libros,$fuera_servicio,$primer_dia,$total_habs);
              
            echo '</tr>';

            echo '<tr><th>% de disponibilidad</th>';
            imprimir_disponibilidad($en_libros,$fuera_servicio,$primer_dia,$total_habs);
              
            echo '</tr>';

            echo '<tr><th>% de Ocupacion</th>';
            imprimir_ocupacion($en_libros,$fuera_servicio,$primer_dia,$total_habs);
              
            echo '</tr>';

            

            die();



            // foreach ($etiquetas as $key => $etiqueta) {
            //     echo '<tr>
            //     <td>'.$etiqueta.'</td>';
            //     $primer_dia = strtotime("first day of");

            //     for ($i = 1; $i <= $mes_largo; $i++) {
            //         $suma=0;
            //         $cant_libros=0;
            //         $llegadas_dia=0;
            //         $salidas_dia=0;
            //         $disponibles=0;

            //         // echo date('Y-m-d',$primer_dia) ."\n";
            //         if($key==0){
            //             $fuera_servicio = $hab->fuera_servicio($primer_dia);
            //             echo '<td>'.$fuera_servicio.'</td>';
            //         }
            //         if($key==1){
            //             $cant_libros = $hab->en_libros($primer_dia);
            //             echo '<td>'.$cant_libros.'</td>';
            //         }
            //         if($key==2){

            //             echo '<td>5500000000</td>';
                        
            //         }
            //         if($key==3){
            //             // echo date('Y-m-d',$primer_dia);
            //             // die();
            //             $llegadas_dia = $hab->llegadas_dia($primer_dia);
            //             echo '<td>'.$llegadas_dia.'</td>';
            //             // die();
            //         }
            //         if($key==4){
            //             // echo date('Y-m-d',$primer_dia);
            //             // die();
            //             $salidas_dia = $hab->llegadas_salida($primer_dia);
            //             echo '<td>'.$salidas_dia.'</td>';
            //             // die();
            //         }
            //         if($key == 5){
            //             $cant_libros = $hab->en_libros($primer_dia);
            //             $fuera_servicio = $hab->fuera_servicio($primer_dia);
            //             $disponibles = $total_habs - $cant_libros - $fuera_servicio;

            //             echo '<td>'.$disponibles.'</td>';

            //         }
            //         if($key==6){
            //             $cant_libros = $hab->en_libros($primer_dia);
            //             $fuera_servicio = $hab->fuera_servicio($primer_dia);
            //             $disponibles = $total_habs - $cant_libros - $fuera_servicio;
            //             //aplicamos 3.
            //             $d  = (100 * $disponibles) / $total_habs;
            //             $d =round($d,2);
            //             echo '<td>'.$d.'</td>';
            //         }
            //         if($key==7){
            //             $cant_libros = $hab->en_libros($primer_dia);
            //             //aplicamos 3.
            //             $d  = (100 * $cant_libros) / $total_habs;
            //             $d =round($d,2);
            //             echo '<td>'.$d.'</td>';
            //         }
            //         // if($key==2){
            //         //     while($fila= mysqli_fetch_array($en_libros)){
            //         //         if(date('Y-m-d',$tiempo_actual) == date('Y-m-d',$fila['detalle_inicio'] ) ||  date('Y-m-d',$tiempo_actual) == date('Y-m-d',$fila['inicio_limpieza'])){
            //         //             $suma++;
            //         //         }
            //         //     }
            //         // $tiempo_actual+=86400;

            //         // echo '<td>'.$suma.'</td>';
            //         // }

            //         $primer_dia+=86400;
            //     }

            //     echo'
            //     </tr>
            //     ';
            // }

            echo'
            <th scope="row">Estandar King</th>
            <tr>
                <td>Fuera de servicio</td>
            </tr>
            <tr>
                <td>En libros (vendidas, reservadas)</td>
            </tr>
            <tr>
                <td>Tarifa promedio</td>
            </tr>
            <tr>
                <td>Llegadas del dia</td>
            </tr>
            <tr>
                <td>Salidas del dia</td>
            </tr>
            <tr>
                <td>Disponibles (a la venta)</td>
            </tr>
            <tr>
                <td>% de disponibilidad</td>
            </tr>
            <tr>
                <td>% de Ocupacion</td>
            </tr>
            <tr>
                <th scope="row">Estandar King</th>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>40</td>
                <td>1240</td>
            </tr>
            <tr>
                <td>Fuera de servicio</td>
            </tr>
            <td>En libros (vendidas, reservadas)</td>
            </tr>
            <tr>
                <td>Tarifa promedio</td>
            </tr>
            <tr>
                <td>Llegadas del dia</td>
            </tr>
            <tr>
                <td>Salidas del dia</td>
            </tr>
            <tr>
                <td>Disponibles (a la venta)</td>
            </tr>
            <tr>
                <td>% de disponibilidad</td>
            </tr>
            <tr>
                <td>% de Ocupacion</td>
            </tr>
            <tr class="table-group-divider">
                <th scope="row">Estandar doble</th>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>1860</td>
            </tr>
            <tr>
                <td>Fuera de servicio</td>
            </tr>
            <td>En libros (vendidas, reservadas)</td>
            </tr>
            <tr>
                <td>Tarifa promedio</td>
            </tr>
            <tr>
                <td>Llegadas del dia</td>
            </tr>
            <tr>
                <td>Salidas del dia</td>
            </tr>
            <tr>
                <td>Disponibles (a la venta)</td>
            </tr>
            <tr>
                <td>% de disponibilidad</td>
            </tr>
            <tr>
                <td>% de Ocupacion</td>
            </tr>
            <tr>
                <th scope="row">Suite</th>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>310</td>
            </tr>
            <tr>
                <td>Fuera de servicio</td>
            </tr>
            <td>En libros (vendidas, reservadas)</td>
            </tr>
            <tr>
                <td>Tarifa promedio</td>
            </tr>
            <tr>
                <td>Llegadas del dia</td>
            </tr>
            <tr>
                <td>Salidas del dia</td>
            </tr>
            <tr>
                <td>Disponibles (a la venta)</td>
            </tr>
            <tr>
                <td>% de disponibilidad</td>
            </tr>
            <tr>
                <td>% de Ocupacion</td>
            </tr>
            </tbody>
        </table>
    </div>
';