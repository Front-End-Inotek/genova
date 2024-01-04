<?php
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab($_GET['hab_id']);
  $movimiento = NEW Movimiento(0);
  $id_huesped= $movimiento->saber_id_huesped($_GET['mov']);
  $huesped= NEW Huesped($id_huesped);  
  $id_maestra=0;
  if(isset($_GET['id_maestra'])){
    $id_maestra=$_GET['id_maestra'];
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Cargar pago del Restaurante</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">';
      if($id_huesped != 0){
        if($id_maestra==0){
          echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a '.$huesped->nombre.' '.$huesped->apellido.' a la habitación '.$hab->nombre.'?';
        }else{
          echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a la cuenta?';
        }
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
      <button type="button" id="btn-restaurant" class="btn btn-primary" onclick="aplicar_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].',0,'.$id_maestra.')"> Aceptar</button>
    </div>
  </div>';
?>