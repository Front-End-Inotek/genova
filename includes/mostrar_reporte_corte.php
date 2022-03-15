<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_corte.php");
  $corte= NEW Corte(0);
	
  $etiqueta= $corte->obtener_etiqueta($_GET['ticket_ini'],$_GET['ticket_fin']);
  $ancho= $_GET['ancho']-50;
  $alto= $_GET['alto']-50;
  if($etiqueta > 0){
    echo '<object width="'.$ancho.'" height="'.$alto.'" type="application/pdf" data="../reporte/corte/reporte_corte_'.$etiqueta.'.pdf">
		<param name="src" value="//192.168.1.145/gestion/viewer/doc.pdf" />
		<p>N o PDF available</p>
		</object>';
  }
?>
