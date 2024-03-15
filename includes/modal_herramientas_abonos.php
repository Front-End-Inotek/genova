<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['usuario']);
  $nombre_usuario= $usuario->usuario;
  $nivel_usuario = $usuario->obtener_nivel($_GET['usuario']);
  
  //echo $nivel_usuario;
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Herramientas de abono</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
				<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
			</svg>
		</button>
    </div>

    <div class="modal-body">
      <div class="table-responsive" id="tabla_abonos">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Usuario</th>
          <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
          if($_GET['id_maestra']==0){
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Habitacion</th>';
          }
          echo'
          <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>';
          if($nivel_usuario <= 1) {
            echo'
            <th><span class=" glyphicon glyphicon-cog"></span> Cambiar no facturado</th>
            ';
          }
          echo'
          </tr>
        </thead>
        <tbody>
          <tr class="fuente_menor text-center">
            <td>'.$nombre_usuario.'</td>
            <td><button class="btn btn-warning" onclick="editar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].','.$_GET['mov'].','.$_GET['id_maestra'].')"> Editar</button></td>';
            $monto= 2;
            if($_GET['id_maestra']==0){
              echo '<td><button class="btn btn-success" onclick="cambiar_hab_herramientas_monto('.$monto.','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].')"> Cambiar</button></td>';
            }
            echo '<td><button class="btn btn-danger" onclick="aceptar_borrar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['abono'].','.$_GET['mov'].','.$_GET['id_maestra'].','.$_GET['id_ticket'].')"> Borrar</button></td>';
            if($nivel_usuario <= 1 ){
              echo '
              <td><button class="btn btn-danger" onclick="cambiarNoFac('.$_GET['id_ticket'].')"> Cambiar</button></td>
              ';
            }
            echo'
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
