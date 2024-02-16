<?php 
date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class Chat_Manager extends ConexionMYSql{

    public function guardarMensaje( $usuarioId , $tipo_mensaje , $mensaje ){
        $tiempo_unix = time();
        $sentencia = "INSERT INTO `chat` ( `usuario_id` , `tipo_mensaje` , `mensaje` , `hora_envio` ) 
        VALUES ($usuarioId , $tipo_mensaje , '$mensaje' , $tiempo_unix);";
        $comentario = "Guardamos mensaje nuevo";
        $consulta = $this->realizaConsulta($sentencia , $comentario);
        if($consulta){
            echo ("NO");
        } else {
            echo ("Error en la consulta");
        }
    }
    
    public function cargarMensajesGlobales(){
        $sentencia = "SELECT * FROM `chat` WHERE `tipo_mensaje` = 0 ORDER BY `mensaje_id` DESC LIMIT 20";
        $comentario = "Cargar 20 mensajes globales";
        $consulta = $this->realizaConsulta($sentencia ,  $comentario);
        return $consulta;
    }

    public function comprobarMensajeGlobal() {
        $sentencia = "SELECT * FROM `chat` WHERE `tipo_mensaje` = 0 ORDER BY `mensaje_id` DESC LIMIT 1";
        $comentario = "comprobar el ultimo mensaje";
        $consulta = $this->realizaConsulta($sentencia , $comentario);

        if($consulta && $consulta->num_rows > 0){
            return $consulta->fetch_assoc();
        } else {
            return ("Error en la consulta");
        }
    }

    public function cargarMensajesHabitacion( $id_habitacion , $mov) {
        $sentencia = "SELECT * FROM `chat` WHERE `tipo_mensaje` = $id_habitacion AND `movimiento` = $mov ORDER BY `mensaje_id` DESC LIMIT 20";
        $comentario = "Cargar 20 mensajes de la habitacion";
        $consulta = $this->realizaConsulta($sentencia , $comentario);
        //echo $sentencia;
        return $consulta;
    }

    public function guardarMensajeHabitacion( $usuarioId , $tipo_mensaje , $mensaje, $movimiento ){
        $tiempo_unix = time();
        $sentencia = "INSERT INTO  `chat` (`usuario_id` , `tipo_mensaje` , `mensaje` , `hora_envio` , `movimiento` )
        VALUES ($usuarioId, $tipo_mensaje, '$mensaje' , $tiempo_unix , '$movimiento');";
        $comentario = "Guardamos mensaje nuevo de la habitacion";
        $consulta = $this->realizaConsulta($sentencia , $comentario);
        if($consulta) {
            echo $consulta;
        }  else {
            echo( "Error en la consulta");
        }
    }

}