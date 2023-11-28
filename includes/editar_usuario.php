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
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_usuario()"> ←</button></div>
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
                <p>Reporte</p>
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
                <label class="form-check-label" for="inventario_ver" >Ver</label>
              </div>

              <div class="form-check form-check-inline">
                <div class="form-check">';
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
                <label class="form-check-label">Ver</label>
              </div>

              <div class="form-check form-check-inline">
                <div class="form-check">';
                if($usuario->restaurante_agregar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_agregar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_agregar" checked>';
                }
                echo '   <label class="form-check-label">
                    Agregar
                  </label>
                </div>
              </div>

              <div class="form-check form-check-inline">
                <div class="form-check">';
                if($usuario->restaurante_editar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_editar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_editar" checked>';
                }
                echo '   <label class="form-check-label">
                    Editar
                  </label>
                </div>
              </div>

              <div class="form-check form-check-inline">
                <div class="form-check">';
                if($usuario->restaurante_borrar==0){
                echo '<input class="form-check-input" type="checkbox" id="restaurante_borrar">';
                }else{
                echo '<input class="form-check-input" type="checkbox" id="restaurante_borrar" checked>';
                }
                echo '   <label class="form-check-label">
                    Borrar
                  </label>
                </div>
              </div>

              </div>
            </section>

            <hr>

            <div class="form-group row">
            <div class="col-sm-3">Cupón:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cupon_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="cupon_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cupon_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cupon_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="cupon_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cupon_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cupon_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="cupon_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cupon_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cupon_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="cupon_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cupon_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>
            <div class="form-group row">
            <div class="col-sm-3">Logs:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->logs_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="logs_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="logs_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            </div><br><hr> 

            <div class="form-group row">
            <div class="col-sm-3">Auditoria:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->auditoria_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="auditoria_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="auditoria_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
            <div class="form-check">';
            if($usuario->auditoria_editar==0){
            echo '<input class="form-check-input" type="checkbox" id="auditoria_editar">';
            }else{
            echo '<input class="form-check-input" type="checkbox" id="auditoria_editar" checked>';
            }
            echo '   <label class="form-check-label">
                Editar
              </label>
            </div>
          </div>
            </div><br><hr> 
            <div class="row">
              <div class="col-sm-9"></div>
              <div class="col-sm-2">
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
            </div>
          </form>
        </div>
      </div>';
?>
