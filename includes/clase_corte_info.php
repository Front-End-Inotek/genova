<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Corte_info extends ConexionMYSql{
	public $hab_tipo_hospedaje=array();
	public $hab_precio_hospedaje=array();
	public $hab_cantidad_hospedaje=array();
	public $hab_total_hospedaje=array();

	public $total_personas;
	public $cantidad_hab;
	public $total_hab;
	public $total_productos;
	public $total_restaurante;
	public $total_restaurante_entrada;
	public $total_productos_hab;
	public $total_productos_rest;
	public $total_global;

	public $total_pago=array();
	public $total_numero_descuento;
	public $total_dinero_descuento;

	public $producto_nombre=array();
	public $producto_venta=array();
	public $producto_precio=array();

	// Constructor
	function __construct($id_usuario)
	{
	  // Obtenemos el total del hospedaje
	  $contador= 0;
	  $cantidad_hab= 0;
	  $total_hab= 0;
	  $sentencia = "SELECT *,tipo_hab.id AS ID,tipo_hab.nombre AS titulo
	  FROM  tarifa_hospedaje 
	  INNER JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id WHERE tipo_hab.estado = 1 AND tarifa_hospedaje.estado = 1;";
	  $comentario="Obtener las tarifas de hospedaje";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $this->hab_tipo_hospedaje[$contador]= $fila['titulo'];
		  $this->hab_precio_hospedaje[$contador]= $fila['precio_hospedaje'];
		  $this->hab_cantidad_hospedaje[$contador]= $this->cantidad_hospedaje($id_usuario,$fila['ID']);
		  $this->hab_total_hospedaje[$contador]= $this->total_hospe($id_usuario,$fila['ID']);
		  $contador++;
	  }
	  $cantidad_hab= $this->cantidad_hab= $this->cantidad_habitaciones($id_usuario);
	  $total_hab= $this->total_hab= $this->total_habitaciones($id_usuario);
	  $total_restaurante_entrada= $this->total_restaurante_entrada= $this->total_restaurante_entrada($id_usuario);

	  // Obtenemos el total de personas extra
	  $this->total_personas=$this->cantidad_personas($id_usuario);// No correcto

	  // Obtenemos la informacion de ventas restaurante
	  $contador= 0;
	  $total_productos= 0;
	  $total_restaurante= 0;
	  $total_productos_hab= 0;
	  $total_productos_rest= 0;
      $sentencia = "SELECT * FROM inventario ORDER BY categoria,nombre";
	  $comentario="Obtener el inventario";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $venta= $this->producto_venta[$contador]= $this->venta_producto($id_usuario,$fila['nombre']);
		  if($venta > 0){
			  $this->producto_nombre[$contador]= $fila['nombre'];
			  $precio= $this->producto_precio[$contador]= $fila['precio'];
			  $rest= $this->producto_tipo_venta[$contador]= $this->venta_sin_hab($id_usuario,$fila['nombre']);
			  //$this->producto_cortesia[$contador]= $this->producto_de_cortresia($id_ini,$id_fin,$fila['nombre']);
			  //$this->producto_inventario[$contador]= $fila['inventario'];
			  $total_productos= $total_productos + $venta;
			  $total_restaurante= $total_restaurante + ($venta * $precio);
			  $total_productos_hab= $total_productos_hab + $rest;
	          $total_productos_rest= $total_productos_rest + ($venta - $rest);
			  $contador++;	  
		  }
	  }
	  $this->total_productos= $total_productos; 
	  $this->total_restaurante= $total_restaurante;
	  $this->total_productos_hab= $total_productos_hab; 
	  $this->total_productos_rest= $total_productos_rest; 

	  // Obtenemos el total global
	  $this->total_global= $total_hab + $total_restaurante_entrada;

	  include_once('clase_forma_pago.php');
	  $forma_pago = NEW Forma_pago(0);
	  $cantidad= $forma_pago->total_elementos();
	  $pago= array();
	  for($z=0 ; $z<$cantidad; $z++){
		$pago[$z]= 0;
	  }
	  $numero_descuento= 0;
	  $dinero_descuento= 0;
	  $sentencia = "SELECT * FROM ticket WHERE id_usuario = $id_usuario AND (pago > 0  OR monto > 0) AND estado = 0 OR estado != 2";//1 
	  //$sentencia = "SELECT * FROM concepto WHERE id_ticket >= $id_usuario AND id_ticket <= $id_fin AND activo = 1";
	  //echo $sentencia;
	  $comentario="Obtener el total de dinero ingresado";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  // Se va sumando el monto de las diferentes formas de pago
		  switch($fila['forma_pago']){
			  case 1:
				  $pago[0]= $pago[0] + ($fila['pago'] - $fila['cambio']);// pago
				  break;
			  case 2:
				  $pago[1]= $pago[1] + $fila['monto'];// total
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 3:
			  	  $pago[2]= $pago[2] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 4:
				  $pago[3]= $pago[3] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 5:
				  $pago[4]= $pago[4] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 6:
				  $pago[5]= $pago[5] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 7:
				  $pago[6]= $pago[6] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 8:
				  $pago[7]= $pago[7] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 9:
				  $pago[8]= $pago[8] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  case 10:
				  $pago[9]= $pago[9] + $fila['monto'];
				  if($fila['pago'] != $fila['monto']){
					$efectivo= $fila['pago'] - $fila['monto'];
					$pago[0]= $pago[0] + $efectivo;
				  }
				  break;
			  default:
				  // No sucede nada	
				  break;	
		  }				
					
		  if($fila['descuento'] > 0){
			  $numero_descuento++;
		  }
		  if($fila['total_descuento'] > 0){
			  $dinero_descuento= $dinero_descuento + $fila['total_descuento'];
		  }
		  $this->total_numero_descuento= $numero_descuento;
		  $this->total_dinero_descuento= $dinero_descuento;
	  }
      for($z=0 ; $z<$cantidad; $z++){
		  $this->total_pago[$z]= $pago[$z];
	  }

	}
	// Obtenemos la cantidad del hospedaje
	function cantidad_hospedaje($id_usuario,$tipo){
	  $total=0;
	  $sentencia = "SELECT *,SUM(cantidad) AS total 
	  FROM concepto 
	  INNER JOIN hab ON concepto.categoria = hab.id WHERE concepto.id_usuario = $id_usuario AND hab.tipo = $tipo AND concepto.activo = 1 AND concepto.tipo_cargo = 3";
	  $comentario="Obtener el total del hospedaje";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $total=$fila['total'];
	  }
	  if($total>0){

	  }else{
		  $total=0;
	  }
	  return $total;
	}
	// Obtenemos el total del hospedaje
	function total_hospe($id_usuario,$tipo){
	  $total=0;
	  $sentencia = "SELECT SUM(total) AS total 
	  FROM concepto 
	  INNER JOIN hab ON concepto.categoria = hab.id WHERE concepto.id_usuario = $id_usuario AND hab.tipo = $tipo AND concepto.activo = 1 AND concepto.tipo_cargo = 3";
	  $comentario="Obtener el total del  de hospedaje";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $total=$fila['total'];
	  }
	  if($total>0){

	  }else{
		  $total=0;
	  }
	  return $total;
	}
	// Obtenemos la cantidad del hospedaje
	function cantidad_personas($id_usuario){ // No correcto
	  $total=0;
	  $sentencia = "SELECT SUM(total) AS total FROM concepto WHERE id_usuario = $id_usuario AND tipo_cargo = 4 AND activo = 1";
	  $comentario="Obtener el total del  de hospedaje";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $total=$fila['total'];
	  }
	  if($total>0){

	  }else{
		  $total=0;
	  }
	  return $total;
	}
	// Obtener el total del producto vendido
	function venta_producto($id_usuario,$nombre){
      $total=0;
	  $sentencia = "SELECT SUM(cantidad) AS cantidad FROM concepto WHERE id_usuario = $id_usuario AND nombre = '$nombre' AND activo = 1";
	  $comentario="Obtener el total del  producto vendido";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $total=$fila['cantidad'];
	  }
	  if($total>0){

	  }else{
		  $total=0;
	  }
	  return $total;
    }
	// Obtener el total del  producto vendido
	function venta_sin_hab($id_usuario,$nombre){
      $total=0;
	  $sentencia = "SELECT SUM(cantidad) AS cantidad FROM concepto LEFT JOIN ticket ON ticket.id = concepto.id_ticket WHERE concepto.id_usuario = $id_usuario AND concepto.nombre = '$nombre' AND ticket.mov > 0 AND concepto.tipo_cargo = 1;";//mov > 0 ?
	  //echo $sentencia;
	  $comentario="Obtener el total del  producto vendido";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $total=$fila['cantidad'];
	  }
	  if($total>0){

	  }else{
		  $total=0;
	  }
	  return $total;
    }
	// Obtener la cantidad de habitaciones del hospedaje
	function cantidad_habitaciones($id_usuario){
	  $cantidad=0;
	  $sentencia = "SELECT count(total) AS total FROM concepto WHERE id_usuario = $id_usuario AND tipo_cargo = 1 AND activo = 1";
	  $comentario="Obtener la cantidad de habitaciones del hospedaje";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  while ($fila = mysqli_fetch_array($consulta))
	  {
		  $cantidad=$fila['total'];
	  }
	  if($cantidad>0){

	  }else{ 
		  $cantidad=0;
	  }
	  return $cantidad;
	}
	// Obtener el total del hospedaje
	function total_habitaciones($id_usuario){
		$total=0;
		$sentencia = "SELECT SUM(total) AS total FROM concepto WHERE id_usuario = $id_usuario AND tipo_cargo = 3 AND activo = 1";
		$comentario="Obtener el total del de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){
  
		}else{ 
			$total=0;
		}
		return $total;
	}
	// Obtener el total del restaurante entrado en el turno
	function total_restaurante_entrada($id_usuario){
		$total=0;
		$sentencia = "SELECT *,SUM(concepto.total) AS total 
		FROM concepto 
		INNER JOIN ticket ON concepto.id_ticket = ticket.id WHERE concepto.id_usuario = $id_usuario AND concepto.tipo_cargo != 3 AND concepto.activo = 1 AND ticket.pago > 0";
		$comentario="Obtener el total del restaurante entrado en el turno";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){
  
		}else{ 
			$total=0;
		}
		return $total;
	}


  }// Fin	
