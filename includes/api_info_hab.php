<?php
    //echo "Datos del servidor";
   
    header("Content-Type: application/json");
    include_once('consulta.php');
    $resultado =array();

    $resultado=0;
    class hab extends ConexionMYSql{
        public $estado=array();
        
        function __construct()
        {
            $cont=0;
            $sentencia = "SELECT * FROM hab ORDER BY id";
           //echo $sentencia;
            $comentario="Mostrar las diferentes actividades del usuario";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
            while ($fila = mysqli_fetch_array($consulta))
            {
                //echo  $fila['estado_energia'];
                $this->estado[$cont]['id']= $fila['id'];
                $this->estado[$cont]['hab']= $fila['nombre'];
                $this->estado[$cont]['estado']= $fila['estado'];
                $this->estado[$cont]['mov']= $fila['mov'];
                if( $fila['ultimo_mov']>0){
                    $this->estado[$cont]['ultimo_mov']= $fila['ultimo_mov'];
                }
                else{
                    $this->estado[$cont]['ultimo_mov']= 0;
                }
                $cont++;
            }

        }
       
    }
    $_POST=json_decode(file_get_contents('php://input'),true);

    $habitacion  = NEW hab();
    $resultado=$habitacion->estado;
    echo json_encode($resultado);
?>
