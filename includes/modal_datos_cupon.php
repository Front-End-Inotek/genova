<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);
  // Checar si codigo descuento esta vacio o no
  if (empty($_GET['codigo_descuento'])){
    //echo 'La variable esta vacia';
    $codigo= 0;
  }else{
    $codigo= urldecode($_GET['codigo_descuento']);
  }
  $id_cupon= $cupon->obtengo_id($codigo);
  $cupon= NEW Cupon($id_cupon);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Datos Cupón
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      if($id_cupon > 0){
        echo '<div class="row">';
          if($cupon->tipo == 0){
            echo '<div class="col-sm-6">Descuento de '.$cupon->cantidad.'%</div>';
          }else{
            echo '<div class="col-sm-6">Descuento $'.number_format($cupon->cantidad, 2).'</div>';
          }     
        echo '<div class="col-sm-6">Vigencia: '.date("d-m-Y",$cupon->vigencia_inicio).' al '.date("d-m-Y",$cupon->vigencia_fin).'</div>
        </div><br>';
      }else{
        echo '<div class="row">';
          echo '<div class="col-sm-12">¡Cupón no valido!</div>
        </div><br>';
      }
    echo '</div>  

    <div class="modal-footer" id="boton_datos_cupon">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
