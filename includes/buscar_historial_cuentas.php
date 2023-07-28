<?php
date_default_timezone_set('America/Mexico_CIty');
include_once('clase_cuenta.php');
$cuenta = new Cuenta(0);
$inicial = $_GET['inicial'];
$final = $_GET['final'];
$a_buscar =$_GET['a_buscar'];
$historial = $cuenta->mostrar_historial_cuentas($inicial,$final,$a_buscar);

    echo '
  
    <table class="table table-striped" id="tabla_historial">
  <thead>
    <tr>
        <th scope="col">ID CUENTA</th>
      <th scope="col">Fecha</th>
      <th scope="col">Huesped</th>
      <th scope="col">Tipo hab.</th>
      <th scope="col">Cargo</th>
      <th scrop="col">Abono</th>
      <th scrop="col">Estado</th>
      <th scope="col">Descripción</th>
    </tr>
  </thead>
  <tbody>';

  while ($fila = mysqli_fetch_array($historial)) {
    $nombre_huesped = $fila['huesped_nombre'] . " ". $fila['huesped_apellido'];
    $estado = $fila['estado_cuenta']== 1 ? "Activo" : "Cerrado";
    echo '
    <tr>
      <th scope="row">'.$fila['id_cuenta'].'</th>
      <th>'.date('Y-m-d',$fila['fecha']).'</th>
      <td>'.$nombre_huesped.'</td>
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