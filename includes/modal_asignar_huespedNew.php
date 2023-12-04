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
    <div class="modal-header">
      <h5 class="modal-title">Asignar Huesped</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
      </button>
    </div>

    <div class="modal-body">
      <div class="col-sm-12">';
        if($reservacion){
          $huesped->mostrar_asignar_huespedNew($_GET['funcion'],$_GET['precio_hospedaje'],$_GET['total_adulto'],$_GET['total_junior'],$_GET['total_infantil']);
        }else{
          $huesped->mostrar_asignar_huesped_maestra($_GET['maestra'],$_GET['mov']);
        }
        echo '
        </div>
      </div>

    <div class="modal-footer" id="boton_asignar_huesped">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    </div>
  ';
?>
