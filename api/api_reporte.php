<?php
    header("Content-Type: application/json");
    include_once("../includes/clase_log.php");
    include_once("../includes/clase_servicio.php");
    include_once("../includes/clase_api_externa.php");

    //METODO DE LA PETICION 
    //echo "Metodo HTTP: " . $_SERVER['REQUEST_METHOD'];
    //echo " Informacion " . file_get_contents('php://input');
    $api_externa = NEW Api_externa(0);
    $logs = NEW Log(0);
    $resultado =array();
    $servicio = NEW Servicio(0);
    $contador = 0;
    $cont = 0;

    switch ($_SERVER['REQUEST_METHOD']) {   
        case 'POST':
            $_POST=json_decode(file_get_contents('php://input'),true);
            if(isset($_POST['token'])){
                if($_POST['token']==""){
                    $resultado['mensaje']= "Conexion fail: token esta vacio";
                    $logs->guardar_logs("Api reporte - token no es mayor de 0");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: token no se ingreso correctamente";
                $logs->guardar_logs("Api reporte - token no se ingreso correctamente");
                $contador++;
            }
            
            if(isset($_POST['id_token'])){
                if($_POST['id_token']==0){
                    $resultado['mensaje']= "Conexion fail: id_token debe ser mayor de 0";
                    $logs->guardar_logs("Api reporte - id_token debe ser mayor de 0");
                    $contador++;
                }
            }else{
                $resultado['mensaje']= "Conexion fail: id_token no se ingreso correctamente";
                $logs->guardar_logs("Api reporte - id_token no se ingreso correctamente");
                $contador++;
            }
            
            if($contador!=0){      
            }else{
                $token_activo = $api_externa->obtener_token($_POST['id_token']);
                if($_POST['token'] == $token_activo){
               
                    if($token_activo!="0"){
                        if(isset( $_POST['id_usuario'])){
                            $id_usuario =  $_POST['id_usuario'];
                        }
                        else{
                            $id_usuario = 0;
                            $cont++;
                            $resultado['mensaje']= "El id_usuario no existe o se encuentra vacio";
                        }
                        if(isset( $_POST['id_cliente'])){
                            $id_cliente =  $_POST['id_cliente'];
                        }
                        else{
                            $id_cliente = 0;
                            $cont++;
                            $resultado['mensaje']= "El id_cliente no existe o se encuentra vacio";
                        }

                        if(isset( $_POST['id_planta'])){
                            $id_planta =  $_POST['id_planta'];
                        }
                        else{
                            $id_planta = 0;
                            $cont++;
                            $resultado['mensaje']= "El id_planta no existe o se encuentra vacia";
                        }
                        if(isset( $_POST['tipo_servicio'])){
                            $tipo_servicio =  $_POST['tipo_servicio'];
                        }
                        else{
                            $tipo_servicio = 0;
                            $cont++;
                            $resultado['mensaje']= "El tipo_servicio no existe o se encuentra vacio";
                        }
                        if(isset( $_POST['recibe_nombre'])){
                            $recibe_nombre =  $_POST['recibe_nombre'];
                        }
                        else{
                            $recibe_nombre = 0;
                            $cont++;
                            $resultado['mensaje']= "El recibe_nombre no existe o se encuentra vacio";
                        }
                        if(isset( $_POST['puesto'])){
                            $puesto =  $_POST['puesto'];
                        }
                        else{
                            $puesto = 0;
                        }
                        if(isset( $_POST['telefono'])){
                            $telefono =  $_POST['telefono'];
                        }
                        else{
                            $telefono = 0;
                            
                        }
                        if(isset( $_POST['filt_prim'])){
                            if($_POST['filt_prim']==1){
                            $filt_prim = TRUE;
                            }else{
                                $filt_prim = FALSE;
                            }
                        }else
                        {
                            $filt_prim = FALSE;
                        }
                        if(isset( $_POST['filt_secun'])){
                            if($_POST['filt_secun']==1){
                            $filt_secun = TRUE;
                            }else{
                                $filt_secun = FALSE;
                            }
                        }else
                        {
                            $filt_secun = FALSE;
                        }
                        if(isset( $_POST['filt_aceite'])){
                            if($_POST['filt_aceite']==1){
                            $filt_aceite = TRUE;
                            }else{
                                $filt_aceite = FALSE;
                            }
                        }else
                        {
                            $filt_aceite = FALSE;
                        }
                        if(isset( $_POST['filt_aire'])){
                            if($_POST['filt_aire']==1){
                            $filt_aire = TRUE;
                            }else{
                                $filt_aire = FALSE;
                            }
                        }else
                        {
                            $filt_aire = FALSE;
                        }
                        if(isset( $_POST['filt_agua'])){
                            if($_POST['filt_agua']==1){
                            $filt_agua = TRUE;
                            }else{
                                $filt_agua = FALSE;
                            }
                        }else
                        {
                            $filt_agua = FALSE;
                        }
                        if(isset( $_POST['filt_separador'])){
                            if($_POST['filt_separador']==1){
                            $filt_separador = TRUE;
                            }else{
                                $filt_separador = FALSE;
                            }
                        }else
                        {
                            $filt_separador = FALSE;
                        }
                        if(isset( $_POST['bateria_mca'])){
                            if($_POST['bateria_mca']==1){
                            $bateria_mca = TRUE;
                            }else{
                                $bateria_mca = FALSE;
                            }
                        }else
                        {
                            $bateria_mca = FALSE;
                        }
                        if(isset( $_POST['revision_reaprete'])){
                            if($_POST['revision_reaprete']==1){
                            $revision_reaprete = TRUE;
                            }else{
                                $revision_reaprete = FALSE;
                            }
                        }else
                        {
                            $revision_reaprete = FALSE;
                        }
                        if(isset( $_POST['nivel_combus'])){
                            if($_POST['nivel_combus']==1){
                            $nivel_combus = TRUE;
                            }else{
                                $nivel_combus = FALSE;
                            }
                        }else
                        {
                            $nivel_combus = FALSE;
                        }
                        if(isset( $_POST['revis_refri'])){
                            if($_POST['revis_refri']==1){
                            $revis_refri = TRUE;
                            }else{
                                $revis_refri = FALSE;
                            }
                        }else
                        {
                            $revis_refri = FALSE;
                        }
                        if(isset( $_POST['revis_panal'])){
                            if($_POST['revis_panal']==1){
                            $revis_panal = TRUE;
                            }else{
                                $revis_panal = FALSE;
                            }
                        }else
                        {
                            $revis_panal = FALSE;
                        }
                        if(isset( $_POST['revis_bandas'])){
                            if($_POST['revis_bandas']==1){
                            $revis_bandas = TRUE;
                            }else{
                                $revis_bandas = FALSE;
                            }
                        }else
                        {
                            $revis_bandas = FALSE;
                        }
                        if(isset( $_POST['revis_apriete'])){
                            if($_POST['revis_apriete']==1){
                            $revis_apriete = TRUE;
                            }else{
                                $revis_apriete = FALSE;
                            }
                        }else
                        {
                            $revis_apriete = FALSE;
                        }
                        if(isset( $_POST['revis_aceite'])){
                            if($_POST['revis_aceite']==1){
                            $revis_aceite = TRUE;
                            }else{
                                $revis_aceite = FALSE;
                            }
                        }else
                        {
                            $revis_aceite = FALSE;
                        }
                        if(isset( $_POST['revis_estado'])){
                            if($_POST['revis_estado']==1){
                            $revis_estado = TRUE;
                            }else{
                                $revis_estado = FALSE;
                            }
                        }else
                        {
                            $revis_estado = FALSE;
                        }
                        if(isset( $_POST['revis_precal'])){
                            if($_POST['revis_precal']==1){
                            $revis_precal = TRUE;
                            }else{
                                $revis_precal = FALSE;
                            }
                        }else
                        {
                            $revis_precal = FALSE;
                        }
                        if(isset( $_POST['revis_cableado'])){
                            if($_POST['revis_cableado']==1){
                            $revis_cableado = TRUE;
                            }else{
                                $revis_cableado = FALSE;
                            }
                        }else
                        {
                            $revis_cableado = FALSE;
                        }
                        if(isset( $_POST['estado_fisico'])){
                            if($_POST['estado_fisico']==1){
                            $estado_fisico = TRUE;
                            }else{
                                $estado_fisico = FALSE;
                            }
                        }else
                        {
                            $estado_fisico = FALSE;
                        }
                        if(isset( $_POST['pintura_equipo'])){
                            if($_POST['pintura_equipo']==1){
                            $pintura_equipo = TRUE;
                            }else{
                                $pintura_equipo = FALSE;
                            }
                        }else
                        {
                            $pintura_equipo = FALSE;
                        }
                        if(isset( $_POST['n_equipo'])){
                            if($_POST['n_equipo']==1){
                            $n_equipo = TRUE;
                            }else{
                                $n_equipo = FALSE;
                            }
                        }else
                        {
                            $n_equipo = FALSE;
                        }
                        if(isset( $_POST['voltaje'])){
                            if($_POST['voltaje']==1){
                            $voltaje = TRUE;
                            }else{
                                $voltaje = FALSE;
                            }
                        }else
                        {
                            $voltaje = FALSE;
                        }
                        if(isset( $_POST['modulo_control'])){
                            if($_POST['modulo_control']==1){
                            $modulo_control = TRUE;
                            }else{
                                $modulo_control = FALSE;
                            }
                        }else
                        {
                            $modulo_control = FALSE;
                        }
                        if(isset( $_POST['hrs_trabajo'])){
                            if($_POST['hrs_trabajo']==1){
                            $hrs_trabajo = TRUE;
                            }else{
                                $hrs_trabajo = FALSE;
                            }
                        }else
                        {
                            $hrs_trabajo = FALSE;
                        }
                        if(isset( $_POST['tipo_uni'])){
                            if($_POST['tipo_uni']==1){
                            $tipo_uni = TRUE;
                            }else{
                                $tipo_uni = FALSE;
                            }
                        }else
                        {
                            $tipo_uni = FALSE;
                        }
                        if(isset( $_POST['voltaje_red'])){
                            if($_POST['voltaje_red']==1){
                            $voltaje_red = TRUE;
                            }else{
                                $voltaje_red = FALSE;
                            }
                        }else
                        {
                            $voltaje_red = FALSE;
                        }
                        if(isset( $_POST['modelo_sensor'])){
                            if($_POST['modelo_sensor']==1){
                            $modelo_sensor = TRUE;
                            }else{
                                $modelo_sensor = FALSE;
                            }
                        }else
                        {
                            $modelo_sensor = FALSE;
                        }
                        if(isset( $_POST['reaprete_sistema'])){
                            if($_POST['reaprete_sistema']==1){
                            $reaprete_sistema = TRUE;
                            }else{
                                $reaprete_sistema = FALSE;
                            }
                        }else
                        {
                            $reaprete_sistema = FALSE;
                        }
                        if(isset( $_POST['inspeccion_fisica'])){
                            if($_POST['inspeccion_fisica']==1){
                            $inspeccion_fisica = TRUE;
                            }else{
                                $inspeccion_fisica = FALSE;
                            }
                        }else
                        {
                            $inspeccion_fisica = FALSE;
                        }
                        if(isset( $_POST['inspeccion_tierras'])){
                            if($_POST['inspeccion_tierras']==1){
                            $inspeccion_tierras = TRUE;
                            }else{
                                $inspeccion_tierras = FALSE;
                            }
                        }else
                        {
                            $inspeccion_tierras = FALSE;
                        }
                        if(isset( $_POST['inspeccion_neutros'])){
                            if($_POST['inspeccion_neutros']==1){
                            $inspeccion_neutros = TRUE;
                            }else{
                                $inspeccion_neutros = FALSE;
                            }
                        }else
                        {
                            $inspeccion_neutros = FALSE;
                        }
                        if(isset( $_POST['mod_carg'])){
                            if($_POST['mod_carg']==1){
                            $mod_carg = TRUE;
                            }else{
                                $mod_carg = FALSE;
                            }
                        }else
                        {
                            $mod_carg = FALSE;
                        }
                        if(isset( $_POST['cal_norm'])){
                            if($_POST['cal_norm']==1){
                            $cal_norm = TRUE;
                            }else{
                                $cal_norm = FALSE;
                            }
                        }else
                        {
                            $cal_norm = FALSE;
                        }
                        if(isset( $_POST['cal_carga'])){
                            if($_POST['cal_carga']==1){
                            $cal_carga = TRUE;
                            }else{
                                $cal_carga = FALSE;
                            }
                        }else
                        {
                            $cal_carga = FALSE;
                        }
                        if(isset( $_POST['cal_emerg'])){
                            if($_POST['cal_emerg']==1){
                            $cal_emerg = TRUE;
                            }else{
                                $cal_emerg = FALSE;
                            }
                        }else
                        {
                            $cal_emerg = FALSE;
                        }
                        if(isset( $_POST['pintura_general'])){
                            if($_POST['pintura_general']==1){
                            $pintura_general = TRUE;
                            }else{
                                $pintura_general = FALSE;
                            }
                        }else
                        {
                            $pintura_general = FALSE;
                        }
                        if(isset( $_POST['limpieza_general'])){
                            if($_POST['limpieza_general']==1){
                            $limpieza_general = TRUE;
                            }else{
                                $limpieza_general = FALSE;
                            }
                        }else
                        {
                            $limpieza_general = FALSE;
                        }
                        if(isset( $_POST['prox_cam'])){
                            if($_POST['prox_cam']==1){
                            $prox_cam = TRUE;
                            }else{
                                $prox_cam = FALSE;
                            }
                        }else
                        {
                            $prox_cam = FALSE;
                        }
                        if(isset( $_POST['presion_aceite'])){
                            if($_POST['presion_aceite']==1){
                            $presion_aceite = TRUE;
                            }else{
                                $presion_aceite = FALSE;
                            }
                        }else
                        {
                            $presion_aceite = FALSE;
                        }
                        if(isset( $_POST['temperatura_refrigerante'])){
                            if($_POST['temperatura_refrigerante']==1){
                            $temperatura_refrigerante = TRUE;
                            }else{
                                $temperatura_refrigerante = FALSE;
                            }
                        }else
                        {
                            $temperatura_refrigerante = FALSE;
                        }
                        if(isset( $_POST['saque_presion'])){
                            if($_POST['saque_presion']==1){
                            $saque_presion = TRUE;
                            }else{
                                $saque_presion = FALSE;
                            }
                        }else
                        {
                            $saque_presion = FALSE;
                        }
                        if(isset( $_POST['saque_generacion'])){
                            if($_POST['saque_generacion']==1){
                            $saque_generacion = TRUE;
                            }else{
                                $saque_generacion = FALSE;
                            }
                        }else
                        {
                            $saque_generacion = FALSE;
                        }
                        if(isset( $_POST['voltaje_generacion'])){
                            if($_POST['voltaje_generacion']==1){
                            $voltaje_generacion = TRUE;
                            }else{
                                $voltaje_generacion = FALSE;
                            }
                        }else
                        {
                            $voltaje_generacion = FALSE;
                        }
                        if(isset( $_POST['frecuencia'])){
                            if($_POST['frecuencia']==1){
                            $frecuencia = TRUE;
                            }else{
                                $frecuencia = FALSE;
                            }
                        }else
                        {
                            $frecuencia = FALSE;
                        }
                        if(isset( $_POST['voltaje_alternador'])){
                            if($_POST['voltaje_alternador']==1){
                            $voltaje_alternador = TRUE;
                            }else{
                                $voltaje_alternador = FALSE;
                            }
                        }else
                        {
                            $voltaje_alternador = FALSE;
                        }
                        if(isset( $_POST['baja_presion'])){
                            if($_POST['baja_presion']==1){
                            $baja_presion = TRUE;
                            }else{
                                $baja_presion = FALSE;
                            }
                        }else
                        {
                            $baja_presion = FALSE;
                        }
                        if(isset( $_POST['alta_temperatura'])){
                            if($_POST['alta_temperatura']==1){
                            $alta_temperatura = TRUE;
                            }else{
                                $alta_temperatura = FALSE;
                            }
                        }else
                        {
                            $alta_temperatura = FALSE;
                        }
                        if(isset( $_POST['falla_generacion'])){
                            if($_POST['falla_generacion']==1){
                            $falla_generacion = TRUE;
                            }else{
                                $falla_generacion = FALSE;
                            }
                        }else
                        {
                            $falla_generacion = FALSE;
                        }
                        if(isset( $_POST['baja_velocidad'])){
                            if($_POST['baja_velocidad']==1){
                            $baja_velocidad = TRUE;
                            }else{
                                $baja_velocidad = FALSE;
                            }
                        }else
                        {
                            $baja_velocidad = FALSE;
                        }
                        if(isset( $_POST['paro_emergencia'])){
                            if($_POST['paro_emergencia']==1){
                            $paro_emergencia = TRUE;
                            }else{
                                $paro_emergencia = FALSE;
                            }
                        }else
                        {
                            $paro_emergencia = FALSE;
                        }
                        if(isset( $_POST['intentos_arranque'])){
                            if($_POST['intentos_arranque']==1){
                            $intentos_arranque = TRUE;
                            }else{
                                $intentos_arranque = FALSE;
                            }
                        }else
                        {
                            $intentos_arranque = FALSE;
                        }
                        if(isset( $_POST['sobre_velocidad'])){
                            if($_POST['sobre_velocidad']==1){
                            $sobre_velocidad = TRUE;
                            }else{
                                $sobre_velocidad = FALSE;
                            }
                        }else
                        {
                            $sobre_velocidad = FALSE;
                        }
                        if(isset( $_POST['sobre_carga'])){
                            if($_POST['sobre_carga']==1){
                            $sobre_carga = TRUE;
                            }else{
                                $sobre_carga = FALSE;
                            }
                        }else
                        {
                            $sobre_carga = FALSE;
                        }
                        if(isset( $_POST['tiempo_arranque'])){
                            if($_POST['tiempo_arranque']==1){
                            $tiempo_arranque = TRUE;
                            }else{
                                $tiempo_arranque = FALSE;
                            }
                        }else
                        {
                            $tiempo_arranque = FALSE;
                        }
                        if(isset( $_POST['tiempo_transferencia'])){
                            if($_POST['tiempo_transferencia']==1){
                            $tiempo_transferencia = TRUE;
                            }else{
                                $tiempo_transferencia = FALSE;
                            }
                        }else
                        {
                            $tiempo_transferencia = FALSE;
                        }
                        if(isset( $_POST['tiempo_retransferencia'])){
                            if($_POST['tiempo_retransferencia']==1){
                            $tiempo_retransferencia = TRUE;
                            }else{
                                $tiempo_retransferencia = FALSE;
                            }
                        }else
                        {
                            $tiempo_retransferencia = FALSE;
                        }
                        if(isset( $_POST['tiempo_desfoge'])){
                            if($_POST['tiempo_desfoge']==1){
                            $tiempo_desfoge = TRUE;
                            }else{
                                $tiempo_desfoge = FALSE;
                            }
                        }else
                        {
                            $tiempo_desfoge = FALSE;
                        }
                        if(isset( $_POST['tiempo_prueba'])){
                            if($_POST['tiempo_prueba']==1){
                            $tiempo_prueba = TRUE;
                            }else{
                                $tiempo_prueba = FALSE;
                            }
                        }else
                        {
                            $tiempo_prueba = FALSE;
                        }
                        if(isset( $_POST['voltaje_generacion_carga'])){
                            if($_POST['voltaje_generacion_carga']==1){
                            $voltaje_generacion_carga = TRUE;
                            }else{
                                $voltaje_generacion_carga = FALSE;
                            }
                        }else
                        {
                            $voltaje_generacion_carga = FALSE;
                        }
                        if(isset( $_POST['frecuencia_carga'])){
                            if($_POST['frecuencia_carga']==1){
                            $frecuencia_carga = TRUE;
                            }else{
                                $frecuencia_carga = FALSE;
                            }
                        }else
                        {
                            $frecuencia_carga = FALSE;
                        }
                        if(isset( $_POST['amparaje'])){
                            if($_POST['amparaje']==1){
                            $amparaje = TRUE;
                            }else{
                                $amparaje = FALSE;
                            }
                        }else
                        {
                            $amparaje = FALSE;
                        }
                        if(isset( $_POST['presion_aceite_carga'])){
                            if($_POST['presion_aceite_carga']==1){
                            $presion_aceite_carga = TRUE;
                            }else{
                                $presion_aceite_carga = FALSE;
                            }
                        }else
                        {
                            $presion_aceite_carga = FALSE;
                        }
                        if(isset( $_POST['temperatura_refrigerante_carga'])){
                            if($_POST['temperatura_refrigerante_carga']==1){
                            $temperatura_refrigerante_carga = TRUE;
                            }else{
                                $temperatura_refrigerante_carga = FALSE;
                            }
                        }else
                        {
                            $temperatura_refrigerante_carga = FALSE;
                        }
                        if(isset( $_POST['trabajos_realizados'])){
                            $trabajos_realizados =  $_POST['trabajos_realizados'];
                        }
                        else{
                            $trabajos_realizados= "";
                        }
                        if(isset( $_POST['recomendaciones_tecnico'])){
                            $recomendaciones_tecnico =  $_POST['recomendaciones_tecnico'];
                        }
                        else{
                            $recomendaciones_tecnico= "";
                        }
                        if(isset( $_POST['material_utilizado'])){
                            $material_utilizado =  $_POST['material_utilizado'];
                        }
                        else{
                            $material_utilizado= "";
                        }
                        if(isset( $_POST['observaciones_cliente'])){
                            $observaciones_cliente =  $_POST['observaciones_cliente'];
                        }
                        else{
                            $observaciones_cliente= "";
                        }
                        if(isset( $_POST['firma_tecnico'])){
                            $firma_tecnico =  $_POST['firma_tecnico'];
                        }
                        else{
                            $firma_tecnico= "";
                        }
                        if(isset( $_POST['firma_cliente'])){
                            $firma_cliente =  $_POST['firma_cliente'];
                        }
                        else{
                            $firma_cliente= "";
                        }
                        if( $cont==0){
                            $servicio->guardar_servicio($id_usuario,$id_cliente,$id_planta,$_POST['fecha_servicio'],$tipo_servicio, $recibe_nombre, $puesto,$telefono,$filt_prim,$filt_secun,$filt_aceite,$filt_aire,$filt_agua,$filt_separador,$bateria_mca,$revision_reaprete,$nivel_combus,$revis_refri,$revis_panal,$revis_bandas,$revis_apriete,$revis_aceite,$revis_estado,$revis_precal,$revis_cableado,$estado_fisico,$pintura_equipo,$n_equipo,$voltaje,$modulo_control,$hrs_trabajo,$tipo_uni,$voltaje_red,$modelo_sensor,$reaprete_sistema,$inspeccion_fisica,$inspeccion_tierras,$inspeccion_neutros,$mod_carg,$cal_norm,$cal_carga,$cal_emerg,$pintura_general,$limpieza_general,$prox_cam,$presion_aceite,$temperatura_refrigerante,$saque_presion,$saque_generacion,$voltaje_generacion,$frecuencia,$voltaje_alternador,$baja_presion,$alta_temperatura,$falla_generacion,$baja_velocidad,$paro_emergencia,$intentos_arranque,$sobre_velocidad,$sobre_carga,$tiempo_arranque,$tiempo_transferencia,$tiempo_retransferencia,$tiempo_desfoge,$tiempo_prueba,$voltaje_generacion_carga,$frecuencia_carga,$amparaje,$presion_aceite_carga,$temperatura_refrigerante_carga,$trabajos_realizados,$recomendaciones_tecnico,$material_utilizado,$observaciones_cliente,$firma_tecnico,$firma_cliente);
                            $resultado['mensaje']= "Conexion succes";
                            $logs->guardar_logs("Api reporte - el usuario guardo reporte");
                        }else{
                            $resultado['mensaje']= "Conexion fail: faltan datos obligatorios";
                            $logs->guardar_logs("Api reporte - el usuario no pudo guardar reporte por falta de datos obligatorios");
                        }
                    }else{
                        $resultado['mensaje']= "Conexion fail: el token no existe";
                        $logs->guardar_logs("Api reporte - token no existe");
                    }
       
                }else{
                    $resultado['mensaje']= "Conexion fail: el token no es valido";
                    $logs->guardar_logs("Api reporte - token no valido o no activo");
                }
               
            }
                
                     
            break;
        
        default:
                    /*$resultado[0]['id']= 0;
                    $resultado[0]['id_usuario']= 0;
                    $resultado[0]['id_cliente']= 0;
                    $resultado[0]['id_planta']= 0;
                    $resultado[0]['fecha_servicio']= 0;
                    $resultado[0]['tipo_servicio']= 0;
                    $resultado[0]['recibe_nombre']= 0;
                    $resultado[0]['puesto']= 0;
                    $resultado[0]['telefono']= 0;
                    $resultado[0]['filt_prim']= 0;
                    $resultado[0]['filt_secun']= 0;
                    $resultado[0]['filt_aceite']= 0;
                    $resultado[0]['filt_aire']= 0;
                    $resultado[0]['filt_agua']= 0;
                    $resultado[0]['filt_separador']= 0;
                    $resultado[0]['bateria_mca']= 0;
                    $resultado[0]['revision_reaprete']= 0;
                    $resultado[0]['nivel_combus']= 0;
                    $resultado[0]['revis_refri']= 0;
                    $resultado[0]['revis_panal']= 0;
                    $resultado[0]['revis_bandas']= 0;
                    $resultado[0]['revis_apriete']= 0;
                    $resultado[0]['revis_aceite']= 0;
                    $resultado[0]['revis_estado']= 0;
                    $resultado[0]['revis_precal']= 0;
                    $resultado[0]['revis_cableado']= 0;
                    $resultado[0]['estado_fisico']= 0;
                    $resultado[0]['pintura_equipo']= 0;
                    $resultado[0]['n_equipo']= 0;
                    $resultado[0]['voltaje']= 0;
                    $resultado[0]['modulo_control']= 0;
                    $resultado[0]['hrs_trabajo']= 0;
                    $resultado[0]['tipo_uni']= 0;
                    $resultado[0]['voltaje_red']= 0;
                    $resultado[0]['modelo_sensor']= 0;
                    $resultado[0]['reaprete_sistema']= 0;
                    $resultado[0]['inspeccion_fisica']= 0;
                    $resultado[0]['inspeccion_tierras']= 0;
                    $resultado[0]['inspeccion_neutros']= 0;
                    $resultado[0]['mod_carg']= 0;
                    $resultado[0]['cal_norm']= 0;
                    $resultado[0]['cal_emerg']= 0;
                    $resultado[0]['pintura_general']= 0;
                    $resultado[0]['limpieza_general']= 0;
                    $resultado[0]['prox_cam']= 0;
                    $resultado[0]['presion_aceite']= 0;
                    $resultado[0]['temperatura_refrigerante']= 0;
                    $resultado[0]['saque_presion']= 0;
                    $resultado[0]['saque_generacion']= 0;
                    $resultado[0]['voltaje_generacion']= 0;
                    $resultado[0]['frecuencia']= 0;
                    $resultado[0]['voltaje_alternador']= 0;
                    $resultado[0]['baja_presion']= 0;
                    $resultado[0]['alta_temperatura']= 0;
                    $resultado[0]['falla_generacion']= 0;
                    $resultado[0]['baja_velocidad']= 0;
                    $resultado[0]['paro_emergencia']= 0;
                    $resultado[0]['intentos_arranque']= 0;
                    $resultado[0]['sobre_velocidad']= 0;
                    $resultado[0]['sobre_carga']= 0;
                    $resultado[0]['tiempo_arranque']= 0;
                    $resultado[0]['tiempo_transferencia']= 0;
                    $resultado[0]['tiempo_retransferencia']= 0;
                    $resultado[0]['tiempo_desfoge']= 0;
                    $resultado[0]['tiempo_prueba']= 0;
                    $resultado[0]['voltaje_generacion_carga']= 0;
                    $resultado[0]['frecuencia_carga']= 0;
                    $resultado[0]['amparaje']= 0;
                    $resultado[0]['presion_aceite_carga']= 0;
                    $resultado[0]['temperatura_refrigerante_carga']= 0;
                    $resultado[0]['trabajos_realizados']= 0;
                    $resultado[0]['recomendaciones_tecnico']= 0;
                    $resultado[0]['material_utilizado']= 0;
                    $resultado[0]['observaciones_cliente']= 0;
                    $resultado[0]['firma_tecnico']= 0;
                    $resultado[0]['firma_cliente']= 0;
                    $resultado[0]['estado']= 0;*/
                    $resultado['mensaje']= "Conexion fail : only use post conection";
                    $logs->guardar_logs("Api reporte - fallo por metodo diferente a POST");
            break;
    }
    echo json_encode($resultado);
?>