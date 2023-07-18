<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Cargo_noche extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $fecha;
      public $total;
      public $cantidad_hab;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->fecha= 0;
          $this->total= 0;
          $this->cantidad_hab= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM cargo_noche WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->fecha= $fila['fecha'];
              $this->total= $fila['total'];
              $this->cantidad_hab= $fila['cantidad_hab'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el cargo_noche
      function guardar_cargo_noche($id_usuario,$total,$cantidad_hab){
        $fecha=time();
        $sentencia = "INSERT INTO `cargo_noche` (`id_usuario`, `fecha`, `total`, `cantidad_hab`, `estado`)
        VALUES ('$id_usuario', '$fecha', '$total', '$cantidad_hab', '1');";
        $comentario="Guardamos el cargo noche en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostramos los reportes de cargos de noche
      function mostrar(){
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("d-m-Y");   
        $inicio_dia= strtotime($inicio_dia);
        $inicio_dia= $inicio_dia + 86399;
        $fin_dia= $inicio_dia - 604799;

        $sentencia = "SELECT *,cargo_noche.id AS ID 
        FROM cargo_noche 
        INNER JOIN usuario ON cargo_noche.id_usuario = usuario.id WHERE (cargo_noche.fecha >= $fin_dia && cargo_noche.fecha <= $inicio_dia) AND cargo_noche.estado = 1 ORDER BY cargo_noche.id DESC";
        $comentario="Mostrar los reportes de cargos de noche";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cargo_noche">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Número</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
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
                <td>$'.number_format($fila['total'], 2).'</td>
                <td><button class="btn btn-success" onclick="mostrar_reporte_cargo_noche('.$fila['ID'].')"> Reporte</button></td>
                </tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Busqueda por fecha en ver reportes de cargos de noche
      function mostrar_cargo_noche_fecha($fecha_ini_tiempo,$fecha_fin_tiempo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);

        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar();
        }else{
          $sentencia = "SELECT *,cargo_noche.id AS ID 
          FROM cargo_noche 
          INNER JOIN usuario ON cargo_noche.id_usuario = usuario.id WHERE cargo_noche.fecha >= $fecha_ini && cargo_noche.fecha <= $fecha_fin && cargo_noche.fecha > 0 && cargo_noche.estado = 1 ORDER BY cargo_noche.id DESC";
          $comentario="Mostrar por fecha los reportes de cargos de noche";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_cargo_noche">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Número</th>
              <th>Usuario</th>
              <th>Fecha</th>
              <th>Total</th>
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
                  <td>$'.number_format($fila['total'], 2).'</td>
                  <td><button class="btn btn-success" onclick="mostrar_reporte_cargo_noche('.$fila['ID'].')"> Reporte</button></td>
                  </tr>';
              }
              echo '
            </tbody>
          </table>
          </div>';
        }
      }
      // Obtener el ultimo cargo noche ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM cargo_noche ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo cargo noche ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
      
        // Obtener el ultimo cargo noche ingresado 
        function ultima_insercion_auto(){
          $sentencia= "SELECT `AUTO_INCREMENT` as id
          FROM  INFORMATION_SCHEMA.TABLES
          WHERE TABLE_SCHEMA = 'visit'
          AND   TABLE_NAME   = 'cargo_noche';";
          $id= 0;
          $comentario="Obtener el ultimo cargo noche ingresado";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $id= $fila['id'];
          }
          return $id;
        }        
  }
?>