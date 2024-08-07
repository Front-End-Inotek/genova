<?php
  date_default_timezone_set('America/Mexico_City');
  /**
   *
   */
  class ConexionMYSql
  {
    function realizaConsulta($sentencia, $comentario){
      include('datos_servidor.php');
      // Open Connection
      $con = @mysqli_connect($servidor,$usuario_servidor, $password, $base_datos);
      if (!$con) {
          echo "Error: " . mysqli_connect_error() . $comentario;
      	exit();
      }
      // Some Query
      if(!($query 	= mysqli_query($con, $sentencia))){
        printf("Mensaje de Error: %s\n",mysqli_error($con));
      }
      mysqli_close ($con);
      return $query;
    }

    function RetrieveLast($statement){
      include('datos_servidor.php');
      $conn = @mysqli_connect($servidor,$usuario_servidor, $password, $base_datos);

      if (!$conn) {
        echo "Error: " . mysqli_connect_error() . $comentario;
        exit();
        }
    
      if (!($query = mysqli_query($conn, $statement))) {
        printf("Mensaje de Error: %s\n", mysqli_error($conn));
       }
    
      $last_insert_id = mysqli_insert_id($conn);
      mysqli_close($conn);
      return $last_insert_id;
      }
    }
  
?>
