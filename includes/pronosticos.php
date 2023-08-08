<?php
include_once('clase_hab.php');

$hab = new Hab(0);

$total_habs = $hab->obtener_todas();


$tiempo = time();

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

            for ($i = 1; $i <= 31; $i++) {
                $dia = date('d', $tiempo);
                $tiempo += 86400;
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

                for ($i = 1; $i <= 31; $i++) {
                    $dia = date('d', $tiempo);
                    $tiempo += 86400;
                    echo '
                    <td>'.$total_habs.'</td>';
            }

            echo '
                <td>3410</td>
            </tr>
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