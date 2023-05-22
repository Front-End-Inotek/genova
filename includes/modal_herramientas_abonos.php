<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['usuario']);
  $nombre_usuario= $usuario->usuario;
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Herramientas de abono
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="table-responsive" id="tabla_abonos">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Habitacion</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
          </tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].','.$_GET['mov'].','.$_GET['id_maestra'].')"> Editar</button></td>';
            $monto= 2;
            echo '<td><button class="btn btn-success" onclick="cambiar_hab_herramientas_monto('.$monto.','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].')"> Cambiar</button></td>';
            echo '<td><button class="btn btn-danger" onclick="aceptar_borrar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].','.$_GET['mov'].','.$_GET['id_maestra'].')"> Borrar</button></td>
            </tr>
        </tbody>
      </table>
      </div>

    </div>  

    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
