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
              echo 'Ocupado';//Detallando
            break;
            case 2:
              echo 'Lavando';
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
              echo 'Sucia';
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
  echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Habitacion '.$_GET['nombre'].' </h3>
      </div>';
  $user = NEW Usuario($_GET['id']);
  echo '<div class="container-fluid">';
  show_info($_GET['hab_id'],$_GET['estado']);
  echo '</br>';
  echo '<div class="row">';
  switch ($_GET['estado']) {
    case 0:

            /*echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
              echo '<div class="detallar btn-square-lg" onclick="master_on('.$_GET['hab_id'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/detallando.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'On';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';

            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
              echo '<div class="detallar btn-square-lg" onclick="master_off('.$_GET['hab_id'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/detallando.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'OFF';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';*/

          /*if($user->nivel<=2 && $conf->motel ==1){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas">';
              echo '<div class="asignar btn-square-lg" onclick="hab_asignar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Espera';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }*/
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
            /*if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="detallar btn-square-lg" onclick="hab_detallar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/detallando.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Detallar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="lavar btn-square-lg" onclick="hab_lavar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/lavando.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Lavar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="limpiar btn-square-lg" onclick="hab_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/limpieza.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Limpiar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="mantenimiento btn-square-lg" onclick="hab_manteni('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/mantenimiento.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Mantenimiento';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){//
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="supervision btn-square-lg" onclick="hab_manteni('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/supervision.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Supervision';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="supervision btn-square-lg" onclick="hab_supervision('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/supervision.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Supervision';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="bloqueo btn-square-lg" onclick="hab_bloqueo('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/bloqueo.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Cancelar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=1){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="sucia btn-square-lg" onclick="hab_sucia('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/basura.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Sucia';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }*/

      break;
        case 1 :
            if($user->nivel<=2){
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
            if($user->nivel<=2){//* *//
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
            }
            if($user->nivel<=2){
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="sucia btn-square-lg" onclick="hab_ocupada_sucia('.$_GET['hab_id'].','.$_GET['estado'].')">';
                //echo '<div class="ocupada" onclick="hab_checkin('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
            if($user->nivel<=2){
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="limpieza btn-square-lg" onclick="hab_ocupada_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
            $mov=$hab->saber_retorno($hab->mov);
            if($mov==0){
              if($user->nivel<=2){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
            }else{
              if($user->nivel<=2){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle_retorno('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/home.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo 'Sucia';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              }
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="lavar btn-square-lg" onclick="hab_camb_per_etalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Cambio Rec.';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
      break;
  case 3 :
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="limpiar btn-square-lg" onclick="hab_camb_per_etalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Cambio Rec.';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
    break;
    case 4 :
    $mov=$hab->saber_retorno($hab->mov);
    if($mov==0){
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
          echo '<div class="detallar btn-square-lg" onclick="hab_detallar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/detallando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Detallar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
          echo '<div class="limpiar btn-square-lg" onclick="hab_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/limpieza.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Limpiar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
    }else{
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle_retorno('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/home.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Sucia';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
    }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="mantenimiento btn-square-lg" onclick="hab_camb_per_mantto('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/persona.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cambio Mantto';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
        
  break;
      case 5 :
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
              echo '<div class="limpiar btn-square-lg" onclick="hab_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/limpieza.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Limpiar';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
    break;
    case 6 :
    if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="ocupada btn-square-lg" onclick="hab_cobrar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cama.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Habitacion.';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';

        echo '<div class="col-xs-6 col-sm-4 col-md-4 btn-herramientas" >';
          echo '<div class="ocupada btn-square-lg" onclick="hab_cobrar_con_resta('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cama.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Hab.y Restaurante.';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
        if($conf->cancelado==1){

          if($user->nivel<=1){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="terminar btn-square-lg" onclick="cancelar_hab('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/home.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Cancelar';
                echo '</div>';
                echo '</br>';
              echo '</div>'; 
            echo '</div>';
          }else{
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="terminar btn-square-lg" onclick="cancelar_hab_espera('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/home.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Cancelar';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
          
        }else{
          if($user->nivel<=1){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="terminar btn-square-lg" onclick="cancelar_hab('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/home.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Cancelar';
                echo '</div>';
                echo '</br>';
              echo '</div>'; 
            echo '</div>';
          }
        }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="asignar btn-square-lg" onclick="hab_camb_per_etalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/persona.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cambio Rec.';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
      /*  if($conf->placas>0){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="placas btn-square-lg" onclick="hab_asignar_placa('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/mantenimiento.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Matricula';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }*/
        break;
        case 7 :
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="sucia btn-square-lg" onclick="hab_terminar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/basura.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Desocupar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="restaurante btn-square-lg" onclick="hab_mostrar_rest('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/restaurant.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Restaurante';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';

            }
            if($conf->horas_extra==1){
              if($user->nivel<=2){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="horas btn-square-lg" onclick="hab_agregar_horas('.$_GET['hab_id'].','.$_GET['estado'].')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/clock.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo 'Horas Extras';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              }
            }
            if($conf->medio_tiempo==1){
              if($user->nivel<=2){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="horas btn-square-lg" onclick="hab_agregar_medio_turno('.$_GET['hab_id'].','.$_GET['estado'].')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/clock.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo 'Medio Turno';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              }
            }
            
            if($user->nivel<=2){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="ocupada btn-square-lg" onclick="hab_renovar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/cama.png"  class="center-block img-responsive">'; 
                    echo '</div>';
                    echo '<div>';
                      echo 'Renovar.';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              }
            if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="personas btn-square-lg" onclick="hab_agregar_personas('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Personas Ext.';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
          /*  if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="alarmas btn-square-lg" onclick="hab_guardar_alarma('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/alarma.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Alarma';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }*/
            if($conf->canc_despues==1){
              //secho "Configuracion de cancelacion";
              
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="terminar btn-square-lg" onclick="hab_terminar_hab_cobrada('.$_GET['hab_id'].','.$_GET['estado'].')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/home.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo 'Cancelar';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
            }else{
              if($user->nivel<=1){
                echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                  echo '<div class="terminar btn-square-lg" onclick="hab_terminar_hab_cobrada('.$_GET['hab_id'].','.$_GET['estado'].')">';
                    echo '</br>';
                    echo '<div>';
                        //echo '<img src="images/home.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo 'Cancelar';
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              }
            }
            if($conf->placas>0){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="paseo btn-square-lg" onclick="hab_paseo('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/clock.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Paseo';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
            if($user->nivel<2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="paseo btn-square-lg" onclick="cambio_placa('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/placa.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Cambio de placa';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
      break;
      case 8 :
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="limpieza btn-square-lg" onclick="hab_limpiar_sucia('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/limpieza.png"  class="center-block img-responsive">'; 
                echo '</div>';
                echo '<div>';
                  echo 'Limpiar';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
          //$tipo= $mov->2($hab->mov); fallo sucia
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
              echo '<div class="ocupada btn-square-lg" onclick="hab_re_ocupar('.$_GET['hab_id'].','.$_GET['estado'].')">';
                echo '</br>';
                echo '<div>';
                    //echo '<img src="images/cama.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Re ocupar';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
          if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
                echo '<div class="lavar btn-square-lg" onclick="hab_lavar_sucia('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/lavando.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Lavar';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
              echo '<div class="mantenimiento btn-square-lg" onclick="hab_manteni('.$_GET['hab_id'].','.$_GET['estado'].','.$hab->mov.')">';
              echo '</br>';
                echo '<div>';
                    //echo '<img src="images/mantenimiento.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Mantenimiento';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
          if($user->nivel<=2){
            echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
              echo '<div class="supervision btn-square-lg" onclick="hab_supervision('.$_GET['hab_id'].','.$_GET['estado'].','.$hab->mov.')">';
              echo '</br>';
                echo '<div>';
                    //echo '<img src="images/mantenimiento.png"  class="center-block img-responsive">';
                echo '</div>';
                echo '<div>';
                  echo 'Supervision';
                echo '</div>';
                echo '</br>';
              echo '</div>';
            echo '</div>';
          }
    break;
    case 9 :
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="terminar btn-square-lg" onclick="hab_liberar('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Liberar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas">';
          echo '<div class="asignar btn-square-lg" onclick="hab_asignar_de_limpieza('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Carro-Cochera';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
        if($user->nivel<=1){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="ocupada btn-square-lg" onclick="hab_re_ocupar('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/cama.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Re ocupar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="detallar btn-square-lg" onclick="hab_camb_per_limpieza_hab('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/persona.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cambio Rec.';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
    break;
    case 10 :
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="terminar btn-square-lg" onclick="hab_liberar('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cobrar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }

    break;
    case 11 :
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >'; 
          echo '<div class="asignar btn-square-lg" onclick="hab_cobrar_rest('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Cobrar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
        }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="ocupada btn-square-lg" onclick="hab_cancelar_rest('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cancelar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="restaurante btn-square-lg" onclick="hab_agregar_rest('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/restaurant.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Agregar +';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
    break;
    case 12:
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="sucia btn-square-lg" onclick="hab_terminar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/basura.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Desocupar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
      if($user->nivel<=2){
              echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                echo '<div class="restaurante btn-square-lg" onclick="hab_mostrar_rest_hospe('.$_GET['hab_id'].','.$_GET['estado'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/restaurant.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo 'Restaurante';
                  echo '</div>';
                  echo '</br>';
                echo '</div>';
              echo '</div>';
            }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas"  >';
            echo '<div class="limpiar btn-square-lg" onclick="hab_limpiar_hospedada('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/limpieza.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Limpiar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
              }

              if($user->nivel<=2){
                  echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                    echo '<div class="ocupada btn-square-lg" onclick="hab_renovar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
                      echo '</br>';
                      echo '<div>';
                          //echo '<img src="images/cama.png"  class="center-block img-responsive">';
                      echo '</div>';
                      echo '<div>';
                        echo 'Renovar.';
                      echo '</div>';
                      echo '</br>';
                    echo '</div>';
                  echo '</div>';
                }
                if($user->nivel<=2){
                  echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                    echo '<div class="ocupada btn-square-lg" onclick="cambio_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
                      echo '</br>';
                      echo '<div>';
                          //echo '<img src="images/cama.png"  class="center-block img-responsive">';
                      echo '</div>';
                      echo '<div>';
                        echo 'Cambiar Hab.';
                      echo '</div>';
                      echo '</br>';
                    echo '</div>';
                  echo '</div>';
                }
                $checkin=$movimiento->reporte_checkin($_GET['hab_id']);
                if($conf->checkin ==1){ 
                  if($checkin==0){
                  if($user->nivel<2){ 
                    echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                        echo '<div class="reporte btn-square-lg" onclick="hab_registro_checkin('.$_GET['hab_id'].','.$_GET['estado'].')">';
                          echo '</br>';
                          echo '<div>';
                              //echo '<img src="images/reporte.png"  class="center-block img-responsive">'; 
                          echo '</div>';
                          echo '<div>';
                            echo 'Checkin.';
                          echo '</div>';
                          echo '</br>';
                        echo '</div>';
                      echo '</div>';
                  }
                }else{
                  if($user->nivel<2){
                    echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
                        echo '<div class="reporte btn-square-lg" onclick="hab_registro_reportes('.$_GET['hab_id'].','.$_GET['estado'].')">';
                          echo '</br>';
                          echo '<div>';
                              //echo '<img src="images/reporte.png"  class="center-block img-responsive">'; 
                          echo '</div>';
                          echo '<div>';
                            echo 'Reporte.';
                          echo '</div>';
                          echo '</br>';
                        echo '</div>';
                      echo '</div>';
                  }
                }
              }
    break;
    case 13:
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="asignar btn-square-lg" onclick="hab_cobrar_rest_hospe('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Cobrar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
        }
        if($user->nivel<=2){
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="ocupada btn-square-lg" onclick="hab_cancelar_rest_hospe('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Cancelar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
    break;
    case 14 :
        if($user->nivel<=2){//
          echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
            echo '<div class="terminar btn-square-lg" onclick="hab_liberar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo 'Liberar';
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }

    break;
    case 15:
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="ocupada btn-square-lg" onclick="hab_re_ocupar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cama.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Re ocupar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
    break;
    case 16:
      if($user->nivel<=2){
        echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
          echo '<div class="ocupada btn-square-lg" onclick="hab_re_ocupar('.$_GET['hab_id'].','.$_GET['estado'].')">';
            echo '</br>';
            echo '<div>';
                //echo '<img src="images/cama.png"  class="center-block img-responsive">';
            echo '</div>';
            echo '<div>';
              echo 'Entregar';
            echo '</div>';
            echo '</br>';
          echo '</div>';
        echo '</div>';
      }
    break;
    case 17:
    if($user->nivel<=2){
      echo '<div class=" bcol-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
        echo '<div class="terminar btn-square-lg" onclick="hab_terminar_detalle('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
