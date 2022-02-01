<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Cupon extends ConexionMYSql{

      public $id;
      public $codigo;
      public $descripcion;
      public $fecha;
      public $vigencia_inicio;
      public $vigencia_fin;
      public $cantidad;
      public $tipo;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->codigo= 0;
          $this->descripcion= 0;
          $this->fecha= 0;
          $this->vigencia_inicio= 0;
          $this->vigencia_fin= 0;
          $this->cantidad= 0;
          $this->tipo= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM cupon WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de un cupon";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->codigo= $fila['codigo'];
              $this->descripcion= $fila['descripcion'];
              $this->fecha= $fila['fecha'];
              $this->vigencia_inicio= $fila['vigencia_inicio'];
              $this->vigencia_fin= $fila['vigencia_fin'];
              $this->cantidad= $fila['cantidad'];
              $this->tipo= $fila['tipo'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el cupon
      function guardar_cupon($vigencia_inicio,$vigencia_fin,$codigo,$descripcion,$cantidad,$tipo,$usuario_id){
        $fecha= time();
        $vigencia_inicio= strtotime($vigencia_inicio);
        $vigencia_fin= strtotime($vigencia_fin);
        $sentencia = "INSERT INTO `cupon` (`codigo`, `descripcion`, `fecha`, `vigencia_inicio`, `vigencia_fin`, `cantidad`, `tipo`, `estado`)
        VALUES ('$codigo', '$descripcion', '$fecha', '$vigencia_inicio', '$vigencia_fin', '$cantidad', '$tipo', '1');";
        $comentario="Guardamos el cupon en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);    
        
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM cupon ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id del cupon agregado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar cupon: ". $id);
      }
      // Obtengo el total de cupones
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM cupon WHERE estado = 1 ORDER BY id";
        //echo $sentencia;
        $comentario="Obtengo el total de cupones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los cupones
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->cupon_editar;
        $borrar = $usuario->cupon_borrar;
    
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

        $sentencia = "SELECT * FROM cupon WHERE estado = 1 ORDER BY id";
        $comentario="Mostrar los cupones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cupon">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Número</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Creación</th>
            <th>Vigencia Inicio</th>
            <th>Vigencia Fin</th>
            <th>Cantidad</th>
            <th>Tipo Descuento</th>';
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
                <td>'.$fila['id'].'</td>  
                <td>'.$fila['codigo'].'</td>
                <td>'.$fila['descripcion'].'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td>'.date("d-m-Y",$fila['vigencia_inicio']).'</td>
                <td>'.date("d-m-Y",$fila['vigencia_fin']).'</td>';
                if($fila['tipo'] == 0){
                  echo '<td>'.$fila['cantidad'].'%</td>';
                  echo '<td>Porcentaje</td>';
                }else{
                  echo '<td>$'.number_format($fila['cantidad'], 2).'</td>';
                  echo '<td>Dinero</td>';
                }
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_cupon('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_cupon('.$fila['id'].')"> Borrar</button></td>';
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
      // Barra de diferentes busquedas en ver huespedes
      function buscar_huesped($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->huesped_editar;
        $borrar = $usuario->huesped_borrar;

        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%' || telefono LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
          $comentario="Mostrar diferentes busquedas en ver huespedes";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Dirección</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Código Postal</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>';
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
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_huesped('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
              }
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar un cupon
      function editar_cupon($id,$vigencia_inicio,$vigencia_fin,$codigo,$descripcion,$cantidad,$tipo){
        $vigencia_inicio= strtotime($vigencia_inicio);
        $vigencia_fin= strtotime($vigencia_fin);
        $sentencia = "UPDATE `cupon` SET
            `codigo` = '$codigo',
            `descripcion` = '$descripcion',
            `vigencia_inicio` = '$vigencia_inicio',
            `vigencia_fin` = '$vigencia_fin',
            `cantidad` = '$cantidad',
            `tipo` = '$tipo'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar cupon dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un cupon
      function borrar_cupon($id){
        $sentencia = "UPDATE `cupon` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de cupon como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el id del cupon
      function obtengo_id($codigo){
        $id= 0;
        $sentencia = "SELECT id FROM cupon WHERE codigo = '$codigo' AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el id del cupon";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
      // Obtengo el nombre completo del huesped
      function obtengo_nombre_completo($id){
        $sentencia = "SELECT nombre,apellido FROM huesped WHERE id = $id AND estado_huesped = 1 LIMIT 1";
        //echo $sentencia;
        $nombre_completo= '';
        $comentario="Obtengo el nombre completo del huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
          $apellido= $fila['apellido'];
          $nombre_completo= $nombre.' '.$apellido;
        }
        return $nombre_completo;
      }
      // Mostrar las huespedes para asignar en una reservacion
      function mostrar_asignar_huesped($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil){
        echo '<div class="row">
              <div class="col-sm-12"><input type="text" placeholder="Buscar" onkeyup="buscar_asignar_huesped('.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')" id="a_buscar" class="color_black form-control-lg" autofocus="autofocus"/></div> 
        </div><br>';
        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC,id DESC LIMIT 30";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY id DESC LIMIT 15";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC LIMIT 15";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-success" onclick="aceptar_asignar_huesped('.$fila['id'].','.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Busqueda de los huespedes para asignar en una reservacion
      function buscar_asignar_huesped($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil,$a_buscar){
        $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%' || telefono LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-success" onclick="aceptar_asignar_huesped('.$fila['id'].','.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Agregamos las visitas correspondientes al checkin realizado
      function modificar_visitas($id,$cantidad_visitas){
        $sentencia = "UPDATE `huesped` SET
        `visitas` = '$cantidad_visitas'
        WHERE `id` = '$id';";
        $comentario="Agregamos las visitas correspondientes al checkin realizado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
             
  }
?>