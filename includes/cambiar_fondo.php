<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  $config = NEW Configuracion(1);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">CAMBIAR FONDO</h2></div>';
          echo '
                <form enctype="multipart/form-data" action="includes/guardar_fondo.php?usuario_id='.$_GET['usuario_id'].'" method="POST">  
                        <div class="row"> 
                                <div class="col-sm-2"><label for="nombre">Nombre del Sistema:</label></div>
                                <div class="col-sm-3">
                                <div class="form-group">
                                        <input class="form-control" type="text" id="nombre" name="nombre" value="'.$config->nombre.'" maxlength="40">
                                </div>        
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2"></div>
                        </div><br>

                        <div class="row margen-1"> 
                                <div class="col-sm-2"><label for="fondo">Color Fondo:</label></div>
                                <div class="col-sm-2">
                                        <input type="color" value="#14040B" id="fondo" name="fondo">
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2"><label for="encabezado">Color Encabezado:</label></div>
                                <div class="col-sm-2">
                                        <input type="color" value="#242C34" id="encabezado" name="encabezado">
                                </div>
                                
                                <div class="col-sm-2">
                                <div id="boton_tipo">
                                        <input type="submit" class="btn btn-success btn-block" value="Guardar">
                                </div>
                                </div>
                        </div
                </form>
  </div>';
?>
