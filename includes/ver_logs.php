<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">LOGS</h2></div>
          
          <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">Fecha Inicial:</div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                <div class="form-group">
                        <input class="form-control form-control-lg" type="date"  id="inicial"  placeholder="Log inicial" autofocus="autofocus"/>
                </div>
                </div>
                <div class="col-sm-1"></div>
          </div>
          
          <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">Fecha Final:</div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                <div class="form-group">
                        <input class="form-control form-control-lg" type="date" id="final" placeholder="Log final" autofocus="autofocus"/>
                </div>
                </div>
                <div class="col-sm-1"></div>
          </div>

          <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                <div id="boton_log">
                        <input type="submit" class="btn btn-success btn-lg btn-block" value="Guardar" onclick="busqueda_logs('.$_GET['usuario_id'].')">
                </div>
                </div>
                <div class="col-sm-1"></div>
          </div><br>
         </div>';
?>
