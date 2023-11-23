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
        <table class="table">
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
                <td><button class="btn btn-primary" onclick="mostrar_reporte_cargo_noche('.$fila['ID'].')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                        <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                        <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                      </svg>
                        Reporte
                    </button></td>
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
          <table class="table">
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
                  <td><button class="btn btn-primary" onclick="mostrar_reporte_cargo_noche('.$fila['ID'].')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                          <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                          <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                        </svg>
                      Reporte</button></td>
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
        $id = $id == 0 ? 1 : $id;
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