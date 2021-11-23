<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  session_start();

  class Informacion extends ConexionMYSql
  {

    function __construct()
    {

    }/*
    function evaluarEntrada($usuario_evaluar ,$password_evaluar){
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
    function conversorSegundosHoras($tiempo_en_segundos) {
      $horas = floor($tiempo_en_segundos / 3600);
      $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
      $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
      if($minutos<10){
        $minutos="0".$minutos;
      }
      return $horas . ':' . $minutos ;
    }
    function obtener_matricula($mov){
      $matricula="-";
      $sentencia = "SELECT matricula FROM movimiento WHERE id = $mov LIMIT 1 ";
      $comentario="Obtener la matricula de los movimientos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           $matricula=$fila['matricula'];
      }
      if(strlen($matricula)<1){
        $matricula="------";
      }
      return $matricula;
    }
    function ver_cobro($hab_id,$estado,$nombre,$persona,$mov){
        if($estado==7 || $estado==11){
          $id=0;
          $sentencia = "SELECT detalle_realiza FROM movimiento WHERE id = $mov ";
          //echo $sentencia;
          $comentario="Obtener la matricula de los movimientos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          while ($fila = mysqli_fetch_array($consulta))
          {
               $id=$fila['detalle_realiza'];
          }
            if($id>0){
              echo $this->obtener_nombre($id);
            }else{
              echo "-----";
            }
            
        }
        elseif($estado==0){
          echo $this->persona_limpio($hab_id);
        }
        else{
            echo "---";
        }

    }

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
            echo "-";
          break;
        case 6:
            echo $persona;
          break;
        case 7:
            echo $this->obtener_matricula($mov);
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
            echo $this->obtener_matricula($mov);
          break;
        case 16:
            echo $this->obtener_matricula($mov);
          break;
          case 17:
            echo $persona;
          break;
        default:
          echo "-";
          break;
      }

    }
    
    function persona_limpio($id){

      $persona=0;
      $sentencia = "SELECT * FROM movimiento WHERE habitacion = $id ORDER BY id DESC LIMIT 1;";
      //echo  $sentencia;
      $comentario="Obtener la persona que realizo la ultima limpieza";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           $persona=$fila['detalle_realiza'];
           if($fila['persona_limpio']>0){
             $persona=$fila['persona_limpio'];
           }
      }

      if($persona>0){
        $persona=$this->obtener_nombre($persona);
      }else{
        $persona="----";
      }
      return $persona;
    }
    function cuenta_total($mov){//va con movimiento

      //$mov=1;
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

      //$mov=1;
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
    function ver_cronometro($hab_id,$estado,$cronometro,$nivel){
     
      include_once('clase_configuracion.php');
      $config = NEW Configuracion();
      $actual =time();

      switch ($estado) {
        case 0:
            if($cronometro>0){
              $mostrar=-1*($cronometro-$actual);
              $mostrar=$this->conversorSegundosHoras($mostrar);
            }else{
              $mostrar="----";
            }
            echo $mostrar;
            //echo $this->persona_limpio($hab_id);
          break;
        case 1:
            $mostrar=$cronometro-$actual;
            if($mostrar<=0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
                $mostrar=$mostrar*-1;
                 echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 2:
            $mostrar=$cronometro-$actual;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
                $mostrar=$mostrar*-1;
                 echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 3:
            $mostrar=$cronometro-$actual;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
                $mostrar=$mostrar*-1;
                 echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 4:
            $mostrar=$actual-$cronometro;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';

              $mostrar=$mostrar*-1;
               echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 5:
            $mostrar=$actual-$cronometro;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              $mostrar=$mostrar*-1;
               echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 6:
            $mostrar=$actual-$cronometro;
            if($mostrar>300){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
               //$mostrar=$mostrar*-1;
                //echo '-';
                if($nivel==2){
                  if($config->autocobro>0){
                    if($mostrar>900){
                      
                      echo '<script type="text/javascript">
                        cobrar_auto('.$hab_id.');
                      </script>';
                    }
                  }
                }
                
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 7:
            $mostrar=$cronometro-$actual;
            if($mostrar<1800){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              if($mostrar<0){
                $mostrar=$mostrar*-1;
              echo '-';
              }
             
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 8:
            $mostrar=$actual-$cronometro;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
                $mostrar=$mostrar*-1;
                 echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 9:
          $mostrar=$cronometro-$actual;
          if($mostrar<0){
            echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                      </script>';
              $mostrar=$mostrar*-1;
               echo '-';
          }
          $mostrar=$this->conversorSegundosHoras($mostrar);
          echo $mostrar;
          break;
        case 11:
            $mostrar=$actual-$cronometro;
            if($mostrar>900){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 12:
            $mostrar=$cronometro-$actual;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              $mostrar=$mostrar*-1;
               echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 13:
            $mostrar=$cronometro-$actual;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              $mostrar=$mostrar*-1;
              echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        case 14:
          $mostrar=$cronometro-$actual;
          if($mostrar<0){
            echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                      </script>';
              $mostrar=$mostrar*-1;
               echo '-';
          }
          $mostrar=$this->conversorSegundosHoras($mostrar);
          echo $mostrar;
          break;
          case 15:
            $mostrar=$cronometro-$actual;
            if($mostrar<1800){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              if($mostrar<0){
                $mostrar=$mostrar*-1;
              echo '-';
              }
            
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
          case 16:
            $mostrar=$cronometro-$actual;
            if($mostrar<1800){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';
              if($mostrar<0){
                $mostrar=$mostrar*-1;
              echo '-';
              }
             
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
          case 17:
            $mostrar=$actual-$cronometro;
            if($mostrar<0){
              echo '<script type="text/javascript">var timeout=setTimeout("parpadear'.$hab_id.'()",10);
                                        </script>';

              $mostrar=$mostrar*-1;
               echo '-';
            }
            $mostrar=$this->conversorSegundosHoras($mostrar);
            echo $mostrar;
          break;
        default:
          echo "-";
          break;
      }

    }
    /*
    function audio($hab,$audio,$id,$estado){//*
      include_once('clase_automatizacion.php');
      $auto = NEW  Automatizacion($hab);
      if(isset ($_SESSION["estadocortina"][$hab])){
        if($_SESSION["estadocortina"][$hab]==1 & $estado==0){
          $auto->guardar_registro($hab,$id,"Cortina Abierta");
          echo '
          <audio autoplay>
          <source src="audio/'.$audio.'" type="audio/mp3">
          Tu navegador no soporta HTML5 audio.
      </audio>';
          //echo "abierta";
        }
        $_SESSION["estadocortina"][$hab]=$estado;
        //echo $_SESSION["estadocortina"][$hab];
      }
      else{
        if($_SESSION["estadocortina"][$hab]=0 & $estado==1){
          $auto->guardar_registro($hab,$id,"Cortina Cerrada");
        }
        $_SESSION["estadocortina"][$hab]=0;
        //echo "no";
      }
    }

    function saber_estado_cortina($hab,$comando,$credenciales,$audio,$id){//*
      include_once('clase_automatizacion.php');
      $auto = NEW  Automatizacion($id);
      $cadena='http://'.$credenciales.substr($comando, 7);

      //echo $comando.'</br>';
      //echo $cadena.'</br>';
      
      $estado =0;

      if(strlen($comando)>5){
        $xml=simplexml_load_file($cadena);
        if($xml){
          foreach ( $xml->children() as $child ) {
            //echo $child['value'];
           if($hab<=10){
              if($child['value']==0){
                $estado =1;
                //echo "cerrada";
              }
              else{
                $estado = 0;
                //echo "abierta";
              }
           }else{
            if($child['value']==0){
              $estado =0;
              //echo "cerrada";
            }
            else{
              $estado = 1;
              //echo "abierta";
            }
           }
  
          }
        }
        if(isset ($_SESSION["estadocortina"][$hab])){
          if($_SESSION["estadocortina"][$hab]==1 & $estado==0){
            $auto->guardar_registro($hab,$id,"Cortina Abierta");
            echo '
            <audio autoplay>
            <source src="audio/'.$audio.'" type="audio/mp3">
            Tu navegador no soporta HTML5 audio.
        </audio>';
            //echo "abierta";
          }
          $_SESSION["estadocortina"][$hab]=$estado;
          //echo $_SESSION["estadocortina"][$hab];
        }
        else{
          if($_SESSION["estadocortina"][$hab]=0 & $estado==1){
            $auto->guardar_registro($hab,$id,"Cortina Cerrada");
          }
          $_SESSION["estadocortina"][$hab]=0;
          //echo "no";
        }
      }

      
      return $estado;
      //$this->cambiar_estado_cortina($hab,$estado);
    }*/

    function mostrarhab($id,$token){
      $tipo= 1;//
      include('clase_movimiento.php');
      include('clase_usuario.php');
      include_once('clase_configuracion.php');
      $config = NEW Configuracion();
      $mivi =NEW movimiento(0);
      $usuario = NEW Usuario($id);
      $cronometro=0;
      $persona='-';
      //$persona= $id;
      //if($token<=0){
        $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario, tipo_hab.nombre AS tipo_monbre FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id ORDER BY id";
      /*}else{
        $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_monbre FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.tipo =$tipo ORDER BY id";
      }*/

      $comentario="mostrar hab  archvivo areatrabajo.php funcion mostrarhab";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {


        $estado="no definido";
        switch ($fila['estado']) {
            case 0:
              $estado="Disponible";
              $cronometro=$mivi->saber_tiempo_ultima_renta($fila['id']);
            break;
            case 1:
              $estado="Ocupado";//Detallado
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin($fila['moviemiento']);//saber_tiempo_fin
            break;
            case 2:
              $estado="Lavar";
              $persona=$mivi->saber_per_deta($fila['moviemiento']);
              $persona=$usuario->obtengo_usuario($id);
              $cronometro=$mivi->saber_tiempo_fin($fila['moviemiento']);
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
              $sub_motivo=$mivi->saber_motivo($fila['moviemiento']);
              $motivo=substr($sub_motivo, 0, 10);
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);
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
              $cronometro=$mivi->saber_tiempo_inicio($fila['moviemiento']);
          break;
        }
          if($fila['tipo']>0){
            echo '<div class="col-xs-4 col-sm-2 col-md-1 espacio clase'.$fila['id'].'">';
              echo '<a  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')"><div class="estado'.$fila['estado'].'">';

                
                if($config->automatizacion==1){
                  echo '<div class="titulo_estados" >';

                  if($fila['respuesta_energia']==0){
                    echo '<div class="estado_auto off_energia"> 
                            off
                          </div>';
                  }else{
                    echo '<div class="estado_auto on_energia">
                            on
                          </div>';
                  }
                  $estado_cortina=0;
                  if($config->cortinas==1){
                    if($fila['estado']==7  || $fila['estado']==11){
                      if(strlen($fila['estado_cortina'])>0){
                        $estado_cortina=$this->saber_estado_cortina($fila['id'],$fila['estado_cortina'],$config->credencial_auto,$fila['audio'],$id);
                        //echo "dentro";
                      }
                    }
                  }
                  $this->audio($fila['id'],$fila['audio'],$id,$estado_cortina);
                  if($estado_cortina==0){
                    echo '<div class="estado_auto on_cortina">
                            abierta
                          </div>';
                  }else{
                    echo '<div class="estado_auto off_cortina ">
                            Cerrada
                          </div>';
                  }

                echo '</div>';
                }

                echo '<div class="titulo_hab">';
                  echo $estado;
                echo '</div>';

                /*echo '<div class="numero_hab_1">';
               
                
                  switch ($fila['estado']) {
                    case 0:
                      
                        //echo '<img src="images/home.png"  class="espacio-imagen center-block img-responsive">';
                      
                          
                      break;
                    case 1:
                          //echo '<img src="images/cama.png"  class="espacio-imagen center-block img-responsive">';//images/detallando.png
                      break;
                    case 2:
                          //echo '<img src="images/lavando.png"  class="espacio-imagen center-block img-responsive">';
                      break;
                    case 3:
                            //echo '<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
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
                echo '</div>';*/
                
                echo '<div class="imagen_hab">';

                if($fila['id']<100){
                    echo '<span class="badge tama_num_hab">'.$fila['nombre'].'</span>';
                }else{
                    echo '<span class="badge tama_num_hab">'.$fila['comentario'].'</span>';
                }

                 
                echo '</div>';
      
                echo '<div class="timepo_hab">';
                        //$this->ver_cronometro($fila['id'],$fila['estado'],0,$usuario->nivel);// anterior de cantidad de segundos
                        $fecha_salida= $this->ver_fecha_salida($fila['id']);
                        echo $fecha_salida;

                echo '</div>';
                echo '<div class="timepo_hab">';//
                        $total= $this->cuenta_total($fila['id']);
                        echo '$'.number_format($total, 2);

                echo '</div>';
                echo '<div class="timepo_hab">';
                          //$this->ver_detalle($fila['id'],$fila['estado'],$fila['tipo_monbre'],$persona,$fila['moviemiento']);// nombre usuario
                      //  $fila['tipo_monbre'];
                echo '</div>';
                echo '<div class="timepo_hab">';
                  if($fila['estado']==4){
                    echo $motivo;
                  }else{
                    $this->ver_cobro($fila['id'],$fila['estado'],$fila['tipo_monbre'],$persona,$fila['moviemiento']);
                  }
                         
                      //  $fila['tipo_monbre'];
                echo '</div>';
                echo '  </div>';
              echo '</div></a>';
            echo '</div>';
          }else{
            echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
             
            echo '</div>';
          }


          /*
          Menu modal
          */
      }

    }
}
?>
