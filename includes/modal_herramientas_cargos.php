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
          <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
          </tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['cargo'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>
            <td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$_GET['id'].')"><span class="glyphicon glyphicon-edit"></span> Borrar</button></td>
          </tr>
        </tbody>
      </table>
      </div>

    </div>  

    <div class="modal-footer" id="boton_asignar_agregar_producto_salida">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
