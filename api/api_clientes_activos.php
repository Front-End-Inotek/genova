<?php
    header("Content-Type: application/json");
    include_once("../includes/clase_log.php");
    include_once("../includes/clase_cliente.php");
    include_once("../includes/clase_api_externa.php");

    //METODO DE LA PETICION 
    //echo "Metodo HTTP: " . $_SERVER['REQUEST_METHOD'];
    //echo " Informacion " . file_get_contents('php://input');
    $api_externa = NEW Api_externa(0);
    $cliente = NEW Cliente(0);
    $logs = NEW Log(0);
    $resultado = array();
    $contador = 0;
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST=json_decode(file_get_contents('php://input'),true);
            if(isset($_POST['token'])){
                if($_POST['token']==""){
                    $resultado['mensaje']= "Conexion fail: token esta vacio";
                    $logs->guardar_logs("Api clientes - token esta vacio");
                    $contador++;
                }
             }else{
                $resultado['mensaje']= "Conexion fail: token no se ingreso correctamente";
                $logs->guardar_logs("Api clientes - token no se ingreso correctamente");
                $contador++;
            }
                
            if(isset($_POST['id_token'])){
                if($_POST['id_token']==0){
                    $resultado['mensaje']= "Conexion fail: id_token debe ser mayor de 0";
                    $logs->guardar_logs("Api clientes - id_token debe ser mayor de 0");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: id_token no se ingreso correctamente";
                $logs->guardar_logs("Api clientes - id_token no se ingreso correctamente");
                $contador++;
            }    

            if($contador!=0){    
            }else{
                $token_activo = $api_externa->obtener_token($_POST['id_token']);
                if($_POST['token'] == $token_activo){

                    if($token_activo!="0"){
                        $consulta = $cliente->mostrar_cliente_api();
                        while ($fila = mysqli_fetch_array($consulta))
                        {
                            $resultado[$fila['id']]['id']= $fila['id'];
                            $resultado[$fila['id']]['nombre']= $fila['nombre'];
                            $resultado[$fila['id']]['nombre_comercial']= $fila['nombre_comercial'];
                            $resultado[$fila['id']]['direccion']= $fila['direccion'];
                            $resultado[$fila['id']]['ciudad']= $fila['ciudad'];
                            $resultado[$fila['id']]['estado']= $fila['estado'];
                            $resultado[$fila['id']]['codigo_postal']= $fila['codigo_postal'];
                            $resultado[$fila['id']]['telefono']= $fila['telefono'];
                            $resultado[$fila['id']]['correo']= $fila['correo'];
                            $resultado[$fila['id']]['rfc']= $fila['rfc'];
                            $resultado[$fila['id']]['curp']= $fila['curp'];
                            $resultado[$fila['id']]['estado_cliente']= $fila['estado_cliente'];
                            $resultado['mensaje']= "Conexion success";
                         }
                         $logs->guardar_logs("Api clientes - el usuario pidio info de clientes");
                    }else{
                        $resultado['mensaje']= "Conexion fail: el token no existe";
                        $logs->guardar_logs("Api clientes - token no existe");
                    }
                }else{
                    $resultado['mensaje']= "Conexion fail: el token no es valido";
                    $logs->guardar_logs("Api clientes - token no valido o no activo");
                }
          
            }
                
            break;
        
        default:
                    /*$resultado[0]['id']= 0;
                    $resultado[0]['nombre']= "";
                    $resultado[0]['nombre_comercial']= "";
                    $resultado[0]['direccion']= "";
                    $resultado[0]['ciudad']= "";
                    $resultado[0]['estado']= "";
                    $resultado[0]['codigo_postal']= "";
                    $resultado[0]['telefono']= "";
                    $resultado[0]['correo']= "";Ñ
                    $resultado[0]['rfc']= "";
                    $resultado[0]['curp']= "";
                    $resultado[0]['estado_cliente']= "";*/
                    $resultado['mensaje']= "Conexion fail : only use post conection";
                    $logs->guardar_logs("Api clientes - fallo por metodo diferente a POST");
            break;
    }
    echo json_encode($resultado);
?>
    