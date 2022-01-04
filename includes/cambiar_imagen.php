<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  $config = NEW Configuracion();
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">CAMBIAR IMAGEN</h2></div>';
          echo '
                <form enctype="multipart/form-data" action="includes/guardar_foto.php?id='.$_GET['usuario_id'].'&foto_id='.$_GET['usuario_id'].'" method="POST">  
                        <div class="row">
                                <div class="col-sm-2" >Foto:</div>
                                <div class="col-sm-4" >
                                <div class="form-group">
                                        <input name="uploadedfile" type="file">
                                </div>
                                </div>
                       
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                <div id="boton_tipo">
                                        <input type="submit" class="btn btn-success btn-block" value="Guardar">
                                </div>
                                </div>
                                
                        </div>
                </form><br>';
                //<div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_tarifa()"> ←</button></div>
                        
                echo '
                <div class="row">
                <div class="col-sm-12 text-left"><h4 class="text-dark margen-1">Presione imagen actual para verla en tamaño original</h4></div>
                <br><br>
                        <div class="col-sm-12 text-center">';
                        echo '&nbsp;&nbsp;';
                        echo '<a href="/visit/images/login/'.$config->imagen.'" target="_blank"><img src="/visit/images/login/'.$config->imagen.'" alt="Imagen de la cotizacion" height="120" width="120"/></a>';
                        echo '&nbsp;&nbsp;
                        </div>
                </div>
  </div>';
?>