///////////
class Cortes_limpieza_manual extends ConexionMYSql{
	public $corte_inicial_id;
	public $corte_final_id;
	public $corte_inicial_fecha;
	public $corte_final_fecha;
	public $ticket_inicial_id;
	public $ticket_final_id;
	public $ticket_inicial_etiqueta;
	public $ticket_final_etiqueta;
	public $contador;

	public $ticket_id=array();
	public $id_concepto=array();
	public $ticket_etiqueta=array();
	public $ticket_hab=array();
	public $ticket_fecha=array();
	public $ticket_total=array();
	public $ticket_pago=array();
	public $ticket_tarjeta=array();
	 public $ticket_efectivo=array();
	public $ticket_cantidad=array();
	public $ticket_concepto=array();
	public $ticket_tipocargo=array();

	public $hab_horas_total=array();
	public $hab_horas_cantidad=array();
	public $hab_personas_total=array();
	public $hab_personas_cantidad=array();

	public $total_antes;
	public $total_hab=array();
	public $total_hab_descip=array();
	public $hospedaje_antes;
	public $consumo_antes;
	public $hospedaje_despues;
	public $consumo_despues;

	public $hab_tipo_hospedaje=array();
	public $hab_cantidad_hospedaje=array();
	public $hab_precio_hospedaje=array();
	public $hab_total_hospedaje=array();
	public $hospedaje_efectivo;
	public $hospedaje_tarjeta;
	public $consumo_efectivo;
	public $consumo_tarjeta;
	public $etiqueta_inicial;
	public $global_hospedaje;
	public $global_consumo;
	public $pocentaje_tickets_hospedaje;
	public $pocentaje_tickets_consumo;

