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
      Pago del Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>
    <div class="modal-body">
      <div class="row">';
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
            echo '<div class="edo_cuenta btn-square-lg" onclick="pedir_rest_cobro_directo('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')">';
            echo '</br>';
            echo '<div>';
                 //echo '<img src="images/persona.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Pagar Directo';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
            echo '<div class="edo_cuenta btn-square-lg" onclick="pedir_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['id_maestra'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/persona.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo $mensaje;
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>
      </div>
      <br>
    <div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>