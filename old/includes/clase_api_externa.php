<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Api_externa extends ConexionMYSql{
    
    public $id;
    public $token;
    public $activo;

    // Constructor
    function __construct($id)
    {
        if($id==0){
          $this->id= 0;
          $this->token= 0;
          $this->activo= 0;
        }else{  
          $sentencia = "SELECT * FROM api_externa WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de la api externa ";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->token= $fila['token'];
              $this->activo= $fila['activo'];
          }
        }
    }
    // Evaluo si el token es valido
    function obtener_token($id){
      $token=0;
      if(empty($id)){
        //echo 'El id se encuentra vacio o es 0';
      }else{
        $sentencia = "SELECT token FROM api_externa  WHERE id = $id AND activo = 1 LIMIT 1";
        $comentario="Obtener el token del usuario ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $token= $fila['token'];  
        }
          return $token; 
      }
    }
       
  }
?>
