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
    $precio_hospedaje= $_GET['precio_hospedaje'];
    $total_adulto= $_GET['total_adulto'];
    $total_junior= $_GET['total_junior'];
    $total_infantil= $_GET['total_infantil'];
  }
  $id_cupon= $cupon->obtengo_id($codigo);
  $cupon= NEW Cupon($id_cupon);
  $vigencia_inicio= $cupon->vigencia_inicio;
  $vigencia_fin= $cupon->vigencia_fin;
  $fecha_actual= time();
  $fecha_actual= date("d-m-Y",$fecha_actual);
  $fecha_actual= strtotime($fecha_actual);
  
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Aplicar Cupón
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      if($id_cupon > 0){
        if($fecha_actual >= $vigencia_inicio && $fecha_actual <= $vigencia_fin){
          echo '<div class="row">';
            echo '<div class="col-sm-12">¡Se aplico con éxito el cupón!</div>
          </div><br>';
          echo "<script>";
              echo "calcular_total_cupon('$precio_hospedaje','$total_adulto','$total_junior','$total_infantil','$cupon->cantidad','$cupon->tipo');";
          echo "</script>";
        }else{
          echo '<div class="row">';
            echo '<div class="col-sm-6">¡Vigencia no valida para el cupón!</div>';
            echo '<div class="col-sm-6">Vigencia: '.date("d-m-Y",$cupon->vigencia_inicio).' al '.date("d-m-Y",$cupon->vigencia_fin).'</div>
          </div><br>';
        }
      }else{
        echo '<div class="row">';
          echo '<div class="col-sm-12">¡Cupón no valido!</div>
        </div><br>';
      }
    echo '</div>  

    <div class="modal-footer" id="boton_datos_cupon">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cerrar</button>
    </div>
  </div>';
?>
