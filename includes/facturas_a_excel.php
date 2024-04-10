<?php

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
  header('Content-Disposition: attachment; filename=ReporteFacturacion.xls'); 

  include ('clase_factura.php');
  $facturacion = NEW factura();
  //$reporte= NEW Reporte();
  $consulta = $facturacion->busqueda_reporte($_GET['modo'],$_GET['inicio'],$_GET['fin'],$_GET['estado_factura']);
  $total =0;
  $producto_nombre="";
  $producto_sumatoria=0;
  $producto_total=0;
  $producto_precio=0;
    $cont=0; 
  echo '<table cellpadding="2" cellspacing="0" width="100%" border="1";>
    <caption>	REPORTE DE FACTURACION 	</caption>
    <tr style="text-align:center">
        <td>RFC</td>
        <td>NOMBRE</td>
        <td>TOTAL</td>
        <td>IMPORTE</td>
		<td>IVA</td>
        <td>ISH</td>
        <td>FOLIO</td>
        <td>ESTADO</td>
		<td>FECHA</td>
        <td>PAGO</td>
        
    </tr>';
    while ($fila = mysqli_fetch_array($consulta))
    {
        $sub_total=$fila['importe']+$fila['iva']+$fila['ish'];
		echo '<tr style="text-align:center">
        <td>'.$fila['rfc'].'</td>
        <td>'.$fila['nombre'].'</td>
        <td>'.$sub_total.'</td>
        <td>'.$fila['importe'].'</td>
		<td>'.$fila['iva'].'</td>
        <td>'.$fila['ish'].'</td>
        <td>'.$fila['folio'].'</td>';

		if($fila['estado']==0){
			echo '<td>Activa</td>';
			//$sheet->setCellValue('H'.$linea, 'Activa');
			$iva=$iva+$fila['iva'];
			$importe=$importe+$fila['importe'];
			$ish=$ish+$fila['ish'];
		}else{
			echo '<td>Cancelada</td>';
		}

		echo '<td>'.date("F j, Y, g:i a",($fila['fecha']+21600)).'</td>';
		switch ($fila['formapago']) {
			case 1:
					echo '<td>Efectivo</td>';
					//$sheet->setCellValue('J'.$linea, 'Efectivo');
				break;
			case 2:
					echo '<td>Cheque</td>';
					
				break;
			case 3:
					echo '<td>Trasferencia</td>';
					
				break;
			case 4:
					echo '<td>Tarjeta de credito</td>';
				
				break;
			case 5:
					echo '<td>Monedero electronico</td>';
				break;
			case 6:
					echo '<td>Dinero electronico</td>';
				break;
			case 8:
					echo '<td>Vales de despensa</td>';
				break;
			case 28:
					echo '<td>Debito</td>';
				break;
			case 29:
					echo '<td>Tarjeta de servicios</td>';
				break;
			case 99:
					echo '<td>Por definir</td>';
				break;
			default:
					echo '<td>Desconocido</td>';
				break;
		}
       echo ' 
    </tr>';
       

        //echo $fila['nombre'].'-'.$cantidad."</br>";
        $cont++;
        //echo '<div>';
    }
	$totales=$importe+$iva+$ish;
   
		echo ' <tr style="text-align:center">
		<td></td>
		<td></td>
		<td>'.$totales.'</td>
		<td>'.$importe.'</td>
		<td>'.$iva.'</td>
		<td>'.$ish.'</td>

		</tr>';
echo '</table>';