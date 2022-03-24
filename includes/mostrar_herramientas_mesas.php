<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_info_mesas.php");
  include_once("clase_mesa.php");
  include_once("clase_configuracion.php");
  include_once("clase_movimiento.php");
  $conf = NEW Configuracion();
  function mostar_info($mesa_id,$estado,$mov,$id){
    $info = NEW Informacion_mesas($mesa_id,$estado,$mov,$id);
  }
  function show_info($mesa_id,$estado){
    $mesa = NEW Mesa($mesa_id);
    
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
                echo 'En Supervision';
              break;
              case 6:
                echo 'Cancelado';
              break;
              default:
                //echo "Estado indefinido";
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
  include_once("clase_ticket.php");
  $mesa = NEW Mesa($_GET['mesa_id']);
  $nombre_mesa = $mesa->nombre;
  $movimiento = NEW Movimiento(0);
  //$cliente = NEW Cliente($_GET['mesa_id']);
  $user = NEW Usuario($_GET['id']);
  $ticket= NEW Ticket(0);
  $concepto= NEW Concepto(0);
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  $precio= $concepto->saber_total_mesa($ticket_id);
  //$estado_interno= $movimiento->mostrar_estado_interno($mesa->mov);
  echo '<div class="modal-header">
          <h3 class="modal-title">Mesa '.$_GET['nombre'].'</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>';
  echo '<div class="container-fluid">';
  show_info($_GET['mesa_id'],$_GET['estado']);
  echo '</br>';
  echo '<div class="row">';
  switch ($_GET['estado']) {
    case 0:
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="ocupada btn-square-mesa-lg" onclick="mesa_disponible_asignar('.$_GET['mesa_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                echo '<img src="images/reporte.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Asignar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      /*if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="limpieza btn-square-mesa-lg" onclick="mesa_estado_limpiar('.$_GET['mesa_id'].','.$_GET['estado'].')">';
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
      }*/
      break;
    case 1 :
      /*if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="desocupar btn-square-mesa-lg" onclick="mesa_desocupar_hospedaje('.$_GET['mesa_id'].','.$_GET['estado'].')">';
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
          echo '<div class="edo_cuenta btn-square-mesa-lg" onclick="estado_cuenta('.$_GET['mesa_id'].','.$_GET['estado'].')">';
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
      }*/
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="restaurante btn-square-mesa-lg" onclick="agregar_restaurante('.$_GET['mesa_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                echo '<img src="images/restaurant.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Restaurante';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $precio>0){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          // Caja para cobrar anterior
          //echo '<div class="cobrar btn-square-mesa-lg" onclick="mesa_cobrar_rest('.$_GET['mesa_id'].','.$_GET['estado'].')">';
          echo '<div class="cobrar btn-square-mesa-lg" onclick="ver_caja_rest('.$_GET['mesa_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Cobrar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="personas btn-square-mesa-lg" onclick="mesa_cambiar_personas('.$_GET['mesa_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                echo '<img src="images/persona.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Cantidad Comensales';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2 && $precio>0){
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="recibo btn-square-mesa-lg" onclick="mesa_imprimir_ticket('.$_GET['mesa_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                echo '<img src="images/recibo2.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Imprimir Ticket';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      break;
  }
  echo '</div>';
  echo '<div class="row">';
    mostar_info($_GET['mesa_id'],$_GET['estado'],$mesa->mov,$_GET['id']);
  echo '</div>';
  echo '</div>';
  echo '<div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> -->
        </div>';
?>
