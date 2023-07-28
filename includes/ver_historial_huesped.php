<?php

include_once('clase_huesped.php');
$huesped = new Huesped($_GET['id']);

$inicial = $_GET['inicial'];
$final = $_GET['final'];
$historial = $huesped->mostrar_historial_cuenta($huesped->id,$inicial,$final,"");


    date_default_timezone_set('America/Mexico_CIty');
    echo '
    <div class="container-fluid blanco">
    <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="ver_huespedes()"> ←</button></div>
    <div class="col-12 text-center"><h2 class="text-dark">Historial del cliente</h2></div>
    <br>
    <div class="row">
            <div class="col-sm-2">';
              echo '<input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_reservacion(event)" class="color_black form-control form-control" autofocus="autofocus"/>
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
              <button class="btn btn-success btn-block btn-default" onclick="buscar_historial_huesped('.$huesped->id.')">
                Buscar 
              </button>
            </div>
           
            <div class="col-sm-1">
              <button class="btn btn-primary btn-block btn-default" onclick="ver_reservaciones_reporte()">
                Reporte
              </button>
            </div>

          </div><br>
    <div class="flex-wrap row>
        <div class="col-12 col-sm-4">
        <p>'.$huesped->nombre.' '.$huesped->apellido.'</p>
    </div>

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