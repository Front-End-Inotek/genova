<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Corte extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $fecha;
      public $etiqueta;
      public $total;
      public $efectivo;
      public $tarjeta;
      public $forma_pago_tres;
      public $forma_pago_cuatro;
      public $forma_pago_cinco;
      public $forma_pago_seis;
      public $forma_pago_siete;
      public $forma_pago_ocho;
      public $forma_pago_nueve;
      public $forma_pago_diez;
      public $descuento;
      public $cantidad_habitaciones;
      public $total_habitaciones;
      public $restaurante;
      //public $personas;
      public $tiket_ini;
      public $tiket_fin;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->fecha= 0;
          $this->etiqueta= 0;
          $this->total= 0;
          $this->efectivo= 0;
          $this->tarjeta= 0;
          $this->forma_pago_tres= 0;
          $this->forma_pago_cuatro= 0;
          $this->forma_pago_cinco= 0;
          $this->forma_pago_seis= 0;
          $this->forma_pago_siete= 0;
          $this->forma_pago_ocho= 0;
          $this->forma_pago_nueve= 0;
          $this->forma_pago_diez= 0;
          $this->descuento= 0;
          $this->cantidad_habitaciones= 0;
          $this->total_habitaciones= 0;
          $this->restaurante= 0;
          $this->tiket_ini= 0;
          $this->tiket_fin= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM corte WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->fecha= $fila['fecha'];
              $this->etiqueta= $fila['etiqueta'];
              $this->total= $fila['total'];
              $this->efectivo= $fila['efectivo'];
              $this->tarjeta= $fila['tarjeta'];
              $this->forma_pago_tres= $fila['forma_pago_tres'];
              $this->forma_pago_cuatro= $fila['forma_pago_cuatro'];
              $this->forma_pago_cinco= $fila['forma_pago_cinco'];
              $this->forma_pago_seis= $fila['forma_pago_seis'];
              $this->forma_pago_siete= $fila['forma_pago_siete'];
              $this->forma_pago_ocho= $fila['forma_pago_ocho'];
              $this->forma_pago_nueve= $fila['forma_pago_nueve'];
              $this->forma_pago_diez= $fila['forma_pago_diez'];
              $this->descuento= $fila['descuento'];
              $this->cantidad_habitaciones= $fila['cantidad_habitaciones'];
              $this->total_habitaciones= $fila['total_habitaciones'];
              $this->restaurante= $fila['restaurante'];
              $this->tiket_ini= $fila['tiket_ini'];
              $this->tiket_fin= $fila['tiket_fin'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el corte
      function guardar_corte($id_usuario,$nueva_etiqueta,$total,$efectivo,$tarjeta,$forma_pago_tres,$forma_pago_cuatro,$forma_pago_cinco,$forma_pago_seis,$forma_pago_siete,$forma_pago_ocho,$forma_pago_nueve,$forma_pago_diez,$cantidad_habitaciones,$total_habitaciones,$restaurante,$ticket_inicial,$ticket_final){
        $fecha=time();
        $sentencia = "INSERT INTO `corte` (`id_usuario`, `fecha`, `etiqueta`, `total`, `efectivo`, `tarjeta`, `forma_pago_tres`, `forma_pago_cuatro`, `forma_pago_cinco`, `forma_pago_seis`, `forma_pago_siete`, `forma_pago_ocho`, `forma_pago_nueve`, `forma_pago_diez`, `descuento`, `cantidad_habitaciones`, `total_habitaciones`, `restaurante`, `tiket_ini`, `tiket_fin`, `estado`)
        VALUES ('$id_usuario', '$fecha', '$nueva_etiqueta', '$total', '$efectivo', '$tarjeta', '$forma_pago_tres', '$forma_pago_cuatro', '$forma_pago_cinco', '$forma_pago_seis', '$forma_pago_siete', '$forma_pago_ocho', '$forma_pago_nueve', '$forma_pago_diez', '0', '$cantidad_habitaciones', '$total_habitaciones', '$restaurante', '$ticket_inicial', '$ticket_final', '1');";
        $comentario="Guardamos el surtir_inventario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);     
        
        $id= $this->ultima_insercion();
        return $id;
      }
      // Obtengo el total de reportes de surtir inventario
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM surtir_inventario WHERE estado = 1 ORDER BY id";
        //echo $sentencia;
        $comentario="Obtengo el total de reportes de surtir inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los reportes de surtir inventario
      function mostrar($posicion,$id){
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

        $sentencia = "SELECT *,surtir_inventario.id AS ID
        FROM surtir_inventario 
        INNER JOIN usuario ON surtir_inventario.id_usuario = usuario.id WHERE surtir_inventario.estado = 1 ORDER BY surtir_inventario.id DESC";
        $comentario="Mostrar los reportes de surtir inventario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_surtir_inventario">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Número</th>
            <th>Nombre Surtió</th>
            <th>Fecha</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ver</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['ID'].'</td> 
                <td>'.$fila['usuario'].'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td><button class="btn btn-success" onclick="reporte_surtir_inventario('.$fila['ID'].')"> Reporte</button></td>
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
      // Busqueda por fecha en ver reportes de surtir inventario
      function mostrar_surtir_fecha($fecha_ini_tiempo,$fecha_fin_tiempo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);

        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar();
        }else{
          $sentencia = "SELECT *,surtir_inventario.id AS ID
          FROM surtir_inventario 
          INNER JOIN usuario ON surtir_inventario.id_usuario = usuario.id WHERE surtir_inventario.fecha >= $fecha_ini && surtir_inventario.fecha <= $fecha_fin && surtir_inventario.fecha > 0 && surtir_inventario.estado = 1 ORDER BY surtir_inventario.id DESC";
          $comentario="Mostrar por fecha los reportes de surtir inventario";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_surtir_inventario">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Número</th>
              <th>Nombre Surtió</th>
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
                  <td>'.date("d-m-Y",$fila['fecha']).'</td>
                  <td><button class="btn btn-success" onclick="reporte_surtir_inventario('.$fila['ID'].')"> Reporte</button></td>
                  </tr>';
              }
              echo '
            </tbody>
          </table>
          </div>';
        }
      }
      // Obtener el ultimo corte ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM corte ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo corte ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
              
  }
?>