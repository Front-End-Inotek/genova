<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Cargo_noche extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $fecha;
      public $total;
      public $cantidad_hab;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->fecha= 0;
          $this->total= 0;
          $this->cantidad_hab= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM cargo_noche WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->fecha= $fila['fecha'];
              $this->total= $fila['total'];
              $this->cantidad_hab= $fila['cantidad_hab'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el cargo_noche
      function guardar_cargo_noche($id_usuario,$total,$cantidad_hab){
        $fecha=time();
        $sentencia = "INSERT INTO `cargo_noche` (`id_usuario`, `fecha`, `total`, `cantidad_hab`, `estado`)
        VALUES ('$id_usuario', '$fecha', '$total', '$cantidad_hab', '1');";
        $comentario="Guardamos el cargo noche en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostramos los reportes de cargos de noche
      function mostrar($id){
        $sentencia = "SELECT * FROM cargo_noche WHERE estado = 1 ORDER BY id DESC";
        $comentario="Mostrar los reportes de cargos de noche";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cargo_noche">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Número</th>
            <th>Usuario</th>
            <th>Total</th>
            <th>Fecha</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
                echo '<tr class="text-center">
                <td>'.$fila['id'].'</td> 
                <td>'.$fila['id_usuario'].'</td>
                <td>$'.number_format($fila['total'], 2).'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td><button class="btn btn-success" onclick="mostrar_reporte_cargo_noche('.$fila['id'].')"> Reporte</button></td>
                </tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar una categoria
      function editar_categoria($id,$nombre){
        $sentencia = "UPDATE `categoria` SET
            `nombre` = '$nombre'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una categoria dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una categoria
      function borrar_categoria($id){
        $sentencia = "UPDATE `categoria` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una categoria como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener el ultimo cargo noche ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM cargo_noche ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo cargo noche ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
              
  }
?>