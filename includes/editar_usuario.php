<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['id']);

  echo '
      <div class="main_container">
      <div class="form_container">
      <form class="formulario_contenedor">

        <div class="main_container_title">
          <h2 >EDITAR USUARIO</h2>
          <button class="btn btn-link" onclick="regresar_logs()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
              <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"></path>
            </svg>
          </button>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text"  id="usuario" value="'.$usuario->usuario.'" maxlength="50" placeholder="Usuario">
            <label for="usuario">Usuario</label>
          </div>
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="nombre_completo" value="'.$usuario->nombre_completo.'" maxlength="70" placeholder="Nombre completo">
            <label for="nombre_completo">Nombre completo</label>
          </div>  
          </div>

        <!-- <div class="row">
            <div class="col-sm-2" >Contrasena:</div>
            <div class="col-sm-4" >
            <div class="form-group">
              <input class="form-control" type="password"  id="contrasena"  maxlength="50">
            </div>
            </div>
            <div class="col-sm-2" >Contrasena:</div>
            <div class="col-sm-4" >
            <div class="form-group">
              <input class="form-control" type="password"  id="recontrasena" value="'.$usuario->pass.'" maxlength="50">
            </div>
            </div>
        </div><br> -->

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <select class="form-control custom_input" id="nivel">
            <option value='.$usuario->nivel.'>'. $usuario->obtener_nivel($_GET['id']).'</option>';
            switch($usuario->nivel)
            {
              case 1:
                  echo ' 
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 2:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 3:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 4:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 5:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 6:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 7:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="8">Ama Llaves</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 8:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="9">Indefinido</option>
                  </select>';
                break;
              case 9:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Recamarera</option>
                  <option value="4">Mantenimiento</option>
                  <option value="5">Supervision</option>
                  <option value="6">Restaurante</option>
                  <option value="7">Reservaciones</option>
                  <option value="8">Ama Llaves</option>
                  </select>';
                break;
              default:
                  $nivel = "Otro";
                break;
            }
            echo '
            <label for="nivel" >Categoría</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="puesto" value="'.$usuario->puesto.'" maxlength="40" placeholder="Puesto">
            <label for="puesto">Puesto</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="celular" value="'.$usuario->celular.'" maxlength="20" placeholder="Celular">
            <label for="celular" >Celular</label>
          </div>
          
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="correo" value="'.$usuario->correo.'" maxlength="70" placeholder="Correo">
            <label for="correo" >Correo</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="direccion" value="'.$usuario->direccion.'" placeholder="Direccion">
            <label for="direccion" >Dirección</label>
          </div>
        </div>


        <div class="form_title_container">
          <h2 class="form_title_text">Otorgar permisos:</h2>
        </div>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Estadisticas</p>
          </div>
          <div class="form_checks_container">

            <div class="form-check form-check-inline">';
              if($usuario->ver_graficas==0){
                echo '<input class="form-check-input" type="checkbox" id="ver_graficas" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="ver_graficas" checked >';
              }
              echo '   
              <label class="form-check-label" for="ver_graficas">Ver</label>
            </div>
            </div>
        </section>

        <hr>


        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Recepción</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if($usuario->check_in==0){
                echo '<input class="form-check-input" type="checkbox" id="check_in" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="check_in" checked >';
              }
              echo '   
              <label class="form-check-label" for="check_in">Check In</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->cuenta_maestra==0){
                echo '<input class="form-check-input" type="checkbox" id="cuenta_maestra" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="cuenta_maestra" checked >';
              }
              echo '   
              <label class="form-check-label" for="cuenta_maestra">Cuenta maestra</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->reporte_diario==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_diario" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_diario" checked >';
              }
              echo '   
              <label class="form-check-label" for="reporte_diario">Reporte diarios</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->reporte_llegada==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_llegada" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_llegada" checked >';
              }
              echo '   
              <label class="form-check-label" for="reporte_llegada">Reporte llegada</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->reporte_salidas==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_salidas" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_salidas" checked >';
              }
              echo '   
              <label class="form-check-label" for="reporte_salidas">Reporte salidas</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->saldo_huspedes==0){
                echo '<input class="form-check-input" type="checkbox" id="saldo_huspedes" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="saldo_huspedes" checked >';
              }
              echo '   
              <label class="form-check-label" for="saldo_huspedes">Saldo huspedes</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->edo_centa_fc==0){
                echo '<input class="form-check-input" type="checkbox" id="edo_centa_fc" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="edo_centa_fc" checked >';
              }
              echo '   
              <label class="form-check-label" for="edo_centa_fc">Edo. cuenta folio casa</label>
            </div>
          </div>
        </section>

        <hr>
        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Reservaciones</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if($usuario->ver_reservaciones==0){
                echo '<input class="form-check-input" type="checkbox" id="ver_reservaciones" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="ver_reservaciones" checked >';
              }
              echo '   
              <label class="form-check-label" for="ver_reservaciones">Ver reservaciones</label>
            </div>
            <div class="form-check form-check-inline">';
              if($usuario->agregar_reservaciones==0){
                echo '<input class="form-check-input" type="checkbox" id="agregar_reservaciones" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="agregar_reservaciones" checked >';
              }
              echo '   
              <label class="form-check-label" for="agregar_reservaciones">Agregar reservaciones</label>
            </div> 
            <div class="form-check form-check-inline">';
              if($usuario->info_huespedes==0){
                echo '<input class="form-check-input" type="checkbox" id="info_huespedes" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="info_huespedes" checked >';
              }
              echo '   
              <label class="form-check-label" for="info_huespedes">Info huespedes</label>
            </div> 
            <div class="form-check form-check-inline">';
              if($usuario->reporte_cancelaciones==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_cancelaciones" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_cancelaciones" checked >';
              }
              echo '   
              <label class="form-check-label" for="reporte_cancelaciones">Reporte de cancelaciones</label>
            </div> 
          </div>
        </section>

        <hr>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Reportes</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if( $usuario->reporte_cortes == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="reporte_cortes" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_cortes" checked >';
              }
              echo '   
              <label class="form-check-label" for="reporte_cortes">Reporte cortes</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->cargos_noche == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="cargos_noche" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="cargos_noche" checked >';
              }
              echo '   
              <label class="form-check-label" for="cargos_noche">Cargos por noche</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->surtir == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="surtir" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="surtir" checked >';
              }
              echo '   
              <label class="form-check-label" for="surtir">Surtir</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->corte_diario == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="corte_diario" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="corte_diario" checked >';
              }
              echo '   
              <label class="form-check-label" for="corte_diario">Corte diario</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->pronosticos == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="pronosticos" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="pronosticos" checked >';
              }
              echo '   
              <label class="form-check-label" for="pronosticos">Pronosticos de ocupación</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->historial_cuentas == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="historial_cuentas" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="historial_cuentas" checked >';
              }
              echo '   
              <label class="form-check-label" for="historial_cuentas">Historial de cuentas</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->ama_de_llaves == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="ama_de_llaves" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="ama_de_llaves" checked >';
              }
              echo '   
              <label class="form-check-label" for="ama_de_llaves">Reporte ama de llaves</label>
            </div>   
          </div>
        </section>

        <hr>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Cortes y transacciones</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if( $usuario->historial_cortes_u == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="historial_cortes_u" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="historial_cortes_u" checked >';
              }
              echo '   
              <label class="form-check-label" for="historial_cortes_u">Historial cortes usuario</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->corte_diario_u == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="corte_diario_u" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="corte_diario_u" checked >';
              }
              echo '   
              <label class="form-check-label" for="corte_diario_u">Corte diario usuario</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->resumen_transacciones == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="resumen_transacciones" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="resumen_transacciones" checked >';
              }
              echo '   
              <label class="form-check-label" for="resumen_transacciones">Resumen transacciones</label>
            </div>   
          </div>
        </section>

        <hr>
        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Facturación</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if( $usuario->factura_individual == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="factura_individual" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="factura_individual" checked >';
              }
              echo '   
              <label class="form-check-label" for="factura_individual">Factura individual</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->factura_global == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="factura_global" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="factura_global" checked >';
              }
              echo '   
              <label class="form-check-label" for="factura_global">Factura individual</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->buscar_fc == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="buscar_fc" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="buscar_fc" checked >';
              }
              echo '   
              <label class="form-check-label" for="buscar_fc">Buscar conceptos por folio casa</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->cancelar_fac == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="cancelar_fac" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="cancelar_fac" checked >';
              }
              echo '   
              <label class="form-check-label" for="cancelar_fac">Cancelar factura</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->bus_fac_fecha == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_fecha" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_fecha" checked >';
              }
              echo '   
              <label class="form-check-label" for="bus_fac_fecha">Buscar factura por fecha</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->bus_fac_folio == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_folio" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_folio" checked >';
              }
              echo '   
              <label class="form-check-label" for="bus_fac_folio">Buscar factura por folio</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->bus_fac_folio_casa == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_folio_casa" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="bus_fac_folio_casa" checked >';
              }
              echo '   
              <label class="form-check-label" for="bus_fac_folio_casa">Buscar factura por folio casa</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->resumen_fac == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="resumen_fac" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="resumen_fac" checked >';
              }
              echo '   
              <label class="form-check-label" for="resumen_fac">Resumen facturas</label>
            </div>   
          </div>
        </section>

        <hr>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Restaurante</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if( $usuario->restaurante == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="restaurante" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante" checked >';
              }
              echo '   
              <label class="form-check-label" for="restaurante">Restaurante</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->agregar_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="agregar_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="agregar_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="agregar_res">Agregar</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->cat_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="cat_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="cat_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="cat_res">Categoías</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->invet_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="invet_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="invet_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="invet_res">Inventario</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->surtir_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="surtir_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="surtir_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="surtir_res">Surtir</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->mesas_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="mesas_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="mesas_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="mesas_res">Mesas</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->agregar_mesas_res == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="agregar_mesas_res" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="agregar_mesas_res" checked >';
              }
              echo '   
              <label class="form-check-label" for="agregar_mesas_res">Agregar mesa</label>
            </div>   
          </div>
        </section>

        <hr>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Configuración habitaciones</p>
          </div>
          <div class="form_checks_container">
            <div class="form-check form-check-inline">';
              if( $usuario->tipo_hab == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="tipo_hab" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="tipo_hab" checked >';
              }
              echo '   
              <label class="form-check-label" for="tipo_hab">Ver tipo de habitación</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->tarifas_hab == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="tarifas_hab" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="tarifas_hab" checked >';
              }
              echo '   
              <label class="form-check-label" for="tarifas_hab">Ver tipos de tarifa</label>
            </div>   
            <div class="form-check form-check-inline">';
              if( $usuario->ver_hab == 0 ){
                echo '<input class="form-check-input" type="checkbox" id="ver_hab" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="ver_hab" checked >';
              }
              echo '   
              <label class="form-check-label" for="ver_hab">Ver habitaciones</label>
            </div>   
          </div>
        </section>

        <hr>

        <section class="form_checks_container">
            <div class="form_checks_title">
              <p>Combinar cuentas</p>
            </div>
            <div class="form_checks_container">

            <div class="form-check form-check-inline">';
            if($usuario->combinar_cuentas==0){
            echo '<input class="form-check-input" type="checkbox" id="combinar_cuentas">';
            }else{
            echo '<input class="form-check-input" type="checkbox" id="combinar_cuentas" checked>';
            }
            echo '
            <label class="form-check-label" for="combinar_cuentas" >Ver</label>
          </div>

          </div>

        </section>


        <hr>
        <div class="alert alert-danger" role="alert">
          Estas opciones se retirarán  en futuras versiones.
        </div>
        <hr>

        <section class="form_checks_container">
          <div class="form_checks_title">
            <p>Usuario</p>
          </div>
          <div class="form_checks_container">

            <div class="form-check form-check-inline">';
              if($usuario->usuario_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="usuario_ver" >';
              }else{
                echo '<input class="form-check-input" type="checkbox" id="usuario_ver" checked >';
              }
              echo '   
              <label class="form-check-label" for="usuario_ver">Ver</label>
            </div>

            <div class="form-check form-check-inline">';
                if($usuario->usuario_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="usuario_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="usuario_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="usuario_agregar">Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->usuario_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="usuario_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="usuario_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="usuario_editar">Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->usuario_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="usuario_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="usuario_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="usuario_borrar">Borrar</label>
              </div>
            </div>
          </section>
          <hr>

          <section class="form_checks_container">
            <div class="form_checks_title">
                <p>Huésped</p>
            </div>
            <div class="form_checks_container">
            
            <div class="form-check form-check-inline">';
              if($usuario->huesped_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_ver" checked>';
              }
              echo '
              <label class="form-check-label" for="huesped_ver">Ver</label>
            </div>

            <div class="form-check form-check-inline">';
              if($usuario->huesped_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_agregar" checked>';
              }
              echo '
              <label class="form-check-label" for="huesped_agregar">Agregar</label>
            </div>

            <div class="form-check form-check-inline">';
              if($usuario->huesped_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_editar" checked>';
              }
              echo '
              <label class="form-check-label" for="huesped_editar">Editar</label>
            </div>

            <div class="form-check form-check-inline">';
              if($usuario->huesped_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_borrar" checked>';
              }
              echo '
              <label class="form-check-label">Borrar</label>
            </div>
            </div>
          </section>
          <hr>';
            /*<div class="form-group row">
            <div class="col-sm-3">Tipo habitacion:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tipo_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="tipo_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tipo_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tipo_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="tipo_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tipo_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tipo_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="tipo_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tipo_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tipo_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="tipo_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tipo_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>*/  
            echo '
            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Usuario</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->tarifa_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="tarifa_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="tarifa_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="tarifa_ver">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->tarifa_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="tarifa_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="tarifa_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="tarifa_agregar">Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->tarifa_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="tarifa_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="tarifa_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="tarifa_editar"> Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->tarifa_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="tarifa_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="tarifa_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="tarifa_borrar">Borrar</label>
              </div>
              </div>
            </section>

            <hr>';

            /*<div class="form-group row">
            <div class="col-sm-3">Habitacion:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->hab_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="hab_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="hab_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->hab_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="hab_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="hab_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->hab_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="hab_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="hab_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->hab_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="hab_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="hab_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>*/  
            echo '
            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Reservación</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->reservacion_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="reservacion_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reservacion_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="reservacion_ver" >Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->reservacion_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="reservacion_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reservacion_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="reservacion_agregar">Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->reservacion_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="reservacion_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reservacion_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="reservacion_editar">Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->reservacion_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="reservacion_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reservacion_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="reservacion_borrar">Borrar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->reservacion_preasignar==0){
                echo '<input class="form-check-input" type="checkbox" id="reservacion_preasignar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reservacion_preasignar" checked>';
                }
                echo '
                <label class="form-check-label" for="reservacion_preasignar">Preasignar</label>
              </div>
            </div>
          </section>

          <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Llegadas y salidas</p>
              </div>
              <div class="form_checks_container">

                  <div class="form-check form-check-inline">';
                  if($usuario->llegadas_salidas_ver==0){
                  echo '<input class="form-check-input" type="checkbox" id="llegadas_salidas_ver">';
                  }else{
                  echo '<input class="form-check-input" type="checkbox" id="llegadas_salidas_ver" checked>';
                  }
                  echo '
                  <label class="form-check-label" for="llegadas_salidas_ver">Ver</label>
                  </div>
                </div>
            </section>

          <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Reportes</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->reporte_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="reporte_ver">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->reporte_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="reporte_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="reporte_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="reporte_agregar" >Agregar</label>
              </div>

              </div>
            </section>

          <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Cortes y transacciones</p>
              </div>
              <div class="form_checks_container">

                <div class="form-check form-check-inline">';
                  if($usuario->cortes_y_transacciones==0){
                  echo '<input class="form-check-input" type="checkbox" id="cortes_y_transacciones">';
                  }else{
                  echo '<input class="form-check-input" type="checkbox" id="cortes_y_transacciones" checked>';
                  }
                  echo '
                  <label class="form-check-label" for="cortes_y_transacciones">Ver</label>
                </div>

              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Forma Pago</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->forma_pago_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="forma_pago_ver">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->forma_pago_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="forma_pago_agregar">Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->forma_pago_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="forma_pago_editar" >Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->forma_pago_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="forma_pago_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="forma_pago_borrar" >Borrar</label>
              </div>

              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Inventario</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->inventario_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="inventario_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="inventario_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="inventario_ver">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->inventario_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="inventario_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="inventario_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="inventario_agregar" >Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->inventario_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="inventario_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="inventario_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="inventario_editar">Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->inventario_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="inventario_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="inventario_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="inventario_borrar" >Borrar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->inventario_surtir==0){
                echo '<input class="form-check-input" type="checkbox" id="inventario_surtir">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="inventario_surtir" checked>';
                }
                echo '
                <label class="form-check-label" for="inventario_surtir" >Surtir</label>
              </div>

              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Categoría</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->categoria_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="categoria_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="categoria_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="categoria_ver">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->categoria_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="categoria_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="categoria_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="categoria_agregar" >Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->categoria_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="categoria_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="categoria_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="categoria_editar" >Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->categoria_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="categoria_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="categoria_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="categoria_borrar" >Borrar</label>
              </div>
              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Restaurante</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->restaurante_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="restaurante_ver" >Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->restaurante_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_agregar" checked>';
                }
                echo '
                <label class="form-check-label" for="restaurante_agregar" >Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->restaurante_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="restaurante_editar" >Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->restaurante_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_borrar" checked>';
                }
                echo '
                <label class="form-check-label" for="restaurante_borrar" >Borrar</label>
              </div>

              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Cupón</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->cupon_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="cupon_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="cupon_ver" checked>';
                }
                echo '
                <label class="form-check-label">Ver</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->cupon_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="cupon_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="cupon_agregar" checked>';
                }
                echo '
                <label class="form-check-label">Agregar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->cupon_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="cupon_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="cupon_editar" checked>';
                }
                echo '
                <label class="form-check-label">Editar</label>
              </div>

              <div class="form-check form-check-inline">';
                if($usuario->cupon_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="cupon_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="cupon_borrar" checked>';
                }
                echo '
                <label class="form-check-label">Borrar</label>
              </div>

              </div>
            </section>

            <hr>

            <section class="form_checks_container">
              <div class="form_checks_title">
                <p>Logs</p>
              </div>
              <div class="form_checks_container">

              <div class="form-check form-check-inline">';
                if($usuario->logs_ver==0){
                echo '<input class="form-check-input" type="checkbox" id="logs_ver">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="logs_ver" checked>';
                }
                echo '
                <label class="form-check-label" for="logs_ver">Ver</label>
                </div>
              </div>
            </section>

            <hr>

            <section class="form_checks_container">
                <div class="form_checks_title">
                  <p>Auditoria</p>
                </div>
                <div class="form_checks_container">

                <div class="form-check form-check-inline">';
                  if($usuario->auditoria_ver==0){
                  echo '<input class="form-check-input" type="checkbox" id="auditoria_ver">';
                  }else{
                  echo '<input class="form-check-input" type="checkbox" id="auditoria_ver" checked>';
                  }
                  echo '
                  <label class="form-check-label" for="auditoria_ver" >Ver</label>
                </div>

                <div class="form-check form-check-inline">';
                if($usuario->auditoria_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="auditoria_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="auditoria_editar" checked>';
                }
                echo '
                <label class="form-check-label" for="auditoria_editar" >Editar</label>
              </div>

              </div>

            </section>

            <hr>

            <section class="form_checks_container">
                <div class="form_checks_title">
                  <p>Facturas</p>
                </div>
                <div class="form_checks_container">

                <div class="form-check form-check-inline">';
                  if($usuario->facturas_ver==0){
                  echo '<input class="form-check-input" type="checkbox" id="facturas_ver">';
                  }else{
                  echo '<input class="form-check-input" type="checkbox" id="facturas_ver" checked>';
                  }
                  echo '
                  <label class="form-check-label" for="facturas_ver" >Ver</label>
                </div>

                <div class="form-check form-check-inline">';
                if($usuario->facturas_cancelar==0){
                echo '<input class="form-check-input" type="checkbox" id="facturas_cancelar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="facturas_cancelar" checked>';
                }
                echo '
                <label class="form-check-label" for="facturas_cancelar" >Cancelar</label>
              </div>

              </div>

            </section>

            <hr>

            

            <div class="container_btn">
              <div id="boton_usuario">
                <button type="submit" class="btn btn-primary btn-block" value="Guardar" onclick="modificar_usuario('.$_GET['id'].')">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z"/>
                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                  </svg>
                  Guardar
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>';
?>
