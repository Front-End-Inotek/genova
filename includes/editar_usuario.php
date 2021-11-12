<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario($_GET['id']);
  echo '
      <div class="container">
        <br>
        <div class="col-sm-12 text-center"><h1 class="text-primary">Editar Usuario</h1></div><br>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2"><button class="btn btn-outline-info btn-lg btn-block" onclick="regresar_editar_usuario()"><span class="glyphicon glyphicon-edit"></span> Regresar</button></div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Usuario:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="usuario" value="'.$usuario->usuario.'" maxlength="50">
          </div>
          </div>
        </div><br>
        <!-- <div class="row">
            <div class="col-sm-2" >Contrasena:</div>
            <div class="col-sm-10" >
            <div class="form-group">
              <input class="form-control" type="password"  id="contrasena" value="'.$usuario->pass.'" maxlength="50">
            </div>
            </div>
          </div><br>
        <div class="row">
            <div class="col-sm-2" >Contrasena:</div>
            <div class="col-sm-10" >
            <div class="form-group">
              <input class="form-control" type="password"  id="recontrasena" value="'.$usuario->pass.'" maxlength="50">
            </div>
            </div>
          </div><br> -->
        <div class="form-group">
        <div class="row">
            <div class="col-sm-2" >Categoria:</div>
            <div class="col-sm-10" >
            <div class="form-group">
              <select class="form-control" id="nivel">
              <option value='.$usuario->nivel.'>'. $usuario->obtener_nivel($_GET['id']).'</option>';
              switch($usuario->nivel)
              {
                case 1:
                    echo ' 
                    <option value="2">Almacen</option>
                    <option value="3">Ventas</option>
                    <option value="4">Compras</option>
                    <option value="5">Tecnico</option>
                    </select>';
                  break;
                case 2:
                    echo ' 
                    <option value="1">Administrador</option>
                    <option value="3">Ventas</option>
                    <option value="4">Compras</option>
                    <option value="5">Tecnico</option>
                    </select>';
                  break;
                case 3:
                    echo ' 
                    <option value="1">Administrador</option>
                    <option value="2">Almacen</option>
                    <option value="4">Compras</option>
                    <option value="5">Tecnico</option>
                    </select>';
                  break;
                case 4:
                    echo ' 
                    <option value="1">Administrador</option>
                    <option value="2">Almacen</option>
                    <option value="3">Ventas</option>
                    <option value="5">Tecnico</option>
                    </select>';
                  break;
                  case 5:
                    echo ' 
                    <option value="1">Administrador</option>
                    <option value="2">Almacen</option>
                    <option value="3">Ventas</option>
                    <option value="4">Compras</option>
                    </select>';
                  break;
                default:
                    $nivel = "Indefinido";
                  break;
              }   
              echo '
            </div>
            </div>
          </div><br>
        <div class="row">
          <div class="col-sm-2" >Nombre completo:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre_completo" value="'.$usuario->nombre_completo.'" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Puesto:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="puesto" value="'.$usuario->puesto.'" maxlength="20">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Celular:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="celular" value="'.$usuario->celular.'" maxlength="20">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Correo:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="correo" value="'.$usuario->correo.'" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Direccion:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="direccion" value="'.$usuario->direccion.'">
          </div>
          </div>
        </div><br>
        <h4><p><a href="#" class="text-primary">Otorgar permisos:</a></p></h4></br>
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
            <div class="col-sm-3">Cliente:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cliente_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="cliente_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cliente_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cliente_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="cliente_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cliente_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cliente_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="cliente_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cliente_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cliente_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="cliente_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cliente_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>
            <div class="form-group row">
            <div class="col-sm-3">Proveedor:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->proveedor_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="proveedor_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="proveedor_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->proveedor_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="proveedor_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="proveedor_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->proveedor_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="proveedor_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="proveedor_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->proveedor_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="proveedor_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="proveedor_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>  
            <div class="form-group row">
            <div class="col-sm-3">Inventario:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->inventario_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="inventario_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="inventario_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->inventario_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="inventario_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="inventario_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->inventario_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="inventario_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="inventario_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->inventario_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="inventario_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="inventario_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Requisicion:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->requisicion_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="requisicion_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="requisicion_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->requisicion_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="requisicion_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="requisicion_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->requisicion_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="requisicion_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="requisicion_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->requisicion_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="requisicion_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="requisicion_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Salida:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->salida_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="salida_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="salida_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->salida_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="salida_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="salida_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->salida_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="salida_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="salida_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->salida_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="salida_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="salida_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
              <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->salida_aprobar==0){
              echo '<input class="form-check-input" type="checkbox" id="salida_aprobar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="salida_aprobar" checked>';
              }
              echo '   <label class="form-check-label">
                  Aprobar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Regreso:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->regreso_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="regreso_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="regreso_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->regreso_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="regreso_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="regreso_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->regreso_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="regreso_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="regreso_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->regreso_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="regreso_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="regreso_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Necesidades:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->necesidades_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="necesidades_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="necesidades_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->necesidades_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="necesidades_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="necesidades_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->necesidades_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="necesidades_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="necesidades_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->necesidades_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="necesidades_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="necesidades_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Cotizaciones:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cotizaciones_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cotizaciones_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cotizaciones_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->cotizaciones_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="cotizaciones_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Servicio:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->servicio_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="servicio_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="servicio_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->servicio_login==0){
              echo '<input class="form-check-input" type="checkbox" id="servicio_login">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="servicio_login" checked>';
              }
              echo '   <label class="form-check-label">
                  Login
                </label>
              </div>
            </div> 
            </div><br><hr>
            <div class="form-group row">
            <div class="col-sm-3">Herramienta:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->herramienta_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="herramienta_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="herramienta_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->herramienta_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="herramienta_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="herramienta_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->herramienta_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="herramienta_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="herramienta_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->herramienta_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="herramienta_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="herramienta_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr>
            <div class="form-group row">
            <div class="col-sm-3">Desperdicio Entrada:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_entrada_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_entrada_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_entrada_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_entrada_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_entrada_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div>
            </div><br><hr> 
            <div class="form-group row">
            <div class="col-sm-3">Desperdicio Salida:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_salida_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_salida_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_salida_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->desperdicio_salida_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="desperdicio_salida_borrar" checked>';
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
            <div class="col-sm-3">Factura:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->factura_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="factura_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="factura_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->factura_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="factura_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="factura_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->factura_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="factura_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="factura_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->factura_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="factura_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="factura_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div> 
            </div><br><br><hr>
            <div class="form-group row">
            <div class="col-sm-3">Orden de Trabajo:</div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->orden_ver==0){
              echo '<input class="form-check-input" type="checkbox" id="orden_ver">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="orden_ver" checked>';
              }
              echo '   <label class="form-check-label">
                  Ver
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->orden_agregar==0){
              echo '<input class="form-check-input" type="checkbox" id="orden_agregar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="orden_agregar" checked>';
              }
              echo '   <label class="form-check-label">
                  Agregar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->orden_editar==0){
              echo '<input class="form-check-input" type="checkbox" id="orden_editar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="orden_editar" checked>';
              }
              echo '   <label class="form-check-label">
                  Editar
                </label>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-check">';
              if($usuario->orden_borrar==0){
              echo '<input class="form-check-input" type="checkbox" id="orden_borrar">';
              }else{
              echo '<input class="form-check-input" type="checkbox" id="orden_borrar" checked>';
              }
              echo '   <label class="form-check-label">
                  Borrar
                </label>
              </div>
            </div> 
            </div><br><hr> 
        <div id="boton_usuario">
        <input type="submit" class="btn btn-outline-info btn-lg btn-block" value="Guardar" onclick="modificar_usuario('.$_GET['id'].')">
      </div>';
?>
