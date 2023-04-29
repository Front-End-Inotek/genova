<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_hab.php");
  $tarifa= NEW Tarifa(0);
  // Checar si hab_id esta vacia o no
  if (empty($_GET['hab_id'])){
    //echo 'La variable esta vacia';
    $hab_id= 0;
    $hab_tipo= 0;
  }else{
    $hab_id= $_GET['hab_id'];
    $hab = NEW Hab($hab_id);
    $hab_tipo= $hab->tipo;
  }
  $dia= time();
  $dia_actual= date("Y-m-d",$dia);
  echo '
      <div class="container blanco">';
        if($hab_id != 0){
          echo '<div class="col-sm-12 text-left"><h2 class="text-dark margen-1">CHECK-IN</h2></div>';
        }else{
          echo '<div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR RESERVACION</h2></div>';
        }
        echo '<div class="row">
          <div class="col-sm-2">Fecha Entrada:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_noches()">
          </div>
          </div>
          <div class="col-sm-2">Fecha Salida:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_noches()">
          </div>
          </div>
          
        </div>
        <div class="row">
          <div class="col-sm-2">No.Hab.:</div>
          <div class="col-sm-2">
          <div class="form-group">';
            if($hab_id != 0){
              echo '<input class="form-control" type="number"  id="numero_hab" value="1" onchange="cambiar_adultos('.$hab_id.')" disabled/>';
            }else{
              echo '<input class="form-control" type="number"  id="numero_hab" placeholder="0" onchange="cambiar_adultos('.$hab_id.')">';
            }
          echo '</div>
          </div>
          <div class="col-sm-1">Tarifa:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="tarifa" onchange="cambiar_adultos('.$hab_id.')">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tarifas($hab_tipo);
              echo '
            </select>
          </div>
          </div>
          
          <div class="col-sm-1">Noches:</div>
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="number"  id="noches" placeholder="0" onchange="cambiar_adultos('.$hab_id.')" disabled/>
          </div>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-secondary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_huespedes_reservacion('.$hab_id.')"> Agregar Huésped</button>
          </div>
        </div>
        <div class="row div_adultos"></div>';
          // Div adultos donde van resto de los datos para agregar una reservacion
          echo '
        </div>
      </div>';
?>
