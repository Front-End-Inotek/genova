<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  include_once('clase_huesped.php');

  /**
   *
   */
  class Informacion extends ConexionMYSql
  {

    function __construct($hab_id,$estado,$mov,$id)
    {
      switch ($estado) {
        case 0:
              $this->disponible($hab_id,$estado);
          break;
        case 1: 
              $this->ocupada($hab_id,$estado,$mov);
          break;
        case 2:
              $this->detllado($hab_id,$estado,$mov);
          break;
        case 3:
              $this->detllado($hab_id,$estado,$mov);
          break;
        case 4:
              $this->mantenimiento($hab_id,$estado,$mov);
          break;
        case 5:
              $this->bloqueo($hab_id,$estado,$mov);

          break;
        case 6:
              $this->por_cobrar($hab_id,$estado,$mov);
          break;
        case 7:
              //$this->ocupada($hab_id,$estado,$mov,$id);
          break;
        case 8:
            $this->sucia($hab_id,$estado,$mov);
          break;
        case 9:

              $this->limpieza($hab_id,$estado,$mov);
          break;
        case 10:
              echo '<div class="col-xs-2 col-sm-2 col-md-2">';
                echo 'Ultima renta:';
              echo '</div>';
          break;
        case 11:
              //$this->ocupada_rest($hab_id,$estado,$mov);
          break;
        case 12:
                //$this->ocupada($hab_id,$estado,$mov,$id);
          break;
        case 13:
              //$this->ocupada_rest($hab_id,$estado,$mov);
          break;
        case 14:

              $this->limpieza($hab_id,$estado,$mov);
          break;
        case 15:
              //$this->ocupada($hab_id,$estado,$mov,$id);
          break;
        case 16:
              //$this->ocupada($hab_id,$estado,$mov,$id);
          break;
        default:
            echo '<div class="col-xs-2 col-sm-2 col-md-2">';
              echo 'No definido';
            echo '</div>';
          break;
      }

    }
    function ocupada($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario="Obtener informacion de la ultima vez que se rento";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $detalle_fin=0;
      $id_huesped=0;
      $total=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $detalle_fin=$fila['detalle_fin'];
        $id_huesped=$fila['id_huesped'];
        $total=$fila['total'];
      }
        $huesped = NEW Huesped($id_huesped);
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Fecha entrada: '.date("Y-m-d H:i:s",  $detalle_inicio);
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Fecha salida: '.date("Y-m-d H:i:s",  $detalle_fin);
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Huésped: '.$huesped->nombre;
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Saldo: $'.$total= number_format($total, 2);
        echo '</div>';
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
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $detalle_fin=$fila['detalle_fin'];
        $detalle_realizo=$fila['detalle_realiza'];

      }
        $usuario = NEW Usuario($detalle_realizo);
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Inicio: '.date("Y-m-d H:i:s",  $detalle_inicio);
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Realiza: '.$usuario->usuario;
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Fin : '.date("Y-m-d H:i:s",  $detalle_fin);
        echo '</div>';
    }
    function mantenimiento($hab_id,$estado,$mov){
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1";
      $comentario="obtener informacion de la ultima vez que se rento ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $detalle_inicio=0;
      $detalle=0;
      $detalle_realizo=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $detalle=$fila['comentario'];
        $detalle_realizo=$fila['detalle_realiza'];

      }
        $usuario = NEW Usuario($detalle_realizo);
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Inicio: '.date("Y-m-d H:i:s",  $detalle_inicio);
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Realiza: '.$usuario->usuario;
        echo '</div>';
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Motivo: '.$detalle;
        echo '</div>';

    }
    function bloqueo($hab_id,$estado,$mov){
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
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Inicio: '.date("Y-m-d H:i:s",  $detalle_inicio);
        echo '</div>';

        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Motivo: '.$detalle;
        echo '</div>';

    }
    function disponible($hab_id,$estado){
      $sentencia = "SELECT liberacion FROM movimiento WHERE habitacion = $hab_id ORDER BY id DESC LIMIT 1";
      $comentario="obtener informacion de la ultima vez que se rento ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia ;
      //se recibe la consulta y se convierte a arreglo
      $fin_hospedaje=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $fin_hospedaje=$fila['liberacion'];
      }
      if($fin_hospedaje>0){
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Ultima renta: '.date("Y-m-d H:i:s",  $fin_hospedaje);
        echo '</div>';
      }else{
        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
          echo 'Ultima renta: INFORMACION NO DISPONIBLE';
        echo '</div>';
      }

    }
    function por_cobrar($hab_id,$estado,$mov){

      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la habitacion  por cobrar ";
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
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Ocupada: '.date("Y-m-d H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
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
                    Ocupada:'.date("Y-m-d H:i:s",  $detalle_inicio).'
                  </div>
                  <div>
                    Termina: '.date("Y-m-d H:i:s",$termina_hospe).'
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
      $comentario="obtener la cantidad de veces que se ha rentado una habitacion ";
      $cantidad = "";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
          $cantidad = $fila['cantidad'];
      }
      return $cantidad;
    }
    /*function ocupada($hab_id,$estado,$mov,$id){

      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      //echo $sentencia;
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
                    Ocupada:'.date("Y-m-d H:i:s",  $detalle_inicio).'
                  </div>
                  <div>
                    Termina: '.date("Y-m-d H:i:s",$termina_hospe).'
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
                    $sentencia1 = "SELECT * FROM concepto WHERE ticket=".$fila['id'] ;
                    $comentario1="obtener los productos vendidos";
                    $consulta1= $this->realizaConsulta($sentencia1,$comentario1);
                    while ($filas = mysqli_fetch_array($consulta1)){
                        echo '<div>';
                        if($nivel_usuario->nivel<=1){
                          
                         // echo '<button type="button" class="btn btn-danger" onclick="borrar_desde_hab('.$filas['id'].')">Borrar</button>';
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


    function sucia($hab_id,$estado,$mov){

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
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $cobara=$fila['detalle_realiza'];
        $termina_hospe=$fila['finalizado'];
        $persona_extra=$fila['persona_extra'];
        $matricula=$fila['matricula'];
        $modelo=$fila['modelo'];
        $anotacion=$fila['anotacion'];
      }
      $usuario = NEW Usuario($cobara);
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Ocupada: '.date("Y-m-d H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Cobro: '. $usuario->usuario;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Termino :   '. date("Y-m-d H:i:s",$termina_hospe);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Personas Extras: '. $persona_extra;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Matricula: '. $matricula;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Modelo: '. $modelo;
      echo '</div>';

      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Anotacion: '. $anotacion;
      echo '</div>';
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la habitacion  por cobrar ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }
    function limpieza($hab_id,$estado,$mov){

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
      $inicio_limpieza=0;
      $fin_limpieza=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $detalle_inicio=$fila['detalle_inicio'];
        $cobara=$fila['detalle_realiza'];
        $termina_hospe=$fila['finalizado'];
        $persona_extra=$fila['persona_extra'];
        $matricula=$fila['matricula'];
        $modelo=$fila['modelo'];
        $anotacion=$fila['anotacion'];
        $inicio_limpieza=$fila['inicio_limpieza'];
        $fin_limpieza=$fila['fin_limpieza'];
      }
      $usuario = NEW Usuario($cobara);
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Ocupada: '.date("Y-m-d H:i:s",  $detalle_inicio);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Cobro: '. $usuario->usuario;
      echo '</div>';


      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Inicio Limpieza :   '. date("Y-m-d H:i:s",$inicio_limpieza);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Fin Limpieza:   '. date("Y-m-d H:i:s",$fin_limpieza);
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Personas Extras: '. $persona_extra;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Matricula: '. $matricula;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Modelo: '. $modelo;
      echo '</div>';
      echo '<div class="col-xs-6 col-sm-6 col-md-6">';
        echo 'Anotacion: '. $anotacion;
      echo '</div>';
      $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1";
      $comentario="obtener de la habitacion  por cobrar ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }
  }

?>