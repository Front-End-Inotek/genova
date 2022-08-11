<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  
  class Log extends ConexionMYSql{
    
    public $id;
    public $usuario;
    public $hora;
    public $ip;
    public $actividad;

    // Constructor
    function __construct($id)
    {
        if($id==0){
          $this->id= 0;
          $this->usuario= 0;
          $this->hora= 0;
          $this->ip= 0;
          $this->actividad= 0;
        }else{  
          $sentencia = "SELECT * FROM logs WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de los logs";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->usuario= $fila['usuario'];
              $this->hora= $fila['hora'];
              $this->ip= $fila['ip'];
              $this->actividad= $fila['actividad']; 
          }
        }
    }
    // Mostramos los logs
    function ver_log(){ 
      $sentencia = "SELECT logs.hora, logs.ip, logs.actividad, usuario.usuario  AS usuario FROM logs LEFT JOIN  usuario ON logs.usuario = usuario.id DESC";
      $comentario="Mostrar las diferentes actividades del usuario";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Ip</th>
            <th>Actividad Realizada</th>
            </tr>
          </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            echo '<td>'.$fila['usuario'].'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>';
    }
    // Obtengo la IP del dispositivo usado
    function get_client_ip_env() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
  
      return $ipaddress;
    }
    // Guardamos los logs dentro de la bd
    function guardar_log($usuario,$actividad){ 
      $hora=time();
      $ip=$this->get_client_ip_env();
      $sentencia = "INSERT INTO `logs` (`usuario`, `hora`,`ip`,`actividad`)
      VALUES ('$usuario', '$hora', '$ip','$actividad');";
      $comentario="Guardamos el log en la base de datos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Guardamos los logs dentro de la API
    function guardar_logs($actividad){ 
      $hora=time();
      $ip=$this->get_client_ip_env();
      $sentencia = "INSERT INTO `logs` (`usuario`, `hora`,`ip`,`actividad`)
      VALUES ('0', '$hora', '$ip','$actividad');";
      $comentario="Guardamos el log en la base de datos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Obtengo el nombre del usuario
    function saber_nombre($id_usuario){ 
      $sentencia = "SELECT usuario FROM usuario WHERE id = $id_usuario LIMIT 1";
      $comentario="Selecciona el nombre del usuario ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id_usuario= $fila['usuario'];
      }
      return $id_usuario;
    }
    // Obtengo los usuarios existentes
    function obtener_usuario(){ 
      $sentencia = "SELECT * FROM usuario ORDER BY usuario";
      $comentario="Obtengo los usuarios existentes dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;
    }
    // Obtengo los datos de logs
    function obtener_logs($id,$fecha_ini,$fecha_fin,$actividad){ 
      if($id == 0 && strlen($actividad) == 0){
        $sentencia = "SELECT * FROM logs WHERE hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 ORDER BY hora DESC";
      }elseif($id != 0 && strlen($actividad) == 0){
        $sentencia = "SELECT * FROM logs WHERE usuario = $id AND hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 ORDER BY hora DESC";
      }elseif($id == 0 && strlen($actividad) > 0){
        $sentencia = "SELECT * FROM logs WHERE hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 AND actividad LIKE '%$actividad%' ORDER BY hora DESC";
      }elseif($id != 0 && strlen($actividad) > 0){
        $sentencia = "SELECT * FROM logs WHERE usuario = $id AND hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 AND actividad LIKE '%$actividad%' ORDER BY hora DESC";
      }else{
        $sentencia = "SELECT * FROM logs WHERE usuario = $id AND hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 AND actividad LIKE '%$actividad%' ORDER BY hora DESC";
      }
      $comentario="Obtengo los logs dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;
    }
    // Mostrar los usuarios de logs
    function mostrar_usuario(){ 
      $sentencia = "SELECT * FROM usuario WHERE estado = 1 ORDER BY usuario";
      $comentario="Mostrar los usuarios de logs";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo

      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '  <option value="'.$fila['id'].'">'.$fila['usuario'].'</option>';
      }
      //return $usuario;
    }
    // Obtengo el total de logs
    function total_elementos(){ 
      $cantidad=0;
      $sentencia = "SELECT count(id) AS cantidad  FROM logs";
      //echo $sentencia;
      $comentario="Obtengo el total de logs";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $cantidad= $fila['cantidad'];
      }
      return $cantidad;
    }
    // Mostramos los logs ya filtrados por fecha
    function mostrar_logs($fecha_ini_tiempo,$fecha_fin_tiempo,$id){ 
      date_default_timezone_set('America/Mexico_City');
      $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
      $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
      $fecha_ini =strtotime($fecha_ini_tiempo);
      $fecha_fin =strtotime($fecha_fin_tiempo);
      $cat_paginas=($this->total_elementos()/40);
      $extra=($this->total_elementos()%40);
      $cat_paginas=intval($cat_paginas);
      if($extra>0){
        $cat_paginas++;
      }
      $ultimoid=0;
      if($id==0){
        $sentencia = "SELECT * FROM logs WHERE hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 ORDER BY hora DESC;";
        //LIMIT 40;";
        $comentario="Seleccionar los datos de logs";
      }else{
        $sentencia = "SELECT * FROM logs WHERE hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 AND id >= '.$id.' ORDER BY hora DESC;";
        $comentario="Seleccionar los datos de logs";
      } 
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$id=$consulta;
      //se recibe la consulta y se convierte a arreglo
      echo '<div class="row">
      <div class="col-sm-1">Usuario:</div>
          <div class="col-sm-3">
            <select type="text" id="usuario" class="color_black form-control form-control-lg" onchange="buscar_logs_usuario('.$fecha_ini.','.$fecha_fin.','.$id.')" autofocus="autofocus">
              <option value="0">Selecciona</option>';
              $this->mostrar_usuario(); 
            echo '</select>
          </div>
          <div class="col-sm-1">Actividad:</div>
          <div class="col-sm-3">
            <input class="form-control form-control-lg" type="text" id="buscar" onkeyup="buscar_logs_actividad()" placeholder="Buscar por actividad" autofocus="autofocus"/>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-secondary btn-block btn-default btn-lg" type="button" value="Buscar" onclick="buscar_usuario_logs()">
              Buscar 
            </button>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-success btn-block btn-default btn-lg" onclick="reporte_logs('.$fecha_ini.','.$fecha_fin.')">
              Reporte
            </button>
          </div>
      </div><br>
      
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th>Fecha</th>
          <th>Ip</th>
          <th>Actividad Realizada</th>
          </tr>
        </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            //echo '<tr>';
            echo '<td>'.$this->saber_nombre($fila['usuario']).'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>
      <ul class="pagination">';
        /*$new_id=((($id-1)/40))+1;
        $new_id_inicial=($new_id-4)-1;
        $new_id_final=($new_id+4)-1;
        for($i = 0; $i < $cat_paginas; $i++){
          $pagina=($i+1);
          if($i>=$new_id_inicial && $i <= $new_id_final ){
            if($pagina== $new_id){
              echo '
              <li class="page-item active" onclick="busqueda_logs('.(($i*40)+1).')"><a class="page-link" href="#">'.($i+1).'</a></li>';
            }else{
              echo '
              <li class="page-item" onclick="busqueda_logs('.(($i*40)+1).')"><a class="page-link" href="#">'.($i+1).'</a></li>';
            }
          }       
        }*/
        echo ' </ul>';
        //echo $sentencia;
    }
    // Mostramos los logs ya filtrados por fecha
    function mostrar_logs_tabla($fecha_ini_tiempo,$fecha_fin_tiempo,$id){ 
      date_default_timezone_set('America/Mexico_City');
      $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
      $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
      $fecha_ini =strtotime($fecha_ini_tiempo);
      $fecha_fin =strtotime($fecha_fin_tiempo);
  
      $sentencia = "SELECT * FROM logs WHERE hora >= $fecha_ini AND hora <= $fecha_fin AND hora > 0 ORDER BY hora DESC;";
      $comentario="Seleccionar los datos de logs";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th>Fecha</th>
          <th>Ip</th>
          <th>Actividad Realizada</th>
          </tr>
        </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            //echo '<tr>';
            echo '<td>'.$this->saber_nombre($fila['usuario']).'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>';
    }
    // Barra de busqueda de usuarios en logs
    function buscar_usuario($a_usuario){ 
      $sentencia = "SELECT * FROM logs WHERE usuario = $a_usuario ORDER BY actividad;";
      $comentario="Mostrar los logs usuario";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Ip</th>
            <th>Actividad Realizada</th>
            </tr>
          </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            echo '<td>'.$this->saber_nombre($fila['usuario']).'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
         </tbody>
       </table>
      </div>';
    }
    // Barra de busqueda de actividad en logs
    function buscar_actividad($a_buscar){ 
      $sentencia = "SELECT * FROM logs WHERE actividad LIKE '%$a_buscar%' ORDER BY actividad;";
      $comentario="Mostrar los logs actividad";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Ip</th>
            <th>Actividad Realizada</th>
            </tr>
          </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            echo '<td>'.$this->saber_nombre($fila['usuario']).'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
         </tbody>
       </table>
      </div>';
    }
    // Boton de busqueda de usuarios y actividad en logs
    function buscar_usuarios_logs($a_buscar,$usuario){
      if(strlen($a_buscar) == 0){
        $sentencia = "SELECT * FROM logs WHERE usuario = $usuario ORDER BY hora DESC;";
      }else{
        $sentencia = "SELECT * FROM logs WHERE actividad LIKE '%$a_buscar%' AND usuario = $usuario ORDER BY hora DESC;";
      }
      $comentario="Mostrar los logs";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Ip</th>
            <th>Actividad Realizada</th>
            </tr>
          </thead>
      <tbody>';
          while ($fila = mysqli_fetch_array($consulta))
          {
            echo '<td>'.$this->saber_nombre($fila['usuario']).'</td>';
            echo '<td>'.date("d-m-y",$fila['hora']).'</td>';
            echo '<td>'.$fila['ip'].'</td>';
            echo '<td>'.$fila['actividad'].'</td>';
            echo '</tr>';
          }
          echo '
         </tbody>
       </table>
      </div>';
    }
    // Obtener la fecha con formato de letras
    function formato_fecha($mes){
      switch ($mes) {
          case "01":
              $mes = "enero";
              break;
          case "02":
              $mes = "febrero";
              break;
          case "03":
              $mes = "marzo";
              break;
          case "04":
              $mes = "abril";
              break;
          case "05":
              $mes = "mayo";
              break;
          case "06":
              $mes = "junio";
              break;
          case "07":
              $mes = "julio";
              break;
          case "08":
              $mes = "agosto";
              break;
          case "09":
              $mes = "septiembre";
              break;
          case "10":
              $mes = "octubre";
              break;
          case "11":
              $mes = "noviembre";
              break;
          case "12":
              $mes = "diciembre";
              break;            
          default:
              echo "No existe este mes";
      }
      return $mes;
    }
      
  }
?>