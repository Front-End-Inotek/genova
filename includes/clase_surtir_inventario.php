<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Surtir_inventario extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $fecha;
      public $cantidad_producto;
      public $total_producto;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->fecha= 0;
          $this->cantidad_producto= 0;
          $this->total_producto= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM surtir_inventario WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->fecha= $fila['fecha'];
              $this->cantidad_producto= $fila['cantidad_producto'];
              $this->total_producto= $fila['total_producto'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el surtir inventario
      function guardar_surtir_inventario($id_usuario,$cantidad_producto,$total_producto){
        $fecha=time();
        $sentencia = "INSERT INTO `surtir_inventario` (`id_usuario`, `fecha`, `cantidad_producto`, `total_producto`, `estado`)
        VALUES ('$id_usuario', '$fecha', '$cantidad_producto', '$total_producto', '1');";
        $comentario="Guardamos el surtir_inventario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Obtengo el total de reportes de surtir inventario
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM surtir_inventario WHERE estado = 1 ORDER BY id";
        //echo $sentencia;
        $comentario="Obtengo el total de reportes de surtir inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los reportes de surtir inventario
      function mostrar($posicion,$id){
        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0){
          $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT *,surtir_inventario.id AS ID
        FROM surtir_inventario 
        INNER JOIN usuario ON surtir_inventario.id_usuario = usuario.id WHERE surtir_inventario.estado = 1 ORDER BY surtir_inventario.id DESC";
        $comentario="Mostrar los reportes de surtir inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_surtir_inventario">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Número</th>
            <th>Nombre Surtió</th>
            <th>Fecha</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['ID'].'</td> 
                <td>'.$fila['usuario'].'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td><button class="btn btn-success" onclick="reporte_surtir_inventario('.$fila['ID'].')"> Reporte</button></td>
                </tr>';
              }
              $cont++;
            }
            echo '
            </tbody>
          </table>
          </div>';
          return $cat_paginas;
      }
      // Busqueda por fecha en ver reportes de surtir inventario
      function mostrar_surtir_fecha($fecha_ini_tiempo,$fecha_fin_tiempo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);

        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar();
        }else{
          $sentencia = "SELECT *,surtir_inventario.id AS ID
          FROM surtir_inventario 
          INNER JOIN usuario ON surtir_inventario.id_usuario = usuario.id WHERE surtir_inventario.fecha >= $fecha_ini && surtir_inventario.fecha <= $fecha_fin && surtir_inventario.fecha > 0 && surtir_inventario.estado = 1 ORDER BY surtir_inventario.id DESC";
          $comentario="Mostrar por fecha los reportes de surtir inventario";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_surtir_inventario">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Número</th>
              <th>Nombre Surtió</th>
              <th>Fecha</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
              </tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                  echo '<tr class="text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.$fila['usuario'].'</td>
                  <td>'.date("d-m-Y",$fila['fecha']).'</td>
                  <td><button class="btn btn-success" onclick="reporte_surtir_inventario('.$fila['ID'].')"> Reporte</button></td>
                  </tr>';
              }
              echo '
            </tbody>
          </table>
          </div>';
        }
      }
      // Obtener el ultimo surtir inventario ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM surtir_inventario ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo surtir inventario ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
              
  }
?>