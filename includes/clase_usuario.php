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
      public $activo;//
      public $usuario_privilegio;
      public $usuario_ver;
      public $usuario_agregar;
      public $usuario_editar;
      public $usuario_borrar;
      public $cliente_ver;
      public $cliente_agregar;
      public $cliente_editar;
      public $cliente_borrar;
      public $inventario_ver;
      public $inventario_agregar;
      public $inventario_editar;
      public $inventario_borrar;
      public $requisicion_ver;
      public $requisicion_agregar;
      public $requisicion_editar;
      public $requisicion_borrar;
      public $salida_ver;
      public $salida_agregar;
      public $salida_editar;
      public $salida_borrar;
      public $salida_aprobar;
      public $regreso_ver;
      public $regreso_agregar;
      public $regreso_editar;
      public $regreso_borrar;
      public $necesidades_ver;
      public $necesidades_agregar;
      public $necesidades_editar;
      public $necesidades_borrar;
      public $cotizaciones_ver;
      public $cotizaciones_agregar;
      public $cotizaciones_editar;
      public $cotizaciones_borrar;
      public $servicio_ver;
      public $desperdicio_entrada_ver;
      public $desperdicio_entrada_agregar;
      public $desperdicio_entrada_editar;
      public $desperdicio_entrada_borrar;
      public $desperdicio_salida_ver;
      public $desperdicio_salida_agregar;
      public $desperdicio_salida_editar;
      public $desperdicio_salida_borrar;
      public $logs_ver;

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
          $this->cliente_ver= -1;
          $this->cliente_agregar= -1;
          $this->cliente_editar= -1;
          $this->cliente_borrar= -1;
          $this->inventario_ver= -1;
          $this->inventario_agregar= -1;
          $this->inventario_editar= -1;
          $this->inventario_borrar= -1;
          $this->requisicion_ver= -1;
          $this->requisicion_agregar= -1;
          $this->requisicion_editar= -1;
          $this->requisicion_borrar= -1;
          $this->salida_ver= -1;
          $this->salida_agregar= -1;
          $this->salida_editar= -1;
          $this->salida_borrar= -1;
          $this->salida_aprobar= -1;
          $this->regreso_ver= -1;
          $this->regreso_agregar= -1;
          $this->regreso_editar= -1;
          $this->regreso_borrar= -1;
          $this->necesidades_ver= -1;
          $this->necesidades_agregar= -1;
          $this->necesidades_editar= -1;
          $this->necesidades_borrar= -1;
          $this->cotizaciones_ver= -1;
          $this->cotizaciones_agregar= -1;
          $this->cotizaciones_editar= -1;
          $this->cotizaciones_borrar= -1;
          $this->servicio_ver= -1;
          $this->desperdicio_entrada_ver= -1;
          $this->desperdicio_entrada_agregar= -1;
          $this->desperdicio_entrada_editar= -1;
          $this->desperdicio_entrada_borrar= -1;
          $this->desperdicio_salida_ver= -1;
          $this->desperdicio_salida_agregar= -1;
          $this->desperdicio_salida_editar= -1;
          $this->desperdicio_salida_borrar= -1;
          $this->logs_ver= -1;
          
          }else{
          $sentencia = "SELECT * FROM usuario WHERE id = $id_usuario LIMIT 1";
          //echo $sentencia ;
          $comentario="Asignación de usuarios a la clase usuario funcion constructor";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->usuario= $fila['usuario'];
              $this->pass= $fila['pass'];
              $this->nivel= $fila['nivel'];
              switch ($fila['nivel']) {

                  case 0:
                      $this->nivel_texto='Master';
                  break;
                  case 1:
                      $this->nivel_texto='Administrador';
                  break;
                  case 2:
                      $this->nivel_texto='Almacen';
                      ;
                  break;
                  case 3:
                      $this->nivel_texto='Ventas';

                  break;
                  case 4:
                      $this->nivel_texto='Compras';

                  break;

                  case 5:
                      $this->nivel_texto='Tecnico';

                  break;
                  default:
                      $this->nivel_texto='Indefinido';

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
              $this->cliente_ver= $fila['cliente_ver'];
              $this->cliente_agregar= $fila['cliente_agregar'];
              $this->cliente_editar= $fila['cliente_editar'];
              $this->cliente_borrar= $fila['cliente_borrar'];
              $this->inventario_ver= $fila['inventario_ver'];
              $this->inventario_agregar= $fila['inventario_agregar'];
              $this->inventario_editar= $fila['inventario_editar'];
              $this->inventario_borrar= $fila['inventario_borrar'];
              $this->requisicion_ver=  $fila['requisicion_ver'];
              $this->requisicion_agregar= $fila['requisicion_agregar'];
              $this->requisicion_editar= $fila['requisicion_editar'];
              $this->requisicion_borrar= $fila['requisicion_borrar'];
              $this->salida_ver= $fila['salida_ver'];
              $this->salida_agregar= $fila['salida_agregar'];
              $this->salida_editar= $fila['salida_editar'];
              $this->salida_borrar= $fila['salida_borrar'];
              $this->salida_aprobar= $fila['salida_aprobar'];
              $this->regreso_ver= $fila['regreso_ver'];
              $this->regreso_agregar= $fila['regreso_agregar'];
              $this->regreso_editar= $fila['regreso_editar'];
              $this->regreso_borrar= $fila['regreso_borrar'];
              $this->necesidades_ver= $fila['necesidades_ver'];
              $this->necesidades_agregar= $fila['necesidades_agregar'];
              $this->necesidades_editar= $fila['necesidades_editar'];
              $this->necesidades_borrar= $fila['necesidades_borrar'];
              $this->cotizaciones_ver= $fila['cotizaciones_ver'];
              $this->cotizaciones_agregar= $fila['cotizaciones_agregar'];
              $this->cotizaciones_editar= $fila['cotizaciones_editar'];
              $this->cotizaciones_borrar= $fila['cotizaciones_borrar'];
              $this->servicio_ver= $fila['servicio_ver'];
              $this->desperdicio_entrada_ver= $fila['desperdicio_entrada_ver'];
              $this->desperdicio_entrada_agregar= $fila['desperdicio_entrada_agregar'];
              $this->desperdicio_entrada_editar= $fila['desperdicio_entrada_editar'];
              $this->desperdicio_entrada_borrar= $fila['desperdicio_entrada_borrar'];
              $this->desperdicio_salida_ver= $fila['desperdicio_salida_ver'];
              $this->desperdicio_salida_agregar= $fila['desperdicio_salida_agregar'];
              $this->desperdicio_salida_editar= $fila['desperdicio_salida_editar'];
              $this->desperdicio_salida_borrar= $fila['desperdicio_salida_borrar'];
              $this->logs_ver= $fila['logs_ver'];
              
              }
          $this->usuario_privilegio=$this->usuario_ver+$this->usuario_editar+$this->usuario_borrar+$this->usuario_agregar+$this->cliente_ver+$this->cliente_agregar+$this->cliente_editar+$this->cliente_borrar+$this->inventario_ver+$this->inventario_agregar+$this->inventario_editar+$this->inventario_borrar+$this->requisicion_ver+$this->requisicion_agregar+$this->requisicion_editar+$this->requisicion_borrar+$this->salida_ver+$this->salida_agregar+$this->salida_editar+$this->salida_borrar+$this->salida_aprobar+$this->regreso_ver+$this->regreso_agregar+$this->regreso_editar+$this->regreso_borrar+$this->necesidades_ver+$this->necesidades_agregar+$this->necesidades_editar+$this->necesidades_borrar+$this->cotizaciones_ver+$this->cotizaciones_agregar+$this->cotizaciones_editar+$this->cotizaciones_borrar+$this->servicio_ver+$this->desperdicio_entrada_ver+$this->desperdicio_entrada_agregar+$this->desperdicio_entrada_editar+$this->desperdicio_entrada_borrar+$this->desperdicio_salida_ver+$this->desperdicio_salida_agregar+$this->desperdicio_salida_editar+$this->desperdicio_salida_borrar+$this->logs_ver;
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
          include_once('clase_log.php');
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
              case 0:// guarda nivel master
                  echo "Este nivel corresponde al master";
                  break;

              case 1:// guarda nivel administrador
                  $pass=md5($pass);
                  $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_aprobar`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`, `servicio_ver`, `desperdicio_entrada_ver`, `desperdicio_entrada_agregar`, `desperdicio_entrada_editar`, `desperdicio_entrada_borrar`, `desperdicio_salida_ver`, `desperdicio_salida_agregar`, `desperdicio_salida_editar`, `desperdicio_salida_borrar`, `logs_ver`)
                  VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
                  $comentario="Guardamos el usuario en la base de datos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  break;

              case 2:// guarda nivel almacen
                  $pass=md5($pass);
                  $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_aprobar`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`, `servicio_ver`, `desperdicio_entrada_ver`, `desperdicio_entrada_agregar`, `desperdicio_entrada_editar`, `desperdicio_entrada_borrar`, `desperdicio_salida_ver`, `desperdicio_salida_agregar`, `desperdicio_salida_editar`, `desperdicio_salida_borrar`, `logs_ver`)
                  VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1', '1', '1', '1', '1', '1', '0', '0', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');";
                  $comentario="Guardamos el usuario en la base de datos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  break; 
                  
              case 3:// guarda nivel ventas 
                  $pass=md5($pass);
                  $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_aprobar`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`, `servicio_ver`, `desperdicio_entrada_ver`, `desperdicio_entrada_agregar`, `desperdicio_entrada_editar`, `desperdicio_entrada_borrar`, `desperdicio_salida_ver`, `desperdicio_salida_agregar`, `desperdicio_salida_editar`, `desperdicio_salida_borrar`, `logs_ver`)
                  VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
                  $comentario="Guardamos el usuario en la base de datos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario); 
                  break; 
                  
              case 4:// guarda nivel compras 
                  $pass=md5($pass);
                  $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_aprobar`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`, `servicio_ver`, `desperdicio_entrada_ver`, `desperdicio_entrada_agregar`, `desperdicio_entrada_editar`, `desperdicio_entrada_borrar`, `desperdicio_salida_ver`, `desperdicio_salida_agregar`, `desperdicio_salida_editar`, `desperdicio_salida_borrar`, `logs_ver`)
                  VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
                  $comentario="Guardamos el usuario en la base de datos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  break;        
                  
              case 5:// guarda nivel tecnico
                  $pass=md5($pass);
                  $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_editar`, `usuario_borrar`, `usuario_agregar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_aprobar`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`,  `servicio_ver`, `desperdicio_entrada_ver`, `desperdicio_entrada_agregar`, `desperdicio_entrada_editar`, `desperdicio_entrada_borrar`, `desperdicio_salida_ver`, `desperdicio_salida_agregar`, `desperdicio_salida_editar`, `desperdicio_salida_borrar`, `logs_ver`)
                  VALUES ('$usuario', '$pass', '$nivel', '1', '1','$nombre_completo', '$puesto', '$celular', '$correo', '$direccion', '1', '1', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
                  $comentario="Guardamos el usuario en la base de datos";
                  $consulta= $this->realizaConsulta($sentencia,$comentario);
                  break;     
                  
              default:
                  echo "Aun no se encuentra registrado ese nivel de usuario";
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
      function mostrar($id){
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0){
           $cat_paginas++;
         }
         $ultimoid=0;

        if($id==0){
          $sentencia = "SELECT * FROM usuario WHERE nivel > 0 && estado = 1 ORDER BY nivel, usuario LIMIT 20";
          $comentario="Mostrar los usuarios";
         }
        else{
          $sentencia = "SELECT * FROM usuario WHERE nivel > 0 && estado = 1 && id >= '.$id.' ORDER BY nivel, usuario LIMIT 20;";
          $comentario="Mostrar los usuarios";
        }
         $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
         echo '<div class="table-responsive" id="tabla_usuario">
           <table class="table table-bordered table-hover">
             <thead>
               <tr class="table-primary text-center">
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
          if($fila['nivel']>0){
            echo '<tr class="text-center">
            <tr class="text-center">
            <td class="texto_entrada">'.$fila['usuario'].'</td>';
            switch ($fila['nivel']) {
  
               case 1:
                  echo '<td class="texto_entrada">Administrador</td>';
                break;
               case 2:
                   echo '<td class="texto_entrada">Almacen</td>';
                break;
               case 3:
                  echo '<td class="texto_entrada">Ventas</td>';
                break;
               case 4:
                  echo '<td class="texto_entrada">Compras</td>';
                break;
               case 5:
                  echo '<td class="texto_entrada">Tecnico</td>';
                break;
               default:
                  echo '<td class="texto_entrada">Indefinido</td>';
                break;
            }
            echo '<td class="texto_entrada">'.$fila['nombre_completo'].'</td>';
            echo '<td class="texto_entrada">'.$fila['puesto'].'</td>';
            echo '<td class="texto_entrada">'.$fila['celular'].'</td>';
            echo '<td class="texto_entrada">'.$fila['correo'].'</td>';
            echo '<td class="texto_entrada">'.$fila['direccion'].'</td>';
            echo '
            <td><button class="btn btn-outline-info btn-lg" onclick="editar_usuario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>
            <td><button class="btn btn-outline-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_usuario('.$fila['id'].')"> Borrar</button></td>
            </tr>';
          }
        }
          echo '
            </tbody>
          </table>
          </div>
          <ul class="pagination">';
          $new_id=((($id-1)/20))+1;
          $new_id_inicial=($new_id-4)-1;
          $new_id_final=($new_id+4)-1;
          for($i = 0; $i < $cat_paginas; $i++){
            $pagina=($i+1);
            if($i>=$new_id_inicial && $i <= $new_id_final ){
              if($pagina== $new_id){
                echo '
                <li class="page-item active" onclick="ver_usuarios('.(($i*20)+1).')"><a class="page-link" href="#">'.($i+1).'</a></li>';
              }else{
                echo '
                <li class="page-item" onclick="ver_usuarios('.(($i*20)+1).')"><a class="page-link" href="#">'.($i+1).'</a></li>';
              }
            }       
          }
          echo ' </ul>';
      }
      // Editar un usuario
      function editar_usuario($id,$usuario,$pass,$nivel,$nombre_completo,$puesto,$celular,$correo,$direccion,$usuario_ver,$usuario_agregar,$usuario_editar,$usuario_borrar,$cliente_ver,$cliente_agregar,$cliente_editar,$cliente_borrar,$inventario_ver,$inventario_agregar,$inventario_editar,$inventario_borrar,$requisicion_ver,$requisicion_agregar,$requisicion_editar,$requisicion_borrar,$salida_ver,$salida_agregar,$salida_editar,$salida_borrar,$salida_aprobar,$regreso_ver,$regreso_agregar,$regreso_editar,$regreso_borrar,$necesidades_ver,$necesidades_agregar,$necesidades_editar,$necesidades_borrar,$cotizaciones_ver,$cotizaciones_agregar,$cotizaciones_editar,$cotizaciones_borrar,$servicio_ver,$desperdicio_entrada_ver,$desperdicio_entrada_agregar,$desperdicio_entrada_editar,$desperdicio_entrada_borrar,$desperdicio_salida_ver,$desperdicio_salida_agregar,$desperdicio_salida_editar,$desperdicio_salida_borrar,$logs_ver){
        $pass=md5($pass);
        $sentencia = "UPDATE `usuario` SET
            `usuario` = '$usuario',
            `pass` = '$pass',
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
            `cliente_ver` = '$cliente_ver',
            `cliente_agregar` = '$cliente_agregar',
            `cliente_editar` = '$cliente_editar',
            `cliente_borrar` = '$cliente_borrar',
            `inventario_ver` = '$inventario_ver',
            `inventario_agregar` = '$inventario_agregar',
            `inventario_editar` = '$inventario_editar',
            `inventario_borrar` = '$inventario_borrar',
            `requisicion_ver` = '$requisicion_ver',
            `requisicion_agregar` = '$requisicion_agregar',
            `requisicion_editar` = '$requisicion_editar',
            `requisicion_borrar` = '$requisicion_borrar',
            `salida_ver` = '$salida_ver',
            `salida_agregar` = '$salida_agregar',
            `salida_editar` = '$salida_editar',
            `salida_borrar` = '$salida_borrar',
            `salida_aprobar` = '$salida_aprobar',
            `regreso_ver` = '$regreso_ver',
            `regreso_agregar` = '$regreso_agregar',
            `regreso_editar` = '$regreso_editar',
            `regreso_borrar` = '$regreso_borrar',
            `necesidades_ver` = '$necesidades_ver',
            `necesidades_agregar` = '$necesidades_agregar',
            `necesidades_editar` = '$necesidades_editar',
            `necesidades_borrar` = '$necesidades_borrar',
            `cotizaciones_ver` = '$cotizaciones_ver',
            `cotizaciones_agregar` = '$cotizaciones_agregar',
            `cotizaciones_editar` = '$cotizaciones_editar',
            `cotizaciones_borrar` = '$cotizaciones_borrar',
            `servicio_ver` = '$servicio_ver',
            `desperdicio_entrada_ver` = '$desperdicio_entrada_ver',
            `desperdicio_entrada_agregar` = '$desperdicio_entrada_agregar',
            `desperdicio_entrada_editar` = '$desperdicio_entrada_editar',
            `desperdicio_entrada_borrar` = '$desperdicio_entrada_borrar',
            `desperdicio_salida_ver` = '$desperdicio_salida_ver',
            `desperdicio_salida_agregar` = '$desperdicio_salida_agregar',
            `desperdicio_salida_editar` = '$desperdicio_salida_editar',
            `desperdicio_salida_borrar` = '$desperdicio_salida_borrar',
            `logs_ver` = '$logs_ver'
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
      // Muestra los nombres de los usuarios en aprobar requisicion
      function mostrar_usuario_aprobacion(){
        $sentencia = "SELECT * FROM usuario WHERE usuario.nivel = 2 && estado = 1 ORDER BY usuario";
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
        return $consulta;
      }
      // Muestra los nombres de los tecnicos en recibir salida
      function mostrar_usuario_recibe(){
        $sentencia = "SELECT * FROM usuario WHERE usuario.nivel = 5 && estado = 1 ORDER BY usuario";
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
        return $consulta;
      }
      // Muestra los nombres de los usuarios a editar
      function mostrar_usuario_recibe_editar($id){
        $sentencia = "SELECT * FROM usuario WHERE usuario.nivel = 5 && estado = 1 ORDER BY usuario";
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
      // Muestra los nombres de los usuarios
      function mostrar_usuario(){
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
                $nivel = "Almacen";
              break;
            case 3:
                $nivel = "Ventas";
              break;
            case 4:
                $nivel = "Compras";
              break;
              case 5:
                $nivel = "Tecnico";
              break;
            default:
                $nivel = "Indefinido";
              break;
            }   
        return $nivel;
      }    
       
  }       
?>