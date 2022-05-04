<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab(0);
  $movimiento= NEW Movimiento(0);
  $cant= strlen($_GET['hab']);
  if($cant > 0){
    $id_mov= $hab->mostrar_movimiento_hab($_GET['hab']);
  }else{
    $id_mov= 0;
  }
  $id_huesped = $movimiento->saber_id_huesped($id_mov);
  $huesped= NEW Huesped($id_huesped);
  if($id_huesped != 0){
    $nombre= $huesped->nombre;
    $apellido= $huesped->apellido;
  }else{
    $nombre= 'Habitación errónea';
    $apellido= 'Habitación errónea';
  }
  echo '
      <div class="div_huesped">
        <div class="row">
          <div class="col-sm-3" >Nombre del  huesped:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="'.$nombre.'" disabled/>
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-3" >Apellido del huesped:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="apellido" value="'.$apellido.'" disabled/>
          </div>
          </div>
        </div>
      </div>';
?>
