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
      public $usuario_editar;
      public $usuario_borrar;
      public $huesped_editar;
      public $huesped_borrar;
      public $tipo_ver;
      public $tipo_agregar;
      public $tipo_editar;
      public $tipo_borrar;
      public $tarifa_editar;
      public $tarifa_borrar;
      public $hab_ver;
      public $hab_agregar;
      public $hab_editar;
      public $hab_borrar;
      public $reservacion_agregar;
      public $reservacion_editar;
      public $reservacion_borrar;
      public $reservacion_preasignar;
      public $forma_pago_ver;
      public $forma_pago_agregar;
      public $forma_pago_editar;
      public $forma_pago_borrar;
      public $inventario_editar;
      public $inventario_borrar;
      public $categoria_editar;
      public $categoria_borrar;
      public $cupon_ver;
      public $cupon_agregar;
      public $cupon_editar;
      public $cupon_borrar;
      public $logs_ver;
      public $auditoria_ver;
      public $auditoria_editar;
      //Facturacon

      //Combinar cuentas
      public $combinar_cuentas;

      //Graficas
      public $ver_graficas;

      public $check_in;

      public $cuenta_maestra;

      public $reporte_diario;
      
      public $reporte_llegada;

      public $reporte_salidas;

      public $saldo_huspedes;

      public $edo_centa_fc;

      public $ver_reservaciones;

      public $info_huespedes;

      public $reporte_cancelaciones;

      public $reporte_cortes;

      public $cargos_noche;

      public $surtir;

      public $corte_diario;

      public $pronosticos;

      public $historial_cuentas;

      public $ama_de_llaves;

      public $historial_cortes_u;

      public $corte_diario_u;

      public $resumen_transacciones;

      public $factura_individual;

      public $factura_global;

      public $buscar_fc;

      public $cancelar_fac;

      public $bus_fac_fecha;

      public $bus_fac_folio;

      public $bus_fac_folio_casa;

      public $resumen_fac;

      public $restaurante;

      public $agregar_res;

      public $cat_res;

      public $invet_res;

      public $surtir_res;

      public $mesas_res;

      public $agregar_mesas_res;

      public $tipo_hab;

      public $tarifas_hab;

      public $ver_hab;

      public $editar_abonos;

      public $editar_cargos;
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
          $this->usuario_editar= -1;
          $this->usuario_borrar= -1;
          $this->huesped_editar= -1;
          $this->huesped_borrar= -1;
          $this->tipo_ver= -1;
          $this->tipo_agregar= -1;
          $this->tipo_editar= -1;
          $this->tipo_borrar= -1;
          $this->tarifa_editar= -1;
          $this->tarifa_borrar= -1;
          $this->hab_ver= -1;
          $this->hab_agregar= -1;
          $this->hab_editar= -1;
          $this->hab_borrar= -1;
          $this->reservacion_agregar= -1;
          $this->reservacion_editar= -1;
          $this->reservacion_borrar= -1;
          $this->reservacion_preasignar= -1;
          $this->forma_pago_ver= -1;
          $this->forma_pago_agregar= -1;
          $this->forma_pago_editar= -1;
          $this->forma_pago_borrar= -1;
          $this->inventario_editar= -1;
          $this->inventario_borrar= -1;
          $this->categoria_editar= -1;
          $this->categoria_borrar= -1;
          $this->cupon_ver= -1;
          $this->cupon_agregar= -1;
          $this->cupon_editar= -1;
          $this->cupon_borrar= -1;
          $this->logs_ver= -1;

          $this->auditoria_ver= -1;
          $this->auditoria_editar=-1;
          $this->combinar_cuentas= -1;

          $this->ver_graficas = -1;

          $this->check_in = -1;

          $this->cuenta_maestra = -1;

          $this->reporte_diario = -1;

          $this->reporte_llegada = -1;

          $this->reporte_salidas = -1;

          $this->saldo_huspedes = -1;

          $this->edo_centa_fc = -1;

          $this->ver_reservaciones = -1;

          $this->info_huespedes = -1;
          
          $this->reporte_cancelaciones = -1;

          $this->reporte_cortes = -1;

          $this->cargos_noche = -1;

          $this->surtir = -1;

          $this->corte_diario = -1;

          $this->pronosticos = -1;

          $this->historial_cuentas = -1;

          $this->ama_de_llaves = -1;

          $this->historial_cortes_u = -1;

          $this->corte_diario_u = -1;

          $this->resumen_transacciones = -1;

          $this->factura_individual = -1;

          $this->factura_global = -1;

          $this->buscar_fc = -1;

          $this->cancelar_fac = -1;

          $this->bus_fac_fecha = -1;

          $this->bus_fac_folio = -1;

          $this->bus_fac_folio_casa = -1;

          $this->resumen_fac = -1;

          $this->restaurante = -1;

          $this->agregar_res = -1;

          $this->cat_res = -1;

          $this->invet_res = -1;

          $this->surtir_res = -1;

          $this->mesas_res = -1;

          $this->agregar_mesas_res = -1;

          $this->tipo_hab = -1;

          $this->tarifas_hab = -1;

          $this->ver_hab = -1;

          $this->editar_abonos =-1;

          $this->editar_cargos =-1;

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
              $this->usuario_editar= $fila['usuario_editar'];
              $this->usuario_borrar= $fila['usuario_borrar'];
              $this->huesped_editar= $fila['huesped_editar'];
              $this->huesped_borrar= $fila['huesped_borrar'];
              $this->tipo_ver= $fila['tipo_ver'];
              $this->tipo_agregar= $fila['tipo_agregar'];
              $this->tipo_editar= $fila['tipo_editar'];
              $this->tipo_borrar= $fila['tipo_borrar'];
              $this->tarifa_editar= $fila['tarifa_editar'];
              $this->tarifa_borrar= $fila['tarifa_borrar'];
              $this->hab_ver= $fila['hab_ver'];
              $this->hab_agregar= $fila['hab_agregar'];
              $this->hab_editar= $fila['hab_editar'];
              $this->hab_borrar= $fila['hab_borrar'];
              $this->reservacion_agregar= $fila['reservacion_agregar'];
              $this->reservacion_editar= $fila['reservacion_editar'];
              $this->reservacion_borrar= $fila['reservacion_borrar'];
              $this->reservacion_preasignar= $fila['reservacion_preasignar'];
              $this->forma_pago_ver= $fila['forma_pago_ver'];
              $this->forma_pago_agregar= $fila['forma_pago_agregar'];
              $this->forma_pago_editar= $fila['forma_pago_editar'];
              $this->forma_pago_borrar= $fila['forma_pago_borrar'];
              $this->inventario_editar= $fila['inventario_editar'];
              $this->inventario_borrar= $fila['inventario_borrar'];
              $this->categoria_editar= $fila['categoria_editar'];
              $this->categoria_borrar= $fila['categoria_borrar'];
              $this->cupon_ver= $fila['cupon_ver'];
              $this->cupon_agregar= $fila['cupon_agregar'];
              $this->cupon_editar= $fila['cupon_editar'];
              $this->cupon_borrar= $fila['cupon_borrar'];
              $this->logs_ver= $fila['logs_ver'];
              
              $this->auditoria_editar= $fila['auditoria_editar'];
              $this->auditoria_ver= $fila['auditoria_ver'];
              $this->combinar_cuentas= $fila['combinar_cuentas'];
              $this->ver_graficas = $fila['ver_graficas'];
              $this->check_in = $fila['check_in'];
              $this->cuenta_maestra = $fila['cuenta_maestra'];
              $this->reporte_diario = $fila['reporte_diario'];
              $this->reporte_llegada = $fila['reporte_llegada'];
              $this->reporte_salidas = $fila['reporte_salidas'];
              $this->saldo_huspedes = $fila['saldo_huspedes'];
              $this->edo_centa_fc = $fila['edo_centa_fc'];
              $this->ver_reservaciones = $fila['ver_reservaciones'];
              $this->info_huespedes = $fila['info_huespedes'];
              $this->reporte_cancelaciones = $fila['reporte_cancelaciones'];
              $this->reporte_cortes = $fila['reporte_cortes'];
              $this->cargos_noche = $fila['cargos_noche'];
              $this->surtir = $fila['surtir'];
              $this->corte_diario = $fila['corte_diario'];
              $this->pronosticos = $fila["pronosticos"];
              $this->historial_cuentas = $fila["historial_cuentas"];
              $this->ama_de_llaves = $fila["ama_de_llaves"];
              $this->historial_cortes_u = $fila["historial_cortes_u"];
              $this->corte_diario_u = $fila["corte_diario_u"];
              $this->resumen_transacciones = $fila["resumen_transacciones"];
              $this->factura_individual = $fila["factura_individual"];
              $this->factura_global = $fila["factura_global"];
              $this->buscar_fc = $fila["buscar_fc"];
              $this->cancelar_fac = $fila["cancelar_fac"];
              $this->bus_fac_fecha = $fila["bus_fac_fecha"];
              $this->bus_fac_folio = $fila["bus_fac_folio"];
              $this->bus_fac_folio_casa = $fila["bus_fac_folio_casa"];
              $this->resumen_fac = $fila["resumen_fac"];
              $this->restaurante = $fila["restaurante"];
              $this->agregar_res = $fila["agregar_res"];
              $this->cat_res = $fila["cat_res"];
              $this->invet_res = $fila["invet_res"];
              $this->surtir_res = $fila["surtir_res"];
              $this->mesas_res = $fila["mesas_res"];
              $this->agregar_mesas_res = $fila["agregar_mesas_res"];
              $this->tipo_hab = $fila["tipo_hab"];
              $this->tarifas_hab = $fila["tarifas_hab"];
              $this->ver_hab = $fila["ver_hab"];
              $this->editar_abonos = $fila["editar_abonos"];
              $this->editar_cargos = $fila["editar_cargos"];
          }
          $this->usuario_privilegio=$this->usuario_editar+$this->usuario_borrar+$this->huesped_editar+$this->huesped_borrar+$this->tipo_ver+$this->tipo_agregar+$this->tipo_editar+$this->tipo_borrar+$this->tarifa_editar+$this->tarifa_borrar+$this->hab_ver+$this->hab_agregar+$this->hab_editar+$this->hab_borrar+$this->reservacion_agregar+$this->reservacion_editar+$this->reservacion_borrar+$this->forma_pago_ver+$this->forma_pago_agregar+$this->forma_pago_editar+$this->forma_pago_borrar+$this->inventario_editar+$this->inventario_borrar+$this->categoria_editar+$this->categoria_borrar+$this->cupon_ver+$this->cupon_agregar+$this->cupon_editar+$this->cupon_borrar+$this->logs_ver;
        }  
      }

      //Obtener si un usuario es valido en base a su id y contraseña

      function evaluar_password($usuario_id,$password_evaluar){
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $id=0;
        $sentencia = "SELECT id FROM usuario WHERE id = '$usuario_id' AND pass= '$password_evaluar' AND estado = 1";
        $comentario="Obtenemos el usuario y contraseña de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
          // Guardamos logs de inicio de session
          $logs->guardar_log($fila['id'],"Consultando contraseña del usuario: ".$id);
        }
        return $id;
      }

      function remover_token($usuario){
        include_once('clase_log.php');
        $sentencia="DELETE FROM token WHERE usuario=$usuario";
        $comentario ="Eliminando token del usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo "SI";
        }else{
          echo "NO";
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

      //Se evalua la existencia del token del usuario dado.
       
        function evaluarToken($usuario_evaluar){
          include_once("clase_log.php");
          $logs = NEW Log(0);
          $id=0;
          $sentencia = "SELECT id FROM token WHERE usuario = '$usuario_evaluar'";
         
          $comentario="Obtenemos el token del usuario dado en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          while ($fila = mysqli_fetch_array($consulta))
          {
            $id= $fila['id'];
            // Guardamos logs de inicio de session
            $logs->guardar_log($fila['id'],"Intento de inicio session el usuario: ".$id . "en otro dispositivo");
          }
          return $id;
        }

      // Evaluar entrada de sesion
      function evaluarEntrada($usuario_evaluar ,$password_evaluar){
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $id=0;
        $sentencia = "SELECT id,nivel FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND estado = 1";
        $comentario="Obtenemos el usuario y contraseña de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
          $nivel =$fila['nivel'];
          // Guardamos logs de inicio de session
          $logs->guardar_log($fila['id'],"Inicio de session el usuario: ".$id);
        }
        return [$id,$nivel];
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
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
                VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1', 
                '1'
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;

          case 2:// guarda nivel cajera
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0', 
                '0',
                '1',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '1',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0'
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 
                
          case 3:// guarda nivel recamarera
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
                VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1', 
                '0',
                '0', 
                '0',
                '0',
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0', 
                '0'  
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break; 
                
          case 4:// guarda nivel mantenimiento
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;
              
          case 5:// guarda nivel supervision
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break;

          case 6:// guarda nivel restaurante
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 
                
          case 7:// guarda nivel reservaciones
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '1',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break; 
                
          case 8:// guarda nivel ama llaves
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario);
              break; 

          case 9:// guarda nivel indefinido
              $pass=md5($pass);
              $sentencia = "INSERT INTO `usuario` (
                `usuario`, 
                `pass`, 
                `nivel`, 
                `estado`, 
                `activo`, 
                `nombre_completo`, 
                `puesto`, 
                `celular`, 
                `correo`, 
                `direccion`,
                `usuario_editar`,
                `usuario_borrar`,
                `huesped_editar`,
                `huesped_borrar`,
                `tarifa_editar`,
                `tarifa_borrar`,
                `reservacion_agregar`,
                `reservacion_editar`,
                `reservacion_borrar`,
                `reservacion_preasignar`,
                `forma_pago_ver`,
                `forma_pago_agregar`,
                `forma_pago_editar`,
                `forma_pago_borrar`,
                `inventario_editar`,
                `inventario_borrar`,
                `categoria_editar`,
                `categoria_borrar`,
                `cupon_ver`,
                `cupon_agregar`,
                `cupon_editar`,
                `cupon_borrar`,
                `logs_ver`,
                `auditoria_ver`,
                `auditoria_editar`,
                `combinar_cuentas`,
                `ver_graficas`,
                `check_in`,
                `cuenta_maestra`,
                `reporte_diario`,
                `reporte_llegada`,
                `reporte_salidas`,
                `saldo_huspedes`,
                `edo_centa_fc`,
                `ver_reservaciones`,
                `info_huespedes`,
                `reporte_cancelaciones`,
                `reporte_cortes`,
                `cargos_noche`,
                `surtir`,
                `corte_diario`,
                `pronosticos`,
                `historial_cuentas`,
                `ama_de_llaves`,
                `historial_cortes_u`,
                `corte_diario_u`,
                `resumen_transacciones`,
                `factura_individual`,
                `factura_global`,
                `buscar_fc`,
                `cancelar_fac`,
                `bus_fac_fecha`,
                `bus_fac_folio`,
                `bus_fac_folio_casa`,
                `resumen_fac`,
                `restaurante`,
                `agregar_res`,
                `cat_res`,
                `invet_res`,
                `surtir_res`,
                `mesas_res`,
                `agregar_mesas_res`,
                `tipo_hab`,
                `tarifas_hab`,
                `ver_hab`,
                `editar_abonos`,
                `editar_cargos`
               )
               VALUES (
                '$usuario', 
                '$pass', 
                '$nivel', 
                '1', 
                '1',
                '$nombre_completo', 
                '$puesto', 
                '$celular', 
                '$correo', 
                '$direccion', 
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0' 
                );";
              $comentario="Guardamos el usuario en la base de datos";
              $consulta= $this->realizaConsulta($sentencia,$comentario); 
              break;    
                
          default:// indeterminado
              echo "Aun no se encuentra registrado ese nivel de usuario";
              break; 

          
        }
        
        return $consulta;
      }
      // Evaluar los datos de un usuario para autorizar un cambio
      function evaluar_datos($usuario_evaluar,$contrasena_evaluar){
        $id= 0;
        $sentencia= "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$contrasena_evaluar' AND nivel <= 1 AND estado = 1";
        $comentario= "Evaluar los datos de un usuario para autorizar un cambio";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia;
        while ($fila = mysqli_fetch_array($consulta))
        {
            $id= $fila['id'];
        }
        return $id;
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
         echo '<div class="table-responsive" id="tabla_usuario" >
           <table class="table  table-hover">
             <thead>
               <tr class="table-primary-encabezado text-center">
               <th>Usuario</th>
               <th>Nivel</th>
               <th>Nombre completo</th>
               <th>Puesto</th>
               <th>Celular o teléfono</th>
               <th>Correo</th>
               <th>Dirección</th>
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
      function editar_usuario($id,$usuario,$nivel,$nombre_completo,$puesto,$celular,$correo,$direccion,$usuario_editar,$usuario_borrar,$huesped_editar,$huesped_borrar,$tarifa_editar,$tarifa_borrar,$reservacion_agregar,$reservacion_editar,$reservacion_borrar,$reservacion_preasignar,$forma_pago_ver,$forma_pago_agregar,$forma_pago_editar,$forma_pago_borrar,$inventario_editar,$inventario_borrar,$categoria_editar,$categoria_borrar,$cupon_ver,$cupon_agregar,$cupon_editar,$cupon_borrar,$logs_ver,$auditoria_ver,$auditoria_editar,$combinar_cuentas,$ver_graficas,$check_in,$cuenta_maestra,$reporte_diario,$reporte_llegada,$reporte_salidas,$saldo_huspedes,$edo_centa_fc,$ver_reservaciones,$info_huespedes , $reporte_cancelaciones,$reporte_cortes,$cargos_noche,$surtir,$corte_diario,$pronosticos,$historial_cuentas,$ama_de_llaves,$historial_cortes_u,$corte_diario_u,$resumen_transacciones,$factura_individual,$factura_global,$buscar_fc,$cancelar_fac, $bus_fac_fecha, $bus_fac_folio, $bus_fac_folio_casa, $resumen_fac, $restaurante, $agregar_res, $cat_res, $invet_res, $surtir_res, $mesas_res, $agregar_mesas_res, $tipo_hab, $tarifas_hab, $ver_hab, $editar_abonos, $editar_cargos){
       
        $sentencia = "UPDATE `usuario` SET
        `usuario` = '$usuario',
        `nivel` = '$nivel',
        `nombre_completo` = '$nombre_completo',
        `puesto` = '$puesto',
        `celular` = '$celular',
        `correo` = '$correo',
        `direccion` = '$direccion',
        `usuario_editar` = '$usuario_editar',
        `usuario_borrar` = '$usuario_borrar',
        `huesped_editar` = '$huesped_editar',
        `huesped_borrar` = '$huesped_borrar',
        `tarifa_editar` = '$tarifa_editar',
        `tarifa_borrar` = '$tarifa_borrar',
        `reservacion_agregar` = '$reservacion_agregar',
        `reservacion_editar` = '$reservacion_editar',
        `reservacion_borrar` = '$reservacion_borrar',
        `reservacion_preasignar` = $reservacion_preasignar,
        `forma_pago_ver` = '$forma_pago_ver',
        `forma_pago_agregar` = '$forma_pago_agregar',
        `forma_pago_editar` = '$forma_pago_editar',
        `forma_pago_borrar` = '$forma_pago_borrar',
        `inventario_editar` = '$inventario_editar',
        `inventario_borrar` = '$inventario_borrar',
        `categoria_editar` = '$categoria_editar',
        `categoria_borrar` = '$categoria_borrar',
        `cupon_ver` = '$cupon_ver',
        `cupon_agregar` = '$cupon_agregar',
        `cupon_editar` = '$cupon_editar',
        `cupon_borrar` = '$cupon_borrar',
        `logs_ver` = '$logs_ver',
        `auditoria_ver` = $auditoria_ver,
        `auditoria_editar` = $auditoria_editar,
        `combinar_cuentas` = $combinar_cuentas,
        `ver_graficas` = $ver_graficas,
        `check_in` = $check_in,
        `cuenta_maestra` = $cuenta_maestra,
        `reporte_diario` = $reporte_diario,
        `reporte_llegada` = $reporte_llegada,
        `reporte_salidas` = $reporte_salidas,
        `saldo_huspedes` = $saldo_huspedes,
        `edo_centa_fc` = $edo_centa_fc,
        `ver_reservaciones` = $ver_reservaciones,
        `info_huespedes` = $info_huespedes,
        `reporte_cancelaciones` = $reporte_cancelaciones,
        `reporte_cortes` = $reporte_cortes,
        `cargos_noche` = $cargos_noche,
        `surtir` = $surtir,
        `corte_diario` = $corte_diario,
        `pronosticos` = $pronosticos,
        `historial_cuentas` = $historial_cuentas,
        `ama_de_llaves` = $ama_de_llaves,
        `historial_cortes_u` = $historial_cortes_u,
        `corte_diario_u` = $corte_diario_u,
        `resumen_transacciones` = $resumen_transacciones,
        `factura_individual` = $factura_individual,
        `factura_global` = $factura_global,
         `buscar_fc` = $buscar_fc,
         `cancelar_fac` = $cancelar_fac,
         `bus_fac_fecha` = $bus_fac_fecha,
         `bus_fac_folio` = $bus_fac_folio,
         `bus_fac_folio_casa` = $bus_fac_folio_casa,
         `resumen_fac` = $resumen_fac,
         `restaurante` = $restaurante,
         `agregar_res` = $agregar_res,
         `cat_res` = $cat_res,
         `invet_res` = $invet_res,
         `surtir_res` = $surtir_res,
         `mesas_res` = $mesas_res,
         `agregar_mesas_res` = $agregar_mesas_res,
         `tipo_hab` = $tipo_hab,
         `tarifas_hab` = $tarifas_hab,
         `ver_hab` = $ver_hab,
         `editar_abonos` = $editar_abonos,
         `editar_cargos` = $editar_cargos
        WHERE `id` = '$id'";
        //echo $sentencia ;
         // die();
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
      // Obtengo el nombre completo del usuario
      function obtengo_nombre_completo($id){
        $nombre_completo= "";
        $sentencia = "SELECT nombre_completo FROM usuario WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el nombre completo del usuario";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre_completo= $fila['nombre_completo'];
        }
        return $nombre_completo;
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
        // echo $hab_id . "|" . $estado ."|".$nuevo_estado;
        if($nuevo_estado == 2){
          $nivel = 3;
        }

        $sentencia = "SELECT * FROM usuario WHERE activo = 1 AND nivel = $nivel AND estado = 1 ORDER BY usuario";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        // echo $sentencia . "|" . $nuevo_estado;

        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          switch($nuevo_estado){
            case 1: case 2:
              echo '<div class="btn_modal_herramientas btn_asginar_recam" onclick="hab_limpieza('.$hab_id.','.$estado.','.$fila['id'].')">';
              echo '<img  class="btn_modal_img" src="./assets/iconos_btn/user-solid.svg"/>';        
                echo $fila['usuario'];
                    echo '</div>';

              break;
            case 3: // Enviar a limpieza
              echo '<div class="select_reca btn-square-lg" onclick="hab_limpieza('.$hab_id.','.$estado.','.$fila['id'].')">';
              echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
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
                  echo '<div class="btn_modal_herramientas btn_asginar_mtto" onclick="hab_modal_inicial('.$hab_id.','.$nuevo_estado.','.$fila['id'].')">';
                  echo '<img  class="btn_modal_img" src="./assets/iconos_btn/user-solid.svg"/>';        
                    echo $fila['usuario'];
                  echo '</div>';
              break;
            case 5:// Enviar a supervision
              
                  echo '<div class="btn_modal_herramientas btn_asginar_surpev" onclick="hab_inicial('.$hab_id.','.$nuevo_estado.','.$fila['id'].')">';
                  echo '<img  class="btn_modal_img" src="./assets/iconos_btn/user-solid.svg"/>';        
                    echo $fila['usuario'];
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
          echo '<div class="btn_modal_herramientas btn_cambiar_hab" onclick="hab_cambiar_persona('.$hab_id.','.$estado.','.$fila['id'].')">';
          echo '<img  class="btn_modal_img" src="./assets/iconos_btn/user-solid.svg"/>';        
                echo $fila['usuario'];
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