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
      public $estado;
      // Constructor
      function __construct($id){
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
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el corte
      function guardar_corte($id_usuario,$nueva_etiqueta,$total,$efectivo,$tarjeta,$forma_pago_tres,$forma_pago_cuatro,$forma_pago_cinco,$forma_pago_seis,$forma_pago_siete,$forma_pago_ocho,$forma_pago_nueve,$forma_pago_diez,$cantidad_habitaciones,$total_habitaciones,$restaurante){
        $fecha=time();
        $sentencia = "INSERT INTO `corte` (`id_usuario`, `fecha`, `etiqueta`, `total`, `efectivo`, `tarjeta`, `forma_pago_tres`, `forma_pago_cuatro`, `forma_pago_cinco`, `forma_pago_seis`, `forma_pago_siete`, `forma_pago_ocho`, `forma_pago_nueve`, `forma_pago_diez`, `descuento`, `cantidad_habitaciones`, `total_habitaciones`, `restaurante`, `estado`)
        VALUES ('$id_usuario', '$fecha', '$nueva_etiqueta', '$total', '$efectivo', '$tarjeta', '$forma_pago_tres', '$forma_pago_cuatro', '$forma_pago_cinco', '$forma_pago_seis', '$forma_pago_siete', '$forma_pago_ocho', '$forma_pago_nueve', '$forma_pago_diez', '0', '$cantidad_habitaciones', '$total_habitaciones', '$restaurante', '0');";
        $comentario="Guardamos el surtir_inventario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      // Mostramos los reportes de cortes
      function mostrar(){
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        $inicio_dia= $inicio_dia + 86399;
        $fin_dia= $inicio_dia - 863989;// 7 - 604799
        $sentencia = "SELECT *,corte.etiqueta AS ID
        FROM corte
        INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE (corte.fecha >= $fin_dia && corte.fecha <= $inicio_dia) ORDER BY corte.etiqueta DESC";
        $comentario="Mostrar los reportes de cortes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_corte">
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
                <td><button class="btn btn-success" onclick="mostrar_reporte_corte('.$fila['ID'].')"> Reporte</button></td>
                </tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Busqueda por fecha en ver reportes de cortes
      function mostrar_corte_fecha($fecha_ini_tiempo,$fecha_fin_tiempo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);
        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar();
        }else{
          $sentencia = "SELECT *,corte.etiqueta AS ID
          FROM corte
          INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE corte.fecha >= $fecha_ini && corte.fecha <= $fecha_fin && corte.fecha > 0 ORDER BY corte.etiqueta DESC";
          $comentario="Mostrar por fecha los reportes de cortes";
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
              while ($fila = mysqli_fetch_array($consulta)){
                  echo '<tr class="text-center">
                  <td>'.$fila['ID'].'</td>
                  <td>'.$fila['usuario'].'</td>
                  <td>'.date("d-m-Y",$fila['fecha']).'</td>
                  <td>$'.number_format($fila['total'], 2).'</td>
                  <td><button class="btn btn-success" onclick="mostrar_reporte_corte('.$fila['ID'].')"> Reporte</button></td>
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
      // Obtener la ultima etiqueta ingresada
      function ultima_etiqueta(){
        $sentencia= "SELECT etiqueta FROM corte ORDER BY id DESC LIMIT 1";
        $etiqueta= 0;
        $comentario="Obtener la ultima etiqueta ingresada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $etiqueta= $fila['etiqueta'];
        }
        return $etiqueta;
      }
  }
?>