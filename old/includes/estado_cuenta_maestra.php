<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_tarifa.php");
  include_once("clase_movimiento.php");
  include_once("clase_cuenta_maestra.php");

  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_GET['hab_id']);
  $tarifa= NEW Tarifa(0);
  $movimiento= NEW Movimiento($_GET['mov']);
  $cm = new CuentaMaestra($_GET['id']);

  $usuario_id = $_GET['usuario_id'];

  //revisar si existe un huesped asignado a la cuenta maestra para mostrar 'cierta'  info de ese huesped

  $id_huesped=0;

  if($cm->huesped!=""){
    require_once('clase_huesped.php');
    $huesped = new Huesped($cm->huesped);
    $id_huesped=$huesped->id;
    $nombre_huesped = $huesped->nombre ." ".$huesped->apellido;
  }

  $saldo_faltante= 0;
  $total_faltante= 0;
  $mov= $_GET['mov'];
  $suma_abonos= $cuenta->obtner_abonos($mov);
//   $saldo_pagado= $total_pago + $suma_abonos;
//   $saldo_faltante= $total_estancia - $saldo_pagado;
  $total_cargos= 0;
  $total_abonos= 0;
  $faltante= 0;
  $faltante= $cuenta->mostrar_faltante($mov);
  if($faltante >= 0){
    $faltante_mostrar= '$'.number_format($faltante, 2);
  }else{
    $faltante_mostrar= substr($faltante, 1);
    $faltante_mostrar= '-$'.number_format($faltante_mostrar, 2);
  }

  echo '
      <div class="container blanco" id="ec"> 
        <div class="row">
        <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="ver_cuenta_maestra()"> ←</button></div>
          <div class="col-sm-5 text-left"><h2 class="text-dark margen-1">ESTADO DE CUENTA MAESTRA - Nombre: '.$cm->nombre.' - Código: '.$cm->codigo.'</h2></div>';
          if($faltante == 0){
            echo '<div class="col-sm-6 text-right"></div>';
          }else{
            if($faltante > 0){
              echo '<div class="col-sm-6 text-right"><h5 class="text-dark margen-1">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }else{
              echo '<div class="col-sm-6 text-right"><h5 class="text-danger margen-1">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }
          }
        echo '</div>
        <div class="row">';
          if(!empty($nombre_huesped)){
            echo '  <div class="col-sm-4">Nombre Huesped: '.$nombre_huesped.'
            <button class="btn btn-info btn-block" href="#caja_herramientas" data-toggle="modal" onclick="asignar_huesped_maestra('.$_GET['id'].','.$mov.')"> Cambiar huesped</button>
            </div>
           </div>';

          }else{
            echo '<div class="col-sm-4">
            <button class="btn btn-info btn-block" href="#caja_herramientas" data-toggle="modal" onclick="asignar_huesped_maestra('.$_GET['id'].','.$mov.')"> Asignar huesped</button>
            </div>
           </div>';
          }


        echo '
        <div class="row">
          <div class="col-sm-6 altura-rest" id="caja_mostrar_busqueda" >';$total_cargos= $cuenta->mostrar_cargos($mov,0,$_GET['hab_id'],$_GET['estado'],$_GET['id'],$usuario_id);echo '</div>
          <div class="col-sm-6 altura-rest" id="caja_mostrar_totales" >';$total_abonos= $cuenta->mostrar_abonos($mov,0,$_GET['hab_id'],$_GET['estado'],$_GET['id'],$usuario_id);echo '</div>
        </div>'; 

        $total_faltante= $total_abonos - $total_cargos;

        echo '<div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-2">Total $'.number_format($total_cargos, 2).'</div>
          <div class="col-sm-4"></div>
          <div class="col-sm-2">Total $'.number_format($total_abonos, 2).'</div>
        </div>

        <div class="row d-flex justify-content-between">';
          /*if($total_faltante==0){
            echo '<div class="col-sm-12"></div>';
          }else{*/
          
            echo '<div class="col-sm-2"><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="agregar_cargo_adicional('.$cm->id.','.$_GET['mov'].')">Cargar</button></div>';
            echo '<div class="col-sm-2"></div>';
            echo '<div class="col-sm-2"><button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].','.$total_faltante.','.$mov.','.$_GET['id'].')"> Abonar</button></div>';
          //}
        echo '</div>
   
      </div>';
?>
