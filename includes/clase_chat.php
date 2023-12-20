<?php 
date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class Chat_Manager extends ConexionMYSql{

    public function guardarMensaje($usuarioId, $tipo_mensaje, $mensaje){
        $sentencia = "INSERT INTO `chat` ( `usuario_id` , `tipo_mensaje` , `mensaje` ) 
        VALUES ($usuarioId , $tipo_mensaje , '$mensaje');";
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
}