<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_GET['hab_id']);
  $total_faltante= 0.0;
  $total_faltante= $cuenta->mostrar_faltante($hab->mov);
  $ver = $_GET['ver'];
  if($ver==1){
    $total_faltante=0;
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Desocupar la habitacion: '.$hab->nombre.'</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>
    <div class="modal-body">';
      $signo="";
      if($total_faltante != 0){
        echo '¡No se puede desocupar la habitación '.$hab->nombre.', tiene un saldo pendiente de $'.number_format($total_faltante, 2).'!';
      }else{
        echo 'Confirmar desocupar habitación '.$hab->nombre.':';
      }
    echo '</div><br>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>';
      if($total_faltante == 0){
        echo '<button type="button" class="btn btn-primary" onclick="hab_desocupar('.$_GET['hab_id'].','.$_GET['estado'].','.$ver.')"> Aceptar</button>';
      }
      if($total_faltante != 0){
        echo '<button type="button" class="btn btn-primary" onclick="estado_cuenta('.$_GET['hab_id'].','.$_GET['estado'].')"> Ver estado de cuenta</button>';
      }
    echo '</div>
  </div>';
?>