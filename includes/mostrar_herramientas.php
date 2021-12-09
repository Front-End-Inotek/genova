<?php
date_default_timezone_set('America/Mexico_City');
include_once("clase_info.php");
include_once("clase_hab.php");
include_once("clase_configuracion.php");
include_once("clase_movimiento.php");
$conf = NEW Configuracion();
function mostar_info($hab_id,$estado,$mov,$id){
    $info = NEW Informacion($hab_id,$estado,$mov,$id);
}
function show_info($hab_id,$estado){
    $hab = NEW Hab($hab_id);
    
  echo '<div class="row">'; 
    echo '<div class="col-xs-12 col-sm-12 col-md-12">';
      echo '<div>';
        echo '<h3>';
          switch ($estado) {
            case 0:
              echo 'Disponible';
            break;
            case 1:
              echo 'Ocupado';
            break;
            case 2:
              echo 'Sucia';
            break;
            case 3:
              echo 'Limpiando';
            break;
            case 4:
              echo 'En Mantenimiento';
            break;
            case 5:
              echo 'Cancelado';
            break;
            case 6:
              echo 'Espera';
            break;
            case 7:
              echo 'Ocupada';
            break;
            case 8:
              echo 'Lavando';
            break;
            case 9:
              echo 'Limpieza';
            break;
            case 10:
              echo 'Restaurante';
            break;
            case 14:
              echo 'Limpieza';
            break;
            case 15:
              echo 'Paseo';
            break;
            case 17:
              echo 'Superv.';
            break;
          }
        echo '</h3>';
      echo '</div>';
      echo '<div>';
        echo '<h4>Información:</h4>';
      echo '</div>';

      echo '</div>';
  echo '</div>';
  //echo '</br>'; 
 
}
  include_once("clase_usuario.php");
  //include_once("clase_cliente.php");
  $hab = NEW Hab($_GET['hab_id']);
  $nombre_habitacion = $hab->nombre;
  $movimiento = NEW Movimiento(0);
  //$cliente = NEW Cliente($_GET['hab_id']);
  $user = NEW Usuario($_GET['id']);
  $estado_interno= $movimiento->mostrar_estado_interno($hab->mov);
  echo '<div class="modal-header">
        <h3 class="modal-title">Habitacion '.$_GET['nombre'].' </h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>';
  echo '<div class="container-fluid">';
  show_info($_GET['hab_id'],$_GET['estado']);
  echo '</br>';
  echo '<div class="row">';
  switch ($_GET['estado']) {
    case 0:
      if($user->nivel<=2 && $conf->hospedaje ==1){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="ocupada btn-square-lg" onclick="disponible_asignar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cama.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Asignar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $conf->hospedaje ==1){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Limpieza';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      break;
    case 1 :
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="desocupar btn-square-lg" onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/home.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Desocupar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="edo_cuenta btn-square-lg" onclick="estado_cuenta('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Edo. Cuenta';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="restaurante btn-square-lg" onclick="agregar_restaurante('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Restaurante';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $estado_interno != 'sucia'){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="sucia btn-square-lg" onclick="hab_sucia_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Sucia';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $estado_interno != 'limpieza'){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Limpieza';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $estado_interno != 'sin estado'){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="terminar btn-square-lg" onclick="hab_ocupada_terminar_interno('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/home.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Terminar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      /*if($user->nivel<=2){
          echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="restaurante btn-square-lg" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].')">';
                //echo '<div class="ocupada" onclick="hab_checkin('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Restaurante';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
      }*/
      break;
    case 2 :
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Limpieza';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="terminar btn-square-lg" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/home.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Terminar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      break;
    case 3 :
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
          //echo '<div class="ocupada" onclick="hab_checkin('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Limpieza';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      break;
  }
  echo '</div>';
  echo '<div class="row">';
    mostar_info($_GET['hab_id'],$_GET['estado'],$hab->mov,$_GET['id']);
  echo '</div>';
  echo '</div>';
  echo '<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>';
?>
