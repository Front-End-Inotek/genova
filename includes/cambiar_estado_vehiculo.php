<?php
    include_once('clase_huesped.php');
    include_once('clase_log.php');
    $huesped = new Huesped(0);
    $huesped->actualizar_estado_vehiculo($_GET['id_huesped'],$_GET['estado']);
    if($_GET['estado']==0){
        echo '
        <button type="button"  class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Auto en habitacion" onclick="cambiar_estado_vehiculo('.$_GET['id_huesped'].',1)"><i class="bx bx-car"></i></button>';
      }else{
        echo '
        <button type="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Auto en habitacion" onclick="cambiar_estado_vehiculo('.$_GET['id_huesped'].',0)"><i class="bx bx-car"></i></button>';
      }
     
?>