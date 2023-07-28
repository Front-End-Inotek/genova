<?php
include_once('clase_cuenta.php');
$cuenta = new Cuenta(0);
$inicial = $_GET['inicial'];
$final = $_GET['final'];
$historial = $cuenta->mostrar_historial_cuentas($inicial,$final,"");


    date_default_timezone_set('America/Mexico_CIty');
    echo '
    <div class="container-fluid blanco">
    <div class="col-12 text-center"><h2 class="text-dark">Historial cuentas</h2></div>
    <br>
    <div class="row">
            <div class="col-sm-2">';
              echo '<input type="text" id="a_buscar" placeholder="Buscar" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-1">Fecha Inicial:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date"  id="inicial_historial"  placeholder="Reservacion inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-1">Fecha Final:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date" id="final_historial" placeholder="Reservacion final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-1">
              <button class="btn btn-success btn-block btn-default" onclick="buscar_historial_cuentas()">
                Buscar 
              </button>
            </div>
            <div class="col-sm-1">
              <button class="btn btn-primary btn-block btn-default" onclick="buscar_historial_cuentas()">
                Reporte
              </button>
            </div>

          </div><br>
    <div class="flex-wrap row>
        <div class="col-12 col-sm-4">
      
    </div>

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