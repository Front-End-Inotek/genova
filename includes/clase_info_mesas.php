<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  include_once('clase_usuario.php');

  /**
   *
   */
  class Informacion_mesas extends ConexionMYSql
  {

    function __construct($mesa_id,$estado,$mov,$id)
    {
      switch ($estado) {
        case 0:
              $this->disponible($mesa_id,$estado);
          break;
        case 1: 
              $this->ocupada($mesa_id,$estado,$mov);
          break;
        case 2:
              $this->sucia($mesa_id,$estado,$mov);
          break;
        case 3:
              $this->limpieza($mesa_id,$estado,$mov);
          break;
        case 4:
              $this->mantenimiento($mesa_id,$estado,$mov);
          break;
        case 5:
              $this->supervision($mesa_id,$estado,$mov);
          break;
        case 6:
              $this->cancelada($mesa_id,$estado,$mov);
              //$this->por_cobrar($mesa_id,$estado,$mov);
          break;
        /*case 7:
              //$this->ocupada($mesa_id,$estado,$mov,$id);
          break;
        case 8:
              $this->detllado($mesa_id,$estado,$mov);
          break;
        case 9:
              $this->detllado($mesa_id,$estado,$mov);
          break;
        case 10:
              echo '<div class="col-xs-2 col-sm-2 col-md-2">';
                echo 'Ultima renta:';
              echo '</div>';
          break;
        case 11:
              //$this->ocupada_rest($mesa_id,$estado,$mov);
          break;
        case 12:
                //$this->ocupada($mesa_id,$estado,$mov,$id);
          break;
        case 13:
              //$this->ocupada_rest($mesa_id,$estado,$mov);
          break;
        case 14:

              $this->limpieza($mesa_id,$estado,$mov);
          break;
        case 15:
              //$this->ocupada($mesa_id,$estado,$mov,$id);
          break;
        case 16:
              //$this->ocupada($mesa_id,$estado,$mov,$id);
          break;*/
        default:
            echo '<div class="col-xs-2 col-sm-2 col-md-2">';
              echo 'No definido';
            echo '</div>';
          break;
      }

    }
    // Estado 0
    function disponible($mesa_id,$estado){
      /*$sentencia = "SELECT liberacion FROM movimiento WHERE mesa = $mesa_id ORDER BY id DESC LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado disponible";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $fin_hospedaje= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $fin_hospedaje= $fila['liberacion'];
      }
      if($fin_hospedaje>0){
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Ultima renta: '.date("d-m-Y H:i:s",  $fin_hospedaje);
        echo '</div>';
      }else{
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Ultima renta: INFORMACION NO DISPONIBLE';
        echo '</div>';
      }*/
    }
    // Estado 1
    function ocupada($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado ocupada";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio= 0;
      $detalle_realiza= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio= $fila['detalle_inicio'];
        $detalle_realiza= $fila['detalle_realiza'];
      }
        $usuario= NEW Usuario($detalle_realiza);
        echo '<div class="container">
          <div class="row flex-wrap">
            <div class="col-12 col-md-6 letras-grandes-modal">';
              echo 'Hora llegada: '.date("d-m-Y H:i:s",  $detalle_inicio);
            echo '</div>';
            echo '<div class="col-12 col-md-6 letras-grandes-modal">';
              $nombre_usuario= $usuario->usuario;
              echo 'Meser@: '.$nombre_usuario;
            echo '</div>

            <div class="col-12 izquierda">
                  <div style="font-size: 1.5rem; padding-bottom: 1rem; padding-top: 0.5rem;">
                    Restaurante:
                  </div>';
                  //$sentencia = "SELECT id FROM ticket WHERE mov = $mov";
                  $sentencia = "SELECT id FROM ticket WHERE mov = $mov";
                  //echo $sentencia ;
                  $comentario="Obtener los productos vendidos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  while ($fila = mysqli_fetch_array($consulta))
                  {
                    $id_ticket= $fila['id'];
                    $sentencia1 = "SELECT * FROM concepto WHERE id_ticket = $id_ticket AND activo = 1";
                    //$sentencia1 = "SELECT * FROM pedido_rest WHERE mov = $mov AND activo = 0";
                    $comentario1="Obtener los productos vendidos";
                    $consulta1= $this->realizaConsulta($sentencia1,$comentario1);
                    while ($filas1 = mysqli_fetch_array($consulta1)){
                      echo '<div>';
                      if($usuario->nivel <= 1){
                        // echo '<button type="button" class="btn btn-danger" onclick="borrar_desde_hab('.$filas1['id'].')">Borrar</button>';
                      }
                      echo '<div class="col-12 letras-grandes-modal" style="padding-bottom: 5px; border-bottom: 1px solid #00000026"> ';
                      echo $filas1['cantidad'].' -  '.$filas1['nombre'].' -  $'.number_format($filas1['total'], 2);
                      echo '</div>';
                    }
                    echo ' </div>';
                  }
                echo '</div>
          </div>
        </div>';
    }
    // Estado 2
    function sucia($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado sucia";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $inicio_hospedaje= 0;
      $termina_hospe= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $inicio_hospedaje= $fila['inicio_hospedaje'];
        $termina_hospe= $fila['finalizado'];
      }
      echo '<div class="col-12 col-md-6">';
        echo 'Ocupada: '.date("d-m-Y H:i:s",  $inicio_hospedaje);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Termino: '. date("d-m-Y H:i:s",$termina_hospe);
      echo '</div>';
    }
    // Estado 3
    function limpieza($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado limpieza";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $inicio_limpieza= 0;
      $termina_hospe= 0;
      $persona_limpio= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $inicio_limpieza= $fila['inicio_limpieza'];
        //$fin_limpieza= $fila['fin_limpieza'];
        $termina_hospe= $fila['finalizado'];
        $persona_limpio= $fila['persona_limpio'];
      }
      $usuario = NEW Usuario($persona_limpio);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Inicio Limpieza :   '. date("d-m-Y H:i:s",$inicio_limpieza);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Termino ocupada: '. date("d-m-Y H:i:s",$termina_hospe);
      echo '</div>';
      echo '<div class="col-xs-12 col-sm-12 col-md-12">';
        echo 'Persona Limpiando: '. $usuario->usuario;
      echo '</div>';
    }
    // Estado 4
    function mantenimiento($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado mantenimiento";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio= 0;
      $detalle_realiza= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio= $fila['detalle_inicio'];
        $detalle_realiza= $fila['detalle_realiza'];
      }
      $usuario = NEW Usuario($detalle_realiza);
      echo '<div class="col-12 col-md-6">';
        echo 'Inicio: '. date("d-m-Y H:i:s",$detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Realiza: '.$usuario->usuario;
      echo '</div>';
    }
    // Estado 5
    function supervision($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario= "Obtener informacion para la mesa con el estado supervision";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio= 0;
      $detalle_realiza= 0;
      while($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio= $fila['detalle_inicio'];
        $detalle_realiza= $fila['detalle_realiza'];
      }
      $usuario = NEW Usuario($detalle_realiza);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Inicio: '. date("d-m-Y H:i:s",$detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Realiza: '.$usuario->usuario;
      echo '</div>';
    }
    function bloqueo($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario="obtener informacion de la ultima vez que se rento ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $detalle=0;

      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $detalle=$fila['comentario'];

      }
        echo '<div class="col-12 col-md-6">';
          echo 'Inicio: '.date("d-m-Y H:i:s",  $detalle_inicio);
        echo '</div>';

        echo '<div class="col-12 col-md-6 letras-grandes-modal">';
          echo 'Motivo: '.$detalle;
        echo '</div>';

    }
    function por_cobrar($mesa_id,$estado,$mov){

      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la mesa  por cobrar ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $cobara=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $cobara=$fila['detalle_realiza'];
      }
      $usuario = NEW Usuario($cobara);
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Ocupada: '.date("d-m-Y H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-12 col-md-6 letras-grandes-modal">';
        echo 'Cobrara: '. $usuario->usuario;
      echo '</div>';
    }
    function ocupada_rest($mesa_id,$estado,$mov){

      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la mesa  por cobrar ";
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
      while ($fila = mysqli_fetch_array($consulta))
      {
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
                <div class="col-12 izquierda">
                  <div>
                    Restaurante
                  </div>';
                  $sentencia = "SELECT * FROM perdido_rest LEFT JOIN pedido ON pedido.id = perdido_rest.pedido WHERE pedido.mov = $mov AND pedido.estado = 0 ";
                  //echo $sentencia;
                  $comentario="obtener los productos vendidos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  while ($fila = mysqli_fetch_array($consulta))
                  {
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
      while ($fila = mysqli_fetch_array($consulta))
      {
          $nombre = $fila['nombre'];
      }
      return $nombre;
    }
    function saber_ventas($placa){
      $sentencia = "SELECT count(*) AS cantidad FROM movimiento WHERE matricula = '$placa'";
      $comentario="obtener la cantidad de veces que se ha rentado una mesa ";
      $cantidad = "";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
          $cantidad = $fila['cantidad'];
      }
      return $cantidad;
    }
    /*function ocupada($mesa_id,$estado,$mov,$id){

      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      //echo $sentencia;
      $comentario="obtener de la mesapor cobrar ";
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
      $ventas = 0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $cobara=$fila['detalle_realiza'];
        $termina_hospe=$fila['fin_hospedaje'];
        $persona_extra=$fila['persona_extra'];
        $matricula=$fila['matricula'];
        $modelo=$fila['modelo'] ;
        $cliente=$fila['cliente'] ;
        $anotacion=$fila['anotacion'];
        $ventas = $this->saber_ventas($fila['matricula']);
      }
      $usuario = NEW Usuario($cobara);
      $nivel_usuario = NEW Usuario($id);
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
                    Cliente '.$cliente.'
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
                  <div>
                    Visitas: '.$ventas.'
                  </div>
                </div>
                <div class="col-sm-6 izquierda">
                  <div>
                    Restaurante
                  </div>';
                  $sentencia = "SELECT id FROM ticket WHERE mov = $mov ";
                // echo $sentencia ;
                  $comentario="obtener los productos vendidos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  while ($fila = mysqli_fetch_array($consulta))
                  {
                    $sentencia1 = "SELECT * FROM concepto WHERE id_ticket=".$fila['id'] ;
                    $comentario1="obtener los productos vendidos";
                    $consulta1= $this->realizaConsulta($sentencia1,$comentario1);
                    while ($filas = mysqli_fetch_array($consulta1)){
                        echo '<div>';
                        if($nivel_usuario->nivel<=1){
                         // echo '<button type="button" class="btn btn-danger" onclick="borrar_desde_mesa('.$filas['id'].')">Borrar</button>';
                        }
                      echo $filas['cantidad'].' -  '.$filas['nombre'].' -  $'.$filas['total'];
                    }
                    //echo  $sentencia1;
                    /**/
                  /*  echo ' </div>';
                  }
                echo '</div>

          </div>
            </div>';

    }*/

    function detllado($mesa_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario="obtener informacion de la ultima vez que se rento ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $detalle_fin=0;
      $detalle_realizo=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
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