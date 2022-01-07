<?php
  //error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
 
  class Informacion extends ConexionMYSql
  {
    // Constructor
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
    function ver_detalle($hab_id,$estado,$nombre,$persona,$mov){
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
    
    function mostrarhab($id,$token){
      include_once("clase_cuenta.php");
      include('clase_movimiento.php');
      $cuenta= NEW Cuenta(0);
      $movimiento= NEW movimiento(0);
      $tipo= 1;
      $cronometro=0;
      $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_monbre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id ORDER BY id";
      $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $total_faltante= 0.0;
        $estado="no definido";
        switch($fila['estado']) {
            case 0:
              $estado= "Disponible";
              $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
              break;
            case 1:
              $estado= "Ocupada";
              $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
              $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
              break;
            case 2:
              $estado= "Sucia";
              $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
              break;
            case 3:
              $estado= "Limpieza";
              $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
              break;
            case 4:
              $estado= "Mant.";
              $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
              /*$sub_motivo= $movimiento->saber_motivo($fila['moviemiento']);
              $motivo= substr($sub_motivo, 0, 15);*/
              break;
            case 5:
              $estado="Super.";
              $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
              break;
            case 6:
              $estado="Cancelada";
              $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
              break;
            /*case 7:
              $estado="Ocupada";
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              break;
            case 8:
              $estado="Lavar";
              $persona=$movimiento->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              break;
            case 9:
              $estado="Limpiar";
              $persona=$movimiento->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              break;
            case 10:
              # code...
              break;
            case 11:
              $cronometro=$movimiento->saber_cobro_rest($fila['moviemiento']);
              $estado="Restaurante";
              break;
            case 12:
              $estado="Hospedada";
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              break;
            case 13:
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              $estado="Restaurante";
              break;
            case 14:
              $estado="Limpieza";
              $persona=$movimiento->saber_per_limpia($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$movimiento->saber_tiempo_fin_limpieza($fila['moviemiento']);
              break;
            case 15:
              $estado="Paseo";
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              break;
            case 16:
              $cronometro=$movimiento->saber_fin_hospedaje($fila['moviemiento']);
              $estado="Restaurante";
              break;
            case 17:
              $estado="Superv.";
              $persona=$movimiento->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $motivo=$movimiento->saber_motivo($fila['moviemiento']);
              $cronometro=$movimiento->saber_tiempo_inicio($fila['moviemiento']);
              break;*/
            default:
              //echo "Estado indefinido";
              break;
        }

        if($fila['tipo']>0){
          echo '<div class="col-xs-4 col-sm-2 col-md-1 espacio">';
            //echo $motivo;
            switch ($fila['interno']){
              case '':
                echo '<div class="sub_estado_sin">';  
                break;
              case 'disponible':
                echo '<div class="sub_estado_sin">';  
                break;
              case 'sin estado':
                echo '<div class="sub_estado_sin">';  
                break;
              case 'sucia':
                echo '<div class="sub_estado_sucia">';
                break;
              case 'limpieza':
                echo '<div class="sub_estado_limpieza">';
                break;
              /*default:
                //echo "Estado interno indefinido";
                break;*/
            }     
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
                      $fecha_salida= $movimiento->ver_fecha_salida($fila['id']);
                      if($fila['estado'] == 1){
                        echo $fecha_salida;
                      }else{
                        if($cronometro == 0){
                          $fecha_inicio= '&nbsp';
                        }else{
                          $fecha_inicio= date("d-m-Y",$cronometro);
                        }
                        echo $fecha_inicio;
                      }
              echo '</div>';

              echo '<div class="timepo_hab">';
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
              echo '</div>';

              echo '<div class="icono_hab">';
                  //echo $motivo;
                  switch ($fila['interno']){
                    case '':
                      echo '<div id="icono_r"><br></div>';  
                      break;
                    case 'disponible':
                      echo '<div id="icono_r"><br></div>';  
                      break;
                    case 'sin estado':
                      echo '<div id="icono_r"><br></div>';  
                      break;
                    case 'sucia':
                      echo '<div id="icono_c"><br></div>';
                      break;
                    case 'limpieza':
                      echo '<div id="icono_c"><br></div>';
                      break;
                    /*default:
                      //echo "Estado interno indefinido";
                      break;*/
                }         
              echo '</div>';

              echo '</div>';
              echo '</div>';
            echo '</a>';
          echo '</div>';echo '</div>';
        }else{
          echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';   
          echo '</div>';
        }
      }
    }

}
?>
