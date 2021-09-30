<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Huesped extends ConexionMYSql{

      public $id;
      public $nombre;
      public $nombre_comercial;
      public $direccion;
      public $ciudad;
      public $estado;
      public $codigo_postal;
      public $telefono;
      public $correo;
      public $rfc;
      public $curp;
      public $estado_huesped;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->nombre_comercial= 0;
          $this->direccion= 0;
          $this->ciudad= 0;
          $this->estado= 0;
          $this->codigo_postal= 0;
          $this->telefono= 0;
          $this->correo= 0;
          $this->rfc= 0;
          $this->curp= 0;
          $this->estado_huesped= 0; 
        }else{
          $sentencia = "SELECT * FROM huesped WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de un huesped";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->nombre_comercial= $fila['nombre_comercial'];
              $this->direccion= $fila['direccion'];
              $this->ciudad= $fila['ciudad'];
              $this->estado= $fila['estado'];
              $this->codigo_postal= $fila['codigo_postal'];
              $this->telefono= $fila['telefono'];
              $this->correo= $fila['correo'];
              $this->rfc= $fila['rfc'];
              $this->curp= $fila['curp'];
              $this->estado_huesped= $fila['estado_huesped'];
          }
        }
      }
      // Guardar la reservacion
      function guardar_cliente($nombre,$nombre_comercial,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$rfc,$curp){
        $sentencia = "INSERT INTO `cliente` (`nombre`, `nombre_comercial`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `telefono`, `correo`, `rfc`, `curp`, `estado_cliente`)
        VALUES ('$nombre', '$nombre_comercial', '$direccion', '$ciudad', '$estado','$codigo_postal', '$telefono', '$correo', '$rfc', '$curp', '1');";
        $comentario="Guardamos el cliente en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);    
        
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM reservacion ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id de la reservacion agregada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar reservacion: ". $id);
      }
      // Obtengo el total de clientes
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad  FROM cliente WHERE estado_cliente = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de clientes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los clientes
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $agregar = $usuario->cliente_agregar;
        $editar = $usuario->cliente_editar;
        $borrar = $usuario->cliente_borrar;
    
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

        $sentencia = "SELECT * FROM cliente WHERE estado_cliente = 1 ORDER BY nombre";
        $comentario="Mostrar los clientes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cliente">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Nombre Comercial</th>
            <th>Direccion</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Codigo Postal</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>RFC</th>';
            if($editar==1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1){
              echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            if($agregar==1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Agregar</th>';
            }
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['nombre_comercial'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['rfc'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-outline-info btn-lg" onclick="editar_cliente('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-outline-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_cliente('.$fila['id'].')"> Borrar</button></td>';
                }
                if($agregar==1){
                  echo '<td><button class="btn btn-outline-primary btn-lg" onclick="agregar_plantas('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Planta</button></td>';
                }
                echo '<td><button class="btn btn-outline-primary btn-lg" onclick="ver_plantas('.$fila['id'].','.$id.')"><span class="glyphicon glyphicon-edit"></span> Planta</button></td>
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
      // Barra de diferentes busquedas en ver clientes
      function buscar_cliente($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $agregar = $usuario->cliente_agregar;
        $editar = $usuario->cliente_editar;
        $borrar = $usuario->cliente_borrar;

        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM cliente WHERE (nombre LIKE '%$a_buscar%' || nombre_comercial LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%') && estado_cliente = 1 ORDER BY nombre;";
          $comentario="Mostrar diferentes busquedas en ver clientes";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_cliente">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Nombre</th>
              <th>Nombre Comercial</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>RFC</th>';
              if($editar==1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
              }
              if($borrar==1){
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
              }
              if($agregar==1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Agregar</th>';
              }
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
              </tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)) 
              {
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['nombre_comercial'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['rfc'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-outline-info btn-lg" onclick="editar_cliente('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-outline-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_cliente('.$fila['id'].')"> Borrar</button></td>';
                }
                if($agregar==1){
                  echo '<td><button class="btn btn-outline-primary btn-lg" onclick="agregar_plantas('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Planta</button></td>';
                }
                echo '<td><button class="btn btn-outline-primary btn-lg" onclick="ver_plantas('.$fila['id'].','.$id.')"><span class="glyphicon glyphicon-edit"></span> Planta</button></td>
                </tr>';
              }
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar un cliente
      function editar_cliente($id,$nombre,$nombre_comercial,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$rfc,$curp){
        $sentencia = "UPDATE `cliente` SET
            `nombre` = '$nombre',
            `nombre_comercial` = '$nombre_comercial',
            `direccion` = '$direccion',
            `ciudad` = '$ciudad',
            `estado` = '$estado',
            `codigo_postal` = '$codigo_postal',
            `telefono` = '$telefono',
            `correo` = '$correo',
            `rfc` = '$rfc',
            `curp` = '$curp'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar cliente dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un cliente
      function borrar_cliente($id){
        $sentencia = "UPDATE `cliente` SET
        `estado_cliente` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de cliente como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
             
  }
?>