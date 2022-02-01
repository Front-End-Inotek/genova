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
      // Barra de diferentes busquedas en ver cupones
      function buscar_cupon($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->cupon_editar;
        $borrar = $usuario->cupon_borrar;

        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM cupon WHERE (id LIKE '%$a_buscar%' || codigo LIKE '%$a_buscar%' || descripcion LIKE '%$a_buscar%') && estado = 1 ORDER BY id DESC;";
          $comentario="Mostrar diferentes busquedas en ver cupones";
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
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Busqueda por fecha en ver cupones
      function mostrar_cupon_fecha($fecha_ini_tiempo,$fecha_fin_tiempo,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->cupon_editar;
        $borrar = $usuario->cupon_borrar;
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);

        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM cupon WHERE vigencia_inicio >= $fecha_ini && vigencia_inicio <= $fecha_fin && vigencia_inicio > 0 && estado = 1 ORDER BY id DESC;";
          $comentario="Mostrar por fecha en ver cupones";
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
             
  }
?>