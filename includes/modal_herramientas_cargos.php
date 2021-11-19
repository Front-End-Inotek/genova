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
          if($_GET['ciclo'] == 1){
            // No se puede borrar el total suplementos
          }else{
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>';
          }
          echo '</tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['cargo'].')"> Editar</button></td>';
            if($_GET['ciclo'] == 1){
              // No se puede borrar el total suplementos
            }else{
              echo '<td><button class="btn btn-danger" onclick="aceptar_borrar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['cargo'].')"> Borrar</button></td>';
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
