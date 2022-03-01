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
        $sentencia = "SELECT count(id) AS cantidad FROM surtir_inventario WHERE estado = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de surtir";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los reportes de surtir inventario
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->surtir_editar;
        $borrar = $usuario->surtir_borrar;

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

      // Busqueda por fecha en ver reportes de cargos de noche
      function mostrar_cargo_noche_fecha($fecha_ini_tiempo,$fecha_fin_tiempo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);
        $fecha_cargo_noche=time();

        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar();
        }else{
          $sentencia = "SELECT *,cargo_noche.id AS ID 
          FROM cargo_noche 
          INNER JOIN usuario ON cargo_noche.id_usuario = usuario.id WHERE cargo_noche.fecha >= $fecha_ini && cargo_noche.fecha <= $fecha_fin && cargo_noche.fecha > 0 && cargo_noche.estado = 1 ORDER BY cargo_noche.id DESC";
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
                  <td>'.$fila['ID'].'</td> 
                  <td>'.$fila['usuario'].'</td>
                  <td>$'.number_format($fila['total'], 2).'</td>
                  <td>'.date("d-m-Y",$fila['fecha']).'</td>
                  <td><button class="btn btn-success" onclick="mostrar_reporte_cargo_noche('.$fila['ID'].')"> Reporte</button></td>
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