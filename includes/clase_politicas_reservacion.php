<?php

date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');
class PoliticasReservacion extends ConexionMYSql
{
    public $id;
    public $nombre;
    public $codigo;
    public $descripcion;
    public $estado;
    public function __construct($id)
    {
        if($id!=0) {
            //consulta las politicas
            $sentencia="SELECT* FROM politicas_reservacion WHERE estado=1 AND id=".$id;
            $comentario ="Consulta la politica de reservacion en base al id";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            while ($fila = mysqli_fetch_array($consulta)) {
                $this->id= $fila['id'];
                $this->nombre= $fila['nombre'];
                $this->codigo= $fila['codigo'];
                $this->descripcion= $fila['descripcion'];
                $this->estado= $fila['estado'];
            }
        }
    }
     // Obtengo los datos de una reservacion
        public function datos_politicas(){
        $sentencia = "SELECT * FROM politicas_reservacion WHERE estado=1";
        $comentario="Mostrar los datos de la reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        return $consulta;
        }

    public function borrar_politica_reservacion($id)
    {
        $sentencia = "UPDATE `politicas_reservacion` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner politica de reservacion como inactiva";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        if($consulta) {
            echo "NO";
        } else {
            echo "error en la consulta";
        }
    }
    // Editar un tipo habitacion
    public function editar_politica($id, $nombre, $codigo, $descripcion){
        $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
        $codigo = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $sentencia = "UPDATE `politicas_reservacion` SET
        `nombre` = '$nombre',
        `codigo` = '$codigo',
        `descripcion` = '$descripcion'
        WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una politica de reservacion en la  base de datos ";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        if($consulta) {
            echo("NO");
        } else {
            echo("error en la consulta");
        }
    }
    public function guardar_politica_reservacion($nombre, $codigo, $descripcion){
        $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
        $codigo = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $sentencia = "INSERT INTO `politicas_reservacion` (`nombre`, `codigo`, `estado`,`descripcion`)
        VALUES ('$nombre', '$codigo', '1','$descripcion');";
        $comentario="Guardamos la politica de reservacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        if($consulta) {
            echo('NO');
        } else {
            echo("error en la consulta");
        }
    }
    public function mostrar($id){
        include_once('clase_usuario.php');
        $usuario = new Usuario($id);
        $editar = $usuario->tipo_editar;
        $borrar = $usuario->tipo_borrar;
        $sentencia = "SELECT* from politicas_reservacion WHERE estado= 1";
        $comentario = "Consulta todos los planes de alimentos disponibles";
        $consulta = $this->realizaConsulta($sentencia, $comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '
        <button class="btn btn-primary" href="#caja_herramientas"  data-toggle="modal" onclick="agregar_politicas_reservacion('.$id.')" style="width: 120px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
            </svg>
            Agregar
        </button>

        <div class="table-responsive" id="tabla_tipo"  ">
        <table class="table  table-hover">
        <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Codigo</th>';
        if($editar==1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
        }
        if($borrar==1) {
            echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
        }
        echo '</tr>
        </thead>
        <tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['codigo'].'</td>
                ';
            if($editar==1) {
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_politica_reservacion('.$fila['id'].')"> Editar</button></td>';
            }
            if($borrar==1) {
                echo '<td><button class="btn btn-danger" onclick="borrar_politica_reservacion(' . $fila['id'] . ', \'' . addslashes($fila['nombre']) . '\', \'' . addslashes($fila['codigo']) . '\')">Borrar</button></td>';
            }
            echo '</tr>';
        }
        echo '
        </tbody>
        </table>
        </div>';
    }
}
