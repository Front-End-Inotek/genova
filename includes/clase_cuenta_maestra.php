<?php
date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class CuentaMaestra extends ConexionMYSql{
    public $id;
    public $nombre;
    public $codigo;
    public $mov;
    public $estado;
    public $huesped;

    function __construct($id){

      if($id!=0){
        //consulta la cuenta maestra 
        $sentencia="SELECT* FROM cuenta_maestra WHERE estado=1 AND id=".$id;
        $comentario ="Consulta la cuenta maestra en base al id";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $this->id= $fila['id'];
            $this->nombre= $fila['nombre'];
            $this->codigo= $fila['codigo'];
            $this->mov= $fila['mov'];
            $this->estado= $fila['estado'];
            $this->huesped = $fila['huesped'];
        }
      }

    }

    function guardar_huesped_maestra($huesped, $maestra,$mov){
      //actualizamos el movimiento, para asignarle el huesped
      $update_movimiento = "UPDATE movimiento SET id_huesped='$huesped' WHERE id='$mov'"; 
      $comentario_mov="Actualizando el movimiento para asignarle un huesped";
      $consulta_mov = $this->realizaConsulta($update_movimiento,$comentario_mov);
      //actualizamos la cuenta maestra para asignarle el husped
      $update_maestra = "UPDATE cuenta_maestra SET huesped = '$huesped' WHERE id='$maestra'";
      $comentario_maestra="Actualizando cuenta maestra para asignarle husped";
      $consulta_maestra = $this->realizaConsulta($update_maestra,$comentario_maestra);
      if($consulta_mov && $consulta_maestra){
        echo "SI";
      }else{
        echo "NO";
      }
    }


    function guardar_cuenta_maestra($nombre,$codigo,$usuario_id){
        //Se debe crear un movimiento 'vacio', el cual estará asociada a la cuenta maestra, y se estará utilizando como movimiento 'principal' de esa cuenta.
        require_once('clase_movimiento.php');   
        $fecha_entrada = time();

        $movimiento = new Movimiento(0);
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
        $sentencia = "SELECT *, cuenta_maestra.nombre as nombre_maestra, cuenta_maestra.id as id_maestra FROM cuenta_maestra 
        LEFT JOIN huesped on cuenta_maestra.huesped = huesped.id
        WHERE cuenta_maestra.estado=1";
        $comentario ="Se obtienen todas las cuentas maestras";
        $usuario = NEW Usuario($id);
        $editar = $usuario->tipo_editar;
        $borrar = $usuario->tipo_borrar;
        // print_r($sentencia);
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
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Cargos adicionales</th>';
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
                <td>'.$fila['nombre_maestra'].'</td>
                <td>'.$fila['codigo'].'</td>';
                if(empty($fila['huesped'])){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="asignar_huesped_maestra('.$fila['id_maestra'].','.$fila['mov'].')">Húesped</button></td>';
                }else{
                  echo '<td>'.$fila['nombre'].' '.$fila['apellido'].' </td>';
                }
              
                echo '<td><button class="btn btn-warning"  onclick="agregar_restaurante(0,0,'.$fila['id_maestra'].','.$fila['mov'].')">Restaurante</button></td>';
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="agregar_cargo_adicional('.$fila['id_maestra'].','.$fila['mov'].')">Adicionales</button></td>';
                echo '<td><button class="btn btn-warning"  onclick="estado_cuenta_maestra(0,1,'.$fila['mov'].','.$fila['id_maestra'].')">Cuenta</button></td>';
                
                '<td></td>
                <td></td>

                ';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo('.$fila['id_maestra'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" onclick="borrar_tipo(' . $fila['id_maestra'] . ', \'' . addslashes($fila['nombre']) . '\', \'' . addslashes($fila['codigo']) . '\')">Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
    }
}