<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);

  $incial = $_GET['inicial'];
  $final = $_GET['final'];
  $opcion=1;
//para dibujar solamente "una vez" los buscadores.
if($_GET['btn']==0) {
    echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">REPORTE DE LLEGADAS</h2></div>

          <div class="row">
            <div class="col-sm-2">';
    echo '<input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_llegadas_salidas(event,'.$opcion.')" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date"  id="inicial_llegada"  placeholder="Reservacion inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Final:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date"  id="final_llegada"  placeholder="Reservacion final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-1">
              <button class="btn btn-success btn-block btn-default" onclick="ver_reportes_llegadas(1)">
                Buscar
              </button>
            </div>
          </div><br>
          <div id="paginacion_reservaciones">';
    $cat_paginas = $reservacion->mostrar_llegadas(1, $_GET['usuario_id'], $incial,$final);

    echo '
          </div>
         </div>';
    $id_paginacion=1;
    $NUM_REPORTE=11;
    echo '
  
  <ul class="pagination">';
    for($i = 1; $i <= $cat_paginas; $i++) {
        echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_reservaciones_paginacion('.$i.','.$id_paginacion.','.$NUM_REPORTE.')">'.$i.'</a></li>';
        $id_paginacion=$id_paginacion+20;
    }
    echo ' </ul>';
}else{
}
?>
