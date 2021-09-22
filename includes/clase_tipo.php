<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tipo extends ConexionMYSql{

      public $id;
      public $nombre;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM tipo_hab WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de tipo habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el tipo habitacion
      function guardar_tipo($nombre){
        $sentencia = "INSERT INTO `tipo_hab` (`nombre`, `estado`)
        VALUES ('$nombre', '1');";
        $comentario="Guardamos el tipo habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Obtengo los datos de una herramienta //
       function datos_herramienta(){
        $sentencia = "SELECT * FROM herramienta WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los datos de tipos habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo el total de tipos habitaciones
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad  FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de tipos habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los tipos habitaciones
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->herramienta_editar;
        $borrar = $usuario->herramienta_borrar;

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

        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las herramientas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_herramienta">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>';
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
                <td>'.$fila['nombre'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-info btn-lg" onclick="editar_herramienta('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_herramienta('.$fila['id'].')"> Borrar</button></td>';
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
      // Barra de busqueda en ver herramientas
      function buscar($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->herramienta_editar;
        $borrar = $usuario->herramienta_borrar;
        
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM herramienta WHERE (nombre LIKE '%$a_buscar%' || marca LIKE '%$a_buscar%' || modelo LIKE '%$a_buscar%' || descripcion LIKE '%$a_buscar%') AND estado = 1 ORDER BY nombre";
          $comentario="Mostrar diferentes busquedas en ver clientes"; 
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo ' 
            <div class="table-responsive" id="tabla_inventario">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Nombre</th> 
                <th>Marca</th>
                <th>Modelo</th>
                <th>Descripcion</th>
                <th>Cantidad en Almacen</th>
                <th>Cantidad Prestadas</th>';
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
                  <td>'.$fila['marca'].'</td>
                  <td>'.$fila['modelo'].'</td>
                  <td>'.$fila['descripcion'].'</td>  
                  <td>'.$fila['cantidad_almacen'].'</td>
                  <td>'.$fila['cantidad_prestadas'].'</td>';
                  if($editar==1){
                    echo '<td><button class="btn btn-outline-info btn-lg" onclick="editar_herramienta('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                  }
                  if($borrar==1){
                    echo '<td><button class="btn btn-outline-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_herramienta('.$fila['id'].')"> Borrar</button></td>';
                  }
                echo '</tr>';
                }
        }
              echo '
              </tbody>
            </table>
            </div>';
      }
      // Editar una herramienta
      function editar_herramienta($id,$nombre,$marca,$modelo,$descripcion,$cantidad_almacen,$cantidad_prestadas){
        $sentencia = "UPDATE `herramienta` SET
            `nombre` = '$nombre',
            `marca` = '$marca',
            `modelo` = '$modelo',
            `descripcion` = '$descripcion',
            `cantidad_almacen` = '$cantidad_almacen',
            `cantidad_prestadas` = '$cantidad_prestadas'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar herramienta dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una herramienta
      function borrar_herramienta($id){
        $sentencia = "UPDATE `herramienta` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de herramienta como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre de la herramienta
      function nombre_herramienta($id){
        $sentencia = "SELECT nombre FROM herramienta WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el nombre de la herramienta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      } 
             
  }
   /**
  *
  */
  class Caja_herramienta extends ConexionMYSql
  {    
      public $id;
      public $id_herramienta;
      public $id_usuario;
      public $cantidad;
      public $fecha_asignar;
      public $entregado;
      public $estado;

      // Constructor
      function __construct($id)
      {
          if($id==0){
            $this->id= 0;
            $this->id_herramienta= 0;
            $this->id_usuario= 0;
            $this->cantidad= 0;
            $this->fecha_asignar= 0;
            $this->entregado= 0;
            $this->estado= 0;
          }else{
            $sentencia = "SELECT * FROM caja_herramienta WHERE id = $id LIMIT 1 ";
            $comentario="Obtener todos los valores de caja herramienta";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
            while ($fila = mysqli_fetch_array($consulta))
            {
                $this->id= $fila['id'];
                $this->id_herramienta= $fila['id_herramienta'];
                $this->id_usuario= $fila['id_usuario'];
                $this->cantidad= $fila['cantidad'];
                $this->fecha_asignar= $fila['fecha_asignar'];
                $this->entregado= $fila['entregado'];
                $this->estado= $fila['estado'];
            }
        }
      }
      // Mostrar las herramientas que tiene la caja de herramientas del usuario
      function mostrar_caja_herramientas($herramienta_id){
        $sentencia = "SELECT caja_herramienta.id,caja_herramienta.id_herramienta,caja_herramienta.id_usuario,caja_herramienta.cantidad,caja_herramienta.fecha_asignar,caja_herramienta.estado,herramienta.nombre,herramienta.marca,herramienta.modelo,herramienta.descripcion,usuario.usuario
        FROM caja_herramienta
        INNER JOIN  herramienta ON caja_herramienta.id_herramienta =  herramienta.id
        INNER JOIN  usuario ON caja_herramienta.id_usuario =  usuario.id WHERE caja_herramienta.id_usuario = $herramienta_id AND caja_herramienta.entregado = 0 ORDER BY herramienta.nombre";
        $comentario="Mostrar las herramientas que tiene la caja de herramientas del usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_material_ver">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              <th>Cant.</th>
              <th>Nombre</th> 
              <th>Marca</th>
              <th>Modelo</th>
              <th>Descripcion</th>
              <th>Nombre Usuario</th>
              <th>Fecha Asignada</th>
            </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-outline-primary btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_entregar_herramienta('.$fila['id'].','.$fila['id_herramienta'].','.$fila['id_usuario'].')"> Entregar</button></td>
                <td>'.$fila['cantidad'].'</td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['marca'].'</td>
                <td>'.$fila['modelo'].'</td>
                <td>'.$fila['descripcion'].'</td>
                <td>'.$fila['usuario'].'</td>  
                <td>'.date("d-m-Y",$fila['fecha_asignar']).'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Mostrar las herramientas para asignar en caja herramientas
      function mostrar_asignar_herramienta($id_usuario,$usuario_id){
        echo '<div class="row">
              <div class="col-sm-12"><input type="text" placeholder="Buscar" onkeyup="buscar_asignar_herramienta('.$id_usuario.','.$usuario_id.')" id="a_buscar" class="color_black form-control-lg" autofocus="autofocus"/></div> 
        </div><br>';
        $sentencia = "SELECT * FROM herramienta WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las herramientas para asignar en caja herramientas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_herramienta">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th> 
              <th>Marca</th>
              <th>Modelo</th>
              <th>Descripcion</th>
              <th>Cantidad en Almacen</th>
              <th>Cantidad Prestadas</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-outline-primary btn-lg" onclick="aceptar_asignar_herramienta('.$fila['id'].','.$id_usuario.','.$usuario_id.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['marca'].'</td>
                <td>'.$fila['modelo'].'</td>
                <td>'.$fila['descripcion'].'</td>  
                <td>'.$fila['cantidad_almacen'].'</td>
                <td>'.$fila['cantidad_prestadas'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Busqueda de las herramientas para asignar en caja herramientas
      function buscar_asignar_herramienta($id_usuario,$usuario_id,$a_buscar){
        $sentencia = "SELECT * FROM herramienta WHERE (nombre LIKE '%$a_buscar%' || marca LIKE '%$a_buscar%' || modelo LIKE '%$a_buscar%' || descripcion LIKE '%$a_buscar%') AND estado = 1 ORDER BY nombre";
        $comentario="Mostrar las herramientas para asignar en caja herramientas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_herramienta">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th> 
              <th>Marca</th>
              <th>Modelo</th>
              <th>Descripcion</th>
              <th>Cantidad en Almacen</th>
              <th>Cantidad Prestadas</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-outline-primary btn-lg" onclick="aceptar_asignar_herramienta('.$fila['id'].','.$id_usuario.','.$usuario_id.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['marca'].'</td>
                <td>'.$fila['modelo'].'</td>
                <td>'.$fila['descripcion'].'</td>  
                <td>'.$fila['cantidad_almacen'].'</td>
                <td>'.$fila['cantidad_prestadas'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Mostrar las herramientas de entregar de herramienta salidas
      function mostrar_entregar_herramienta($usuario_id){
        $sentencia = "SELECT herramienta_salida.id,herramienta_salida.id_herramienta,herramienta_salida.cantidad,herramienta_salida.id_usuario,herramienta.nombre,herramienta.marca,herramienta.modelo,herramienta.descripcion
        FROM herramienta_salida 
        INNER JOIN  herramienta ON herramienta_salida.id_herramienta =  herramienta.id
        WHERE herramienta_salida.id_usuario = $usuario_id AND herramienta_salida.abierto = 0 AND herramienta_salida.estado = 1 AND herramienta_salida.pedido = 0 ORDER BY herramienta.nombre";
        $comentario="Mostrar las herramientas para la regreso";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_material_ver">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Cant.</th>
              <th>Nombre</th> 
              <th>Marca</th>
              <th>Modelo</th>
              <th>Descripcion</th>
            </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td>'.$fila['cantidad'].'</td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['marca'].'</td>
                <td>'.$fila['modelo'].'</td>
                <td>'.$fila['descripcion'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Aceptamos asignar herramienta en caja de herramienta
      function aceptar_asignar_herramienta($id_herramienta,$id_usuario,$usuario_id){
        $fecha_asignar=time();
        $sentencia = "INSERT INTO `caja_herramienta` (`id_herramienta`, `id_usuario`, `cantidad`, `fecha_asignar`, `entregado`, `estado`)
        VALUES ('$id_herramienta', '$id_usuario', '1', '$fecha_asignar', '0', '1');";
        $comentario="Asignar herramienta en caja de herramienta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        $sentencia2 = "SELECT cantidad_almacen, cantidad_prestadas FROM herramienta WHERE id = $id_herramienta AND estado = 1 LIMIT 1 ";
          $comentario2="Obtengo datos de la herramienta guardada";
          $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
          while ($fila2 = mysqli_fetch_array($consulta2))
          {
            $cantidad_almacen= $fila2['cantidad_almacen'];
            $cantidad_prestadas= $fila2['cantidad_prestadas'];
          }

          $almacen_cantidad = $cantidad_almacen - 1;
          $prestadas_cantidad = $cantidad_prestadas + 1;
        
          $sentencia3 = "UPDATE `herramienta` SET
          `cantidad_almacen` = '$almacen_cantidad',
          `cantidad_prestadas` = '$prestadas_cantidad'
          WHERE `id` = '$id_herramienta';";
          //echo $sentencia3 ;
          $comentario3="Editar cantidad en almacen y prestadas de la herramienta de la base de datos ";
          $consulta3= $this->realizaConsulta($sentencia3,$comentario3);


        include_once('clase_log.php');
          $logs = NEW Log(0);
          $sentencia = "SELECT id FROM caja_herramienta ORDER BY id DESC LIMIT 1";
          $comentario="Obtengo el id de la caja herramienta agregada";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $id= $fila['id'];
          }
          $logs->guardar_log($usuario_id,"Agregar en caja herramienta: ". $id);
      }
      // Entregamos herramienta en caja de herramienta
      function entregar_herramienta($id,$id_herramienta){
        $sentencia = "UPDATE `caja_herramienta` SET
        `entregado` = '1'
        WHERE `id` = '$id';";
        $comentario="Poner como si entregado la herramienta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        $sentencia2 = "SELECT cantidad_almacen, cantidad_prestadas FROM herramienta WHERE id = $id_herramienta AND estado = 1 LIMIT 1 ";
          $comentario2="Obtengo datos de la herramienta guardada";
          $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
          while ($fila2 = mysqli_fetch_array($consulta2))
          {
            $cantidad_almacen= $fila2['cantidad_almacen'];
            $cantidad_prestadas= $fila2['cantidad_prestadas'];
          }

          $almacen_cantidad = $cantidad_almacen + 1;
          $prestadas_cantidad = $cantidad_prestadas - 1;
        
          $sentencia3 = "UPDATE `herramienta` SET
          `cantidad_almacen` = '$almacen_cantidad',
          `cantidad_prestadas` = '$prestadas_cantidad'
          WHERE `id` = '$id_herramienta';";
          //echo $sentencia3 ;
          $comentario3="Editar cantidad en almacen y prestadas de la herramienta de la base de datos ";
          $consulta3= $this->realizaConsulta($sentencia3,$comentario3);
      }   
  
  }       
?>