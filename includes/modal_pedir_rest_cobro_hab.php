<?php
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab($_GET['hab_id']);
  $movimiento = NEW Movimiento(0);
  $id_huesped= $movimiento->saber_id_huesped($_GET['mov']);
  $huesped= NEW Huesped($id_huesped);  
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Cargar pago del Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      if($id_huesped != 0){
        echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a '.$huesped->nombre.' '.$huesped->apellido.' a la habitación '.$hab->nombre.'?';
      }else{
        if($hab->nombre!=0){
          echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a la habitación '.$hab->nombre.'?';
        }else{
          echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a la cuenta?';
        }
        
      }
      echo '
    </div><br>   

    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="aplicar_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')"> Aceptar</button>
    </div>
  </div>';
?>