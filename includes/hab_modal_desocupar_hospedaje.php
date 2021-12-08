<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_GET['hab_id']);
  $total_faltante= 0.0;
  $total_faltante= $cuenta->mostrar_faltante($hab->mov);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      if($total_faltante < 0){
        $total= substr($total_faltante, 1);
        echo '¡No se puede desocupar la habitación '.$hab->nombre.', tiene un saldo pendiente de -$'.number_format($total, 2).'!';
      }else{
        echo 'Confirmar desocupar habitación '.$hab->nombre.':';
      }
    echo '</div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>';
      if($total_faltante >= 0){
        echo '<button type="button" class="btn btn-success" onclick="hab_desocupar('.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>';
      }
    echo '</div>
  </div>';
?>