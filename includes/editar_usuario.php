<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR USUARIO</h2></div>

        <div class="row">
          <div class="col-sm-2">Usuario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text"  id="usuario" value="'.$usuario->usuario.'" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Nombre completo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre_completo" value="'.$usuario->nombre_completo.'" maxlength="70">
          </div>
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
        <div class="row">
          <div class="col-sm-2" >Categoria:</div>
          <div class="col-sm-4" >
          <div class="form-group">
            <select class="form-control" id="nivel">
            <option value='.$usuario->nivel.'>'. $usuario->obtener_nivel($_GET['id']).'</option>';
            switch($usuario->nivel)
            {
              case 1:
                  echo ' 
                  <option value="2">Cajera</option>
                  <option value="3">Reservaciones</option>
                  <option value="4">Ama Llaves</option>
                  <option value="5">Indefinido</option>
                  </select>';
                break;
              case 2:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="3">Reservaciones</option>
                  <option value="4">Ama Llaves</option>
                  <option value="5">Indefinido</option>
                  </select>';
                break;
              case 3:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="4">Ama Llaves</option>
                  <option value="5">Indefinido</option>
                  </select>';
                break;
              case 4:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Reservaciones</option>
                  <option value="5">Indefinido</option>
                  </select>';
                break;
                case 5:
                  echo ' 
                  <option value="1">Administrador</option>
                  <option value="2">Cajera</option>
                  <option value="3">Reservaciones</option>
                  <option value="4">Ama Llaves</option>
                  </select>';
                break;
              default:
                  $nivel = "Otro";
                break;
            }   
            echo '      
          </div>
          </div>
          <div class="col-sm-2">Puesto:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="puesto" value="'.$usuario->puesto.'" maxlength="20">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Celular:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="celular" value="'.$usuario->celular.'" maxlength="20">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" value="'.$usuario->correo.'" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Direccion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" value="'.$usuario->direccion.'">
          </div>
          </div>
          <div class="col-sm-6"></div>
        </div>       
        <h4><p><a href="#" class="text-dark">Otorgar permisos:</a></p></h4></br>
        <div class="form-group row">
        <div class="col-sm-3">Usuario:</div>
        <div class="col-sm-1">
          <div class="form-check">';
          if($usuario->usuario_ver==0){
            echo '<input class="form-check-input" type="checkbox" id="usuario_ver" >';
          }else{
            echo '<input class="form-check-input" type="checkbox" id="usuario_ver" checked >';
          }
          echo '   <label class="form-check-label">
              Ver
            </label>
          </div>
        </div>
        <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->usuario_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="usuario_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="usuario_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->usuario_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="usuario_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="usuario_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->usuario_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="usuario_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="usuario_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Huesped:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->huesped_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->huesped_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->huesped_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->huesped_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="huesped_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="huesped_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>
            <div class="form-group row">
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
            </div><br><hr>  
            <div class="form-group row">
            <div class="col-sm-3">Tarifa Hospedaje:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tarifa_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="tarifa_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tarifa_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tarifa_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="tarifa_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tarifa_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tarifa_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="tarifa_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tarifa_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->tarifa_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="tarifa_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="tarifa_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
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
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Reservacion:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->reservacion_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="reservacion_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="reservacion_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->reservacion_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="reservacion_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="reservacion_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->reservacion_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="reservacion_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="reservacion_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->reservacion_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="reservacion_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="reservacion_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Reporte:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->reporte_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="reporte_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="reporte_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Forma Pago:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->forma_pago_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->forma_pago_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->forma_pago_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->forma_pago_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="forma_pago_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="row">
              <div class="col-sm-9"></div>
              <div class="col-sm-2">
              <div id="boton_usuario">
                <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_usuario('.$_GET['id'].')">
              </div>
              </div>
              <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_usuario()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
            </div>
      </div>';
?>