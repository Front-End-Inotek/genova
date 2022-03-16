<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_corte.php");
  $corte= NEW Corte(0);
	
  $etiqueta= $corte->ultima_etiqueta();
  $ancho= $_GET['ancho']-50;
  $alto= $_GET['alto']-50;
  if($etiqueta > 0){
    sleep(2);
    echo '<object width="'.$ancho.'" height="'.$alto.'" type="application/pdf" data="../reportes/corte/reporte_corte_'.$etiqueta.'.pdf">
		<param name="src" value="//192.168.1.145/gestion/viewer/doc.pdf" />
		<p>No PDF available</p>
		</object>';
  }
?>
