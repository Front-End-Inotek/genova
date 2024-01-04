<?php
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  $total= $_GET['total'];
  $mensaje ="";
  $mensaje = $_GET['hab_id'] ==0 ? "Cargo a cuenta" : "Cargo Habitación";
  $id_maestra=0;
  if(isset($_GET['id_maestra'])){
      $id_maestra=$_GET['id_maestra'];
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Pago del Restaurante</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>


    <div class="modal-body">
      <div class="contenedor_botones">';
        echo '<div class="btn_modal_herramientas btn_edo_cuenta" onclick="pedir_rest_cobro_directo('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')" >';
        echo ' <img class="btn_modal_img" src="./assets/iconos_btn/pagar.svg"> ';
        echo '<p>Pagar Directo</p>';
        echo '</div>';

        echo '<div class="btn_modal_herramientas btn_edo_cuenta" onclick="pedir_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['id_maestra'].')" >';
        echo ' <img class="btn_modal_img" src="./assets/iconos_btn/cargo.svg"> ';
       echo '<p>'.$mensaje.'</p>';
        echo '</div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>