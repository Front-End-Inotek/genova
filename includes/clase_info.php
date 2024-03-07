<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  include_once("clase_cuenta.php");
  include_once('clase_huesped.php');
  include_once('clase_hab.php');
  class Informacion extends ConexionMYSql
  {
    function __construct($hab_id,$estado,$mov,$id,$entrada="",$salida="")
    {
      switch ($estado) {
        case 0:
              $this->disponible($hab_id,$estado);
          break;
        case 1:
              $this->ocupada($hab_id,$estado,$mov);
          break;
        case 2:
              $this->sucia($hab_id,$estado,$mov);
          break;
        case 3:
              $this->limpieza($hab_id,$estado,$mov);
          break;
        case 4:
              $this->mantenimiento($hab_id,$estado,$mov);
          break;
        case 5:
              $this->supervision($hab_id,$estado,$mov);
          break;
        // case 6:
        //       // $this->cancelada($hab_id,$estado,$mov);
        //       //$this->por_cobrar($hab_id,$estado,$mov);
        //   break;
        case 8:
            $this->uso_casa($hab_id,$estado,$mov);
          break;
        case 7: case 6:
          $this->reserva_pendiente($hab_id,$estado,$mov,$id,$entrada,$salida);
          break;
        default:
            echo '<ul class="list-group" style="width: 100%;">';
              echo '<li class="list-group-item">No definido</li>';
            echo '</ul>';
          break;
      }
    }
    // Estado 0
    function disponible($hab_id,$estado){
      $sentencia = "SELECT liberacion FROM movimiento WHERE id_hab = $hab_id ORDER BY id DESC LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado disponible";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $fin_hospedaje= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $fin_hospedaje= $fila['liberacion'];
      }
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '<ul class="list-group" style="width: 100%;" >';
      echo '<li class="list-group-item info_hab_header"><b>Info de reservación pendiente</b></li> ';
      if($fin_hospedaje>0){
        echo '<li class="list-group-item info_hab_li">';
          echo '<b>Ultima renta:</b> '.date("d-m-Y H:i:s",  $fin_hospedaje);
        echo '</li>';
      }else{
        echo '<li class="list-group-item info_hab_li">';
          echo '<b>Ultima renta:</b> INFORMACION NO DISPONIBLE';
        echo '</li>';
      }
      echo '<li class="list-group-item info_hab_li">';
        echo '<b>Tipo Habitación:</b> '.$tipo_habitacion;
      echo '</li>';
      echo '</ul>';
    }
    // Estado 1
    function ocupada($hab_id,$estado,$mov){
      $sentencia = "SELECT *, huesped.comentarios FROM movimiento INNER JOIN huesped ON movimiento.id_huesped = huesped.id WHERE movimiento.id = $mov ORDER BY movimiento.id DESC LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado ocupada";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $total_faltante= 0.0;
      $detalle_inicio= 0;
      $detalle_fin= 0;
      $id_huesped= 0;
      $total= 0;
      $estado_interno= '';
      $inicio_limpieza= 0;
      $persona_limpio= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        if($fila['motivo'] == "preasignar"){
          $detalle_inicio = $fila['inicio_hospedaje'];
        }else{
          $detalle_inicio= $fila['detalle_inicio'];
        }
        //$detalle_fin=$fila['detalle_fin'];
        $fin_hospedaje= $fila['fin_hospedaje'];
        $id_huesped= $fila['id_huesped'];
        $estado_interno= $fila['estado_interno'];
        $inicio_limpieza= $fila['inicio_limpieza'];
        $persona_limpio= $fila['persona_limpio'];
        $comentario=$fila['comentarios'];
        //var_dump($fila);
      }
        $cuenta= NEW Cuenta(0);
        $huesped= NEW Huesped($id_huesped);
        $hab= NEW Hab(0);
        $total= $cuenta->mostrar_total_cargos($mov);
        $total_faltante= $cuenta->mostrar_faltante($mov);
        $tipo_habitacion= $hab->consultar_tipo($hab_id);
        $nombre_huesped= $huesped->nombre.' '.$huesped->apellido;
        echo '
        <ul class="list-group" style="width: 100%;">
          <li class="list-group-item info_hab_header"><b>Información</b></li>
          <li class="list-group-item info_hab_li">
            <b>Fecha de entrada</b>
            '.date("d-m-Y H:i:s",  $detalle_inicio).'
          </li>
          <li class="list-group-item info_hab_li">
            <b>Fecha salida</b>
            '.date("d-m-Y H:i:s",  $fin_hospedaje).'
          </li>
          <li class="list-group-item info_hab_li">
            <b>Huésped</b>
            '.$nombre_huesped.'
          </li>
          <li class="list-group-item info_hab_li">
            <b>Saldo</b>
          ';
          if($total_faltante >= 0){
            echo '<span class="text-success">$'.number_format($total_faltante, 2).'</span>';
          }else{
            $total_faltante= substr($total_faltante, 1);
            echo '<span class="text-danger">$-'.number_format($total_faltante, 2).'</span>';
          }
        echo'
          </li>
          
        ';
        if($estado_interno == 'sucia'){
          echo '
          <li class="list-group-item info_hab_li">
            <b>Inicio sucia</b> 
            '.date("d-m-Y H:i:s",  $detalle_inicio),'
          </li>';
        }
        if($estado_interno == 'limpieza'){
          $usuario = NEW Usuario($persona_limpio);
          echo '
          <li class="list-group-item info_hab_li">
            <b>Inicio Limpieza</b> 
            '.date("d-m-Y H:i:s",  $detalle_inicio).'
          </li>
          <li class="list-group-item info_hab_li">
            <b>Persona Limpiando</b> 
            '. $usuario->usuario,'
          </li>
          ';
        }
        echo '
          <li class="list-group-item info_hab_li">
            <b>Tipo habitación</b>
            '.$tipo_habitacion.'
          </li>';
        if($comentario!=''){
          echo '
          <li class="list-group-item info_hab_li">
            <b>Comentarios</b> 
            '.$comentario.'
          </li>';
        }
        echo '
        </ul>
        ';
        echo '</div>';

        
    }
    // Estado 2
    function sucia($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado sucia";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $inicio_hospedaje= 0;
      $termina_hospe= 0;
      $txt_inicio ="Última reservación:";
      $txt_fin ="Termino ocupada:";
      while($fila = mysqli_fetch_array($consulta))
      {
        $inicio_hospedaje= $fila['inicio_hospedaje'];
        $termina_hospe= $fila['finalizado'];
        if(empty($inicio_hospedaje)){
          $inicio_hospedaje = $fila['detalle_inicio'];
          $txt_inicio ="Último movimiento:";
        }
        if(empty($termina_hospe)){
          $termina_hospe = $fila['detalle_fin'];
          $txt_fin ="Termino movimiento:";
        }
      }
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '
      <ul class="list-group" style="width: 100%">
        <li class="list-group-item info_hab_header">
          <b>Info de vacia sucia</b>
        </li>
        <li class="list-group-item info_hab_li">
          <b>'.$txt_inicio.'</b> 
          '.date("d-m-Y H:i:s",  $inicio_hospedaje).'
        </li>
        <li class="list-group-item info_hab_li">
          <b>'.$txt_fin.'</b> 
          '.date("d-m-Y H:i:s",$termina_hospe).'
        </li>
        <li class="list-group-item info_hab_li">
          <b>Tipo Habitación</b> 
          '.$tipo_habitacion.'
        </li>
      </ul>
      ';
    }
    // Estado 3
    function limpieza($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado limpieza";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $inicio_limpieza= 0;
      $termina_hospe= 0;
      $persona_limpio= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $inicio_limpieza= $fila['inicio_limpieza'];
        //$fin_limpieza= $fila['fin_limpieza'];
        $termina_hospe= $fila['finalizado'] == 0 ? "" : date("d-m-Y H:i:s",$fila['finalizado']);
        $persona_limpio= $fila['persona_limpio'];
      }
      $usuario = NEW Usuario($persona_limpio);
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '
      <ul class="list-group" style="width: 100%;">
        <li class="list-group-item info_hab_header">
          <b>Info de limpieza</b>
        </li>
        <li class="list-group-item info_hab_li">
          <b>Inicio Limpieza</b> 
          '. date("d-m-Y H:i:s",$inicio_limpieza).'
        </li>
        <li class="list-group-item info_hab_li">
          <b>Termino ocupada</b> 
          '.$termina_hospe.'
        </li>
        <li class="list-group-item info_hab_li">
          <b>Persona Limpiando</b> 
          '.$usuario->usuario.'
        </li>
        <li class="list-group-item info_hab_li">
          <b>Tipo Habitación</b> 
          '.$tipo_habitacion.'
        </li>
      </ul>
      ';
    }
    // Estado 4
    function mantenimiento($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado mantenimiento";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio= 0;
      $detalle_realiza= 0;
      $motivo= '';
      while($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio= $fila['detalle_inicio'];
        $detalle_realiza= $fila['detalle_realiza'];
        $motivo= $fila['comentario'];
      }
      $usuario = NEW Usuario($detalle_realiza);
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '
      <ul class="list-group" style="width: 100%;">
        <li class="list-group-item info_hab_header">
          <b>Info de mantenimiento</b>
        </li>
        <li class="list-group-item info_hab_li">
          <b>Inicio</b> 
          '. date("d-m-Y H:i:s",$detalle_inicio).'
        </li>
        <li class="list-group-item info_hab_li">
          <b>Realiza</b> 
          '.$usuario->usuario.'
        </li>';
        if($motivo != ''){
          echo '
          <li class="list-group-item info_hab_li">
            <b>Motivo</b> 
          '.$motivo.'
          </li>';
        }
        echo '
        <li class="list-group-item info_hab_li">
          <b>Tipo Habitación</b> 
          '.$tipo_habitacion.'
        </li>
      </ul>
      ';
    }
    // Estado 5
    function supervision($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      //echo $sentencia;
      $comentario= "Obtener informacion para la habitacion con el estado supervision";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio= 0;
      $detalle_realiza= 0;
      //var_dump($consulta);
      while($fila = mysqli_fetch_array($consulta))
      {
        
        $detalle_inicio= $fila['detalle_inicio'];
        $detalle_realiza= $fila['detalle_realiza'];
        $motivo= $fila['comentario'];
      }
      $usuario = NEW Usuario($detalle_realiza);
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '<div class="col-12 col-md-6">';
        echo 'Inicio: '. date("d-m-Y H:i:s",$detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6">';
        echo 'Motivo: '.$motivo;
      echo '</div>';
      echo '<div class="col-xs-12 col-sm-12 col-md-12">';
        echo 'Tipo Habitación: '.$tipo_habitacion;
      echo '</div>';
    }
    // Estado 6
    function cancelada($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="Obtener informacion para la habitacion con el estado cancelada";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $motivo= '';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio= $fila['detalle_inicio'];
        $motivo= $fila['comentario'];
      }
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Inicio: '.date("d-m-Y H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        if($motivo != ''){
          echo 'Motivo: '.$motivo;
        }
      echo '</div>';
      echo '<div class="col-xs-12 col-sm-12 col-md-12">';
        echo 'Tipo Habitación: '.$tipo_habitacion;
      echo '</div>';
    }
    // Estado 7
    function reserva_pendiente($hab_id,$estado,$mov,$id,$entrada,$salida){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="Obtener informacion para la habitacion con el estado cancelada";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

      //se recibe la consulta y se convierte a arreglo
      $inicio_hospedaje=$entrada;
      $fin_hospedaje=$salida;
      $motivo= '';
      while ($fila = mysqli_fetch_array($consulta))
      {
        //var_dump($fila);
        $id_huesped = $fila['id_huesped'];
      }
      $huesped= NEW Huesped($id_huesped);
      $nombre = $huesped->nombre;
      $apellido = $huesped->apellido;
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '
      <ul class="list-group" style="width: 100%;">
         <li class="list-group-item info_hab_header"><b>Info de reservación pendiente</b></li>
         <li class="list-group-item info_hab_li"><b>Quien reserva</b> '.$nombre.' '.$apellido.'</li>
         <li class="list-group-item info_hab_li"><b>Inicio</b> '.date("d-m-Y H:i:s",  $inicio_hospedaje).'</li>
         <li class="list-group-item info_hab_li"><b>Fin</b> '.date("d-m-Y H:i:s",  $fin_hospedaje).'</li>
         <li class="list-group-item info_hab_li"><b>Tipo habitación</b> '.$tipo_habitacion.'</li>
      </ul>';
    }
    // Estado 8
    function uso_casa($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la habitacion con el estado limpieza";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $inicio_uso= 0;
      $fin_uso= 0;
      $persona_uso= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $inicio_uso= $fila['detalle_inicio'];
        //$fin_limpieza= $fila['fin_limpieza'];
        $fin_uso= $fila['detalle_fin'];
        $persona_uso= $fila['persona_uso'];
      }
      // $usuario = NEW Usuario($persona_limpio);
      $hab= NEW Hab(0);
      $tipo_habitacion= $hab->consultar_tipo($hab_id);
      echo '<div class="col-12 col-md-6">';
        echo 'Inicio Uso :   '. date("d-m-Y H:i:s",$inicio_uso);
      echo '</div>';
      echo '<div class="col-12 col-md-6">';
        echo 'Termino Uso: '. date("d-m-Y H:i:s",$fin_uso);
      echo '</div>';
      echo '<div class="col-12 col-md-6">';
        echo 'Usando hab: '. $persona_uso;
      echo '</div>';
      echo '<div class="col-12 col-md-6">';
        echo 'Tipo Habitación: '.$tipo_habitacion;
      echo '</div>';
    }
    function por_cobrar($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="Obtener de la habitacion  por cobrar ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $cobrara=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $cobrara=$fila['detalle_realiza'];
      }
      $usuario = NEW Usuario($cobara);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Ocupada: '.date("d-m-Y H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Cobrara: '. $usuario->usuario;
      echo '</div>';
    }
    function ocupada_rest($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la habitacion  por cobrar ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $cobara=0;
      $termina_hospe=0;
      $persona_extra=0;
      $matricula=0;
      $modelo=0;
      $modelo=0;
      $anotacion=0;
      while ($fila = mysqli_fetch_array($consulta)){
        $detalle_inicio=$fila['detalle_inicio'];
        $cobara=$fila['detalle_realiza'];
        $termina_hospe=$fila['fin_hospedaje'];
        $persona_extra=$fila['persona_extra'];
        $matricula=$fila['matricula'];
        $modelo=$fila['modelo'];
        $anotacion=$fila['anotacion'];
      }
      $usuario = NEW Usuario($cobara);
        echo '<div class="container">
          <div class="row">
                <div class="col-sm-3">
                  <div>
                    Ocupada:'.date("d-m-Y H:i:s",  $detalle_inicio).'
                  </div>
                  <div>
                    Termina: '.date("d-m-Y H:i:s",$termina_hospe).'
                  </div>
                  <div>
                    Matricula '.$matricula.'
                  </div>
                  <div>
                    Anotacion: '.$anotacion.'
                  </div>
                </div>
                <div class="col-sm-3">
                  <div>
                    Cobro: '.$usuario->usuario.'
                  </div>
                  <div>
                    Personas Extras: '.$persona_extra.'
                  </div>
                  <div>
                    Modelo: '.$modelo.'
                  </div>
                </div>
                <div class="col-sm-6 izquierda">
                  <div>
                    Restaurante
                  </div>';
                  $sentencia = "SELECT * FROM perdido_rest LEFT JOIN pedido ON pedido.id = perdido_rest.pedido WHERE pedido.mov = $mov AND pedido.estado = 0 ";
                  //echo $sentencia;
                  $comentario="obtener los productos vendidos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  while ($fila = mysqli_fetch_array($consulta)){
                      echo '<div>
                      '.$fila['cantidad'].' -  '.$this->nombre_producto($fila['producto']).'
                      </div>';
                  }
                echo '</div>
          </div>
        </div>';
    }
    function nombre_producto($id){
      $sentencia = "SELECT nombre FROM  producto WHERE id  = $id  LIMIT 1 ";
      $comentario="obtener el nombre del procucto ";
      $nombre = "";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta)){
        $nombre = $fila['nombre'];
      }
      return $nombre;
    }
    function saber_ventas($placa){
      $sentencia = "SELECT count(*) AS cantidad FROM movimiento WHERE matricula = '$placa'";
      $comentario="obtener la cantidad de veces que se ha rentado una habitacion ";
      $cantidad = "";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta)){
        $cantidad = $fila['cantidad'];
      }
      return $cantidad;
    }
    function detllado($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario="obtener informacion de la ultima vez que se rento ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $detalle_fin=0;
      $detalle_realizo=0;
      while ($fila = mysqli_fetch_array($consulta)){
        $detalle_inicio=$fila['detalle_inicio'];
        $detalle_fin=$fila['detalle_fin'];
        $detalle_realizo=$fila['detalle_realiza'];
      }
      $usuario = NEW Usuario($detalle_realizo);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Inicio: '.date("d-m-Y H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Realiza: '.$usuario->usuario;
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Fin : '.date("d-m-Y H:i:s",  $detalle_fin);
      echo '</div>';
    }
  }
?>
