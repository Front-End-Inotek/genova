<?php
  include_once('consulta.php');
    class Email extends ConexionMYSql{
        public $emisor_email;
        public $emisor_nombre;
        public $emisor_password;
        public $receptor_email;
        public $receptor_nombre;

        function __construct()
        {
            $sentencia = "SELECT * FROM correo WHERE id = 1 LIMIT 1 ";
            $comentario="Obtener la fecha del corte ";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
            while ($fila = mysqli_fetch_array($consulta))
            {
                $this->emisor_email=$fila['emisor_email'];
                $this->emisor_nombre=$fila['emisor_nombre'];
                $this->emisor_password=$fila['emisor_password'];
                $this->receptor_email=$fila['receptor_email'];
                $this->receptor_nombre=$fila['receptor_nombre'];
            }
        }
    }
?>