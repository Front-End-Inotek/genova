<?php
date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class CuentaMaestra extends ConexionMYSql{




    function guardar_cuenta_maestra($nombre,$codigo,$usuario_id){
        //Se debe crear un movimiento 'vacio', el cual estará asociada a la cuenta maestra, y se estará utilizando como movimiento 'principal' de esa cuenta.
        require_once('clase_movimiento.php');   
        $fecha_entrada = time();

        $movimiento = new Movimiento();
        $mov = $movimiento->disponible_asignar(0,0,0,$fecha_entrada,'',$usuario_id,'',"maestra");


        $sentencia = "INSERT INTO `cuenta_maestra` (`nombre`, `codigo`,`mov`, `estado`)
        VALUES ('$nombre', '$codigo','$mov', '1');";
        $comentario="Guardamos el plan de alimentos en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ("error en la consulta");
        }
    }

    function mostrar($id){
        require_once('clase_usuario.php');
        $sentencia = "SELECT * FROM cuenta_maestra WHERE estado=1";
        $comentario ="Se obtienen todas las cuentas maestras";
        $usuario = NEW Usuario($id);
        $editar = $usuario->tipo_editar;
        $borrar = $usuario->tipo_borrar;

        $consulta=$this->realizaConsulta($sentencia,$comentario);

        echo '
        <button class="btn btn-success" href="#caja_herramientas"  data-toggle="modal" onclick="agregar_cuentas_maestras('.$id.')"> Agregar </button>
        <br>
        <br>
        <div class="table-responsive" id="tabla_tipo"  style="max-height:860px; overflow-x: scroll; ">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Código</th>';
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Asignar huesped</th>';
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Cargo restaurante</th>';
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Cargo extra</th>';
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Estado de cuenta</th>';

            if($editar==1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1){
              echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['codigo'].'</td>';
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo('.$fila['id'].')">Húesped</button></td>';
                echo '<td><button class="btn btn-warning"  onclick="agregar_restaurante(0,0,'.$fila['id'].')">Restaurante</button></td>';
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo('.$fila['id'].')">Extra</button></td>';
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo('.$fila['id'].')">Cuenta</button></td>';
                
                '<td></td>
                <td></td>

                ';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" onclick="borrar_tipo(' . $fila['id'] . ', \'' . addslashes($fila['nombre']) . '\', \'' . addslashes($fila['codigo']) . '\')">Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
    }
}