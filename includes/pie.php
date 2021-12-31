<?php
    /*include_once("clase_tarifas.php");
    include_once("clase_ticket.php");
    $info_ticket=NEW Ticket();
    $tarifa = NEW tarifas(0);
    echo '
    <div class="container-fluid Alin-center">
    <div class="row  ">';
        $tarifa->venta_tarifa($info_ticket->ticket_ini(),$info_ticket->ticket_fin());
        
    echo '</div></div>'; */
    echo ' <div class="container blanco">
    <div class="row">';
    $total=0;
      $sentencia = "SELECT * FROM tarifa WHERE  estado = 1";
      $comentario="Asignación de usuarios a la clase usuario funcion constructor";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta)){
        $sub = $this->cantida_renta($id_ini, $id_fin,$fila['id']);
        $per = $this->cantida_per($id_ini, $id_fin,$fila['id']);
        echo '<div class="col-sm-1">
          <div class="panel panel-primary pie">
            <div class="panel-heading">'.$fila['nombre'].': '.$sub.'</div>
            <div class="panel-body">P. Extra:'.$per.'</div>
          </div>
        </div>';
        $total= $total+$sub;
        
      }
      $hosp=$this->cantida_hosp($id_ini, $id_fin)+$total;
      $resta = $this->cantida_resta($id_ini, $id_fin);
      $venta = $this->cantida_venta($id_ini, $id_fin);
      /*$personas = $this->cantidad_personas($id_ini, $id_fin);
      echo '<div class="col-sm-1">
      <div class="panel panel-primary">
        <div class="panel-heading">Personas Ext. </div>
        <div class="panel-body">'.$personas.'</div>
       
      </div>
      </div>';*/
      

      echo '<div class="col-sm-1">
        <div class="panel panel-primary">
          <div class="panel-heading">Habitaciones. </div>
          <div class="panel-body">'.$hosp.'</div>
        </div>
      </div>';

      echo '<div class="col-sm-1">
        <div class="panel panel-danger">
          <div class="panel-heading">Hospedaje</div>
          <div class="panel-body">$'.$venta.'</div>
        </div>
      </div>';
      
      
      echo '<div class="col-sm-1">
        <div class="panel panel-danger">
          <div class="panel-heading">Restaurante</div>
          <div class="panel-body">$'.$resta.'</div>
        </div>
      </div>
      
         </div></div>';
?>