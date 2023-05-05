<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  $tarifa= NEW Tarifa(0);
  $reservacion = new Reservacion(0);
  $inputFechaEn="";
  $inputValueFecha="";
  $dia= time();
  $dia_actual= date("Y-m-d",$dia);

  

  // echo $reservacion->comprobarFechaReserva("1682744400",1);




  // Checar si hab_id esta vacia o no
  if (empty($_GET['hab_id'])){
    //echo 'La variable esta vacia';
    $hab_id= 0;
    $hab_tipo= 0;
    // die(false);
    $hab = NEW Hab(0);
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
  }else{
    $hab_id= $_GET['hab_id'];
    $hab = NEW Hab($hab_id);
    $hab_tipo= $hab->tipo;
    $inputFechaEn="disabled";
    $inputValueFecha=$dia_actual;
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
    // die("no");
  
  }

 

 

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
            <input '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control" type="date"  id="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.')">
          </div>
          </div>
          <div class="col-sm-2">Fecha Salida:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.')">
          </div>
          </div>
          
        </div>
        <div class="row">
          <div class="col-sm-2">Cant.Hab.:</div>
          <div class="col-sm-2">
          <div class="form-group">';
            if($hab_id != 0){
              echo '<input class="form-control" type="number"  id="numero_hab" value="1" onchange="cambiar_adultos('.$hab_id.')"/>';
              // echo '<input class="form-control" type="number"  id="numero_hab" value="1" onchange="cambiar_adultos('.$hab_id.')" disabled/>';

            }else{
            
              echo '<input class="form-control" type="number"  id="numero_hab" placeholder="0" onchange="cambiar_adultos('.$hab_id.')">';
              // echo '<select required class="form-control" id="numero_hab" onchange="cambiar_adultos('.$hab_id.',event)">
              // <option value="0">Selecciona</option>';
              // $hab->mostrar_hab_option();
              echo '
            </select>';
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
