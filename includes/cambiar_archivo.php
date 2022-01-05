<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  $config= NEW Configuracion();
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">CAMBIAR COLOR</h2></div>';
          echo '
          <form enctype="multipart/form-data" action="includes/guardar_archivo.php?usuario_id='.$_GET['usuario_id'].'" method="POST"> 
                <div class="row"> 
                        <div class="col-sm-2"><label for="principal">Selecciona estado</label>:</div>
                        <div class="col-sm-2">
                                <div class="form-group">
                                        <select class="form-control" id="estado" name="estado" onchange="previsualizar_estado()">
                                        <option value="estado0">Disponible</option>
                                        <option value="estado1">Ocupada</option>
                                        <option value="estado2">Sucia</option>
                                        <option value="estado3">Limpieza</option>
                                        <option value="estado4">Mant.</option>
                                        <option value="estado5">Super.</option>
                                        <option value="estado6">Cancelada</option>
                                        </select>
                                </div>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"><label for="principal">Color Principal:</label></div>
                        <div class="col-sm-4">
                                <input type="color" value="#7b2416" id="principal" name="principal" onchange="previsualizar_estado()">
                        </div>
                </div>

                <div class="row"> 
                        <div class="col-sm-2"><label for="fondo">Color Fondo:</label></div>
                        <div class="col-sm-4">
                                <input type="color" value="#c03a2f" id="fondo" name="fondo" onchange="previsualizar_estado()">
                        </div>
                        <div class="col-sm-2"><label for="letra">Color Letra:</label></div>
                        <div class="col-sm-2">
                                <input type="color" value="#D98880" id="letra" name="letra" onchange="previsualizar_estado()">
                        </div>
                        <div class="col-sm-2">
                        <div id="boton_tipo">
                                <input type="submit" class="btn btn-success btn-block" value="Guardar">
                        </div>
                        </div>
                </div>
          </form><br><br>

          <div class="row div_previsualizar"></div>';
                // Div previsualizar donde se ve el cambio de los colores del estado del rack antes de ser guardado
                echo '
          </div>
  </div>';
  //#ff0000
?>