	function __construct($corte_ini,$corte_fin,$hopedaje,$consumo)
	{
	   $this->global_hospedaje=$hopedaje;
	   $this->global_consumo=$consumo;
	   $this->corte_inicial_id=$corte_ini;
	   $this->corte_final_id=$corte_fin;
	   $this->ticket_inicial($corte_ini);
	   $this->ticket_final($corte_fin);
	   //$this->cambiar_estado_todos_0();
	   $this->cargar_info();
	   $this->porcentage_tickets($this->ticket_inicial_id,$this->ticket_final_id);
	   $this->ticket_inicial_etiqueta=$this->obtener_etiqueta($this->ticket_inicial_id);
	   $this->ticket_final_etiqueta=$this->obtener_etiqueta($this->ticket_final_id);
	   $this->corte_inicial_fecha=$this->obtener_fecha_corte($corte_ini);
	   $this->corte_final_fecha=$this->obtener_fecha_corte($corte_fin);
	}
	function totales(){
		$this->total_antes=0;
		$this->total_despues=0;
		$this->hospedaje_antes=0;
		$this->consumo_antes=0;
		$this->hospedaje_despues=0;
		$this->consumo_despues=0;
		//$this->total_hab=0;
		$this->sumar_total_antes();
		$this->sumar_hospedaje_antes();
		$this->suma_consumo_antes();
		$this->sumar_total_despues();
		$this->sumar_hospedaje_despues();
		$this->suma_consumo_despues();
		$this->desgloce();
		$this->hospedaje_efectivo=$this->total_hospe_efectivo($this->ticket_inicial_id,$this->ticket_final_id);
		$this->hospedaje_tarjeta=$this->total_hospe_tarjeta($this->ticket_inicial_id,$this->ticket_final_id);
		$this->consumo_efectivo=$this->total_consumo_efectivo($this->ticket_inicial_id,$this->ticket_final_id);
		$this->consumo_tarjeta=$this->total_consumo_tarjeta($this->ticket_inicial_id,$this->ticket_final_id);
		$this->etiqueta_inicial=$this->obtener_etiqueta_inicial($this->ticket_inicial_id,$this->ticket_final_id);
		$this->tarifa_limpieza($this->ticket_inicial_id,$this->ticket_final_id);
	}
	function porcentage_tickets($id_ini, $id_fin){
	   $cantidad_tickets_hospedaje=$this->contar_tickets($id_ini, $id_fin,1);
	   $cantidad_tickets_consumo=$this->contar_tickets($id_ini, $id_fin,2);
	   $cantidad_tickets_horas=$this->contar_tickets($id_ini, $id_fin,3);
	   $cantidad_tickets_personas=$this->contar_tickets($id_ini, $id_fin,4);
	   $this->pocentaje_tickets_hospedaje=round((($cantidad_tickets_hospedaje+$cantidad_tickets_horas+$cantidad_tickets_personas)/100)*$this->global_hospedaje,0);
	   $this->pocentaje_tickets_consumo=round(($cantidad_tickets_consumo/100)*$this->global_consumo,0);
	   //echo $pocentaje_tickets_hospedaje ."- ".$this->global_hospedaje; 

   }
   function saber_etiqueta_fin(){
	   $inicial_id= $this->ticket_inicial_id;
	   $final_id=$this->ticket_final_id;
	   $etiqueta = 0;
	   $sentencia = "SELECT etiqueta FROM ticket WHERE estado = 1 AND etiqueta > 0 AND id>$inicial_id AND id <=$final_id  ORDER BY id DESC LIMIT 1 ;";
	   //echo $sentencia.'</br>';
	   $comentario="Obtener las tarifas de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $etiqueta= $fila['etiqueta'];
	   }
	   return $etiqueta;
   }
   function contar_tickets($id_ini, $id_fin,$tipocargo){
	   $cantidad = 0;
	   $sentencia = "SELECT sum(total) AS cantidad  FROM concepto WHERE ticket >= $id_ini AND ticket <= $id_fin	AND tipocargo = $tipocargo;";
	   //echo $sentencia.'</br>';
	   $comentario="Obtener las tarifas de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $cantidad= $fila['cantidad'];
	   }
	   return $cantidad;
   }
   function saber_si_incluir($nombre){
	   $incluird = "";
	   $sentencia = "SELECT incluir FROM producto WHERE nombre = '$nombre' LIMIT 1 ;";
	   //echo $sentencia.'</br>';
	   $comentario="Obtener las tarifas de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $incluir= $fila['incluir'];
	   }
	   return $incluir;
   }
	function desgloce(){
		$contador=0;
		$sentencia = "SELECT * FROM  tarifa;";
		$comentario="Obtener las tarifas de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->hab_tipo_hospedaje[$contador]=$fila['nombre'];
			$this->hab_precio_hospedaje[$contador]=$fila['precio_lunes'];
			$this->hab_cantidad_hospedaje[$contador]=$this->cantidad_hospedaje($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);
			$this->hab_total_hospedaje[$contador]=$this->total_hospe($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);
			$this->hab_horas_cantidad[$contador]=$this->medios_turnos($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);
			$this->hab_horas_total[$contador]=$this->total_medios_turnos($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);
			$this->hab_personas_total[$contador]=$this->personas_extras_cantidad($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);
			$this->hab_personas_cantidad[$contador]=$this->personas_extras_total($this->ticket_inicial_id,$this->ticket_final_id,$fila['id']);

			$contador++;
			//echo $this->hab_tipo[$contador];
		}


		$sentencia = "SELECT * FROM  tarifa_hospedaje;";
		$comentario="Obtener las tarifas de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
		   $this->hab_tipo_hospedaje[$contador]=$fila['nombre'];
		   $this->hab_precio_hospedaje[$contador]=$fila['precio_hospedaje'];
		   $this->hab_cantidad_hospedaje[$contador]=$this->cantidad_hospedaje_tarifa($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
		   $this->hab_total_hospedaje[$contador]=$this->total_hospe_tarifa($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
		   $this->hab_horas_cantidad[$contador]=0;
		   $this->hab_horas_total[$contador]=0;
		   $this->hab_personas_total[$contador]=0;
		   $this->hab_personas_cantidad[$contador]=0;
		   $contador++;
		}

	}
	function corte_final($id){
		$sentencia = "SELECT fecha FROM corte WHERE 	etiqueta = $id LIMIT 1 ";
		$fecha=0;
		$comentario="obtener los conceptos de los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			if($fila['fecha']>0){
					$fecha=date("Y-m-d H:i:s",$fila['fecha']);
			}
			else{
				$fecha="---";
			}
		}
		return $fecha;
	}
	function cantidad_hospedaje($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(concepto.cantidad) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND concepto.activo = 1;";
		//echo $sentencia;
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function cantidad_hospedaje_tarifa($id_ini, $id_fin,$tarifa){

	   $total=0;
	   $sentencia = "SELECT SUM(concepto.cantidad) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 3 AND concepto.categoria = $tarifa AND concepto.activo = 1;";
	   //echo $sentencia;
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
	function saber_si_cambiar($id){
		$activo=array();
		$activo[0]=0;
		$activo[1]=0;
		$sentencia = "SELECT *  FROM concepto WHERE ticket = $id AND activo = 1 ;";
		//echo $sentencia .'</br>';
		$comentario="Obtener informacion de los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$activo[0]=$activo[0]+$fila['activo'];

			$activo[1]=$activo[1]+$fila['total'];


		}
		return $activo;
	}
	function obtener_tickets_a_cambiar($impresora){
		$total=0;
		$inicial=$this->etiqueta_inicial;
		$t_inicial=$this->ticket_inicial_id;
		 $t_final=$this->ticket_final_id;
		$sentencia = "SELECT * FROM ticket  WHERE id >= $t_inicial AND id <= $t_final ";
		//echo $sentencia;
		$comentario="Obtener los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{

			$activo= $this->saber_si_cambiar($fila['id']);
			if($activo[0]>0){
				if($fila['pago']>0){
					$pago=$activo[1];
					$tarjeta=0;
					$descuento=0;
				} elseif ($fila['tarjeta']>0){
					$pago=0;
					$tarjeta=$activo[1];
					$descuento=0;
				}else{
					$pago=0;
					$tarjeta=0;
					$descuento=$activo[1];
				}
				$this->aplicar_cambio_etiqueta_manual($fila['id'],$inicial,$impresora,$activo[1],$pago,$tarjeta,$descuento,1);
				$inicial++;
			}else{

				   $this->aplicar_cambio_etiqueta($fila['id'],0,1,2);
			}
		}
		$sentencia = "SELECT * FROM ticket  WHERE id >  $t_final ";
		//echo $sentencia;
		$comentario="Obtener los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
		   $this->aplicar_cambio_etiqueta($fila['id'],$inicial,1,$fila['estado']);
		   $inicial++;
		}
		$this->apicar_cambio_corte();
		$this->cambiar_etiqueta_general($inicial);
	}
	function total_medios_turnos($id_ini, $id_fin,$tarifa){
		$total=0;
		$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 5 AND activo =1 AND categoria = $tarifa;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function medios_turnos($id_ini, $id_fin,$tarifa){
		$total=0;
		$sentencia = "SELECT COUNT(cantidad) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 5 AND activo =1 AND categoria = $tarifa;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}

	function personas_extras_cantidad($id_ini, $id_fin,$tarifa){
		$total=0;
		$sentencia = "SELECT SUM(cantidad) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 4 AND activo =1 AND categoria = $tarifa;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function personas_extras_total($id_ini, $id_fin,$tarifa){
		$total=0;
		$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 4 AND activo =1 AND categoria = $tarifa;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function apicar_cambio_corte(){
		$sentencia = "UPDATE `corte` SET
	   `estado` = '1'
	   WHERE `id` >= '$this->corte_inicial_id' AND `id` <= '$this->corte_final_id' ;";
	   $comentario="Recojer el id del limpieza anterior";

	   $consulta= $this->realizaConsulta($sentencia,$comentario);

	}
	function guardar_limpieza_manual($corte_ini,$corte_fin,$realizo){
		$tiempo=time();
	  $sentencia = "INSERT INTO `limpieza` (`fecha`, `corte_ini`, `corte_fin`, `realizo`)
		VALUES ('$tiempo', '$corte_ini', '$corte_fin', '$realizo');";
	  $comentario="Guardar Limpieza";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  $id_limpieza=$this->id_mysql();
	  return $id_limpieza;
	}
	function id_mysql(){
		$id=0;
		$sentencia = "SELECT id FROM limpieza ORDER BY id DESC LIMIT 1";
		$comentario="Recojer el id del limpieza anterior";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
				   $id= $fila['id'];
		}
		return $id;
	}
	function cambiar_etiqueta_general($etiqueta){
		$sentencia = "UPDATE `labels` SET
		   `ticket` = '$etiqueta'
		   WHERE `id` = '1';";
		$comentario="Recojer el id del limpieza anterior";
		//echo $sentencia.'</br>';
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	}
	function total_hospe($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND concepto.activo = 1;";
		//echo $sentencia;
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function total_hospe_tarifa($id_ini, $id_fin,$tarifa){

	   $total=0;
	   $sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 3 AND concepto.categoria = $tarifa AND concepto.activo = 1;";
	   //echo $sentencia;
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
	function total_hospe_efectivo($id_ini, $id_fin){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo != 2  AND concepto.activo = 1 AND  ticket.facturado = 0;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function tarifa_limpieza($id_ini, $id_fin){
		$cont=0;
		$sentencia = "SELECT id,nombre FROM tarifa ORDER BY precio_lunes";
		$comentario="Obtener la sumatoria del hospedaje";
		//echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->total_hab[$cont]=$this->sumatoria_hospedaje($id_ini, $id_fin,$fila['id']);
			$this->total_hab_descip[$cont]=$fila['nombre'];
			$cont++;
		}
	}
	function sumatoria_hospedaje($id_ini, $id_fin,$id){

		$cantidad=0;
		$sentencia = "SELECT SUM(concepto.cantidad) AS cantidad FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1  AND concepto.activo = 1  AND concepto.categoria = $id;";
		$comentario="Obtener la sumatoria del hospedaje";
		//echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$cantidad=$fila['cantidad'];
		}
		if($cantidad>0){

		}else{
			$cantidad=0;
		}
		return $cantidad;
	}
	function total_hospe_tarjeta($id_ini, $id_fin){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo != 2  AND concepto.activo = 1 AND  ticket.facturado = 1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function obtener_etiqueta_inicial($id_ini, $id_fin){
		$etiqueta=0;
		$sentencia = "SELECT etiqueta FROM ticket WHERE id < $id_ini AND estado  = 1 ORDER BY id DESC LIMIT 1 ";
		//echo $sentencia .'</br>';
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$etiqueta=$fila['etiqueta'];
		}
		$etiqueta++;
		return $etiqueta;
	}
	function obtener_fecha_corte($id){
	   $fecha="";
	   $sentencia = "SELECT fecha  FROM corte WHERE id  = $id LIMIT 1 ";
	   $comentario="Obtener la fecha del corte ";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $fecha=$fila['fecha'];
	   }
	   $fecha=date("j/ n/ Y",$fecha);
	   return $fecha;
   }
	function total_consumo_efectivo($id_ini, $id_fin){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 2  AND concepto.activo = 1 AND  ticket.facturado=0;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function total_consumo_tarjeta($id_ini, $id_fin){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 2  AND concepto.activo = 1 AND  ticket.facturado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function obtener_etiqueta($id){
		$etiqueta=0;
		$sentencia = "SELECT etiqueta FROM ticket WHERE  id = $id limit 1 ";
		//echo  $sentencia.'</br>';
		$comentario="Recojer el id del limpieza anterior";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
				   $etiqueta= $fila['etiqueta'];
		}
		return $etiqueta;
	}
	function sumar_total_antes(){
	   $t_inicial=$this->ticket_inicial_id;
	   $t_final=$this->ticket_final_id;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final;";
	   $comentario="obtener el total del hospedaje antes de la limpieza";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->total_antes=$this->total_antes+$fila['total'];
	   }
	}
	function sumar_hospedaje_antes(){
	   $t_inicial=$this->ticket_inicial_id;
	   $t_final=$this->ticket_final_id;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final AND (nombre = 'HOSPEDAJE' OR nombre = 'PERSONAS EXTRAS' OR nombre = 'HORAS EXTRAS' );";
	   $comentario="obtener el total del hospedaje antes de la limpieza";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->hospedaje_antes=$this->hospedaje_antes+$fila['total'];
	   }
	}
	function suma_consumo_antes(){
		 $t_inicial=$this->ticket_inicial_id;
			$t_final=$this->ticket_final_id;
			 $sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final AND (nombre != 'HOSPEDAJE' AND nombre != 'PERSONAS EXTRAS' AND nombre != 'HORAS EXTRAS' );";
			$comentario="obtener el total del hospedaje antes de la limpieza";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$this->consumo_antes=$this->consumo_antes+$fila['total'];
			}
	}
	function sumar_total_despues(){
	   $t_inicial=$this->ticket_inicial_id;
	   $t_final=$this->ticket_final_id;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final AND concepto.activo = 1;";
	   //echo $sentencia
	   $comentario="obtener el total del hospedaje antes de la limpieza";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->total_despues=$this->total_despues+$fila['total'];
	   }
	}
	function sumar_hospedaje_despues(){
	   $t_inicial=$this->ticket_inicial_id;
	   $t_final=$this->ticket_final_id;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final AND concepto.activo = 1 AND (nombre = 'HOSPEDAJE' OR nombre = 'PERSONAS EXTRAS' OR nombre = 'HORAS EXTRAS' );";
	   $comentario="obtener el total del hospedaje antes de la limpieza";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->hospedaje_despues=$this->hospedaje_despues+$fila['total'];
	   }
	}
	function suma_consumo_despues(){
		 $t_inicial=$this->ticket_inicial_id;
			$t_final=$this->ticket_final_id;
			 $sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $t_inicial AND ticket.id <= $t_final AND concepto.activo = 1 AND concepto.tipocargo=2;";
		   //echo $sentencia;
		   $comentario="obtener el total del hospedaje antes de la limpieza";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$this->consumo_despues=$this->consumo_despues+$fila['total'];
			}
	}
	function ticket_inicial($id){
		$sentencia = "SELECT ticket_ini FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el primer ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_inicial_id=$fila['ticket_ini'];
		}
	}
	function ticket_final($id){
		$sentencia = "SELECT ticket_fin FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el ultimo ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_final_id=$fila['ticket_fin'];
		}
   }
   function cambiar_estado_todos_0(){
	   $sentencia = "UPDATE `concepto` SET
	   `activo` = '0'
	   WHERE `ticket` >= '".$this->ticket_inicial_id."' AND `ticket` <= '".$this->ticket_final_id."';";
		$comentario="cambiar el estado a 0 de los conceptos";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
   }
   function cambiar_estado($id,$estado){
	   $sentencia = "UPDATE `concepto` SET
	   `activo` = '$estado'
	   WHERE `id` = $id";
	   //echo $sentencia;
		$comentario="cambiar el estado a 0 de los conceptos";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
   }
   function conceptos($inicial,$final){
	   $total=0;
	   $sentencia = "SELECT ticket.id ,ticket.etiqueta ,ticket.habitacion ,ticket.tiempo ,ticket.facturado,concepto.nombre , concepto.id AS id_concepto,concepto.cantidad ,concepto.total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket  WHERE ticket.id >= ".$this->ticket_inicial_id." AND ticket.id <= ".$this->ticket_final_id." AND activo  = 1; ";
	   $comentario="cargar informacion interna de los tickets ";
	   //echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	   $contador=0;
		while ($fila = mysqli_fetch_array($consulta))
		{
		   if($contador==0){
			   echo '<table class="table">
				   <thead>
					   <tr>
						   <th>Ticket</th>
						   <th>Cuarto</th>
						   <th>Hora</th>
						   <th>Cantidad</th>
						   <th>Concepto</th>
						   <th>Total</th>
						   <th></th>
						   <th></th>
					   </tr>
				   </thead>';
		   }
		   if(($contador%2)==0){
				   echo '<tr class="success">';
		   }else{
				   echo '<tr class="active">';
		   }

				   $total=$total+$fila['total'];
				   //echo '<td><a href="#caja_herramientas" data-toggle="modal" onclick="editar_ticket('.$fila['id'].','.$inicial.','.$final.')" ><button type="button" class="btn btn-primary btn-block btn-sm" >'.$fila['etiqueta'].'</button></a></td>';
				   echo '<td>'.$fila['etiqueta'].'</td>';
				   echo '<td>'.$fila['habitacion'].'</td>';
				   echo '<td>'.date("H:i" ,$fila['tiempo']).'</td>';
				   echo '<td>'.$fila['cantidad'].'</td>';
				   echo '<td>'.$fila['nombre'].'
				   </td>';
				   echo '<td>$'.$fila['total'].'</td>';
				   if($fila['facturado']==0){
						 echo '<td><button type="button" class="btn btn-warning btn-xs" onclick="cargar_datos_limpieza('.$fila['id_concepto'].','.$inicial.','.$final.',0,'.$this->global_hospedaje.','.$this->global_consumo.')">Quitar</button></td>';
							   echo '<td><a href="#caja_herramientas" data-toggle="modal" onclick="editar_concepto('.$fila['id_concepto'].','.$inicial.','.$final.',0,'.$this->global_hospedaje.','.$this->global_consumo.')" ><button type="button" class="btn btn-warning btn-xs" >Modificar</button></a></td>';
				   }
				   else{
					   echo '<td></td>';
						   echo '<td><a href="#caja_herramientas" data-toggle="modal" onclick="editar_concepto('.$fila['id_concepto'].','.$inicial.','.$final.',0,'.$this->global_hospedaje.','.$this->global_consumo.')" ><button type="button" class="btn btn-warning btn-xs" >Modificar</button></a></td>';
				   }

			   echo'


			   </tr>';


		   $contador++;
	   }
	   echo '<tr>
		   <th></th>
		   <th>Total</th>

		   <th></th>
		   <th></th>
		   <th>$'.$total.'</th>
		   <th></th>
		   <th></th>
	   </tr>';
   }
   function conceptos_libre($inicial,$final){
	   $sentencia = "SELECT ticket.id ,ticket.etiqueta ,ticket.habitacion ,ticket.tiempo ,ticket.facturado,concepto.nombre , concepto.id AS id_concepto,concepto.cantidad ,concepto.total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket  WHERE ticket.id >= ".$this->ticket_inicial_id." AND ticket.id <= ".$this->ticket_final_id." AND activo  = 0; ";
	   $comentario="cargar informacion interna de los tickets ";
	   //echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	   $contador=0;
		while ($fila = mysqli_fetch_array($consulta))
		{
		   if($contador==0){
			   echo '<table class="table">
				   <thead>
					   <tr>
						   <th>Ticket</th>
						   <th>Cuarto</th>
						   <th>Hora</th>
						   <th>Cantidad</th>
						   <th>Concepto</th>
						   <th>Total</th>
						   <th></th>
					   </tr>
				   </thead>';
		   }
		   if(($contador%2)==0){
				   echo '<tr class="success">';
		   }else{
				   echo '<tr class="active">';
		   }


				   echo '<td>'.$fila['etiqueta'].'</td>';
				   echo '<td>'.$fila['habitacion'].'</td>';
				   echo '<td>'.date("H:i" ,$fila['tiempo']).'</td>';
				   echo '<td>'.$fila['cantidad'].'</td>';
				   echo '<td>'.$fila['nombre'].'</td>';
				   echo '<td>$'.$fila['total'].'</td>';
				   if($fila['facturado']==0){
						 echo '<td><button type="button" class="btn btn-warning btn-xs" onclick="cargar_datos_limpieza('.$fila['id_concepto'].','.$inicial.','.$final.',1,'.$this->global_hospedaje.','.$this->global_consumo.')">agregar</button></td>';
						 echo '<td><button type="button" class="btn btn-warning btn-xs" onclick="ticket_a_facturar('.$fila['id'].','.$inicial.','.$final.',1)">Facturados</button></td>';
				   }
				   else{
					   echo '<td></td>';
				   }
			   echo'</tr>';


		   $contador++;
	   }
   }
   function ticket_facturado($inicial,$final){
	   $sentencia = "SELECT ticket.id ,ticket.etiqueta ,ticket.habitacion ,ticket.tiempo ,ticket.facturado,concepto.nombre , concepto.id AS id_concepto,concepto.cantidad ,concepto.total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket  WHERE ticket.id >= ".$this->ticket_inicial_id." AND ticket.id <= ".$this->ticket_final_id." AND facturado  = 1; ";
	   $comentario="cargar informacion interna de los tickets ";
	   //echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	   $contador=0;
	   $suma_faturado=0;
		while ($fila = mysqli_fetch_array($consulta))
		{
		   if($contador==0){
			   echo '<table class="table">
				   <thead>
					   <tr>
						   <th>Ticket</th>
						   <th>Cuarto</th>
						   <th>Hora</th>
						   <th>Cantidad</th>
						   <th>Concepto</th>
						   <th>Total</th>
						   <th></th>
					   </tr>
				   </thead>';
		   }
		   if(($contador%2)==0){
				   echo '<tr class="success">';
		   }else{
				   echo '<tr class="active">';
		   }


				   echo '<td>'.$fila['etiqueta'].'</td>';
				   echo '<td>'.$fila['habitacion'].'</td>';
				   echo '<td>'.date("H:i" ,$fila['tiempo']).'</td>';
				   echo '<td>'.$fila['cantidad'].'</td>';
				   echo '<td>'.$fila['nombre'].'</td>';
				   echo '<td>$'.$fila['total'].'</td>';
				   if($fila['facturado']==1){
					   $suma_faturado = $suma_faturado+$fila['total'];
						 echo '<td><button type="button" class="btn btn-warning btn-xs" onclick="ticket_a_no_facturar('.$fila['id'].','.$inicial.','.$final.',1)">Facturados</button></td>';
				   }
				   else{
					   echo '<td></td>';
				   }
			   echo'</tr>';

			   
		   $contador++;
	   }
	   echo '<tr>
			   <th></th>
			   <th>Total</th>
   
			   <th></th>
			   <th></th>
			   <th>$'.$suma_faturado.'</th>
			   <th></th>
			   <th></th>
			 </tr>';
   }
   function cargar_info(){

	   $sentencia = "SELECT ticket.id ,ticket.etiqueta ,ticket.habitacion,ticket.pago ,ticket.tarjeta,ticket.tiempo ,ticket.facturado,concepto.nombre ,concepto.tipocargo, concepto.id AS id_concepto,concepto.cantidad ,concepto.total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket  WHERE ticket.id >= ".$this->ticket_inicial_id." AND ticket.id <= ".$this->ticket_final_id."; ";
	   //echo $sentencia;
	   $comentario="cargar informacion interna de los tickets ";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	   $this->contador=0;
		while ($fila = mysqli_fetch_array($consulta))
		{
		   $this->ticket_id[$this->contador]=$fila['id'];
		   $this->ticket_etiqueta[$this->contador]=$fila['etiqueta'];
			  $this->ticket_hab[$this->contador]=$fila['habitacion'];
			  $this->ticket_fecha[$this->contador]=$fila['tiempo'];
		   $this->ticket_total[$this->contador]=$fila['total'];
		   $this->ticket_tarjeta[$this->contador]=$fila['tarjeta'];
		   $this->ticket_pago[$this->contador]=$fila['pago'];
			  $this->ticket_cantidad[$this->contador]=$fila['cantidad'];
			 $this->ticket_facturado[$this->contador]=$fila['facturado'];
		   $this->ticket_concepto[$this->contador]=$fila['nombre'];
		   $this->ticket_tipocargo[$this->contador]=$fila['tipocargo'];
		   $this->id_concepto[$this->contador]=$fila['id_concepto'];
		   $this->contador++;
		}
   }
   function aplicar_cambio_etiqueta($id,$etiqueta,$impreso,$estado){
	   $sentencia = "UPDATE `ticket` SET
	`etiqueta` = '$etiqueta',
	`estado` = '$estado',
	`impreso` = '$impreso'
	WHERE `id` = '$id';";
	   $comentario="Aplicar Cambio de las etiquetas ";
	   //echo $sentencia.'</br>';
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
   }
   function aplicar_cambio_etiqueta_manual($id,$etiqueta,$impreso,$total,$pago,$tarjeta,$descuento,$estado){
	   $sentencia = "UPDATE `ticket` SET
	`etiqueta` = '$etiqueta',
	`total` = '$total',
	`pago` = '$pago',
	`cambio` = 0,
	`estado` = '$estado',
	`tarjeta` = '$tarjeta',
	`descuento` = '$descuento',
	`impreso` = '$impreso'
	WHERE `id` = '$id';";
	   $comentario="Aplicar Cambio de las etiquetas ";
	   //echo $sentencia.'</br>';
	   $consulta= $this->realizaConsulta($sentencia,$comentario);

   }



}
class Cortes_limpieza_info extends ConexionMYSql
{
	public $hab_tipo=array();
	public $hab_cantidad=array();
	public $hab_precio=array();
	public $hab_total=array();

