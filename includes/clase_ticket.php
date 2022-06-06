<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Ticket extends ConexionMYSql{

      public $id;
      public $etiqueta;
      public $mov;
      public $id_hab;
      public $id_mesa;
      public $corte;
      public $fecha;
      public $tiempo;
      public $id_usuario;
      public $forma_pago;
      public $total;
      public $pago;
      public $cambio;
      public $monto;
      public $descuento;
      public $total_descuento;
      public $facturado;
      public $baucher;
      public $comentario;
      public $impreso;
      public $resta;
      public $comanda;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->etiqueta= 0;
          $this->mov= 0;
          $this->id_hab= 0;
          $this->id_mesa= 0;
          $this->corte= 0;
          $this->fecha= 0;
          $this->tiempo= 0;
          $this->id_usuario= 0;
          $this->forma_pago= 0;
          $this->total= 0;
          $this->pago= 0;
          $this->cambio= 0;
          $this->monto= 0;
          $this->descuento= 0;
          $this->total_descuento= 0;
          $this->facturado= 0;
          $this->baucher= 0;
          $this->comentario= 0;
          $this->impreso= 0;
          $this->resta= 0;
          $this->comanda= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM ticket WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de ticket";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->etiqueta= $fila['etiqueta'];
              $this->mov= $fila['mov'];
              $this->id_hab= $fila['id_hab'];
              $this->id_mesa= $fila['id_mesa'];
              $this->corte= $fila['corte'];
              $this->fecha= $fila['fecha'];
              $this->tiempo= $fila['tiempo'];
              $this->id_usuario= $fila['id_usuario'];
              $this->forma_pago= $fila['forma_pago'];
              $this->total= $fila['total'];
              $this->pago= $fila['pago'];
              $this->cambio= $fila['cambio'];
              $this->monto= $fila['monto'];
              $this->descuento= $fila['descuento'];
              $this->total_descuento= $fila['total_descuento'];
              $this->facturado= $fila['facturado'];
              $this->baucher= $fila['baucher'];
              $this->comentario= $fila['comentario'];
              $this->impreso= $fila['impreso'];
              $this->resta= $fila['resta'];
              $this->comanda= $fila['comanda'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el ticket
      function guardar_ticket($mov,$hab_id,$id_usuario,$forma_pago,$total,$pago,$cambio,$monto,$descuento,$total_descuento,$facturar,$folio,$comentario,$nueva_etiqueta,$resta,$comanda,$mesa){
        $fecha=date("Y-m-d H:i");
        $tiempo=time();
        if($mesa == 0){
          $sentencia = "INSERT INTO `ticket` (`etiqueta`, `mov`, `id_hab`, `id_mesa`, `corte`, `fecha`, `tiempo`, `id_usuario`, `forma_pago`, `total`, `pago`, `cambio`, `monto`, `descuento`, `total_descuento`, `facturado`, `baucher`, `comentario`, `impreso`, `resta`, `comanda`, `estado`)
          VALUES ('$nueva_etiqueta', '$mov', '$hab_id', '0', '0', '$fecha', '$tiempo', '$id_usuario', '$forma_pago', '$total', '$pago', '$cambio', '$monto', '$descuento', '$total_descuento', '$facturar', '$folio', '$comentario', '$resta', '1', '$comanda', '0');";
          $comentario="Guardamos el ticket en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }else{
          $sentencia = "INSERT INTO `ticket` (`etiqueta`, `mov`, `id_hab`, `id_mesa`, `corte`, `fecha`, `tiempo`, `id_usuario`, `forma_pago`, `total`, `pago`, `cambio`, `monto`, `descuento`, `total_descuento`, `facturado`, `baucher`, `comentario`, `impreso`, `resta`, `comanda`, `estado`)
          VALUES ('$nueva_etiqueta', '$mov', '0', '$hab_id', '0', '$fecha', '$tiempo', '$id_usuario', '$forma_pago', '$total', '$pago', '$cambio', '$monto', '$descuento', '$total_descuento', '$facturar', '$folio', '$comentario', '$resta', '1', '$comanda', '0');";
          $comentario="Guardamos el ticket en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }
        
        $id= $this->ultima_insercion();
        return $id;
      }
      // Recoger el id del ticket anterior
      function ultima_insercion(){
        $id=0;
        $sentencia = "SELECT id FROM ticket ORDER BY id DESC LIMIT 1";
        $comentario="Recoger el id del ticket anterior";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $id= $fila['id'];
        }
        return $id;
      }
      // Cambiar estado de impreso del ticket
      function cambiar_estado($id_ticket){
        $sentencia = "UPDATE `ticket` SET
        `impreso` = '0'
        WHERE `id` = '$id_ticket';";
        $comentario="Cambiar estado de impreso del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Cambiar a un estado en especifico del ticket
      function cambiar_estado_especifico($id_ticket,$estado){
        $sentencia = "UPDATE `ticket` SET
        `estado` = '$estado'
        WHERE `id` = '$id_ticket';";
        $comentario="Cambiar a un estado en especifico del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Editar el estado del ticket
      function editar_estado($id_usuario,$corte,$estado){
        $sentencia = "UPDATE `ticket` SET
        `corte` = '$corte',
        `estado` = '$estado'
        WHERE `id_usuario` = '$id_usuario' AND `estado` = '0';";
        $comentario="Editar el estado del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Seleccionar ticket inicial para hacer corte
      function ticket_ini(){
        $id= 0;
        $sentencia = "SELECT id FROM ticket WHERE estado = 0 ORDER BY id LIMIT 1";
        $comentario="Seleccionar ticket inicial para hacer corte";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $id= $fila['id'];
        }
        return $id;
      }
      // Seleccionar ticket final para hacer corte
      function ticket_fin(){
        $id= 0;
        $sentencia = "SELECT id FROM ticket WHERE estado = 0 ORDER BY id DESC LIMIT 1 ";
        $comentario="Seleccionar ticket final para hacer corte";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $id= $fila['id'];
        }
        return $id;
      }
      // Obtener la etiqueta del ticket
      function obtener_etiqueta($id){
        $etiqueta= 0;
        $sentencia = "SELECT etiqueta FROM ticket WHERE id = $id LIMIT 1";
        $comentario="Obtener la etiqueta del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $etiqueta=$fila['etiqueta'];
        }
        return $etiqueta;
      }
      // Mostrar el id de un ticket
      function saber_id_ticket($mov){
        $sentencia = "SELECT * FROM ticket WHERE mov = $mov LIMIT 1";
        $comentario="Mostrar el id de un ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia."</br>";
        $id_ticket= 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_ticket= $fila['id'];
        }
        return $id_ticket;
      }
      // Buscar el id de un ticket
      function buscar_id_ticket($mov,$id_mesa){
        $sentencia = "SELECT * FROM ticket WHERE mov = $mov AND id_mesa = $id_mesa LIMIT 1";
        $comentario="Buscar el id de un ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id_ticket= 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_ticket= $fila['id'];
        }
        return $id_ticket;
      }
      // Cambiar datos del ticket para imprimir el ticket una mesa
      function cambiar_imprimir_ticket($id_ticket,$total){
        $fecha= date("Y-m-d H:i");
        $tiempo= time();
        $sentencia = "UPDATE `ticket` SET
        `fecha` = '$fecha',
        `tiempo` = '$tiempo',
        `total` = '$total'
        WHERE `id` = '$id_ticket';";
        $comentario="Cambiar datos del ticket para imprimir el ticket una mesa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Actualizar datos del ticket para imprimir el ticket una mesa a su termino
      function actualizar_ticket($id_ticket,$id_usuario,$forma_pago,$total,$pago,$cambio,$monto,$descuento,$total_descuento,$facturar,$folio,$comentario){
        $fecha= date("Y-m-d H:i");
        $tiempo= time();
        $sentencia = "UPDATE `ticket` SET
        `fecha` = '$fecha',
        `tiempo` = '$tiempo',
        `id_usuario` = '$id_usuario',
        `forma_pago` = '$forma_pago',
        `total` = '$total',
        `pago` = '$pago',
        `cambio` = '$cambio',
        `monto` = '$monto',
        `descuento` = '$descuento',
        `total_descuento` = '$total_descuento',
        `facturado` = '$facturar',
        `baucher` = '$folio',
        `comentario` = '$comentario'
        WHERE `id` = '$id_ticket';";
        $comentario="Actualizar datos del ticket para imprimir el ticket una mesa a su termino";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
             
  }
  /**
  *
  */
  class Labels extends ConexionMYSql
  {    
      public $id;
      public $ticket;
      public $comanda;
      public $corte;

      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->ticket= 0;
          $this->comanda= 0;
          $this->corte= 0;
        }else{
          $sentencia = "SELECT * FROM labels WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de labels";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $this->id= $fila['id'];
            $this->ticket= $fila['ticket'];
            $this->comanda= $fila['comanda'];
            $this->corte= $fila['corte'];               
          }
        }
      }
      // Obtener la etiqueta del ticket
      function obtener_etiqueta(){
        $sentencia = "SELECT ticket FROM labels LIMIT 1";
        $etiqueta= "";
        $comentario="Obtener la etiqueta del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $etiqueta=$fila["ticket"];
        }
        return $etiqueta;
      }
      // Actualizar la etiqueta del ticket
      function actualizar_etiqueta(){
        $nueva_etiqueta= $this->obtener_etiqueta() + 1;
        $sentencia = "UPDATE `labels` SET
        `ticket` = '$nueva_etiqueta'
        WHERE `id` = '1';";
        $comentario="Actualizar la etiqueta del ticket";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener la etiqueta del corte 
      function obtener_corte(){
        $sentencia = "SELECT corte FROM labels LIMIT 1";
        $etiqueta= "";
        $comentario="Obtener la etiqueta del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $etiqueta=$fila["corte"];
        }
        return $etiqueta;
      }
      // Actualizar la etiqueta del corte
      function actualizar_etiqueta_corte(){
        $nueva_etiqueta= $this->obtener_corte() + 1;
        $sentencia = "UPDATE `labels` SET
        `corte` = '$nueva_etiqueta'
        WHERE `id` = '1';";
        $comentario="Actualizar la etiqueta del corte";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener la comanda que es el id de la tabla sql pedido_rest
      function obtener_comanda(){
        $sentencia = "SELECT comanda FROM labels LIMIT 1";
        $comanda= "";
        $comentario="Obtener la comanda";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $comanda=$fila["comanda"];
        }
        return $comanda;
      }
      // Actualizar la comanda que es el id de la tabla sql pedido_rest
      function actualizar_comanda($comanda){
        //$comanda= $this->obtener_comanda() + 1;
        $sentencia = "UPDATE `labels` SET
        `comanda` = '$comanda'
        WHERE `id` = '1';";
        $comentario="Actualizar la comanda";
        $this->realizaConsulta($sentencia,$comentario);
      }
  
  }
  /**
  *
  */
  class Concepto extends ConexionMYSql
  {    
      public $id;
      public $activo;
      public $id_ticket;
      public $id_usuario;
      public $nombre;
      public $cantidad;
      public $precio;
      public $total;
      public $efectivo_pago;
      public $tipo_pago;
      public $tipo_cargo;
      public $categoria;

      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->activo= 0;
          $this->id_ticket= 0;
          $this->id_usuario= 0;
          $this->nombre= 0;
          $this->cantidad= 0;
          $this->precio= 0;
          $this->total= 0;
          $this->efectivo_pago= 0;
          $this->tipo_pago= 0;
          $this->tipo_cargo= 0;
          $this->categoria= 0;
        }else{
          $sentencia = "SELECT * FROM concepto WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de concepto";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $this->id= $fila['id'];
            $this->activo= $fila['activo'];
            $this->id_ticket= $fila['id_ticket'];
            $this->id_usuario= $fila['id_usuario'];
            $this->nombre= $fila['nombre'];
            $this->cantidad= $fila['cantidad'];
            $this->precio= $fila['precio'];
            $this->total= $fila['total'];
            $this->efectivo_pago= $fila['efectivo_pago'];
            $this->tipo_pago= $fila['tipo_pago'];
            $this->tipo_cargo= $fila['tipo_cargo'];
            $this->categoria= $fila['categoria'];               
          }
        }
      }
      // Guardar el concepto del ticket
      function guardar_concepto($id_ticket,$id_usuario,$nombre,$cantidad,$precio,$total,$efectivo_pago,$tipo_pago,$tipo_cargo,$categoria){
        $sentencia = "INSERT INTO `concepto` (`activo`, `id_ticket`, `id_usuario`, `nombre`, `cantidad`, `precio`, `total`, `efectivo_pago`, `tipo_pago`, `tipo_cargo`, `categoria`)
        VALUES ('1', '$id_ticket', '$id_usuario', '$nombre', '$cantidad', '$precio', '$total', '$efectivo_pago', '$tipo_pago', '$tipo_cargo', '$categoria');";
        $comentario="Guardamos el concepto en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Saber cual es el numero del concepto
      function saber_pedido($id_ticket,$nombre){
        $sentencia = "SELECT * FROM concepto WHERE id_ticket = $id_ticket AND nombre = '$nombre' AND activo = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Buscar si existe el id del concepto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $pedido= 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $pedido= $fila['id'];
        }
        return $pedido;
      }
      // Saber cual es la cantidad del concepto
      function saber_cantidad_pedido($id){
        $sentencia = "SELECT cantidad FROM concepto WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $comentario="Mostrar la cantidad del concepto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cantidad= 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      function agregar_concepto_ticket($id_ticket,$id_usuario,$nombre,$cantidad,$precio,$total,$efectivo_pago,$tipo_pago,$tipo_cargo,$categoria){
        $pedido= $this->saber_pedido($id_ticket,$nombre);
        if($pedido == 0){
          $this->guardar_concepto($id_ticket,$id_usuario,$nombre,$cantidad,$precio,$total,$efectivo_pago,$tipo_pago,$tipo_cargo,$categoria);
        }else{
          $cant= $this->saber_cantidad_pedido($pedido);
          $cant= $cant + $cantidad;
          $total_final= $precio * $cant;
          $sentencia = "UPDATE `concepto` SET
          `cantidad` = '$cant',
          `total` = '$total_final'
          WHERE `id` = '$pedido';";
          $comentario="Modificar la cantidad de productos en el concepto";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //echo "Es producto ya existe";
        }
      }
      // Cambiar estado activo del concepto
      function cambiar_activo($id_usuario){
        $sentencia = "UPDATE `concepto` SET
        `activo` = '0'
        WHERE `id_usuario` = '$id_usuario';";
        $comentario="Poner estado activo como inactivo del concepto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Saber el total de la cuenta en la mesa
      function saber_total_mesa($ticket){
        $sentencia = "SELECT * FROM concepto WHERE id_ticket = $ticket";
        //echo $sentencia;
        $comentario="Obtener el total del pedido";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $total=0;
        $subtotal=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          //$subtotal= $fila['total'];
          $subtotal= $fila['cantidad'] * $fila['precio'];
          $total= $total + $subtotal;
        }
        return  $total;
      }
      // Mostrar los conceptos del ticket
      function mostrar_comanda($mesa_id,$ticket){
        include_once("clase_inventario.php");
        $inventario= NEW Inventario(0);

        $sentencia = "SELECT * FROM concepto WHERE id_ticket = $ticket AND activo = 1";
        $comentario="Mostrar los conceptos del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cantidad=0;
        $total=0;
        echo '<ul class="list-group altura_comanda">';
        while ($fila = mysqli_fetch_array($consulta))
        {
          $producto= $inventario->obtener_id($fila['nombre']);
          $total_fila= $fila['cantidad'] * $fila['precio'];
          if(($cantidad%2)==0){
            echo '<div href="#" class="list-group-item list-group-item-success" onclick="herramienta_comanda('.$mesa_id.','.$fila['id'].','.$fila['cantidad'].','.$fila['precio'].','.$producto.')">
              <h6 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.number_format($fila['precio'], 2).' </h6>
              <h6 class="list-group-item-text"> Total: $'.number_format($total_fila, 2).' </h6>
            </div>';
          }else{
            echo '<div href="#" class="list-group-item list-group-item-info" onclick="herramienta_comanda('.$mesa_id.','.$fila['id'].','.$fila['cantidad'].','.$fila['precio'].','.$producto.')">
              <h6 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.number_format($fila['precio'], 2).' </h6>
              <h6 class="list-group-item-text"> Total: $'.number_format($total_fila, 2).' </h6>
            </div>';
          }
          $total= $total + $total_fila;
          $cantidad++;
          /*echo ' <a href="#" class="list-group-item list-group-item-info" onclick="herramienta_comanda('.$fila['id'].')">
              <div class="row">
                <div class="col-sm-5">
                  <h5 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.$fila['precio'].' </h5>
                </div>
                <div class="col-sm-3">
                  <p class="list-group-item-text">Total: $'.$fila['total'].' </p>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-success btn" href="#caja_herramientas" data-toggle="modal" onclick="editar_modal_producto_mesa('.$mesa_id.','.$fila['id'].')"> Editar</button>
                  <button class="btn btn-primary btn" href="#caja_herramientas" data-toggle="modal" onclick="borrar_modal_producto_mesa('.$mesa_id.','.$fila['id'].')"> Quitar</button>
                </div>
              </div>
            </a>';*/
        }
  
        /*if($cantidad<12){
          for ($i = $cantidad; $i <= 13; $i++) {
              echo '<div class="panel-body"></div>';
          }
        }*/
        echo '</ul>';
        
        return $total;
        /*if($cantidad>0){
          echo '<div class="row">
            <div class="col-sm-6 fuente_menor_bolder margen_sup_pedir">
            </div>
            <div class="col-sm-2 fuente_menor_bolder margen_sup_pedir">
              <h6 for="sel1">Total: $'.$total.'</h6>
            </div>
            <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">
              <button type="button" id="boton_cobrar" class="btn btn-danger btn-block" onclick="cobrar_rest('.$mesa_id.','.$total.')">Cobrar</button>
            </div>
            <div class="col-sm-1 fuente_menor_bolder margen_sup_pedir">
            </div>
          </div><br>';
        }*/
  
      }
      // Mostrar la informacion del concepto seleccionado del ticket
      function mostar_info_comanda($id){
        $sentencia = "SELECT  * FROM concepto WHERE id = $id LIMIT  1";
        $comentario="Mostrar la informacion del concepto seleccionado del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $total_fila= $fila['cantidad'] * $fila['precio'];
          echo '<div href="#" class="list-group-item list-group-item">
              <h6 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.number_format($fila['precio'], 2).' </h6>
              <h6 class="list-group-item-text"> Total: $'.number_format($total_fila, 2).' </h6>
          </div>';//$fila['total']
        }
      }
      // Editar la cantidad del concepto seleccionado del ticket
      function editar_concepto($id,$cantidad,$precio){
        $total= $cantidad * $precio;
        $sentencia = "UPDATE `concepto` SET
        `cantidad` = '$cantidad',
        `total` = '$total'
        WHERE `id` = '$id';";
        $comentario="Editar la cantidad del concepto seleccionado del ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un concepto
      function borrar_concepto($id){
        $sentencia = "UPDATE `concepto` SET
        `activo` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de concepto como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
    
  }
?>
