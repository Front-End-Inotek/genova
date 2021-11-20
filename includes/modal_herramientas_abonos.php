<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['usuario']);
  $nombre_usuario= $usuario->usuario;
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Herramientas de cargo
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="table-responsive" id="tabla_abonos">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
          if($_GET['ciclo'] == 1){
            // No se puede cambiar de habitacion el total pago
            // No se puede borrar el total pago
          }else{
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Habitacion</th>';
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>';
          }
          echo '</tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_abono('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].')"> Editar</button></td>';
            if($_GET['ciclo'] == 1){
              // No se puede cambiar de habitacion el total pago
              // No se puede borrar el total pago
            }else{
              $monto= 2;
              echo '<td><button class="btn btn-success" onclick="cambiar_hab_herramientas_monto('.$_GET['ciclo'].','.$monto.','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].')"> Cambiar</button></td>';
              echo '<td><button class="btn btn-danger" onclick="aceptar_borrar_herramientas_abono('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].')"> Borrar</button></td>';
            }
            echo '</tr>
        </tbody>
      </table>
      </div>

    </div>  

    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
