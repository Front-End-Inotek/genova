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
            <th>Descripción</th>
            <th>Categoría</th>
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
              <th>Descripción</th>
              <th>Categoría</th>
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
      // Mostramos los productos para poder surtir inventario
      function mostrar_surtir_inventario(){
        $cantidad= 0;
        $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
        FROM inventario 
        INNER JOIN categoria ON inventario.categoria = categoria.id WHERE inventario.estado = 1 ORDER BY categoria.id,inventario.nombre";
        $comentario="Mostramos los productos para poder surtir inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        echo '<div class="table-responsive" id="tabla_surtir_inventario">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Inventario</th>
            <th>Diferencia</th>
            <th>Faltante</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              $faltante= $fila['stock'] - $fila['inventario'];
              if($faltante <= 0){
                $faltante= 0;
              }
              $cantidad++;
              echo '<tr class="text-center">
              <td>'.$fila['nom'].'</td>
              <td>'.$fila['categoria'].'</td>
              <td>'.$fila['stock'].'</td>
              <td>'.$fila['inventario'].'</td>
              <td>'.$faltante.'</td>
              <td><input type="nombre" class="color_black" value = "'.$faltante.'" id="cantidad'.$fila['ID'].'"></td>
              <td><button class="btn btn-success" onclick="inventario_surtir_producto('.$fila['ID'].')"> Guardar</button></td>
              </tr>';
            }
            echo '
            </tbody>
          </table>
          </div>';
      }
      // Barra de diferentes busquedas en ver inventario surtir
      function buscar_surtir_inventario($a_buscar){
        $cantidad= 0;
        $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
        FROM inventario 
        INNER JOIN categoria ON inventario.categoria = categoria.id WHERE (inventario.nombre LIKE '%$a_buscar%' || inventario.descripcion LIKE '%$a_buscar%' || categoria.nombre LIKE '%$a_buscar%' || inventario.clave LIKE '%$a_buscar%') && inventario.estado = 1 ORDER BY categoria.id,inventario.nombre";
        $comentario="Mostrar diferentes busquedas en ver inventario surtir";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_surtir_inventario">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Inventario</th>
            <th>Diferencia</th>
            <th>Faltante</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              $faltante= $fila['stock'] - $fila['inventario'];
              if($faltante <= 0){
                $faltante= 0;
              }
              $cantidad++;
              echo '<tr class="text-center">
              <td>'.$fila['nom'].'</td>
              <td>'.$fila['categoria'].'</td>
              <td>'.$fila['stock'].'</td>
              <td>'.$fila['inventario'].'</td>
              <td>'.$faltante.'</td>
              <td><input type="nombre" class="color_black" value = "'.$faltante.'" id="cantidad'.$fila['ID'].'"></td>
              <td><button class="btn btn-success" onclick="inventario_surtir_producto('.$fila['ID'].')"> Guardar</button></td>
              </tr>';
            }
            echo '
            </tbody>
          </table>
          </div>';
      }
      // Mostrar diferentes categorias en ver inventario surtir
      function mostrar_surtir_categoria($categoria){
        include_once("clase_surtir.php");
        $surtir = NEW Surtir(0);
        $cantidad= 0;

        if($categoria==0){
          $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
          FROM inventario 
          INNER JOIN categoria ON inventario.categoria = categoria.id WHERE inventario.estado = 1 ORDER BY categoria.id,inventario.nombre";
        }else{
          $sentencia = "SELECT *,inventario.id AS ID,inventario.nombre AS nom,categoria.nombre AS categoria
          FROM inventario 
          INNER JOIN categoria ON inventario.categoria = categoria.id WHERE categoria.id = $categoria && inventario.estado = 1 ORDER BY categoria.id,inventario.nombre";
        }
        $comentario="Mostrar diferentes categorias en ver inventario surtir";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="row">
          <div class="col-sm-2">
            <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_surtir_inventario()" class="color_black form-control form-control" autofocus="autofocus"/>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <select class="form-control-lg" id="categoria" onchange="mostrar_surtir_categoria()">';
                if($categoria==0){
                  echo '<option value="0" selected>Todos</option>';
                }else{
                  echo '<option value="0" selected>Todos</option>';
                  $this->categoria_surtir_valor($categoria);
                }
              echo '</select>
            </div>
          </div>
          <div class="col-sm-8"></div>
        </div><br>';
        
        echo '<div class="row">
          <div class="col-sm-8">';
            echo '<div class="table-responsive" id="tabla_surtir_inventario">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Inventario</th>
                <th>Diferencia</th>
                <th>Faltante</th>
                <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
                </tr>
              </thead>
            <tbody>';
                while ($fila = mysqli_fetch_array($consulta))
                {
                  $faltante= $fila['stock'] - $fila['inventario'];
                  if($faltante <= 0){
                    $faltante= 0;
                  }
                  $cantidad++;
                  echo '<tr class="text-center">
                  <td>'.$fila['nom'].'</td>
                  <td>'.$fila['categoria'].'</td>
                  <td>'.$fila['stock'].'</td>
                  <td>'.$fila['inventario'].'</td>
                  <td>'.$faltante.'</td>
                  <td><input type="nombre" class="color_black" value = "'.$faltante.'" id="cantidad'.$fila['ID'].'"></td>
                  <td><button class="btn btn-success" onclick="inventario_surtir_producto('.$fila['ID'].')"> Guardar</button></td>
                  </tr>';
                }
                echo '
                </tbody>
              </table>
            </div>
          </div>
          
          <div class="col-sm-4" id="a_surtir">';
            $surtir->mostrar_a_surtir();
          echo  '</div>
        </div>
        </div>';
      }
      // Mostrar las categorias del inventario
      function categoria_surtir(){
        $sentencia = "SELECT * FROM categoria ORDER BY nombre";
        $comentario="Mostrar las categorias del inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
      }
      // Obtengo el valor de las categoria seleccionada
      function categoria_surtir_valor($categoria){
        $sentencia = "SELECT * FROM categoria ORDER BY nombre";
        $comentario="Obtengo el valor de las categoria seleccionada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['id']==$categoria){
            echo '<option value="'.$fila['id'].'" selected>'.$fila['nombre'].'</option>';
          }else{
            echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
          }
        }
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
      function mostar_producto_busqueda($busqueda,$hab_id,$estado,$mov,$mesa){
        $sentencia = "SELECT * FROM inventario WHERE nombre LIKE '%$busqueda%' ORDER BY categoria, nombre";
        $comentario="Busqueda de cualquier producto en el inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $categoria= 0;
        $cunt= 0;
        echo '<div class="row">';
          $cont=0;
          while ($fila = mysqli_fetch_array($consulta))
          {
            if($cunt%3==0){
              //echo '<div class="col-sm-4"><button type="button" class="btn btn-success btn-block" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
              echo $fila['nombre'];
              echo'</button></div>';
              $cunt=0;
            }elseif($cunt%2==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
              echo $fila['nombre'];
              echo'</button></div>';
            }else{
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
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
      function mostrar_producto_restaurente($categoria,$hab_id,$estado,$mov,$mesa){
        $sentencia = "SELECT * FROM inventario WHERE categoria = $categoria ORDER BY nombre";
        $comentario="Mostrar los productos por restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cunt=0;

        echo '<div class="row">';
          $cont=0;
          while ($fila = mysqli_fetch_array($consulta))
          {
            if($cunt%3==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
              echo $fila['nombre'];
              echo'</button></div>';
              $cunt=0;
            }elseif($cunt%2==0){
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
              echo $fila['nombre'];
              echo'</button></div>';
            }else{
              echo '<div class="col-sm-2 margen_inf"><button type="button" class="btn btn-info btn-square-md" onclick="cargar_producto_restaurante('.$fila['id'].','.$categoria.','.$hab_id.','.$estado.','.$mov.','.$mesa.')">';
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
      public $id_mesa;
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
          $this->id_mesa= 0;
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
            $this->id_mesa= $fila['id_mesa'];
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
          include_once("clase_movimiento.php");
          include_once("clase_ticket.php");
          $movimiento= NEW Movimiento(0);
          $labels= NEW Labels(0);

          if($mov != 0){
            $id_mesa= $movimiento->saber_id_mesa($mov);
          }else{
            $id_mesa= 0;
          }
          $sentencia = "INSERT INTO `pedido_rest` ( `mov`, `id_mesa`, `id_producto`, `cantidad`, `pagado`, `pedido`, `estado`)
          VALUES ('$mov', '$id_mesa', '$producto', '1', '0', '0', '1');";
          $comentario="Agregar un producto al pedido de restaurante";
          $consulta= $this->realizaConsulta($sentencia,$comentario);

          $comanda= $this->ultima_insercion();
          $labels->actualizar_comanda($comanda);
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
      // Obtener el estado del producto del pedido de restaurante
      function saber_pedido($mov,$producto){
        $sentencia = "SELECT * FROM pedido_rest WHERE mov = $mov AND id_producto = $producto AND pagado = 0 AND pedido = 0 AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtener el estado del producto del pedido de restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $pedido=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $pedido=$fila['id'];
        }
        return $pedido;
      }
      // Obtener la cantidad de un producto de un pedido restaurante
      function saber_cantidad_pedido($pedido){
        $sentencia = "SELECT cantidad FROM pedido_rest WHERE id = $pedido AND pagado = 0 AND pedido = 0 AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtener la cantidad de un producto de un pedido restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cantidad=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad=$fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostrar los productos del pedido restaurente sin habitacion
      function mostar_pedido($hab_id,$estado,$mov,$mesa){
        $sentencia = "SELECT *, pedido_rest.id AS ID 
        FROM pedido_rest 
        INNER JOIN inventario ON pedido_rest.id_producto = inventario.id WHERE pedido_rest.mov = $mov AND pedido_rest.pagado = 0 AND pedido_rest.pedido = 0 AND pedido_rest.estado = 1";
        $comentario="Mostrar los productos del pedido restaurente sin habitacion";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cont=0;
        $total=0;
        //echo '<tr class="fuente_menor text-center"> thead-light
        echo '<table class="fuente_menor margen_sup table">
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
              <td>'.$fila['cantidad'].'</td>
              <td>'.$fila['nombre'].'</td>
              <td>$'.number_format($fila['precio'], 2).'</td>
              <td>$'.number_format($fila['precio']*$fila['cantidad'], 2).'</td>';
              echo '<td><button class="btn btn-outline-warning btn-sm" onclick="eliminar_producto_restaurante('.$fila['ID'].','.$hab_id.','.$estado.','.$mov.','.$mesa.')"> 🗑️</button></td>';
              echo '</tr>';
            } 
            echo '
          </tbody>
        </table>';
      }
      // Mostrar los productos del pedido restaurente habitacion
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

        echo '<div class="row">'; 
          if($cantidad > 0){
            if($hab_id != 0){
              echo '<div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">#Items: '.$cantidad.'</div> 
              <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">Habitación: '.$hab_nombre.'</div>';
            }else{
              echo '<div class="col-sm-3"></div>
              <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">#Items: '.$cantidad.'</div>';
            } 
            echo '<div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">Total: $'.number_format($total, 2).'</div> 
            <div class="col-sm-3"><button class="btn btn-danger btn-rectangle-sm"  href="#caja_herramientas" data-toggle="modal" onclick="pedir_rest_cobro('.$total.','.$hab_id.','.$estado.','.$mov.')">Pedir</button></></div>';                 
          }else{
            echo '<div class="col-sm-12"></div>'; 
          }
        echo '</div>'; 
      }
      // Mostrar los productos del pedido restaurente mesa
      function mostar_pedido_funciones_mesa($mesa_id,$estado,$mov){
        if($mesa_id != 0){
          include_once("clase_mesa.php");
          $mesa= NEW Mesa($mesa_id);
          $mesa_nombre= $mesa->nombre;
        }
        $cantidad= 0;
        $total= 0;
        $consulta= $this->total_productos($mov);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $cantidad+$fila['cantidad'];
          $total= $total+($fila['precio']*$fila['cantidad']);
        }

        echo '<div class="row">'; 
          if($cantidad > 0){
            if($mesa_id != 0){
              echo '<div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">#Items: '.$cantidad.'</div> 
              <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">Mesa: '.$mesa_nombre.'</div>';
            }else{
              echo '<div class="col-sm-3"></div>
              <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">#Items: '.$cantidad.'</div>';
            } 
            echo '<div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">Total: $'.number_format($total, 2).'</div> 
            <div class="col-sm-3"><button class="btn btn-danger btn-rectangle-sm"  href="#caja_herramientas" data-toggle="modal" onclick="pedir_rest_cobro('.$total.','.$mesa_id.','.$estado.','.$mov.')">Pedir</button></></div>';                 
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
      // Obtener la ultimo pedido restaurante ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM pedido_rest ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo pedido restaurante ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
      // Obtener el pedido restaurante para guardarlo en el ticket
      function saber_comanda($mov){
        $sentencia = "SELECT id FROM pedido_rest WHERE mov = $mov AND estado = 1 ORDER BY id DESC LIMIT 1";
        //echo $sentencia;
        $comentario="Obtener el pedido restaurante para guardarlo en el ticket";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $comanda= 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $comanda=$fila['id'];
        }
        return $comanda;
      }

  }
  /**
  *
  */
  class Pedido extends ConexionMYSql
  {    
      public $id;
      public $mov;
      public $id_hab;
      public $id_mesa;
      public $tiempo;
      public $comentarios;
      public $impreso;
      public $recepcion;
      public $estado;

      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->mov= 0;
          $this->id_hab= 0;
          $this->id_mesa= 0;
          $this->tiempo= 0;
          $this->comentarios= 0;
          $this->impreso= 0;
          $this->recepcion= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM pedido WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores del pedido";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $this->id= $fila['id'];
            $this->mov= $fila['mov'];
            $this->id_hab= $fila['id_hab'];
            $this->id_mesa= $fila['id_mesa'];
            $this->tiempo= $fila['tiempo'];
            $this->comentarios= $fila['comentarios'];
            $this->impreso= $fila['impreso'];
            $this->recepcion= $fila['recepcion'];
            $this->estado= $fila['estado'];             
          }
        }
      }
      // Agregar un producto al pedido de restaurante
      function agregar_producto_apedido($hab_id,$estado,$producto,$mov){
        $pedido=$this->saber_pedido($mov,$producto);
        //
      }

  }
?>