<?php
  //error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
 
  class Informacion_mesas extends ConexionMYSql
  {
    // Constructor
    function __construct()
    {

    } 
    function evaluarEntrada($usuario_evaluar ,$password_evaluar){
      //include_once('log.php');
      //$logs = NEW Log(0);
      $id=0;
      $sentencia = "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND estado = 1";
      $comentario="Busqueda de colores en base de datos archvivo Colors.php funcion constructor";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      //echo $sentencia;
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
           //$logs->guardar_log($fila['id'],"Inicio de session el usuario: ".$id);
      }
      return $id;
    }

    function guardar_mesa($nombre,$comentario,$capacidad,$mov){
      $id= 0;
      $sentencia= "INSERT INTO `mesa`( `nombre`, `mov`, `comentario`, `capacidad`, `estado`, `estado_mesa`,`tipo`) VALUES 
      ('$nombre','$mov','$comentario','$capacidad',0,1,1)";
      $comentario= "Evaluar los datos para cambiar los productos de una mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      //echo $sentencia;
      if($consulta){
        echo "OK";
      }else{
        echo "NO";
      }
     
    }
    // Evaluar los datos para cambiar los productos de una mesa
    function evaluar_datos($usuario_evaluar ,$password_evaluar){
      $id= 0;
      $sentencia= "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND nivel <= 1 AND estado = 1";
      $comentario= "Evaluar los datos para cambiar los productos de una mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      //echo $sentencia;
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
    function ver_detalle($mesa_id,$estado,$nombre,$persona,$mov){
      switch ($estado) {
        case 0:
            echo $nombre;
          break;
        case 1:
            echo $persona;
          break;
        case 2:
            echo $persona;
          break;
        case 3:
            echo $persona;
          break;
        case 4:
            echo $persona;
          break;
        case 5:
            echo $persona;
          break;
        case 6:
            echo "-";
          break;
        /*case 7:
            echo $nombre;
          break;
        case 8:
            echo $nombre;
          break;
        case 9:
            echo $persona;
          break;
        case 11:
           echo $nombre;
          break;
        case 12:
            echo $nombre;
          break;
        case 13:
            echo $nombre;
          break;
        case 14:
            echo $persona;
          break;
        case 15:
            echo $nombre;
          break;
        case 16:
            echo $nombre; 
          break;
          case 17:
            echo $persona;
          break;*/
        default:
          echo "-";
          break;
      }
    }
    function mostrar_mesas(){
      include('clase_movimiento.php');
      $movimiento= NEW Movimiento(0);
      $tipo= 1;
      $cronometro=0;
      //$sentencia = "SELECT mesa.id,mesa.nombre,mesa.tipo,mesa.mov as moviemiento,mesa.estado,mesa.comentario,tipo_mesa.nombre AS tipo_monbre,movimiento.estado_interno AS interno FROM mesa LEFT JOIN tipo_mesa ON mesa.tipo = tipo_mesa.id LEFT JOIN movimiento ON mesa.mov = movimiento.id ORDER BY id";
      $sentencia = "SELECT mesa.id,mesa.nombre,mesa.tipo,mesa.mov as moviemiento,mesa.capacidad,mesa.estado,mesa.comentario,movimiento.personas FROM mesa LEFT JOIN movimiento ON mesa.mov = movimiento.id WHERE mesa.estado_mesa = 1 ORDER BY id";
      $comentario="Mostrar mesa archivo areatrabajo.php funcion mostrarmesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $estado="no definido";
        switch ($fila['estado']) {
            case 0:
              $estado="Disponible";
              //$cronometro=$movimiento->saber_tiempo_ultima_renta($fila['id']);
            break;
            case 1:
              $estado="Ocupada";
              //$cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
            break;
            case 2:
              $estado="Sucia";
              //$cronometro=$movimiento->saber_inicio_sucia($fila['moviemiento']);
            break;
            case 3:
              $estado="Limpieza";
              //$cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
            break;
            case 4:
              $estado="Mant.";
              //$cronometro=$movimiento->saber_detalle_inicio($fila['moviemiento']);
              /*$sub_motivo=$movimiento->saber_motivo($fila['moviemiento']);
              $motivo=substr($sub_motivo, 0, 15);*/
            break;
            case 5:
              $estado="Super.";
              //$cronometro=$movimiento->saber_tiempo_inicio($fila['moviemiento']);
            break;
            case 6:
              $estado="Cancelada";
              //$persona=$movimiento->saber_per_deta($fila['moviemiento']);
              //$persona=$usuario->obtengo_usuario($id);"no existe"
              //$cronometro=$movimiento->saber_tiempo_inicio($fila['moviemiento']);
            break;
          break;
        }

        if($fila['tipo']>0){
          echo '<div class="col-xs-4 col-sm-2 col-md-1 espacio_mesa">';
            echo '<a href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas_mesas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')"><div class="estado_mesa'.$fila['estado'].'">';

              echo '<div class="row">
                <div class="col-sm-12">
                  <div class="titulo_mesa">';
                    echo $estado;
                  echo '</div>
                </div>

                <div class="col-sm-12">
                  <div class="imagen_mesa">';
                    if($fila['id']<100){
                        echo '<span class="tama_num_mesa">'.$fila['nombre'].'</span>';
                    }else{
                        echo '<span class="tama_num_mesa">'.$fila['comentario'].'</span>';
                    }
                  echo '</div>
                </div>
              </div>';

              echo '<div class="capacidad_mesa">';
                      if($fila['estado'] == 0){
                        $capacidad= $fila['capacidad'];
                      }else{
                        $capacidad= $fila['personas'];
                      }
                      if($capacidad>0){
                        echo $capacidad;
                      }
              echo '</div>';

              /*echo '<div class="capacidad_mesa">';
                      //$total= $movimiento->cuenta_total($fila['id']);
                      if($fila['estado'] == 1){
                        if($total_faltante >= 0){
                          echo '$'.number_format($total_faltante, 2);
                        }else{
                          $total_faltante= substr($total_faltante, 1);
                          echo '-$'.number_format($total_faltante, 2);
                        }
                      }else{
                        $total_faltante= '&nbsp';
                        echo $total_faltante;
                      }
              echo '</div>';*/

              echo '<div class="icono_mesa">';
              //echo '<img id="icono" src="images/mesa.png">';
                  //echo $motivo;
                  /*switch ($fila['interno']){
                    case '':
                      echo '<img id="icono_r" src="."';  
                      break;
                    case 'disponible':
                      echo '<img id="icono_r" src="."';  
                      break;
                    case 'sin estado':
                      echo '<img id="icono_r" src="."';  
                      break;
                    case 'sucia':
                      echo '<img id="icono_c" src="images/basura.png">';
                      break;
                    case 'limpieza':
                      echo '<img id="icono_c" src="images/lavando.png">';
                      break;
                    case 4:
                      //echo '<img src="images/mantenimiento.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 5:
                      //echo '<img src="images/bloqueo.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 6:
                      //echo '<img src="images/cobrando.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 7:
                      //echo '<img src="images/cama.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 8:
                      //echo '<img src="images/basura.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 9:
                      //echo '<img src="images/limpieza.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 11:
                      //echo '<img src="images/restaurant.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 12:
                      //echo '<img src="images/cama.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 13:
                      //echo '<img src="images/restaurant.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    default:
                      //echo '<img src="images/home.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                    case 14:
                      //echo '<img src="images/limpieza.png"  class="espacio_mesa-imagen center-block img-responsive">';
                      break;
                }   */      
              echo '</div>';

              echo '</div>';
              echo '</div>';
            echo '</a>';
          echo '</div>';
        }else{
          echo '<div class="hidden-xs hidden-sm col-md-1 espacio_mesa">';   
          echo '</div>';
        }
      }
    }

  }
?>

