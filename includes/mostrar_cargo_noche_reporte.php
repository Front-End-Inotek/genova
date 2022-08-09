<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_cargo_noche.php');
  $cargo_noche = NEW Cargo_noche(0);
	
  sleep(1);
  $numero_actual= $cargo_noche->ultima_insercion();
  $ancho= $_GET['ancho']-50;
  $alto= $_GET['alto']-50;
  if($numero_actual > 0){
    echo '<object width="'.$ancho.'" height="'.$alto.'" type="application/pdf" data="../reportes/reservaciones/cargo_noche/reporte_cargo_noche_'.$numero_actual.'.pdf">
		<param name="src" value="//192.168.1.145/gestion/viewer/doc.pdf" />
		<p>No PDF available</p>
		</object>';
  }
?>
