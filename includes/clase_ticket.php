<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tipo extends ConexionMYSql{

      public $id;
      public $nombre;
      public $codigo;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->codigo= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM tipo_hab WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de tipo habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->codigo= $fila['codigo'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el tipo habitacion
      function guardar_tipo($nombre,$codigo){
        $sentencia = "INSERT INTO `tipo_hab` (`nombre`, `codigo`, `estado`)
        VALUES ('$nombre', '$codigo', '1');";
        $comentario="Guardamos el tipo habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
             
  }
?>