	public $hab_tipo_hospedaje=array();
	public $hab_cantidad_hospedaje=array();
	public $hab_precio_hospedaje=array();
	public $hab_total_hospedaje=array();

	public $ticket_etiqueta=array();
	public $ticket_hab=array();
	public $ticket_fecha=array();
	public $ticket_recepcion=array();
	public $ticket_total=array();
	public $ticket_efectivo=array();
	public $ticket_tarjeta=array();
	public $ticket_baucher=array();
	public $ticket_tipo=array();
	public $ticket_matricula=array();


	public $tipo_restaurante=array();
	public $global_restaurante=array();
	public $total_restaurante=array();

	public $producto_nombre=array();
	public $producto_venta=array();
	public $producto_inventario=array();

	public $gasto_nombre=array();
	public $gasto_venta=array();
	public $ticket_inicial_id;
	public $ticket_inicial_etiqueta;
	public $ticket_final_id;
	public $total_personas;
	public $total_gastos;

	public $total_efectivo;
	public $total_tarjeta;
	public $total_cortesia;
	public $ticket_primero_etiqueta;
	public $ticket_fin_etiqueta;
	public $total_Restaurante;


	public $num_corte=0;
	function __construct($corte_ini,$corte_fin)
	{
		$this->ticket_inicial($corte_ini);
		$this->ticket_final($corte_fin);
		$this->total_Restaurante= $this->cantidad_Restaurante($this->ticket_inicial_id, $this->ticket_final_id);
		$this->total_personas=$this->cantidad_personas($this->ticket_inicial_id,$this->ticket_final_id);
		$this->ticket_inicial_etiqueta=$this->obtener_etiqueta($this->ticket_inicial_id);
		$this->cantidad_dinero($this->ticket_inicial_id, $this->ticket_final_id);
		$contador=0;
		$sentencia = "SELECT * FROM tarifa;";
		$comentario="Obtener las tarifas";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->hab_tipo[$contador]=$fila['nombre'];
			$this->hab_precio[$contador]=$fila['precio_lunes'];
			$this->hab_cantidad[$contador]=$this->cantida_renta($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			$this->hab_total[$contador]=$this->total_renta($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			$contador++;
			//echo $this->hab_tipo[$contador];
		}



		//function obtenemos los tickets
		$contador=0;
		$sentencia = "SELECT * FROM ticket WHERE id >= $this->ticket_inicial_id AND id <= $this->ticket_final_id AND estado  = 1 ;";
		//echo $sentencia;
		$comentario="Obtener las tarifas de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_etiqueta[$contador]=$fila['etiqueta'];
		   $this->ticket_hab[$contador]=$fila['habitacion'];
			$this->ticket_fecha[$contador]=$fila['fecha'];
			$this->ticket_recepcion[$contador]=$this->nombre_cajera($fila['recep']);
			$this->ticket_total[$contador]=$fila['total'];
			$this->ticket_efectivo[$contador]=$fila['pago'];
			$this->ticket_tarjeta[$contador]=$fila['tarjeta'];
			$this->ticket_baucher[$contador]=$fila['baucher'];
			switch ($fila['resta']) {
				case 1:
						 $this->ticket_tipo[$contador]="Consumo";
					break;
			   case 2:
						  $this->ticket_tipo[$contador]="Horas Extras";
					 break;
			   case 3:
						$this->ticket_tipo[$contador]="Personas Extras";
				   break;
			   default:
						$this->ticket_tipo[$contador]="Hospedaje";
				   break;

			}

			$this->ticket_matricula[$contador]= $this->obtenermatricula($fila['mov']);
			$contador++;
			//echo $this->hab_tipo[$contador];
		}


		//function obtenemos el total del hospedaje
		$contador=0;
		$sentencia = "SELECT * FROM  tarifa_hospedaje;";
		$comentario="Obtener las tarifas de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->hab_tipo_hospedaje[$contador]=$fila['nombre'];
			$this->hab_precio_hospedaje[$contador]=$fila['precio_hospedaje'];
			$this->hab_cantidad_hospedaje[$contador]=$this->cantida_hospedaje($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			$this->hab_total_hospedaje[$contador]=$this->total_hospe($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			$contador++;
			//echo $this->hab_tipo[$contador];
		}
	}
	function obtenermatricula($mov){
	   $matricula=0;
	   $sentencia = "SELECT matricula FROM movimiento WHERE id  = $mov LIMIT 1 ";
	   $comentario="Recojer el id del limpieza anterior";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
				$matricula= $fila['matricula'];
	   }
	   return $matricula;
	}
	function cantidad_dinero($id_ini, $id_fin){
	   $this->total_efectivo=0;
	   $this->total_tarjeta=0;
	   $this->total_cortesia=0;
	   $sentencia = "SELECT SUM(total) AS total , SUM(tarjeta) AS tarjeta , SUM(descuento) AS descuento FROM ticket WHERE id >= $id_ini AND id <= $id_fin AND estado = 1 ";
	   //echo $sentencia;
	   $comentario="Obtener el total de dinero ingresado";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->total_efectivo=$fila['total']-$fila['tarjeta']-$fila['descuento'];
		   $this->total_tarjeta=$fila['tarjeta'];
		   $this->total_cortesia=$fila['descuento'];
	   }

   }
	function guardar_limpieza($corte_ini,$corte_fin,$realizo){
	  $tiempo=time();
	  $sentencia = "INSERT INTO `limpieza` (`fecha`, `corte_ini`, `corte_fin`, `realizo`)
		VALUES ('$tiempo', '$corte_ini', '$corte_fin', '$realizo');";
	  $comentario="Guardar Limpieza";
	  $consulta= $this->realizaConsulta($sentencia,$comentario);
	  $id_limpieza=$this->id_mysql();
	  return $id_limpieza;
	}
	function cantida_hospedaje($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(concepto.cantidad) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 3 AND concepto.categoria = $tarifa AND ticket.estado = 1;";
		$comentario="Obtener el total del  de hospedaje";

		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}

	function total_hospe($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id  WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 3 AND concepto.categoria = $tarifa AND ticket.estado = 1;  ";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}

	function id_mysql(){
		$id=0;
		$sentencia = "SELECT id FROM limpieza ORDER BY id DESC LIMIT 1";
		$comentario="Recojer el id del limpieza anterior";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
				   $id= $fila['id'];
		}
		return $id;
	}
	function obtener_etiqueta(){
		$etiqueta=0;
		$sentencia = "SELECT etiqueta FROM ticket WHERE  id = $this->ticket_inicial_id limit 1 ";
		//echo  $sentencia.'</br>';
		$comentario="Recojer el id del limpieza anterior";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
				   $etiqueta= $fila['etiqueta'];
		}
		return $etiqueta;
	}
	function cambiar_etiqueta($etiqueta,$impreso,$corte_ini,$corte_fin){

		$sentencia = "SELECT * FROM ticket WHERE id >= $this->ticket_inicial_id ";
		$comentario="Recojer el id del limpieza anterior";
		//echo $sentencia;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
		{
			if($fila['id']<= $this->ticket_final_id){
				if($fila['estado']==1){
					$this->aplicar_cambio_etiqueta($fila['id'],$etiqueta,$impreso);
						$etiqueta++;
				}else{
					$this->aplicar_cambio_etiqueta($fila['id'],0,1);
				}
			}else{
				$this->aplicar_cambio_etiqueta($fila['id'],$etiqueta,1);
				   $etiqueta++;
			}
		}
		 $this->cambiar_etiqueta_general($etiqueta);
		 $this->apicar_cambio_corte($corte_ini,$corte_fin);
	}
	function nombre_cajera($id){
		$nombre="";
			if($id>0){
			   $sentencia = "SELECT * FROM usuario WHERE id = $id  LIMIT 1 ";
			   //echo $sentencia.'</br>';
			 $comentario="obtener nombre de la cajera";
			 $consulta= $this->realizaConsulta($sentencia,$comentario);
			 while ($fila = mysqli_fetch_array($consulta))
			 {
				 $nombre=$fila['usuario'];
			 }
		   }
		   return $nombre;
	}
	function aplicar_cambio_etiqueta($id,$etiqueta,$impreso){
		$sentencia = "UPDATE `ticket` SET
	   `etiqueta` = '$etiqueta',
	   `impreso` = '$impreso'
	   WHERE `id` = '$id';";
		$comentario="Aplicar Cambio de las etiquetas ";
		//echo $sentencia.'</br>';
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	}

	function apicar_cambio_corte($corte_ini,$corte_fin){
		$sentencia = "UPDATE `corte` SET
	   `estado` = '1'
	   WHERE `id` >= '$corte_ini' AND `id` <= '$corte_fin' ;";
	   $comentario="Recojer el id del limpieza anterior";

	   $consulta= $this->realizaConsulta($sentencia,$comentario);

	}
	function cambiar_etiqueta_general($etiqueta){
		$sentencia = "UPDATE `labels` SET
		   `ticket` = '$etiqueta'
		   WHERE `id` = '1';";
		$comentario="Recojer el id del limpieza anterior";
		//echo $sentencia.'</br>';
		$consulta= $this->realizaConsulta($sentencia,$comentario);
	}
	function ticket_inicial($id){
		$sentencia = "SELECT ticket_ini FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el primer ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_inicial_id=$fila['ticket_ini'];
		}
	}
	function ticket_final($id){
		$sentencia = "SELECT ticket_fin FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el ultimo ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_final_id=$fila['ticket_fin'];
		}
	}
   function cantida_renta($id_ini, $id_fin,$tarifa){

	   $total=0;
	   $sentencia = "SELECT SUM(cantidad) AS total FROM concepto LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND  ticket.estado=1;";
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
   function cantidad_horas($id_ini, $id_fin){
	   $total=0;
	   $sentencia = "SELECT SUM(concepto.total) AS total  FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 5 AND  ticket.estado=1;";
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }


   function cantidad_personas($id_ini, $id_fin){
	   $total=0;
	   $sentencia = "SELECT SUM(concepto.total) AS total  FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 4 AND  ticket.estado=1;";
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
   function cantidad_Restaurante($id_ini, $id_fin){
	   $total=0;
	   $sentencia = "SELECT SUM(concepto.total) AS total FROM ticket INNER JOIN concepto ON ticket.id = concepto.ticket WHERE ticket.id >= $id_ini AND ticket.id <= $id_fin AND concepto.activo = 1 AND concepto.tipocargo=2";
	   //echo $sentencia;
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
   function total_renta($id_ini, $id_fin,$tarifa){

	   $total=0;
	   $sentencia = "SELECT SUM(concepto.total) AS total FROM concepto LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND  ticket.estado=1;";
	   $comentario="Obtener el total del  de hospedaje";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $total=$fila['total'];
	   }
	   if($total>0){

	   }else{
		   $total=0;
	   }
	   return $total;
   }
}
class Cortes_limpieza extends ConexionMYSql
{
   public $corte_inicial_id;
   public $corte_inicial_etiqueta;
   public $corte_inicial_fecha;
   public $corte_final_id;
   public $corte_final_etiqueta;
   public $ticket_inicial_id;
   public $ticket_inicial_etiqueta;
   public $ticket_final_id;
   public $ticket_final_etiqueta;
   public $cantidad_tickets;
   public $tickets_id=array();
   public $tickets_fecha=array();
   public $tickets_etiqueta=array();
   public $tickets_total=array();
   public $tickets_tarjeta=array();
   public $tickets_habitacion=array();
   public $tickets_tipo=array();
   public $tickets_facturado=array();
   public $tickets_conservar=array();
   public $cantidad_hospedaje;
   public $cantidad_consumo;
   public $total_hospedaje;
   public $total_consumo;

   public $contador;

   function __construct()
   {
	   $this->obtenercorteinicial();
   }
   function obtenercorteinicial(){
	   $sentencia = "SELECT * FROM corte WHERE estado = 0 ORDER BY id DESC ";
	   $comentario="Seleccionar el corte inicial ";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->corte_inicial_id=$fila['id'];
		   $this->corte_inicial_etiqueta=$fila['etiqueta'];
		   if($fila['fecha']>0){
				   $this->corte_inicial_fecha=date("Y-m-d H:i:s",$fila['fecha']);
		   }else{
				   $this->corte_inicial_fecha="---";
		   }

	   }
   }
   function cargar_datos_faltantes($horas,$personas,$corte_final, $hospedaje,$consumo){
	   $this->contador=0;
	   $this->ticket_inicial($this->corte_inicial_id);
	   $this->ticket_final($corte_final);
	   $this->ticket_inicial_etiqueta=$this->ticket_etiqueta($this->ticket_inicial_id);
	   $this->ticket_final_etiqueta=$this->ticket_etiqueta($this->ticket_final_id);
	   $this->cantidad_tickes($this->ticket_inicial_id,$this->ticket_final_id);
	   $this->cambiar_estado_global($this->ticket_inicial_id,$this->ticket_final_id);
	   $this->cargar_info($this->ticket_inicial_id,$this->ticket_final_id,$horas,$personas);

   }
   function corte_final($id){
	   $sentencia = "SELECT fecha FROM corte WHERE 	etiqueta = $id LIMIT 1 ";
	   $fecha=0;
	   $comentario="obtener los conceptos de los tickets";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   if($fila['fecha']>0){
				   $fecha=date("Y-m-d H:i:s",$fila['fecha']);
		   }
		   else{
			   $fecha="---";
		   }
	   }
	   return $fecha;
   }
   function cambiar_estado_global($id_ini,$id_fin){
	   $sentencia = "UPDATE `ticket` SET
	   `estado` = '2'
	   WHERE `id` >= '$id_ini' AND `id` <= '$id_fin';";
	   $comentario="cambiar el estado de los tickets";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);

   }
   function cambiar_estado_individual($id_ini){
	   $sentencia = "UPDATE `ticket` SET
	   `estado` = '1'
	   WHERE `id` = '$id_ini';";
	   $comentario="cambiar el estado de los tickets";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);

   }
   function sabertipo($id){
	   $sentencia = "SELECT * FROM concepto WHERE id =$id ";

	   //echo $sentencia ."</br>";
	   $tipo=0;
	   $comentario="obtener los conceptos de los tickets";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   if($fila['nombre']=="PERSONAS EXTRA"){
			   $tipo=2;
		   }
		   else if($fila['nombre']=="HORAS EXTRA"){
			   $tipo=3;
		   }else{
			   $tipo=0;
		   }
	   }
	   return $tipo;
   }
   function cargar_info($id_ini,$id_fin,$horas,$personas){
	   $sentencia = "SELECT * FROM ticket WHERE id >= $id_ini AND id <= $id_fin ";
	   /*if($horas=='true'){
		   $sentencia=$sentencia." OR resta = 2";
	   }
	   if($personas=='true'){
		   $sentencia=$sentencia." OR resta = 3";
	   }
		   $sentencia=$sentencia." );";*/
	   //echo $sentencia;
	   $comentario="Obtener informacion de los tickets";
	   $this->total_consumo=0;
	   $this->total_hospedaje=0;
	   $saber=0;
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $saber=0;
		   if($fila['resta']<2){
			   $saber=1;
		   }else{
			   if($fila['resta']==2){
				   if($horas=='true'){
						   $saber=1;
				   }else{
					   if($fila['facturado']==1){
							   $saber=1;
					   }
				   }

			   }
			   if($fila['resta']==3){
					   if($personas=='true'){
							   $saber=1;
					   }
					   else{
						   if($fila['facturado']==1){
								   $saber=1;
						   }
					   }
			   }
		   }


		   if($saber==1){
			   $this->tickets_id[$this->contador]=$fila['id'];
			   $this->tickets_etiqueta[$this->contador]=$fila['etiqueta'];
			   $this->tickets_tipo[$this->contador]=$fila['resta'];
			   $this->tickets_total[$this->contador]=$fila['total'];
			   $this->tickets_fecha[$this->contador]=$fila['fecha'];
			   $this->tickets_facturado[$this->contador]=$fila['facturado'];
			   $this->tickets_tarjeta[$this->contador]=$fila['tarjeta'];
			   $this->tickets_habitacion[$this->contador]=$fila['habitacion'];
			   $this->tickets_conservar[$this->contador]=0;
			   $this->contador++;
			   if($fila['resta']==1){
				   $this->cantidad_consumo++;
				   $this->total_consumo= $this->total_consumo+$fila['total'] ;
			   }else{
				   $this->cantidad_hospedaje++;
				   $this->total_hospedaje= $this->total_hospedaje+$fila['total'] ;
				   //$this->total_hospedaje= $this->total_hospedaje+ $this->tickets_total[$this->contador];
			   }
		   }


		   }
   }
   function ticket_inicial($id){
	   $sentencia = "SELECT ticket_ini FROM  corte WHERE id = $id LIMIT 1 ";
	   $comentario="Seleccionar el primer ticket";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->ticket_inicial_id=$fila['ticket_ini'];
	   }
   }
   function ticket_final($id){
	   $sentencia = "SELECT ticket_fin FROM  corte WHERE id = $id LIMIT 1 ";
	   $comentario="Seleccionar el primer ticket";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->ticket_final_id=$fila['ticket_fin'];
	   }
   }
   function cantidad_tickes($id_ini,$id_fin){
	   $total = 0;
	   $sentencia = "SELECT COUNT(*) AS total FROM ticket WHERE id >= $id_ini AND id <= $id_fin  ";
	   $comentario="Seleccionar la cantidad de ticket";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $this->cantidad_tickets=$fila['total'];
	   }
   }
   function ticket_etiqueta($id){
	   $etiqueta=0;
	   $sentencia = "SELECT etiqueta FROM ticket  WHERE id = $id LIMIT 1 ";
	   $comentario="Obtener la etiqueta del ticket";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   while ($fila = mysqli_fetch_array($consulta))
	   {
		   $etiqueta=$fila['etiqueta'];
	   }
	   return $etiqueta;
   }
}

 class Corte_ver extends ConexionMYSql
 {
	 function __construct()
   {

   }
   function ver_cortes(){
	   $sentencia = "SELECT * FROM corte  ORDER BY id DESC LIMIT 100 ";
	   $comentario="Obtener los cortes hechos";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);

			echo '<div class="table-responsive">
			   <table class="table">
				 <thead>
				   <tr>
					 <th>Corte</th>
					 <th>Total</th>
								   <th>Fecha</th>
					 <th>Efectivo</th>
					 <th>Tarjeta</th>
					 <th>Descuento</th>
					 <th>Ver</th>
				   </tr>
				 </thead>
				 <tbody>';
			 while ($fila = mysqli_fetch_array($consulta))
			 {
			   echo '<tr>
			   <td>'.$fila['etiqueta'].'</td>
			   <td>'.$fila['total'].'</td>';
					   if($fila['fecha']>0){
						   echo '<td>'.date('Y-m-d H:i:s',$fila['fecha']).'</td>';
					   }else{
							   echo '<td>---</td>';
					   }
			   echo '<td>'.$fila['efectivo'].'</td>
			   <td>'.$fila['tarjeta'].'</td>
			   <td>'.$fila['descuento'].'</td>
			   <td><button onclick="mostrar_corte_hecho('.$fila['etiqueta'].')" class="btn btn-info">Ver pdf</button></td>
			 </tr>';
		   }

			   echo '</table>
				 </div>';

   }
	   function ver_cortes_busqueda($inicial,$final){
	   $sentencia = "SELECT * FROM corte WHERE  etiqueta >= $inicial  AND etiqueta <=$final ORDER BY id DESC ";
		   $comentario="Obtener los cortes hechos";
		   $consulta= $this->realizaConsulta($sentencia,$comentario);
		   $contador=0;
			echo '<div class="table-responsive">
			   <table class="table">
				 <thead>
				   <tr>
					 <th>Corte</th>
					 <th>Total</th>
					 <th>Efectivo</th>
					 <th>Tarjeta</th>
					 <th>Descuento</th>
					 <th>Ver</th>
				   </tr>
				 </thead>
				 <tbody>';
			 while ($fila = mysqli_fetch_array($consulta))
			 {
					   $contador++;
			   echo '<tr>
			   <td>'.$fila['etiqueta'].'</td>
			   <td>'.$fila['total'].'</td>
			   <td>'.$fila['efectivo'].'</td>
			   <td>'.$fila['tarjeta'].'</td>
			   <td>'.$fila['descuento'].'</td>
			   <td><button onclick="mostrar_corte_hecho('.$fila['etiqueta'].')" class="btn btn-info">Ver pdf</button></td>
			 </tr>';
		   }
			   if($contador>0){
				   echo '<tr>
				   <td> </td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td><button onclick="mostrar_corte_global('.$inicial.','.$final.')" class="btn btn-info">Ver global</button></td>
			   </tr>';
			   }
			   echo '</table>
				 </div>';

   }
	   function ver_reportes_hecho(){
	   $sentencia = "SELECT * FROM limpieza ORDER BY id DESC ";
	   $comentario="Obtener los cortes hechos";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);

			echo '<div class="table-responsive">
			   <table class="table">
				 <thead>
				   <tr>
					 <th>Reporte</th>
					 <th>Fecha</th>
					 <th>Primer corte</th>
					 <th>Ultimo Corte</th>

					 <th>Ver</th>
				   </tr>
				 </thead>
				 <tbody>';
			 while ($fila = mysqli_fetch_array($consulta))
			 {
			   echo '<tr>
			   <td>'.$fila['id'].'</td>
			   <td>'.date('Y-m-d',$fila['fecha']).'</td>
			   <td>'.$fila['corte_ini'].'</td>
			   <td>'.$fila['corte_fin'].'</td>
			   <td><button onclick="mostrar_reporte_hecho('.$fila['id'].')" class="btn btn-info">Ver pdf</button></td>
			 </tr>';
		   }

			   echo '</table>
				 </div>';

   }
 }
?>
