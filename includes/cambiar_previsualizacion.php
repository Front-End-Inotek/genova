<?php
  $nombre= 'estados';
  $contador= urldecode($_GET['contador']);
  
  if($contador == 0){
  $eestado= urldecode($_GET['estado']);
  $principal= '#'.urldecode($_GET['principal']);
  $fondo= '#'.urldecode($_GET['fondo']);
  $letra= '#'.urldecode($_GET['letra']);
  /*$eestado= 'estado1';
  $principal= '#186A3B';
  $fondo= '#28B463';
  $letra= '#82E0AA';*/
  /*
  // Se comprueba si existe el archivo previamente antes de generarlo
  if(!file_exists('../styles/'.$nombre.'.css')){
    //echo "Existio un problema borrando el archivo";
  }else{
    //echo "Archivo borrado con exito";
    unlink('../styles/'.$nombre.'.css');
  }
  // Se genera el archivo de css
  $archivo=fopen('../styles/'.$nombre.'.css','a') or die ('Error al crear');

  fwrite($archivo,'.'.$nombre.'{');
  fwrite($archivo,"\n");
  fwrite($archivo,'background-color:'.$principal.';');
  fwrite($archivo,"\n");
  fwrite($archivo,'color:'.$letra.';');
  fwrite($archivo,"\n");
  fwrite($archivo,'padding: 0em 10px 0px 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'border-radius: 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');
  fwrite($archivo,"\n");

  fwrite($archivo,'.'.$nombre.':hover{');
  fwrite($archivo,"\n");
  fwrite($archivo,'background-color:'.$fondo.';');
  fwrite($archivo,"\n");
  fwrite($archivo,'color:'.$letra.';');
  fwrite($archivo,"\n");
  fwrite($archivo,'padding: 0em 10px 0px 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'border-radius: 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');
  //header("location:../includes/cambiar_previsualizacion.php");
  //header("location:../inicio.php");

    $contador= 1;
    echo "<script>";
      echo "previsualizar_estado('.$contador.');";//'3','2','1'
    echo "</script>";*/
  }else{
    // No se repite mas de una vez
  }

  echo '
  <style>
    .estados{
      background-color:'.$principal.';
      color:'.$letra.';
      padding: 0em 10px 0px 10px;
      border-radius: 10px;
    }
    .estados:hover{
      background-color:'.$fondo.';
      color:'.$letra.';
      padding: 0em 10px 0px 10px;
      border-radius: 10px;
    }
  </style>';
  
  echo '
      <div class="container blanco"> 
        <div class="row div_previsualizar">';
          echo '<div class="col-sm-5"></div>

          <div class="col-sm-2">';
            $estado_num= substr($_GET['estado'],6, 1);
            $tiempo=time();
            $tipo= 1;
            switch($estado_num){
              case 0:
                $estado= "Disponible";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              case 1:
                $estado= "Ocupada";
                $cronometro= date("d-m-Y",$tiempo);
                $total_faltante= 1200;
                break;
              case 2:
                $estado= "Sucia";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              case 3:
                $estado= "Limpieza";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              case 4:
                $estado= "Mant.";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              case 5:
                $estado="Super.";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              case 6:
                $estado="Cancelada";
                $cronometro= date("d-m-Y",$tiempo);
                break;
              default:
                //echo "Estado indefinido";
                break; 
            }  
              
            echo '<div class="estados">';
      
              echo '<div class="row">
                <div class="col-sm-6">
                  <div class="titulo_hab">';
                    echo $estado;
                  echo '</div>
                </div>
      
                <div class="col-sm-6">
                  <div class="imagen_hab">';
                    if(2<100){
                      echo '<span class="badge tama_num_hab">'.$tipo.'</span>';
                    }else{
                      echo '<span class="badge tama_num_hab">'.$tipo.'</span>';
                    }
                echo '</div>
                </div>
              </div>';
      
              echo '<div class="timepo_hab">';
                $fecha_salida= $cronometro;
                if($estado_num == 1){
                  echo $fecha_salida;
                }else{
                  if($cronometro == 0){
                    $fecha_inicio= '&nbsp';
                  }else{
                    $fecha_inicio= $cronometro;
                  }
                  echo $fecha_inicio;
                }
              echo '</div>';
      
              echo '<div class="timepo_hab">';
                if($estado_num == 1){
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
                $interno= 'sin estado';
                switch($interno){
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
                  default:
                    //echo "Estado indefinido";
                    break;
                }         
              echo '</div>';
            echo '</div>';
          echo '</div>

          <div class="col-sm-5"></div>
        </div>
      </div>';
?>
