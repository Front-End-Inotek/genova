<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Forma_pago extends ConexionMYSql{
    
    public $id;
    public $descripcion;
    public $estado;

    // Constructor
    function __construct($id)
    {
      if($id==0){
        $this->id= 0;
        $this->descripcion= 0;
        $this->estado= 0;
      }else{  
        $sentencia = "SELECT * FROM forma_pago WHERE id = $id LIMIT 1";
        $comentario="Obtener todos los valores de forma de pago";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $this->id= $fila['id'];  
            $this->descripcion= $fila['descripcion']; 
            $this->estado= $fila['estado'];            
        }
      }
    }
    // Guardar una forma de pago
    function guardar_forma_pago($descripcion){
      $sentencia = "INSERT INTO `forma_pago` (`descripcion`, `estado`)
      VALUES ('$descripcion', '1');";
      $comentario="Guardamos la forma de pago en la base de datos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);                 
    }
    // * //
    // Editar una forma de pago
    function editar_forma_pago($id,$descripcion){
      $sentencia = "UPDATE `forma_pago` SET
          `descripcion` = '$descripcion'
          WHERE `id` = '$id';";
      //echo $sentencia ;
      $comentario="Editar una forma de pago dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Borrar una forma de pago
    function borrar_forma_pago($id){
      $sentencia = "UPDATE `forma_pago` SET
      `estado` = '0'
      WHERE `id` = '$id';";
      $comentario="Poner estado de una forma de pago como inactivo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Muestra las formas de pago
    function mostrar_forma_pago(){
      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar las formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
      }
      return $consulta;
    }
    // Muestra las formas de pago a editar
    function mostrar_forma_pago_editar($id){
      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar las formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($id==$fila['id']){
          echo '<option value="'.$fila['id'].'" selected>'.$fila['descripcion'].'</option>';
        }else{
          echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';  
        }
      }
    }
    // Mostramos el pago*//
    function mostrar_nombre_pago($id){ 
      $sentencia = "SELECT limite_pago FROM pago WHERE id = $id AND estado = 1 LIMIT 1";
      //echo $sentencia;
      $limite_pago = 0;
      $comentario="Obtengo el pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $limite_pago= $fila['limite_pago'];
      }
      return $limite_pago;
    }
    
  }
?>
