<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Usuario extends ConexionMYSql{

      public $id;
      public $usuario;
      public $pass;
      public $nivel;
      public $nombre_completo;
      public $puesto;
      public $celular;
      public $correo;
      public $direccion;
      public $nivel_texto;
      public $estado;
      public $token;
      public $fecha_generado;
      public $fecha_vencimiento;
      public $activo;
      public $usuario_privilegio;
      public $usuario_ver;
      public $usuario_agregar;
      public $usuario_editar;
      public $usuario_borrar;
      public $huesped_ver;
      public $huesped_agregar;
      public $huesped_editar;
      public $huesped_borrar;
      public $tipo_ver;
      public $tipo_agregar;
      public $tipo_editar;
      public $tipo_borrar;
      public $tarifa_ver;
      public $tarifa_agregar;
      public $tarifa_editar;
      public $tarifa_borrar;
      public $hab_ver;
      public $hab_agregar;
      public $hab_editar;
      public $hab_borrar;
      public $reservacion_ver;
      public $reservacion_agregar;
      public $reservacion_editar;
      public $reservacion_borrar;
      public $reporte_ver;
      public $forma_pago_ver;
      public $forma_pago_agregar;
      public $forma_pago_editar;
      public $forma_pago_borrar;
      public $inventario_ver;
      public $inventario_agregar;
      public $inventario_editar;
      public $inventario_borrar;
      public $categoria_ver;
      public $categoria_agregar;
      public $categoria_editar;
      public $categoria_borrar;
      public $restaurante_ver;
      public $restaurante_agregar;
      public $restaurante_editar;
      public $restaurante_borrar;

      /*function __construct(){
      }*/
      // Constructor
      function __construct($id_usuario)
      {
        if($id_usuario==0){
          $this->id= 0;
          $this->usuario= "Sin/Nombre";
          $this->pass= -1;
          $this->nivel= -1;
          $this->estado=-1;
          $this->activo= -1;
          $this->nombre_completo= -1;
          $this->puesto= -1;
          $this->celular= -1;
          $this->correo= -1;
          $this->direccion= -1;
          $this->usuario_privilegio= -1;
          $this->usuario_ver= -1;
          $this->usuario_agregar= -1;
          $this->usuario_editar= -1;
          $this->usuario_borrar= -1;
          $this->huesped_ver= -1;
          $this->huesped_agregar= -1;
          $this->huesped_editar= -1;
          $this->huesped_borrar= -1;
          $this->tipo_ver= -1;
          $this->tipo_agregar= -1;
          $this->tipo_editar= -1;
          $this->tipo_borrar= -1;
          $this->tarifa_ver= -1;
          $this->tarifa_agregar= -1;
          $this->tarifa_editar= -1;
          $this->tarifa_borrar= -1;
          $this->hab_ver= -1;
          $this->hab_agregar= -1;
          $this->hab_editar= -1;
          $this->hab_borrar= -1;
          $this->reservacion_ver= -1;
          $this->reservacion_agregar= -1;
          $this->reservacion_editar= -1;
          $this->reservacion_borrar= -1;
          $this->reporte_ver= -1;
          $this->forma_pago_ver= -1;
          $this->forma_pago_agregar= -1;
          $this->forma_pago_editar= -1;
          $this->forma_pago_borrar= -1;
          $this->inventario_ver= -1;
          $this->inventario_agregar= -1;
          $this->inventario_editar= -1;
          $this->inventario_borrar= -1;
          $this->categoria_ver= -1;
          $this->categoria_agregar= -1;
          $this->categoria_editar= -1;
          $this->categoria_borrar= -1;
          $this->restaurante_ver= -1;
          $this->restaurante_agregar= -1;
          $this->restaurante_editar= -1;
          $this->restaurante_borrar= -1;
          
        }else{
          $sentencia = "SELECT * FROM usuario WHERE id = $id_usuario LIMIT 1";
         // echo $sentencia ;
          $comentario="Asignación de usuarios a la clase usuario funcion constructor";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->usuario= $fila['usuario'];
              $this->pass= $fila['pass'];
              $this->nivel= $fila['nivel'];
              switch ($fila['nivel']){

                  case 0:
                      $this->nivel_texto='Superusuario';
                  break;
                  case 1:
                      $this->nivel_texto='Administrador';
                  break;
                  case 2:
                      $this->nivel_texto='Cajera';
                  break;
                  case 3:
                      $this->nivel_texto='Recamarera';
                  break;
                  case 4:
                      $this->nivel_texto='Mantenimiento';
                  break;
                  case 5:
                    $this->nivel_texto='Supervision';
                  break;
                  case 6:
                      $this->nivel_texto='Restaurante';
                  break;
                  case 7:
                      $this->nivel_texto='Reservaciones';
                  break;
                  case 8:
                      $this->nivel_texto='Ama Llaves';
                  break;
                  case 9:
                    $this->nivel_texto='Indefinido';
                  break;
                  default:
                      $this->nivel_texto='Indeterminado';
                  break;
              }
              $this->estado= $fila['estado'];
              $this->activo= $fila['activo'];
              $this->nombre_completo= $fila['nombre_completo'];
              $this->puesto= $fila['puesto'];
              $this->celular= $fila['celular'];
              $this->correo= $fila['correo'];
              $this->direccion= $fila['direccion'];
            
              $this->usuario_ver= $fila['usuario_ver'];
              $this->usuario_agregar= $fila['usuario_agregar'];
              $this->usuario_editar= $fila['usuario_editar'];
              $this->usuario_borrar= $fila['usuario_borrar'];
              $this->huesped_ver= $fila['huesped_ver'];
              $this->huesped_agregar= $fila['huesped_agregar'];
              $this->huesped_editar= $fila['huesped_editar'];
              $this->huesped_borrar= $fila['huesped_borrar'];
              $this->tipo_ver= $fila['tipo_ver'];
              $this->tipo_agregar= $fila['tipo_agregar'];
              $this->tipo_editar= $fila['tipo_editar'];
              $this->tipo_borrar= $fila['tipo_borrar'];
              $this->tarifa_ver=  $fila['tarifa_ver'];
              $this->tarifa_agregar= $fila['tarifa_agregar'];
              $this->tarifa_editar= $fila['tarifa_editar'];
              $this->tarifa_borrar= $fila['tarifa_borrar'];
              $this->hab_ver= $fila['hab_ver'];
              $this->hab_agregar= $fila['hab_agregar'];
              $this->hab_editar= $fila['hab_editar'];
              $this->hab_borrar= $fila['hab_borrar'];
              $this->reservacion_ver= $fila['reservacion_ver'];
              $this->reservacion_agregar= $fila['reservacion_agregar'];
              $this->reservacion_editar= $fila['reservacion_editar'];
              $this->reservacion_borrar= $fila['reservacion_borrar'];
              $this->reporte_ver= $fila['reporte_ver'];
              $this->forma_pago_ver= $fila['forma_pago_ver'];
              $this->forma_pago_agregar= $fila['forma_pago_agregar'];
              $this->forma_pago_editar= $fila['forma_pago_editar'];
              $this->forma_pago_borrar= $fila['forma_pago_borrar'];
              $this->inventario_ver= $fila['inventario_ver'];
              $this->inventario_agregar= $fila['inventario_agregar'];
              $this->inventario_editar= $fila['inventario_editar'];
              $this->inventario_borrar= $fila['inventario_borrar'];
              $this->categoria_ver= $fila['categoria_ver'];
              $this->categoria_agregar= $fila['categoria_agregar'];
              $this->categoria_editar= $fila['categoria_editar'];
              $this->categoria_borrar= $fila['categoria_borrar'];
              $this->restaurante_ver= $fila['restaurante_ver'];
              $this->restaurante_agregar= $fila['restaurante_agregar'];
              $this->restaurante_editar= $fila['restaurante_editar'];
              $this->restaurante_borrar= $fila['restaurante_borrar'];
              
          }
          $this->usuario_privilegio=$this->usuario_ver+$this->usuario_editar+$this->usuario_borrar+$this->usuario_agregar+$this->huesped_ver+$this->huesped_agregar+$this->huesped_editar+$this->huesped_borrar+$this->tipo_ver+$this->tipo_agregar+$this->tipo_editar+$this->tipo_borrar+$this->tarifa_ver+$this->tarifa_agregar+$this->tarifa_editar+$this->tarifa_borrar+$this->hab_ver+$this->hab_agregar+$this->hab_editar+$this->hab_borrar+$this->reservacion_ver+$this->reservacion_agregar+$this->reservacion_editar+$this->reservacion_borrar+$this->reporte_ver+$this->forma_pago_ver+$this->forma_pago_agregar+$this->forma_pago_editar+$this->forma_pago_borrar+$this->inventario_ver+$this->inventario_agregar+$this->inventario_editar+$this->inventario_borrar+$this->categoria_ver+$this->categoria_agregar+$this->categoria_editar+$this->categoria_borrar+$this->restaurante_ver+$this->restaurante_agregar+$this->restaurante_editar+$this->restaurante_borrar;
        }  
      }
      // Datos inicio de sesion
      function datos($id){
        $sentencia = "SELECT * FROM usuario WHERE id = $id LIMIT 1 ";
        $comentario="Obtener todos los valores del usuario ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $this->usuario= $fila['usuario'];
          $this->nivel= $fila['nivel'];
          $this->estado= $fila['estado'];
          $this->activo= $fila['activo'];
          
        }
        $this->obtener_token_activo($id);
      }
      // Obtener token activo
      function obtener_token_activo($id){
        $sentencia = "SELECT * FROM token  WHERE usuario = $id AND activo = 1 ORDER BY id DESC LIMIT 1 ";
        $comentario="Obtener el token del usuario ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $this->token=$fila['token'];
          $this->fecha_generado= $fila['fecha_generado'];
          $this->fecha_vencimiento= $fila['fecha_vencimiento'];
          $this->activo= $fila['activo'];
        }
      }
      // Evaluar entrada de sesion
      function evaluarEntrada($usuario_evaluar ,$password_evaluar){
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $id=0;
        $sentencia = "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND estado = 1";
        $comentario="Obtenemos el usuario y contraseña de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
          // Guardamos logs de inicio de session
          $logs->guardar_log($fila['id'],"Inicio de session el usuario: ".$id);
        }
        return $id;
      }
      // Guardar el token
      function guardar_token($token,$usuario){
        $fecha_generado= time();
        $fecha_vencimiento= $fecha_generado+604800;
         
        $sentencia = "INSERT INTO `token` (`token`, `usuario`, `fecha_generado`, `fecha_vencimiento` ,`activo`)
        VALUES ('$token', '$usuario', '$fecha_generado', '$fecha_vencimiento', '1');";
        $comentario="Guardamos el token con la fecha de inicio y la vigencia";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Guardar un usuario
      function guardar_usuario($usuario,$pass,$nivel,$nombre_completo,$puesto,$celular,$correo,$direccion){
        switch ($nivel) {
          case 0:// guarda nivel superusuario o master
              echo "Este nivel corresponde al superusuario";
              break;

          case 1:// guarda nivel administrador
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;

          case 2:// guarda nivel cajera
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 
                
          case 3:// guarda nivel recamarera
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break; 
                
          case 4:// guarda nivel mantenimiento
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;
              
          case 5:// guarda nivel supervision
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;

          case 6:// guarda nivel restaurante
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 
                
          case 7:// guarda nivel reservaciones
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break; 
                
          case 8:// guarda nivel ama llaves
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '0', '0', '0', '0',  '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 

          case 9:// guarda nivel indefinido
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `huesped_ver`, `huesped_agregar`, `huesped_editar`, `huesped_borrar`, `tipo_ver`, `tipo_agregar`, `tipo_editar`, `tipo_borrar`, `tarifa_ver`, `tarifa_agregar`, `tarifa_editar`, `tarifa_borrar`, `hab_ver`, `hab_agregar`, `hab_editar`, `hab_borrar`, `reservacion_ver`, `reservacion_agregar`, `reservacion_editar`, `reservacion_borrar`, `reporte_ver`, `forma_pago_ver`, `forma_pago_agregar`, `forma_pago_editar`, `forma_pago_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `categoria_ver`, `categoria_agregar`, `categoria_editar`, `categoria_borrar`, `restaurante_ver`, `restaurante_agregar`, `restaurante_editar`, `restaurante_borrar`)
              VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0');";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break;    
                
          default:// indeterminado
              echo "Aun no se encuentra registrado ese nivel de usuario";
              break; 
        }                 
      }
      // Mostramos el nivel del usuario
      function mostrar_nivel($id){
        $sentencia = "SELECT nivel FROM usuario WHERE id = $id LIMIT 1 ";
        //echo $sentencia;
        $comentario="Inicio de nivel usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nivel= $fila['nivel'];
        }
        return $nivel;
      }
      // Obtengo el total de usuarios
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM usuario";
        //echo $sentencia;
        $comentario="Obtengo el total de usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los usuarios
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->usuario_editar;
        $borrar = $usuario->usuario_borrar;

        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0){
          $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT * FROM usuario WHERE nivel > 0 && estado = 1 ORDER BY nivel, usuario";
        $comentario="Mostrar los usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
         echo '<div class="table-responsive" id="tabla_usuario">
           <table class="table table-bordered table-hover">
             <thead>
               <tr class="table-primary-encabezado text-center">
               <th>Nombre</th>
               <th>Nivel</th>
               <th>Nombre</th>
               <th>Puesto</th>
               <th>Celular o telefono</th>
               <th>Correo</th>
               <th>Direccion</th>
               <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
               <th><span class="glyphicon glyphicon-cog"></span> Borrar</th>
               </tr>
             </thead>
           <tbody>';
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($cont>=$posicion & $cont<$final ){
            if($fila['nivel']>0){
              echo '<tr class="text-center">
              <td>'.$fila['usuario'].'</td>';
              switch ($fila['nivel']) {
    
                case 1:
                    echo '<td>Administrador</td>';
                  break;
                case 2:
                    echo '<td>Cajera</td>';
                  break;
                case 3:
                    echo '<td>Recamarera</td>';
                  break;
                case 4:
                    echo '<td>Mantenimiento</td>';
                  break;
                case 5:
                    echo '<td>Supervision</td>';
                  break;
                case 6:
                    echo '<td>Restaurante</td>';
                  break;
                case 7:
                    echo '<td>Reservaciones</td>';
                  break;
                case 8:
                    echo '<td>Ama Llaves</td>';
                  break;
                case 9:
                    echo '<td>Indefinido</td>';
                  break;   
                default:
                    echo '<td>Indeterminado</td>';
                  break;
              }
              echo '<td>'.$fila['nombre_completo'].'</td>';
              echo '<td>'.$fila['puesto'].'</td>';
              echo '<td>'.$fila['celular'].'</td>';
              echo '<td>'.$fila['correo'].'</td>';
              echo '<td>'.$fila['direccion'].'</td>';
              if($editar==1){
                echo '<td><button class="btn btn-warning" onclick="editar_usuario('.$fila['id'].')"> Editar</button></td>';
              }
              if($borrar==1){
                echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_usuario('.$fila['id'].')"> Borrar</button></td>';
              }
              echo '</tr>';
            }
          }
          $cont++;
        }
          echo '
            </tbody>
          </table>
          </div>';
          return $cat_paginas;
      }
      // Editar un usuario
      function editar_usuario($id,$usuario,$nivel,$nombre_completo,$puesto,$celular,$correo,$direccion,$usuario_ver,$usuario_agregar,$usuario_editar,$usuario_borrar,$huesped_ver,$huesped_agregar,$huesped_editar,$huesped_borrar,$tipo_ver,$tipo_agregar,$tipo_editar,$tipo_borrar,$tarifa_ver,$tarifa_agregar,$tarifa_editar,$tarifa_borrar,$hab_ver,$hab_agregar,$hab_editar,$hab_borrar,$reservacion_ver,$reservacion_agregar,$reservacion_editar,$reservacion_borrar,$reporte_ver,$forma_pago_ver,$forma_pago_agregar,$forma_pago_editar,$forma_pago_borrar,$inventario_ver,$inventario_agregar,$inventario_editar,$inventario_borrar,$categoria_ver,$categoria_agregar,$categoria_editar,$categoria_borrar,$restaurante_ver,$restaurante_agregar,$restaurante_editar,$restaurante_borrar){
        //$pass=md5($pass);
        $sentencia = "UPDATE `usuario` SET
            `usuario` = '$usuario',
            `nivel` = '$nivel',
            `nombre_completo` = '$nombre_completo',
            `puesto` = '$puesto',
            `celular` = '$celular',
            `correo` = '$correo',
            `direccion` = '$direccion',
            `usuario_ver` = '$usuario_ver',
            `usuario_agregar` = '$usuario_agregar',
            `usuario_editar` = '$usuario_editar',
            `usuario_borrar` = '$usuario_borrar',
            `huesped_ver` = '$huesped_ver',
            `huesped_agregar` = '$huesped_agregar',
            `huesped_editar` = '$huesped_editar',
            `huesped_borrar` = '$huesped_borrar',
            `tipo_ver` = '$tipo_ver',
            `tipo_agregar` = '$tipo_agregar',
            `tipo_editar` = '$tipo_editar',
            `tipo_borrar` = '$tipo_borrar',
            `tarifa_ver` = '$tarifa_ver',
            `tarifa_agregar` = '$tarifa_agregar',
            `tarifa_editar` = '$tarifa_editar',
            `tarifa_borrar` = '$tarifa_borrar',
            `hab_ver` = '$hab_ver',
            `hab_agregar` = '$hab_agregar',
            `hab_editar` = '$hab_editar',
            `hab_borrar` = '$hab_borrar',
            `reservacion_ver` = '$reservacion_ver',
            `reservacion_agregar` = '$reservacion_agregar',
            `reservacion_editar` = '$reservacion_editar',
            `reservacion_borrar` = '$reservacion_borrar',
            `reporte_ver` = '$reporte_ver',
            `forma_pago_ver` = '$forma_pago_ver',
            `forma_pago_agregar` = '$forma_pago_agregar',
            `forma_pago_editar` = '$forma_pago_editar',
            `forma_pago_borrar` = '$forma_pago_borrar',
            `inventario_ver` = '$inventario_ver',
            `inventario_agregar` = '$inventario_agregar',
            `inventario_editar` = '$inventario_editar',
            `inventario_borrar` = '$inventario_borrar',
            `categoria_ver` = '$categoria_ver',
            `categoria_agregar` = '$categoria_agregar',
            `categoria_editar` = '$categoria_editar',
            `categoria_borrar` = '$categoria_borrar',
            `restaurante_ver` = '$restaurante_ver',
            `restaurante_agregar` = '$restaurante_agregar',
            `restaurante_editar` = '$restaurante_editar',
            `restaurante_borrar` = '$restaurante_borrar'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar usuario dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un usuario
      function borrar_usuario($id){
        $sentencia = "UPDATE `usuario` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de usuario como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre del usuario
      function obtengo_usuario($id){
        $usuario= "";
        $sentencia = "SELECT usuario FROM usuario WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el nombre del usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $usuario= $fila['usuario'];
        }
        return $usuario;
      }     
      // Muestra los nombres de los usuarios
      function mostrar_usuario(){
        $sentencia = "SELECT * FROM usuario WHERE usuario.nivel > 0 && estado = 1 ORDER BY usuario";
        $comentario="Mostrar los nombres de los usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['usuario'].'</option>';
        }
        return $consulta;
      }  
      // Muestra los nombres de los usuarios a editar
      function mostrar_usuario_editar($id){
        $sentencia = "SELECT * FROM usuario WHERE usuario.nivel > 0 && estado = 1 ORDER BY usuario";
        $comentario="Mostrar los nombres de los usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($id==$fila['id']){
              echo '  <option value="'.$fila['id'].'" selected>'.$fila['usuario'].'</option>';
          }else{
              echo '  <option value="'.$fila['id'].'">'.$fila['usuario'].'</option>';
          }
        }
      }  
      // Muestra el nivel de los usuarios
      function obtener_nivel($id){
        $sentencia = "SELECT nivel FROM usuario WHERE id = $id LIMIT 1 ";
        //echo $sentencia;
        $comentario="Inicio de nivel usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nivel= $fila['nivel'];
        }
        switch ($nivel) {

            case 1:
                $nivel = "Administrador";
              break;
            case 2:
                $nivel = "Cajera";
              break;
            case 3:
                $nivel = "Recamarera";
              break;
            case 4:
                $nivel = "Mantenimiento";
              break;
            case 5:
                $nivel = "Supervision";
              break;
            case 6:
                $nivel = "Restaurante";
              break;
            case 7:
                $nivel = "Reservaciones";
              break;
            case 8:
                $nivel = "Ama Llaves";
              break;
            case 9:
                $nivel = "Indefinido";
              break;
            default:
                $nivel = "Indeterminado";
              break;
            }   
        return $nivel;
      }
      // Seleccionar recamarera    
      function select_reca($hab_id,$estado,$nuevo_estado){
        if($nuevo_estado == 1){
          $nivel= 3;
        }else{
          $nivel= $nuevo_estado;
        }
        $sentencia = "SELECT * FROM usuario WHERE activo = 1 AND nivel = $nivel AND estado = 1 ORDER BY usuario";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          switch($nuevo_estado){
            case 1:
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                  echo '<div class="select_reca btn-square-lg" onclick="hab_limpieza('.$hab_id.','.$estado.','.$fila['id'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo $fila['usuario'];
                  echo '</div>';
                  /*echo '<div>Limpiadas: ';
                    $fecha= $this->ultima_fecha();
                    echo $this->cantidad_limpieza($fecha,$fila['id']);
                  echo '</div>';*/
                  //echo '</br>';
                echo '</div>';
              echo '</div>';
              break;
            case 3:// Enviar a limpieza
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                  echo '<div class="select_reca btn-square-lg" onclick="hab_limpieza('.$hab_id.','.$estado.','.$fila['id'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo $fila['usuario'];
                  echo '</div>';
                  /*echo '<div>Limpiadas: ';
                    $fecha= $this->ultima_fecha();
                    echo $this->cantidad_limpieza($fecha,$fila['id']);
                  echo '</div>';*/
                  //echo '</br>';
                echo '</div>';
              echo '</div>';
              break;
            case 4:// Enviar a mantenimiento
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                  echo '<div class="select_reca btn-square-lg" onclick="hab_modal_inicial('.$hab_id.','.$nuevo_estado.','.$fila['id'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo $fila['usuario'];
                  echo '</div>';
                echo '</div>';
              echo '</div>';
              break;
            case 5:// Enviar a supervision
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                  echo '<div class="select_reca btn-square-lg" onclick="hab_inicial('.$hab_id.','.$nuevo_estado.','.$fila['id'].')">';
                  echo '</br>';
                  echo '<div>';
                      //echo '<img src="images/persona.png"  class="center-block img-responsive">';
                  echo '</div>';
                  echo '<div>';
                    echo $fila['usuario'];
                  echo '</div>';
                echo '</div>';
              echo '</div>';
              break;
            default:
                    echo "Sin Información que mostrar";
                  echo '</div>';
                echo '</div>';
              break;
          }
        }
      }
      // Seleccionar usuario a cambiar   
      function select_cambiar_usuario($hab_id,$estado,$usuario){
        $cambio= 0;
        switch($estado){
          case 3:// Cambiar recamarera limpieza-edo.3
              $sentencia = "SELECT * FROM usuario WHERE id != $usuario AND activo = 1 AND nivel = 3 AND estado = 1 ORDER BY usuario";
              break;
          case 4:// Cambiar usuario mantenimiento-edo.4
              $sentencia = "SELECT * FROM usuario WHERE id != $usuario AND activo = 1 AND nivel = 4 AND estado = 1 ORDER BY usuario";
              break;
          case 5:// Cambiar usuario supervision-edo.5
              $sentencia = "SELECT * FROM usuario WHERE id != $usuario AND activo = 1 AND nivel = 5 AND estado = 1 ORDER BY usuario";
              break;
          default:
              //echo "Estado indefinido";
              break;
        }
        $comentario="Seleccionar usuario a cambiar";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
              echo '<div class="select_reca btn-square-lg" onclick="hab_cambiar_persona('.$hab_id.','.$estado.','.$fila['id'].')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/persona.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo $fila['usuario'];
              echo '</div>';
            echo '</div>';
          echo '</div>';
          $cambio= $fila['id'];
        }

        if($cambio == 0){// Checar si la consulta de sql esta vacia o no
          echo '<div class="col-sm-12 text-left">
            <div class="text-dark margen-1">
              ¡No existe otro usuario disponible!
            </div>
          </div>';  
        }   
      }
      // Obtener la cantidad de habitaciones limpiadas
      function cantidad_limpieza($fecha,$id){
        $cantidad = 0;
        $sentencia ="SELECT count(*) AS cantidad FROM movimiento WHERE persona_limpio = $id AND inicio_limpieza >= $fecha;";
        //echo $sentencia.'</br>';
        $comentario="Obtener el ultimo movimento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $cantidad= $fila['cantidad'];
        }

        $sentencia ="SELECT count(*) AS cantidad FROM movimiento WHERE detalle_inicio >= $fecha AND (motivo = 'limpieza' OR motivo = 'lavado' OR motivo = 'detalle') AND detalle_realiza = $id;";
        //echo $sentencia.'</br>';
        $comentario="Obtener el ultimo movimento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $cantidad= $cantidad+$fila['cantidad'];
        }
        return $cantidad;
      }
       
  }       
?>