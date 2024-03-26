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
      <table class="table table-hover">
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
      while ($fila = mysqli_fetch_array($consulta)){
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
      while ($fila = mysqli_fetch_array($consulta)){
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
      echo '
      <div class="inputs_form_container justify-content-start">
          <div class="form-floating">
            <select type="text" id="usuario" class="form-select custom_input" onchange="buscar_logs_usuario('.$fecha_ini.','.$fecha_fin.','.$id.')" autofocus="autofocus">
              <option value="0">Selecciona</option>';
              $this->mostrar_usuario();
            echo '</select>
            <label for="usuario" >Usuario</label>
          </div>

          <div class="form-floating">
            <input class="form-control custom_input" type="text" id="buscar" onkeyup="buscar_logs_actividad()" placeholder="Buscar por actividad" autofocus="autofocus"/>
            <label>Buscar por actividad</label>
          </div>

          <div class="form-floating">
            <button class="btn btn-primary btn-block btn-default btn-lg" type="button" value="Buscar" onclick="buscar_usuario_logs()">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
              Buscar
            </button>
          </div>

          <div class="form-floating">
            <button class="btn btn-primary btn-block btn-default btn-lg" onclick="reporte_logs('.$fecha_ini.','.$fecha_fin.')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
              </svg>
              Reporte
            </button>
          </div>
          
      </div>
      
      <div class="table-responsive" id="tabla_logs">
      <table class="table table-hover">
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
    function mostrar_quien_hizo_checkin ($hab_id) {
      $sentencia = "SELECT usuario FROM logs WHERE actividad = 'Check-in en habitacion: $hab_id' ORDER BY id DESC LIMIT 1;";
      $comentario = "Seleccionar el ultimo usuario que hizo check-in";
      $consulta = $this->realizaConsulta( $sentencia , $comentario );
      //echo $sentencia;
      //var_dump($consulta);
      while($fila = mysqli_fetch_array($consulta)){
        $user = $fila['usuario'];
      }
      return $user;
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