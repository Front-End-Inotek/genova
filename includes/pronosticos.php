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
            foreach ($etiquetas as $key => $etiqueta) {
                echo '<tr>
                <td>'.$etiqueta.'</td>';
                $primer_dia = strtotime("first day of");

                for ($i = 1; $i <= $mes_largo; $i++) {
                    $suma=0;
                    $cant_libros=0;

                    // echo date('Y-m-d',$primer_dia) ."\n";
                    if($key==0){
                        $fuera_servicio = $hab->fuera_servicio($primer_dia);
                        echo '<td>'.$fuera_servicio.'</td>';
                    }
                    if($key==1){
                        $cant_libros = $hab->en_libros($primer_dia);
                        echo '<td>'.$cant_libros.'</td>';
                    }
                    if($key==2){

                        echo '<td></td>';
                        
                    }
                    if($key==3){
                        $llegadas_dia = $hab->llegadas_dia($primer_dia);
                        echo '<td>'.$llegadas_dia.'</td>';
                    }
                    // if($key==2){
                    //     while($fila= mysqli_fetch_array($en_libros)){
                    //         if(date('Y-m-d',$tiempo_actual) == date('Y-m-d',$fila['detalle_inicio'] ) ||  date('Y-m-d',$tiempo_actual) == date('Y-m-d',$fila['inicio_limpieza'])){
                    //             $suma++;
                    //         }
                    //     }
                    // $tiempo_actual+=86400;

                    // echo '<td>'.$suma.'</td>';
                    // }

                    $primer_dia+=86400;
                }

                echo'
                </tr>
                ';
            }

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