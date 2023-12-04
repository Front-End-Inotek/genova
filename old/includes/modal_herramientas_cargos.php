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
      <div class="table-responsive" id="tabla_cargos">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
          if($_GET['id_maestra']==0){
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Habitacion</th>';
          }
          echo'
          <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
          </tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_cargo('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['cargo'].','.$_GET['id_maestra'].','.$_GET['mov'].')"> Editar</button></td>';
            $monto= 1;
            if($_GET['id_maestra']==0){
              echo '<td><button class="btn btn-success" onclick="cambiar_hab_herramientas_monto('.$monto.','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['cargo'].')"> Cambiar</button></td>';
            }
            echo '<td><button class="btn btn-danger" onclick="aceptar_borrar_herramientas_cargo('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['cargo'].','.$_GET['id_maestra'].','.$_GET['mov'].')"> Borrar</button></td>
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
