<?php
  //error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
 
  class Informacion extends ConexionMYSql
  {

    function __construct()
    {

    }

    /*function evaluarEntrada($usuario_evaluar ,$password_evaluar){
      include_once('clase_log.php');
      $logs = NEW Log();
      $id=0;
      $sentencia = "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND estado = 1";
      $comentario="Busqueda de colores en base de datos archvivo Colors.php funcion constructor";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      //echo $sentencia;
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
           $logs->guardar_log($fila['id'],"Inicio de sesion el usuario: ".$id);// Inicio de sesion
      }
      return $id;
    }*/
    function conversorSegundosHoras($tiempo_en_segundos){//?
      $horas = floor($tiempo_en_segundos / 3600);
      $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
      $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
      if($minutos<10){
        $minutos="0".$minutos;
      }
      return $horas . ':' . $minutos ;
    }

    function ver_detalle($hab_id,$estado,$nombre,$persona,$mov){
      switch ($estado) {
        case 0:
            echo $nombre;
          break;
        case 1:
            echo $persona;
          break;
        /*case 2:
            echo $persona;
          break;
        case 3:
            echo $persona;
          break;
        case 4:
            echo $persona;
          break;
        case 5:
            echo "-";
          break;
        case 6:
            echo $persona;
          break;
        case 7:
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
    
    function cuenta_total($mov){//va con movimiento
      $id_reservacion=0;
      $total=0;
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
      //echo  $sentencia;
      $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id_reservacion= $fila['id_reservacion']; 
      }

      $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
      //echo  $sentencia;
      $comentario="Obtener la cuenta total de la habitacion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           if($fila['forzar_tarifa']>0){
             $total= $fila['forzar_tarifa']; 
           }else{
             $total= $fila['total']; 
           }
      }
      return $total;
    }
    
    function ver_fecha_salida($mov){//va con movimiento
      $id_reservacion=0;
      $fecha_salida=0;
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
      //echo  $sentencia;
      $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id_reservacion= $fila['id_reservacion']; 
      }

      $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
      //echo  $sentencia;
      $comentario="Obtener la fecha de salida de la habitacion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
             $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      }
      return $fecha_salida;
    }
  
    function mostrarhab($id,$token){
      $tipo= 1;
      include_once("clase_cuenta.php");
      include_once('clase_configuracion.php');
      include('clase_movimiento.php');
      include('clase_usuario.php');
      $cuenta= NEW Cuenta(0);
      $config = NEW Configuracion();
      $mivi =NEW movimiento(0);
      $usuario = NEW Usuario($id);
      $cronometro=0;
      $persona='-';
      //$persona= $id;
      $total_faltante= 0.0;
      $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario, tipo_hab.nombre AS tipo_monbre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id ORDER BY id";
     
      $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
        $estado="no definido";
        switch ($fila['estado']) {
            case 0:
              $estado="Disponible";
              $cronometro=$mivi->saber_tiempo_ultima_renta($fila['id']);
            break;
            case 1:
              $estado="Ocupado";//Detallado
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $cronometro=$mivi->saber_tiempo_fin($fila['moviemiento']);//saber_tiempo_fin
            break;
            /*case 2:
              $estado="Lavar";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin($fila['moviemiento']);
              //$sub_motivo=$mivi->saber_motivo($fila['moviemiento']);
              //$motivo=substr($sub_motivo, 0, 15);
            break;
            case 3:
              $estado="Limpiar";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin($fila['moviemiento']);
            break;
            case 4:
              $estado="Mantto.";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);
              $sub_motivo=$mivi->saber_motivo($fila['moviemiento']);
              $motivo=substr($sub_motivo, 0, 15);
            break;
            case 5:
              $estado="Cancelado";
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);
            break;
            case 6:
              $estado="Espera";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);
            break;
            case 7:
              $estado="Ocupada";
              $cronometro=$mivi->saber_fin_hospedaje($fila['moviemiento']);
            break;
            case 8:
              $estado="Sucia";
              $cronometro=$mivi->saber_inicio_sucia($fila['moviemiento']);
            break;
            case 9:
              $estado="Limpieza";
              $persona=$mivi->saber_per_limpia($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin_limpieza($fila['moviemiento']);
            break;
            case 10:
                # code...
            break;
            case 11:
              $cronometro=$mivi->saber_cobro_rest($fila['moviemiento']);
              $estado="Restaurante";
            break;
            case 12:
              $estado="Hospedada";
              $cronometro=$mivi->saber_fin_hospedaje($fila['moviemiento']);
            break;
            case 13:
              $cronometro=$mivi->saber_fin_hospedaje($fila['moviemiento']);
              $estado="Restaurante";
            break;
            case 14:
              $estado="Limpieza";
              $persona=$mivi->saber_per_limpia($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin_limpieza($fila['moviemiento']);
            break;
            case 15:
              $estado="Paseo";
              $cronometro=$mivi->saber_fin_hospedaje($fila['moviemiento']);
            break;
            case 16:
              $cronometro=$mivi->saber_fin_hospedaje($fila['moviemiento']);
              $estado="Restaurante";
            break;
            case 17:
              $estado="Superv.";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $motivo=$mivi->saber_motivo($fila['moviemiento']);
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);*/
          break;
        }

        if($fila['tipo']>0){
          echo '<div class="col-xs-4 col-sm-2 col-md-1 espacio ">';
            echo '<a href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')"><div class="estado'.$fila['estado'].'">';

              echo '<div class="row">
                <div class="col-sm-6">
                  <div class="titulo_hab">';
                    echo $estado;
                  echo '</div>
                </div>

                <div class="col-sm-6">
                  <div class="imagen_hab">';
                    if($fila['id']<100){
                        echo '<span class="badge tama_num_hab">'.$fila['nombre'].'</span>';
                    }else{
                        echo '<span class="badge tama_num_hab">'.$fila['comentario'].'</span>';
                    }
                  echo '</div>
                </div>
              </div>';

              echo '<div class="timepo_hab">';
                      $fecha_salida= $this->ver_fecha_salida($fila['id']);
                      echo $fecha_salida;
              echo '</div>';

              echo '<div class="timepo_hab">';
                      $total= $this->cuenta_total($fila['id']);
                      if($total_faltante >= 0){
                        echo '$'.number_format($total_faltante, 2);
                      }else{
                        $total_faltante= substr($total_faltante, 1);
                        echo '-$'.number_format($total_faltante, 2);
                      }
              echo '</div>';

              echo '<div class="icono_hab">';
                  //echo $motivo;
                  switch ($fila['interno']) {
                    case 'Sin estado':
                      echo '<img id="icono_r" src="images/cama.png"';  
                      break;
                    case 'Sucia':
                      echo '<img id="icono_c" src="images/basura.png">';
                      break;
                    case 'Limpieza':
                      echo '<img id="icono_c" src="images/lavando.png">';
                      break;
                    case 'Disponible':
                      echo '<img id="icono_c" src="images/home.png"';  
                      break;
                    case 4:
                      //echo '<img src="images/mantenimiento.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 5:
                      //echo '<img src="images/bloqueo.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 6:
                      //echo '<img src="images/cobrando.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 7:
                      //echo '<img src="images/cama.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 8:
                      //echo '<img src="images/basura.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 9:
                      //echo '<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 11:
                      //echo '<img src="images/restaurant.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 12:
                      //echo '<img src="images/cama.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 13:
                      //echo '<img src="images/restaurant.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    default:
                      //echo '<img src="images/home.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 14:
                      //echo '<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                }         
              echo '</div>';

              echo '</div>';
              echo '</div>';
            echo '</a>';
          echo '</div>';
        }else{
          echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';   
          echo '</div>';
        }
      }
    }

}
?>
