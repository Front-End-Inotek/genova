<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  
  $reservacion=true;

  if(isset($_GET['maestra'])){
    if($_GET['maestra']!=0){
        $reservacion=false;
    }
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Asignar Huesped
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">';
        if($reservacion){
          $huesped->mostrar_asignar_huespedNew($_GET['funcion'],$_GET['precio_hospedaje'],$_GET['total_adulto'],$_GET['total_junior'],$_GET['total_infantil']);
        }else{
          $huesped->mostrar_asignar_huesped_maestra($_GET['maestra'],$_GET['mov']);
        }
        echo '</div>
      </div><br>
    </div>  

    <div class="modal-footer" id="boton_asignar_huesped">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
