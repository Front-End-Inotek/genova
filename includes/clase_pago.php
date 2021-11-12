<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Pago extends ConexionMYSql{
    
    public $id;
    public $limite_pago;

    // Constructor
    function __construct($id)
    {
      if($id==0){
        $this->id= 0;
        $this->limite_pago= 0;
      }else{  
        $sentencia = "SELECT * FROM pago WHERE id = $id LIMIT 1";
        $comentario="Obtener todos los valores de pago";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $this->id= $fila['id'];  
            $this->limite_pago= $fila['limite_pago'];             
        }
      }
    }
    // Muestra los pagos
    function mostrar_pago(){
      $sentencia = "SELECT * FROM pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar los pagos de servicios";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<option value="'.$fila['id'].'">'.$fila['limite_pago'].'</option>';
      }
      return $consulta;
    }
    // Muestra los pagos a editar
    function mostrar_pago_editar($id){
      $sentencia = "SELECT * FROM pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar los pagos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($id==$fila['id']){
          echo '<option value="'.$fila['id'].'" selected>'.$fila['limite_pago'].'</option>';
        }else{
          echo '<option value="'.$fila['id'].'">'.$fila['limite_pago'].'</option>';  
        }
      }
    }
    // Mostramos el pago*
    /*function mostrar_nombre_pago($id){ 
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
    }*/
    
  }
?>
