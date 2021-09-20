<?php
    header("Content-Type: application/json");
    include_once("../includes/clase_log.php");
    include_once("../includes/clase_planta.php");
    include_once("../includes/clase_api_externa.php");

    //METODO DE LA PETICION 
    //echo "Metodo HTTP: " . $_SERVER['REQUEST_METHOD'];
    //echo " Informacion " . file_get_contents('php://input');
    $api_externa = NEW Api_externa(0);
    $logs = NEW Log(0);
    $planta = NEW Planta(0);
    $resultado = array();
    $contador = 0;
    $cont = 0;
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST=json_decode(file_get_contents('php://input'),true);
            if(isset($_POST['token'])){
                if($_POST['token']==""){
                    $resultado['mensaje']= "Conexion fail: token esta vacio";
                    $logs->guardar_logs("Api plantas - token esta vacio");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: token no se ingreso correctamente";
                $logs->guardar_logs("Api plantas - token no se ingreso correctamente");
                $contador++;
            }
            
            if(isset($_POST['id_token'])){
                if($_POST['id_token']==0){

                    $resultado['mensaje']= "Conexion fail: id_token debe ser mayor de 0";
                    $logs->guardar_logs("Api plantas - id_token debe ser mayor de 0");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: id_token no se ingreso correctamente";
                $logs->guardar_logs("Api plantas - id_token no se ingreso correctamente");
                $contador++;
            }

            if(isset($_POST['id_cliente'])){
                if($_POST['id_cliente']==0){
                    $resultado['mensaje']= "Conexion fail: id_cliente debe ser mayor de 0";
                    $logs->guardar_logs("Api plantas - id_cliente debe ser mayor de 0");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: id_cliente no se ingreso correctamente";
                $logs->guardar_logs("Api plantas - id_cliente no se ingreso correctamente");
                $contador++;
            }
            
            if($contador!=0){                
            }else{
                $token_activo = $api_externa->obtener_token($_POST['id_token']);
                if($_POST['token'] == $token_activo){
                    
                    if($token_activo!="0"){
                        $consulta = $planta->mostrar_plantas_api($_POST['id_cliente']);
                        while ($fila = mysqli_fetch_array($consulta))
                        {
                            $cont++;
                            if($cont!="0"){
                                $resultado[$fila['id']]['id']= $fila['id'];
                                $resultado[$fila['id']]['id_cliente']= $fila['id_cliente'];
                                $resultado[$fila['id']]['nombre']= $fila['nombre'];
                                $resultado[$fila['id']]['numero_serie']= $fila['numero_serie'];
                                $resultado[$fila['id']]['kwh']= $fila['kwh'];
                                $resultado[$fila['id']]['voltaje']= $fila['voltaje'];
                                $resultado[$fila['id']]['motor']= $fila['motor'];
                                $resultado[$fila['id']]['modelo']= $fila['modelo'];
                                $resultado[$fila['id']]['cpl']= $fila['cpl'];
                                $resultado[$fila['id']]['descripcion']= $fila['descripcion'];
                                $resultado[$fila['id']]['estado']= $fila['estado'];
                                $resultado['mensaje']= "Conexion success";
                            }
                            $logs->guardar_logs("Api plantas - el usuario pidio info de plantas del cliente: ". $_POST["id_cliente"]);
                        }
                        if($cont=="0"){
                            $resultado['mensaje']= "Conexion fail: el id_planta no existe";
                            $logs->guardar_logs("Api plantas - el usuario ingreso id_planta que no existe");
                        }
                    }else{
                        $resultado['mensaje']= "Conexion fail: el token no existe";
                        $logs->guardar_logs("Api plantas - token no existe");
                    }
                }else{
                    $resultado['mensaje']= "Conexion fail: el token no es valido";
                    $logs->guardar_logs("Api plantas - token no valido o no activo");
                }

            }
                
            break;
        
        default:
                    /*$resultado[0]['id']= 0;
                    $resultado[0]['id_cliente']= "";
                    $resultado[0]['nombre']= "";
                    $resultado[0]['numero_serie']= "";
                    $resultado[0]['kwh']= "";
                    $resultado[0]['voltaje']= "";
                    $resultado[0]['motor']= "";
                    $resultado[0]['modelo']= "";
                    $resultado[0]['cpl']= "";
                    $resultado[0]['descripcion']= "";
                    $resultado[0]['estado']= "";*/
                    $resultado['mensaje']= "Conexion fail : only use post conection";
                    $logs->guardar_logs("Api plantas - fallo por metodo diferente a POST");
            break;
    }
    echo json_encode($resultado);
?>