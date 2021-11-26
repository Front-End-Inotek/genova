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
      public $clave;
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
          $this->clave= 0;
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
              $this->clave= $fila['clave'];
              $this->historial= $fila['historial'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el inventario
      function guardar_inventario($nombre,$descripcion,$categoria,$precio,$precio_compra,$stock,$inventario,$bodega_inventario,$bodega_stock,$clave){
        $sentencia = "INSERT INTO `inventario` (`nombre`, `descripcion`, `categoria`, `precio`, `precio_compra`, `stock`, `inventario`, `bodega_inventario`, `bodega_stock`, `clave`, `historial`, `estado`)
        VALUES ('$nombre', '$descripcion', '$categoria', '$precio', '$precio_compra', '$stock', '$inventario', '$bodega_inventario', '$bodega_stock', '$clave', '0', '1');";
        $comentario="Guardamos el inventario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);    
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

        $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
        FROM inventario 
        INNER JOIN categoria ON inventario.categoria = categoria.id WHERE inventario.estado = 1 ORDER BY inventario.nombre";
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
            <th>Clave SAT</th>
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
                <td>'.$fila['nom'].'</td>  
                <td>'.$fila['descripcion'].'</td>
                <td>'.$fila['categoria'].'</td>
                <td>$'.number_format($fila['precio'], 2).'</td>
                <td>$'.number_format($fila['precio_compra'], 2).'</td>
                <td>'.$fila['inventario'].'</td>
                <td>'.$fila['stock'].'</td>
                <td>'.$fila['bodega_inventario'].'</td>
                <td>'.$fila['bodega_stock'].'</td>
                <td>'.$fila['clave'].'</td>
                <td>'.$fila['historial'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_inventario('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_inventario('.$fila['ID'].')"> Borrar</button></td>';
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
          $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
          FROM inventario 
          INNER JOIN categoria ON inventario.categoria = categoria.id WHERE (inventario.nombre LIKE '%$a_buscar%' || inventario.descripcion LIKE '%$a_buscar%' || categoria.nombre LIKE '%$a_buscar%' || inventario.clave LIKE '%$a_buscar%') && inventario.estado = 1 ORDER BY inventario.nombre;";
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
              <th>Clave SAT</th>
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
                <td>'.$fila['nom'].'</td>  
                <td>'.$fila['descripcion'].'</td>
                <td>'.$fila['categoria'].'</td>
                <td>'.$fila['precio'].'</td>
                <td>'.$fila['precio_compra'].'</td>
                <td>'.$fila['inventario'].'</td>
                <td>'.$fila['stock'].'</td>
                <td>'.$fila['bodega_inventario'].'</td>
                <td>'.$fila['bodega_stock'].'</td>
                <td>'.$fila['clave'].'</td>
                <td>'.$fila['historial'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_inventario('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_inventario('.$fila['ID'].')"> Borrar</button></td>';
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
      function editar_inventario($id,$nombre,$descripcion,$categoria,$precio,$precio_compra,$inventario,$stock,$bodega_inventario,$bodega_stock,$clave){
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
            `clave` = '$clave'
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
      // Mostrar productos de las categorias existentes en el inventario
      function mostrar_producto_restaurente($categoria){
        $sentencia = "SELECT * FROM inventario WHERE categoria = $categoria ORDER BY nombre";
        $comentario="Mostrar los productos por restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cunt=0;
        echo '
        <div class="row">
        ';
        $cont=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          /*echo '<div class="col-sm-4"><button type="button" class="btn btn-primary btn-block" onclick="cargar_producto_restaurante('.$fila['id'].')">';
          echo $fila['nombre'];
          echo'</button></div>';*/
          /*echo '<div class="row color_black">
            <div class="col-sm-4">'.$fila['nombre'].'</div>
            <div class="col-sm-3">$'.$fila['precio'].'</div>
            <div class="col-sm-3"><button type="button" class="btn btn-primary btn-md" onclick="cargar_producto_rest_cobro('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> Seleccionar</button></div>
  
          </div>
          </br>';*/
          if($cunt%3==0){
            echo '<div class="col-sm-4"><button type="button" class="btn btn-success btn-block" onclick="cargar_producto_restaurante('.$fila['id'].')">';
            echo $fila['nombre'];
            echo'</button></div>';
            $cunt=0;
          }elseif($cunt%2==0){
            echo '<div class="col-sm-4"><button type="button" class="btn btn-success btn-block" onclick="cargar_producto_restaurante('.$fila['id'].')">';
            echo $fila['nombre'];
            echo'</button></div>';
          }else{
            echo '<div class="col-sm-4"><button type="button" class="btn btn-info btn-block" onclick="cargar_producto_restaurante('.$fila['id'].')">';
            echo $fila['nombre'];
            echo'</button></div>';
          }
          $cunt++;
  
          if($cont==1){
            $cont=0;
            echo '</br></br>';
  
          }
          else{
            $cont++;
          }
        }
        echo '</div>';
        if ($cont==0){
          $sentencia;
        }
        }
      function agregar_producto_apedido($mov,$producto,$hab){//2.5
        $pedido=$this->saber_pedido($mov,$producto);
        if($pedido==0){
          $sentencia = "INSERT INTO `perdido_rest` (`estado`, `movimiento`, `producto`, `cantidad`)
          VALUES ('0', '$mov', '$producto', '1');";
          $comentario="Agregar producto a pedido de restaurante";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }else{
          $cantidad= $this->saber_cantidad_pedido($pedido);
          $cantidad++;
          $sentencia = "UPDATE `perdido_rest` SET
          `cantidad` = '$cantidad'
          WHERE `id` = '$pedido';";
          $comentario="Modificar la cantidad de productos en el pedido";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //echo "Es producto ya existe";
        }
      }
             
  }
?>