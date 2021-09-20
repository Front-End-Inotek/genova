<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Configuracion extends ConexionMYSql{
    
    public $activacion;
    public $nombre;

    function __construct()
    {
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1 ";
      $comentario="Obtener todos los valores de la configuracion ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           
           $this->activacion= $fila['activacion'];
           $this->nombre= $fila['nombre'];
           
      }
    }
    
  }
?>
