<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Inventario extends ConexionMYSql{

      public $id;
      public $nombre;
      public $descripcion;
      public $categoria;
      public $precio;
      public $precio_compra;
      public $inventario;
      public $stock;
      public $bodega_inventario;
      public $bodega_stock;
      public $clabe;
      public $historial;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->descripcion= 0;
          $this->categoria= 0;
          $this->precio= 0;
          $this->precio_compra= 0;
          $this->inventario= 0;
          $this->stock= 0;
          $this->bodega_inventario= 0;
          $this->bodega_stock= 0;
          $this->clabe= 0;
          $this->historial= 0;
          $this->estado= 0; 
        }else{
          $sentencia = "SELECT * FROM inventario WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores del inventario";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->descripcion= $fila['descripcion'];
              $this->categoria= $fila['categoria'];
              $this->precio= $fila['precio'];
              $this->precio_compra= $fila['precio_compra'];
              $this->inventario= $fila['inventario'];
              $this->stock= $fila['stock'];
              $this->bodega_inventario= $fila['bodega_inventario'];
              $this->bodega_stock= $fila['bodega_stock'];
              $this->clabe= $fila['clabe'];
              $this->historial= $fila['historial'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el inventario
      function guardar_inventario($nombre,$descripcion,$categoria,$precio,$precio_compra,$inventario,$stock,$bodega_inventario,$bodega_stock,$clabe,$historial){
        $sentencia = "INSERT INTO `inventario` (`nombre`, `descripcion`, `categoria`, `precio`, `precio_compra`, `inventario`, `stock`, `bodega_inventario`, `bodega_stock`, `clabe`, `historial`, `estado`)
        VALUES ('$nombre', '$descripcion', '$categoria', '$precio', '$precio_compra','$inventario', '$stock', '$bodega_inventario', '$bodega_stock', '$clabe', '$historial', '1');";
        $comentario="Guardamos el inventario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);    
        
        include_once("clase_log.php");//MALLL
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM inventario ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id del inventario agregado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar inventario: ". $id);
      }
      // Obtengo el total de inventario
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM inventario WHERE estado = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los inventario
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->inventario_editar;
        $borrar = $usuario->inventario_borrar;
    
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

        $sentencia = "SELECT * FROM inventario WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_inventario">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Categoria</th>
            <th>Precio</th>
            <th>Precio Compra</th>
            <th>Inventario</th>
            <th>Stock</th>
            <th>Bodega Inventario</th>
            <th>Bodega Stock</th>
            <th>Clabe</th>
            <th>Historial</th>';
            if($editar==1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1){
              echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['descripcion'].'</td>
                <td>'.$fila['categoria'].'</td>
                <td>'.$fila['precio'].'</td>
                <td>'.$fila['precio_compra'].'</td>
                <td>'.$fila['inventario'].'</td>
                <td>'.$fila['stock'].'</td>
                <td>'.$fila['bodega_inventario'].'</td>
                <td>'.$fila['bodega_stock'].'</td>
                <td>'.$fila['clabe'].'</td>
                <td>'.$fila['historial'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_inventario('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_inventario('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
              }
              $cont++;
            }
            echo '
            </tbody>
          </table>
          </div>';
          return $cat_paginas;
      }
      // Barra de diferentes busquedas en ver inventario
      function buscar_inventario($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->inventario_editar;
        $borrar = $usuario->inventario_borrar;

        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM inventario WHERE (nombre LIKE '%$a_buscar%' || descripcion LIKE '%$a_buscar%' || categoria LIKE '%$a_buscar%' || stock LIKE '%$a_buscar%') && estado = 1 ORDER BY nombre;";
          $comentario="Mostrar diferentes busquedas en ver inventario";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_inventario">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Categoria</th>
              <th>Precio</th>
              <th>Precio Compra</th>
              <th>Inventario</th>
              <th>Stock</th>
              <th>Bodega Inventario</th>
              <th>Bodega Stock</th>
              <th>Clabe</th>
              <th>Historial</th>';
              if($editar==1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
              }
              if($borrar==1){
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
              }
              echo '</tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)) 
              {
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['descripcion'].'</td>
                <td>'.$fila['categoria'].'</td>
                <td>'.$fila['precio'].'</td>
                <td>'.$fila['precio_compra'].'</td>
                <td>'.$fila['inventario'].'</td>
                <td>'.$fila['stock'].'</td>
                <td>'.$fila['bodega_inventario'].'</td>
                <td>'.$fila['bodega_stock'].'</td>
                <td>'.$fila['clabe'].'</td>
                <td>'.$fila['historial'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_inventario('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_inventario('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
              }
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar el inventario
      function editar_inventario($id,$nombre,$descripcion,$categoria,$precio,$precio_compra,$inventario,$stock,$bodega_inventario,$bodega_stock,$clabe,$historial){
        $sentencia = "UPDATE `inventario` SET
            `nombre` = '$nombre',
            `descripcion` = '$descripcion',
            `categoria` = '$categoria',
            `precio` = '$precio',
            `precio_compra` = '$precio_compra',
            `inventario` = '$inventario',
            `stock` = '$stock',
            `bodega_inventario` = '$bodega_inventario',
            `bodega_stock` = '$bodega_stock',
            `clabe` = '$clabe',
            `historial` = '$historial'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar inventario dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar el inventario
      function borrar_inventario($id){
        $sentencia = "UPDATE `inventario` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de inventario como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre en el inventario
      function obtengo_nombre($id){
        $sentencia = "SELECT nombre FROM inventario WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el nombre en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      }
             
  }
?>