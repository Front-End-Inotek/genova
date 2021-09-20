<?php
  header("Content-Type: application/json");
  include_once("../includes/clase_usuario.php");
  include_once("../includes/clase_log.php");
  include_once("../includes/clase_api_externa.php");
  //METODO DE LA PETICION 
  //echo "Metodo HTTP: " . $_SERVER['REQUEST_METHOD'];
  //echo " Informacion " . file_get_contents('php://input');
  $api_externa = NEW Api_externa(0);
  $logs = NEW Log(0);
  $resultado = array();
  $contador = 0;
  
  switch ($_SERVER['REQUEST_METHOD']) {
      case 'POST':
          $_POST=json_decode(file_get_contents('php://input'),true);
          if(isset($_POST['token'])){
            if($_POST['token']==""){
                $resultado['mensaje']= "Conexion fail: token esta vacio";
                $logs->guardar_logs("Api usuario - token esta vacio");
                $contador++;
            }
          }else{
              $resultado['mensaje']= "Conexion fail: token no se ingreso correctamente";
              $logs->guardar_logs("Api usuario - token no se ingreso correctamente");
              $contador++;
          }
        
          if(isset($_POST['id_token'])){
              if($_POST['id_token']==0){
                  $resultado['mensaje']= "Conexion fail: id_token debe ser mayor de 0";
                  $logs->guardar_logs("Api usuario - id_token debe ser mayor de 0");
                  $contador++;
              }
          }else{
              $resultado['mensaje']= "Conexion fail: id_token no se ingreso correctamente";
              $logs->guardar_logs("Api usuario - id_token no se ingreso correctamente");
              $contador++;
          }

          if(isset($_POST['user_name'])){
              if($_POST['user_name']==""){
                  $resultado['mensaje']= "Conexion fail: user_name esta vacio";
                  $logs->guardar_logs("Api usuario - user_name esta vacio");
                  $contador++;
              }
          }else{
              $resultado['mensaje']= "Conexion fail: user_name no se ingreso correctamente";
              $logs->guardar_logs("Api usuario - user_name no se ingreso correctamente");
              $contador++;
          }

          if(isset($_POST['user_password'])){
              if($_POST['user_password']==""){
                  $resultado['mensaje']= "Conexion fail: user_password esta vacio";
                  $logs->guardar_logs("Api usuario - user_password esta vacio");
                  $contador++;
              }
          }else{
              $resultado['mensaje']= "Conexion fail: user_password no se ingreso correctamente";
              $logs->guardar_logs("Api usuario - user_password no se ingreso correctamente");
              $contador++;
          }
        
          if($contador!=0){ 
          }else{
              $token_activo = $api_externa->obtener_token($_POST['id_token']);
              if($_POST['token'] == $token_activo){
                  
                  if($token_activo!="0"){
                      $usuario =$_POST["user_name"];
                      $password =md5($_POST["user_password"]); 
                      $users = NEW Usuario(0);
                     
                      $id=$users->evaluarEntrada($usuario ,$password);
                      if($id>0){
                          $timepo = time();
                          $token = hash('sha256', $timepo.$usuario.$password);
                          $users->guardar_token($token,$id);
                          $resultado['user_name'] =$_POST['user_name'];
                          $resultado['user_password'] ="1";
                          $resultado['id']= $id;
                          $resultado['token']= $token;
                          $resultado['mensaje']= "Conexion success";
                          $logs->guardar_logs("Api usuario: inicio de sesion por usuario: ". $_POST["user_name"]);

                      }else{
                          /*$resultado['user_name'] =0;
                          $resultado['user_password'] =0;
                          $resultado['id']=0;
                          $resultado['token']= 0;*/
                          $resultado['mensaje']= "Evaluation fail";
                          $logs->guardar_logs("Api usuario: fallo de inicio sesion por usuario: ". $_POST["user_name"]);        
                      }     
                  }else{
                      $resultado['mensaje']= "Conexion fail: el token no existe";
                      $logs->guardar_logs("Api usuario: token no existe");
                  }
              }else{
                  $resultado['mensaje']= "Conexion fail: el token no es valido";
                  $logs->guardar_logs("Api usuario: token no valido o no activo");
              }
       
          }
             
          break;
      
      default:
                      /*$resultado['user_name'] =0;
                      $resultado['user_password'] =0;
                      $resultado['id']=0;
                      $resultado['token']= 0;*/
                      $resultado['mensaje']= "Conexion fail : only use post conection";
                      $logs->guardar_logs("Api usuario: fallo por metodo diferente a POST");
          break;
  }
  echo json_encode($resultado);
?>