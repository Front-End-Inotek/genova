<?php
  $nombre= 'estados';
  $estado= urldecode($_GET['estado']);
  $rack= '#'.urldecode($_GET['rack']);
  $hover= '#'.urldecode($_GET['hover']);
  $letra= '#'.urldecode($_GET['letra']);
  /*$estado= 'estado1';
  $rack= '#186A3B';// '#152679';
  $hover= '#28B463';// '#2f75c1';
  $letra= '#82E0AA';// '#8197d9';;*/
  if($estado != "estado1"){
    echo '
    <style>
      .estados{
        background-color:'.$rack.';
        color:'.$letra.';
        padding: 0em 10px 0px 10px;
        border-radius: 10px;
      }
      .estados:hover{
        background-color:'.$hover.';
        color:'.$letra.';
        padding: 0em 10px 0px 10px;
        border-radius: 10px;
      }
    </style>';
  }else{
    $sub_sucia= '#'.urldecode($_GET['sub_sucia']);
    $sub_limpieza= '#'.urldecode($_GET['sub_limpieza']);

    echo '
    <style>
      .sub_estado_sucia{
        background-color:'.$sub_sucia.';
        padding: 0em 0px 0px 0px;
        border-radius: 10px;
      }
      .sub_estado_limpieza{
        background-color:'.$sub_limpieza.';
        padding: 0em 0px 0px 0px;
        border-radius: 10px;
      }
      .estados{
        background-color:'.$rack.';
        color:'.$letra.';
        padding: 0em 10px 0px 10px;
        border-radius: 10px 10px 100px 10px;
      }
      .estados:hover{
        background-color:'.$hover.';
        color:'.$letra.';
        padding: 0em 10px 0px 10px;
        border-radius: 10px 10px 100px 10px;
      }
    </style>';
  }

  $subestados= 1;
  $estado_num= substr($estado,6, 1);
  $tiempo=time();
  $tipo= 1;
  switch($estado_num){
    case 0:
      $estado_nombre= "Disponible";
      $cronometro= date("d-m-Y",$tiempo);
      break;                
    case 1:
      $estado_nombre= "Ocupada";
      $cronometro= date("d-m-Y",$tiempo);
      $total_faltante= 1200;
      break;
    case 2:
      $estado_nombre= "Sucia";
      $cronometro= date("d-m-Y",$tiempo);
      break;
    case 3:
      $estado_nombre= "Limpieza";
      $cronometro= date("d-m-Y",$tiempo);
      break;
    case 4:
      $estado_nombre= "Mant.";
      $cronometro= date("d-m-Y",$tiempo);
      break;
    case 5:
      $estado_nombre="Super.";
      $cronometro= date("d-m-Y",$tiempo);
      break;
    case 6:
      $estado_nombre="Cancelada";
      $cronometro= date("d-m-Y",$tiempo);
      break;
    default:
      //echo "Estado indefinido";
      break; 
  }                    
  echo '
      <div class="container blanco"> 
        <div class="row div_previsualizar">';
        while($subestados <= 2){
          if($estado != "estado1"){
            $subestados= 3;
            echo '<div class="col-sm-5"></div>';
            echo '<div class="col-sm-2">';
          }else{
            $subestados++;
            echo '<div class="col-sm-1"></div>';
            echo '<div class="col-sm-2">';
            if($subestados == 1){
              echo '<div class="sub_estado_sucia">';
            }else{
              echo '<div class="sub_estado_limpieza">';
            }
          }
              //echo '<div class="col-sm-2">';
                  echo '<div class="estados">';
              
                    echo '<div class="row">
                      <div class="col-sm-6">
                        <div class="titulo_hab">';
                          echo $estado_nombre;
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
                          //echo "Estado interno indefinido";
                          break;
                      }         
                    echo '</div>';
                  echo '</div>';
                  if($estado != "estado1"){
                    echo '<div class="col-sm-5"></div>';
                  }else{
                    echo '</div>';
                    echo '<div class="col-sm-1"></div>';
                    echo '<div class="col-sm-2">';
        
              echo '<div class="sub_estado_limpieza">';
           
          }
              //echo '<div class="col-sm-2">';
                  echo '<div class="estados">';
              
                    echo '<div class="row">
                      <div class="col-sm-6">
                        <div class="titulo_hab">';
                          echo $estado_nombre;
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
                          //echo "Estado interno indefinido";
                          break;
                      }         
                    echo '</div>';
                  echo '</div>';
                  }
                  

            //echo '<div class="col-sm-5"></div>';
                    }
        echo '</div>
      </div>';
?>
