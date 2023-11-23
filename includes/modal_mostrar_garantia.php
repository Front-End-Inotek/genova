<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");


  $id = !empty($_GET['huesped']) ? $_GET['huesped'] : 0;

  $estado_tarjeta =  !empty($_GET['estadotarjeta']) ? $_GET['estadotarjeta'] : 0;

  $huesped= NEW Huesped($id);

  echo '

    <div class="modal-header">
      <h5 class="modal-title">Metodo de pago / Metodo de garantia</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
      </button>
    </div>

    <div class="modal-body">
        <div id="datos_garantia">';
        $huesped->mostrar_garantia($estado_tarjeta);
    echo'</div>
    </div>

    <div class="modal-footer" id="boton_asignar_huesped">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button class="btn btn-primary" onclick="asignarValorTarjeta()" ><span>Listo</span></button>
    </div>
  ';
?>
