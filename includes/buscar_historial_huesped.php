<?php
date_default_timezone_set('America/Mexico_CIty');
include_once('clase_huesped.php');
$huesped = new Huesped($_GET['id']);

$inicial = $_GET['inicial'];
$final = $_GET['final'];
$historial = $huesped->mostrar_historial_cuenta($huesped->id,$inicial,$final);



    echo '

    <table class="table table-striped" id="tabla_historial">
  <thead>
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Tipo hab.</th>
      <th scope="col">Cargo</th>
      <th scrop="col">Abono</th>
      <th scrop="col">Estado</th>
      <th scope="col">Descripción</th>
    </tr>
  </thead>
  <tbody>';

  while ($fila = mysqli_fetch_array($historial)) {
    $estado = $fila['estado_cuenta']== 1 ? "Activo" : "Cerrado";
    echo '
    <tr>
      <th scope="row">'.date('Y-m-d',$fila['fecha']).'</th>
      <td>'.$fila['hab_nombre'].'</td>
      <td>$'.number_format($fila['cargo'],2).'</td>
      <td>$'.number_format($fila['abono'],2).'</td>
      <td>'.$estado.'</td>
      <td>'.$fila['descripcion'].'</td>
    </tr>

    ';
  }
  echo '
  </tbody>
</table>
    ';
?>