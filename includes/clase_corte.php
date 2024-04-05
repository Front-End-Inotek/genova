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
        $registrosPorPagina = 10;
        
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        $inicio_dia= $inicio_dia + 86399;
        $fin_dia= $inicio_dia - 863989;// 7 - 604799

        $resultado=$sentencia = "SELECT COUNT(*) as total ,corte.etiqueta AS ID
        FROM corte
        INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE (corte.fecha >= $fin_dia && corte.fecha <= $inicio_dia) ORDER BY corte.etiqueta DESC";
        $comentario="numero de cortes";
        $consulta= $this->realizaConsulta($resultado,$comentario);
        $fila = $consulta->fetch_assoc();
        $totalRegistros = $fila['total'];
        // Calcular el número total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        // Obtener el número de página actual
        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        // Calcular el índice inicial del primer registro en la página actual
        $indiceInicial = ($paginaActual - 1) * $registrosPorPagina;
        
        $sentencia = "SELECT *,corte.etiqueta AS ID
        FROM corte
        INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE (corte.fecha >= $fin_dia && corte.fecha <= $inicio_dia) ORDER BY corte.etiqueta DESC LIMIT $indiceInicial, $registrosPorPagina";
        $comentario="Mostrar los reportes de cortes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_corte">
        <table class="table  table-hover">
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
                <td><button class="btn btn-primary" onclick="mostrar_reporte_corte('.$fila['ID'].')">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                    <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114m2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                    <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                  </svg>
                  Reporte
                </button></td>
                </tr>';
            }
            echo '
          </tbody>
        </table>';
        echo '<nav aria-label="Page navigation" >';
          echo "<ul class='pagination'>";
          for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "
              <li class='page-item'>
                <a class='page-link' onclick='ver_cortes_paginacion(".$i.")'>$i</a> 
              </li>
            ";
          }
          echo '</ul>';
        echo '</nav>
        </div>';
      }
      function mostrar_paginacion_corte($posicion) {
        
        $registrosPorPagina = 10;
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        $inicio_dia= $inicio_dia + 86399;
        $fin_dia= $inicio_dia - 863989;

        $resultado = $sentencia = "SELECT COUNT(*) as total , corte.etiqueta AS ID
        FROM corte
        INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE (corte.fecha >= $fin_dia && corte.fecha <= $inicio_dia) ORDER BY corte.etiqueta DESC";
        $comentario = "Numero de cortes";
        $consulta = $this->realizaConsulta($resultado , $comentario);
        $fila = $consulta->fetch_assoc();
        $totalRegistros = $fila["total"];
        $totalPaginas = ceil( $totalRegistros / $registrosPorPagina );
        $paginaActual = $posicion;
        $indiceInicial = ($paginaActual - 1) * $registrosPorPagina;

        $sentencia = "SELECT * , corte.etiqueta AS ID
        FROM corte
        INNER JOIN usuario ON corte.id_usuario = usuario.id WHERE (corte.fecha >= $fin_dia && corte.fecha <= $inicio_dia) ORDER BY corte.etiqueta DESC LIMIT $indiceInicial, $registrosPorPagina";
        $consulta = $this->realizaConsulta($sentencia , $comentario);
        echo '
        <div class="table-responsive" id="tabla_corte">
          <table class="table table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
                <th>Número</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th><span class="glyphicon glyphicon-cog"></span>Ver</th>
              </tr>
            </thead>
            <tbody>
            ';
            while ($fila = mysqli_fetch_array($consulta)) {
              echo '
              <tr class="text-center">
                <td>'.$fila['ID'].'</td>
                <td>'.$fila['usuario'].'</td>
                <td>'.date("d-m-y" , $fila['fecha']).'</td>
                <td>$'.number_format($fila['total'], 2).'</td>
                <td>
                  <button class="btn btn-primary" onclick="mostrar_reporte_corte('.$fila['ID'].')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                      <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114m2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                      <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                    </svg>
                    Reporte
                  </button>
                </td>
              </tr>
              ';
            }
        echo '
            </tbody>
          </table>';
          echo '
          <nav aria-label="Page navigation">
            <ul class="pagination" >';
            for ( $i = 1; $i <= $totalPaginas ; $i++ ) {
              if ($i == $posicion ) {
                echo '
                  <li class="page-item active">
                    <a class="page-link" onclick="ver_cortes_paginacion('.$i.')">'.$i.'</a>
                  </li>
                ';
              }else {
                echo '
                  <li class="page-item">
                    <a class="page-link" onclick="ver_cortes_paginacion('.$i.')">'.$i.'</a>
                  </li>
                ';
              }
            }
          echo'
            </ul>
          </nav>
          </div>
        ';
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