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
        $nombre= '';
        $comentario="Obtengo el nombre en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      }
      // Obtengo el precio en el inventario
      function obtengo_precio($id){
        $sentencia = "SELECT precio FROM inventario WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $precio= 0;
        $comentario="Obtengo el precio en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $precio= $fila['precio'];
        }
        return $precio;
      }
      // Obtengo la categoria en el inventario
      function obtengo_categoria($id){
        $sentencia = "SELECT categoria FROM inventario WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $categoria= 0;
        $comentario="Obtengo la categoria en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $categoria= $fila['categoria'];
        }
        return $categoria;
      }
      // Mostrar la cantidad de inventario de un producto
      function cantidad_inventario($id){
        $sentencia = "SELECT inventario FROM inventario WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $inventario= 0;
        $comentario="Mostrar la cantidad de inventario de un producto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $inventario= $fila['inventario'];
        }
        return $inventario;
      }
      // Mostrar el historial de inventario de un producto
      function cantidad_historial($id){
        $sentencia = "SELECT historial FROM inventario WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $historial= 0;
        $comentario="Mostrar el historial de inventario de un producto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $historial= $fila['historial'];
        }
        return $historial;
      }
      // Editar la cantidad de inventario de un producto
      function editar_cantidad_inventario($id,$cantidad){
        $sentencia = "UPDATE `inventario` SET
          `inventario` = '$cantidad'
          WHERE `id` = '$id';";
        $comentario="Editar la cantidad de inventario de un producto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Editar el historial de inventario de un producto
      function editar_cantidad_historial($id,$cantidad){
        $sentencia = "UPDATE `inventario` SET
          `historial` = '$cantidad'
          WHERE `id` = '$id';";
        $comentario="Editar el historial de inventario de un producto";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Busqueda de cualquier producto en el inventario
      function mostar_producto_busqueda($busqueda,$hab_id,$estado,$mov){
        $sentencia = "SELECT * FROM inventario WHERE nombre LIKE '%$busqueda%' ORDER BY categoria, nombre";
        $comentario="Busqueda de cualquier producto en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cunt=0;
        echo '<h6 class="alinear_centro_categorias"> Productos</h6>
        <div class="row">';
          $cont=0;
          while ($fila = mysqli_fetch_array($consulta))
          {
            if($cunt%3==0){
              //echo '<div class="col-sm-4"><button type="button" class="btn btn-success btn-block" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
              echo $fila['nombre'];
              echo'</button></div>';
              $cunt=0;
            }elseif($cunt%2==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
              echo $fila['nombre'];
              echo'</button></div>';
            }else{
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
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
      // Mostrar productos de las categorias existentes en el inventario
      function mostrar_producto_restaurente($categoria,$hab_id,$estado,$mov){
        $sentencia = "SELECT * FROM inventario WHERE categoria = $categoria ORDER BY nombre";
        $comentario="Mostrar los productos por restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cunt=0;
        echo '<h6 class="alinear_centro_categorias"> Productos</h6>
        <div class="row">';
          $cont=0;
          while ($fila = mysqli_fetch_array($consulta))
          {
            if($cunt%3==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
              echo $fila['nombre'];
              echo'</button></div>';
              $cunt=0;
            }elseif($cunt%2==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
              echo $fila['nombre'];
              echo'</button></div>';
            }else{
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$hab_id.','.$estado.','.$mov.')">';
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
             
  }
  /**
  *
  */
  class Pedido_rest extends ConexionMYSql
  {    
      public $id;
      public $mov;
      public $id_producto;
      public $cantidad;
      public $pagado;
      public $pedido;
      public $estado;

      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->mov= 0;
          $this->id_producto= 0;
          $this->cantidad= 0;
          $this->pagado= 0;
          $this->pedido= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM pedido_rest WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores del pedido rest";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $this->id= $fila['id'];
            $this->mov= $fila['mov'];
            $this->id_producto= $fila['id_producto'];
            $this->cantidad= $fila['cantidad'];
            $this->pagado= $fila['pagado'];
            $this->pedido= $fila['pedido'];
            $this->estado= $fila['estado'];             
          }
        }
      }
      // Agregar un producto al pedido de restaurante
      function agregar_producto_apedido($hab_id,$estado,$producto,$mov){
        $pedido=$this->saber_pedido($mov,$producto);
        if($pedido==0){
          $sentencia = "INSERT INTO `pedido_rest` ( `mov`, `id_producto`, `cantidad`, `pagado`, `pedido`, `estado`)
          VALUES ('$mov', '$producto', '1', '0', '0', '1');";
          $comentario="Agregar un producto al pedido de restaurante";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }else{
          $cantidad= $this->saber_cantidad_pedido($pedido);
          $cantidad++;
          $sentencia = "UPDATE `pedido_rest` SET
          `cantidad` = '$cantidad'
          WHERE `id` = '$pedido';";
          $comentario="Modificar la cantidad de productos en el pedido de restaurante";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //echo "Es producto ya existe";
        }
      }
      // Obtner el estado del producto del pedido de restaurante
      function saber_pedido($mov,$producto){
        $sentencia = "SELECT * FROM pedido_rest WHERE mov = $mov AND id_producto = $producto AND pagado = 0 AND pedido = 0 AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtner el estado del producto del pedido de restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $pedido=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $pedido=$fila['id'];
        }
        return $pedido;
      }
      // Obtner la cantidad de un producto de un pedido restaurante
      function saber_cantidad_pedido($pedido){
        $sentencia = "SELECT cantidad FROM pedido_rest WHERE id = $pedido AND pagado = 0 AND pedido = 0 AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtner la cantidad de un producto de un pedido restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cantidad=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad=$fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostrar los productos del pedido restaurente sin habitacion
      function mostar_pedido($hab_id,$estado,$mov){
        $sentencia = "SELECT *, pedido_rest.id AS ID 
        FROM pedido_rest 
        INNER JOIN inventario ON pedido_rest.id_producto = inventario.id WHERE pedido_rest.mov = $mov AND pedido_rest.pagado = 0 AND pedido_rest.pedido = 0 AND pedido_rest.estado = 1";
        $comentario="Mostrar los productos del pedido restaurente sin habitacion";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cont=0;
        $total=0;
        //echo '<tr class="fuente_menor text-center"> thead-light
        echo '<table class="fuente_menor table">
          <thead class="encabezado_gris">
            <tr class="text-center">
            <th scope="col">Cant</th>
            <th scope="col">Nombre</th>
            <th scope="col">Precio</th>
            <th>Subtotal</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Quitar</th>
            </tr>
          </thead>
          <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              $total=$total+($fila['precio']*$fila['cantidad']);
              $cont++;
              echo '<tr class="text-center">
              <th cope="row">'.$fila['cantidad'].'</th>
              <td>'.$fila['nombre'].'</td>
              <td>$'.number_format($fila['precio'], 2).'</td>
              <td>$'.number_format($fila['precio']*$fila['cantidad'], 2).'</td>';
              echo '<td><button class="btn btn-outline-warning btn-sm" onclick="eliminar_producto_restaurante('.$fila['ID'].','.$hab_id.','.$estado.','.$mov.')"> 🗑️</button></td>';
              echo '</tr>';
            } 
            echo '
          </tbody>
        </table>';
      }
      // Mostrar los productos del pedido restaurente sin habitacion
      function mostar_pedido_funciones($hab_id,$estado,$mov){
        if($hab_id != 0){
          include_once("clase_hab.php");
          $hab= NEW Hab($hab_id);
          $hab_nombre= $hab->nombre;
        }
        $cantidad= 0;
        $total= 0;
        $consulta= $this->total_productos($mov);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $cantidad+$fila['cantidad'];
          $total= $total+($fila['precio']*$fila['cantidad']);
        }

        echo '<div class="row margen_supa">'; 
          if($cantidad > 0){
            echo '<div class="col-sm-3">#Items: '.$cantidad.'</div> 
            <div class="col-sm-0"></div>';
            if($hab_id != 0){
              echo '<div class="col-sm-3">Habitación: '.$hab_nombre.'</div> 
              <div class="col-sm-0"></div>';
            } 
            echo '<div class="col-sm-3">Total: $'.number_format($total, 2).'</div> 
            <div class="col-sm-0"></div>
            <div class="col-sm-3"><button class="btn btn-danger btn-block"  href="#caja_herramientas" data-toggle="modal" onclick="pedir_rest_cobro('.$total.','.$hab_id.','.$estado.','.$mov.')"> Pedir</button></></div>
            <div class="col-sm-0"></div>';                 
          }else{
            echo '<div class="col-sm-12"></div>'; 
          }
        echo '</div>'; 
      }
      // Obtengo el total de productos del pedido restaurente
      function total_productos($mov){
        $cantidad=0;
        $sentencia = "SELECT *, pedido_rest.id AS ID  
        FROM pedido_rest 
        INNER JOIN inventario ON pedido_rest.id_producto = inventario.id WHERE pedido_rest.mov = $mov AND pedido_rest.pagado = 0 AND pedido_rest.pedido = 0 AND pedido_rest.estado = 1";
        //echo $sentencia;
        $comentario="Obtengo el total de productos del pedido restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Eliminar un producto al pedido de restaurante
      function eliminar_producto_apedido($id){
        $sentencia = "UPDATE `pedido_rest` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Eliminar un producto al pedido de restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener los datos del pedido restaurante cobrado
      function saber_pedido_rest_cobro($mov){
        $sentencia = "SELECT * FROM pedido_rest WHERE mov = $mov AND pagado = 0 AND pedido = 0 AND estado = 1";
        //echo $sentencia;
        $comentario="Obtener los datos del pedido restaurante cobrado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Cambiar el estado del pedido restaurante cobrado
      function cambiar_estado_pedido_cobro($mov){
        $sentencia = "UPDATE `pedido_rest` SET
        `pagado` = '1',
        `pedido` = '1'
        WHERE `mov` = $mov;";
        $comentario="Cambiar el estado del pedido restaurante cobrado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }

  }
?>