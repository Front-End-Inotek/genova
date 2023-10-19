<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_cuenta.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab($_GET['hab_id']);
  $cuenta= NEW Cuenta(0);
  $mov= $hab->mov;
  $nombre= $hab->nombre;
  $movimiento= NEW Movimiento($mov);
  $id_reservacion= $movimiento->saber_id_reservacion($mov);
  $usuario_id = $_GET['usuario_id'];

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">';
      echo 'Seleccionar un cuarto para cambiar todas las cuentas de la habitación '.$nombre.':';
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
    echo ' <div class="row">
    <div class="col-sm-6 altura-rest" id="caja_mostrar_busqueda" >';$total_cargos= $cuenta->mostrar_cargos_seleccion($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado'],0,$usuario_id);echo '</div>
    <div class="col-sm-6 altura-rest" id="caja_mostrar_totales" >';$total_abonos= $cuenta->mostrar_abonos_seleccion($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado'],0,$usuario_id);echo '</div>
    </div>';
//     echo '<div class="row">';
//     $hab->cambiar_cuentas_hab_ocupada($_GET['hab_id'],$_GET['estado'],$_GET['mov']); 
//   echo '</div>';
    

    echo '<div>     
    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="cargos_seleccionados()"> Siguiente</button>
    </div>
  </div>';
?>
