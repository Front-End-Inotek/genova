<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Ticket extends ConexionMYSql{

      public $id;
      public $etiqueta;
      public $mov;
      public $id_hab;
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
      function guardar_ticket($mov,$hab_id,$id_usuario,$forma_pago,$total,$pago,$cambio,$monto,$descuento,$total_descuento,$facturar,$folio,$comentario,$nueva_etiqueta){
        $fecha=date("Y-m-d H:i");
        $tiempo=time();
        $sentencia = "INSERT INTO `ticket` (`etiqueta`, `mov`, `id_hab`, `fecha`, `tiempo`, `id_usuario`, `forma_pago`, `total`, `pago`, `cambio`, `monto`, `descuento`, `total_descuento`, `facturado`, `baucher`, `comentario`, `impreso`, `resta`, `comanda`, `estado`)
        VALUES ('$nueva_etiqueta', '$mov', '$hab_id', '$fecha', '$tiempo', '$id_usuario', '$forma_pago', '$total', '$pago', '$cambio', '$monto', '$descuento', '$total_descuento', '$facturar', '$folio', '$comentario', '1', '1', '0', '1');";
        $comentario="Guardamos el ticket en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        
        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      // Recoger el id del ticket anterior
      function id_mysql(){
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
        $etiqueta ="";
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
        $nueva_etiqueta=$this->obtener_etiqueta()+1;
        $sentencia = "UPDATE `labels` SET
        `ticket` = '$nueva_etiqueta'
        WHERE `id` = '1';";
        $comentario="Actualizar la etiqueta del ticket";
        $this->realizaConsulta($sentencia,$comentario);
      }
  
  }
  /**
  *
  */
  class Concepto extends ConexionMYSql
  {    
      public $id;
      public $id_ticket;
      public $nombre;
      public $cantidad;
      public $precio;
      public $total;
      public $tipocargo;
      public $categoria;

      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_ticket= 0;
          $this->nombre= 0;
          $this->cantidad= 0;
          $this->precio= 0;
          $this->total= 0;
          $this->tipocargo= 0;
          $this->categoria= 0;
        }else{
          $sentencia = "SELECT * FROM concepto WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de concepto";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $this->id= $fila['id'];
            $this->id_ticket= $fila['id_ticket'];
            $this->nombre= $fila['nombre'];
            $this->cantidad= $fila['cantidad'];
            $this->precio= $fila['precio'];
            $this->total= $fila['total'];
            $this->tipocargo= $fila['tipocargo'];
            $this->categoria= $fila['categoria'];               
          }
        }
      }
      // Obtener la etiqueta del ticket
      function guardar_concepto($id_ticket,$nombre,$cantidad,$precio,$total,$tipocargo,$categoria){
        $sentencia = "INSERT INTO `concepto` (`id_ticket`, `nombre`, `cantidad`, `precio`, `total`, `tipocargo`, `categoria`)
        VALUES ('$id_ticket', '$nombre', '$cantidad', '$precio', '$total', '$tipocargo', '$categoria');";
        $comentario="Guardamos el concepto en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
    
  }
?>
