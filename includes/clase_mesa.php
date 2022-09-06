<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  
 
  class Mesa extends ConexionMYSql
  {
    public $id;
    public $nombre;
    public $tipo;
    public $hotel;
    public $motel;
    public $tipo_num;
    public $mov;
    public $capacidad;
    public $estado;
    public $comentario;

    function __construct($id)
    {
      if($id>0){
        //$sentencia = "SELECT mesa.nombre,mesa.tipo,tipo_mesa.motel,tipo_mesa.hotel,mesa.mov,mesa.estado,mesa.comentario,tipo_mesa.nombre as tiponom FROM mesa LEFT JOIN tipo_mesa ON mesa.tipo = tipo_mesa.id WHERE mesa.id = $id";
        $sentencia = "SELECT mesa.nombre,mesa.tipo,mesa.mov,mesa.capacidad,mesa.estado,mesa.comentario FROM mesa WHERE mesa.id = $id";
        $comentario="Crear el objeto de la clase mesa dentro del sql";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $this->id=$id;
          $this->nombre=$fila['nombre'];
          $this->tipo_num=$fila['tipo'];
          //$this->tipo=$fila['tiponom'];
          $this->mov=$fila['mov'];
          $this->capacidad=$fila['capacidad'];
          $this->estado=$fila['estado'];
          $this->comentario=$fila['comentario'];
        }
      }
    }
    function cambiomesa($mesa,$mov,$estado){
      $sentencia = "UPDATE `mesa` SET
      `mov` = '$mov',
      `estado` = '$estado'
      WHERE `id` = '$mesa';";
      $comentario="Crear el objeto de la clase mesa dentro del sql";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function tipo_mesa(){
      $sentencia = "SELECT * FROM tipo_mesa";
      $comentario="Obtenemos los tipos de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '
          <li><a href="#" onclick="ver_categoria('.$fila['id'].')">'.$fila['nombre'].'</a></li>
        ';
      }
    }
    function saber_retorno($mov){
      $retorno=0;
      $sentencia = "SELECT retorno FROM movimiento WHERE id =$mov LIMIT 1";
      $comentario="Obtenemos los tipos de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $retorno=$fila['retorno'];
      }
      return $retorno;
    }
    function saber_mov($mesa_id){//
      $sentencia = "SELECT mov FROM mesa WHERE id =$mesa_id LIMIT 1";
      $comentario="Obtenemos el movimiento de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $mov=$fila['mov'];
      }
      return $mov;
    }
    function saber_nombre_mesa($mesa_id){//
      $sentencia = "SELECT nombre FROM mesa WHERE id =$mesa_id LIMIT 1";
      $comentario="Obtenemos el nombre de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $nombre=$fila['nombre'];
      }
      return $nombre;
    }
    function saber_cliente_mesa($mesa_id){//
      $sentencia = "SELECT mov FROM mesa WHERE id =$mesa_id LIMIT 1";
      $comentario="Obtenemos el movimiento de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $mov=$fila['mov'];
      }
  
      $sentencia2 = "SELECT cliente FROM  movimiento WHERE id = $mov LIMIT 1";
      $comentario2="Obtener el cliente de movimiento de check-in";
      $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
      //se recibe la consulta y se convierte a arreglo
      while ($fila2 = mysqli_fetch_array($consulta2))
      {
         $cliente= $fila2['cliente'];
      }
      return $cliente;
    }
    function saber_inicio($mesa_id){
      $sentencia = "SELECT mov FROM mesa WHERE id =$mesa_id LIMIT 1 ";
      $comentario="Obtenemos el movimiento de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $mov=$fila['mov'];
      }
  
      $sentencia2 = "SELECT detalle_inicio FROM  movimiento WHERE id = $mov LIMIT 1";
      $comentario2="Obtener el tiempo de inicio de hospedaje";
      $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
      //se recibe la consulta y se convierte a arreglo
      while ($fila2 = mysqli_fetch_array($consulta2))
      {
         $detalle_inicio= $fila2['detalle_inicio'];
      }
      return $detalle_inicio;
    }
    function saber_fin($mesa_id){
      $sentencia = "SELECT mov FROM mesa WHERE id =$mesa_id LIMIT 1 ";
      $comentario="Obtenemos el movimiento de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $mov=$fila['mov'];
      }
   
      $sentencia2 = "SELECT fin_hospedaje FROM  movimiento WHERE id = $mov LIMIT 1";
      $comentario2="Obtener el tiempo de fin de hospedaje";
      $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
      //se recibe la consulta y se convierte a arreglo
      while ($fila2 = mysqli_fetch_array($consulta2))
      {
        $fin_hospedaje= $fila2['fin_hospedaje'];
      }
      return $fin_hospedaje;
      //return $detalle_fin;
    }
    function guardarmovcambio($origen,$destino,$usuario,$mov){
      $timpo=time();
      $sentencia = "INSERT INTO `cambio_mesa` (`mesa_origen`, `mesa_destino`, `usuario`, `movi`, `tiempo`, `estado`)
      VALUES ('$origen', '$destino', '$usuario', '$mov', '$timpo', '0');";
      $comentario="Obtenemos los tipos de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      
    }
    function cambiohosp($id){
      $sentencia = "SELECT * FROM mesa WHERE tipo = " . $this->tipo_num  .' AND estado = 0';
      //echo $sentencia ;
      $comentario="Obtenemos los tipos de mesa";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
              echo '<div class="asignar_reca_activa" onclick="aplicarcambiohospe('.$id.','.$fila['id'].','.$this->tipo_num.')">';
              echo '</br>';
              echo '<div>';
                  echo '<img src="images/cama.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo $fila['nombre'];
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
      }
    }
    
  }
?>
