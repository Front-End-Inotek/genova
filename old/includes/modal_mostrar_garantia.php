<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");


  $id = !empty($_GET['huesped']) ? $_GET['huesped'] : 0;

  $estado_tarjeta =  !empty($_GET['estadotarjeta']) ? $_GET['estadotarjeta'] : 0;

  $huesped= NEW Huesped($id);

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
    Metodo de pago / Metodo de garantia
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12" id="datos_garantia">';
        $huesped->mostrar_garantia($estado_tarjeta);
        echo '</div>
      </div><br>
    </div>  

    <div class="modal-footer" id="boton_asignar_huesped">
      <button class="btn btn-success" onclick="asignarValorTarjeta()" ><span>Listo</span></button>
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
