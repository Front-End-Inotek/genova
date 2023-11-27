<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <div class="form_container">
  <form onsubmit="event.preventDefault();" id="agregar_usuarios" class="formulario_contenedor">
    <div class="form_title_container">
      <h2 class="form_title_text">AGREGAR USUARIOS</h2>
      </div>
       <div class="inputs_form_container">
         <div class="form-floating input_container">
         <input class="form-control custom_input" type="text" id="usuario" placeholder="Ingresa el nombre para el usuario" maxlength="50">
         <label for="usuario">Usuario</label>       
       </div>
         <div class="form-floating input_container">
         <input class="form-control custom_input" type="text" id="nombre_completo" placeholder="Ingresa el nombre completo del usuario" maxlength="70">
         <label for="nombre completo">Nombre completo</label>       
        </div>
        </div>
         <div class="inputs_form_container">
           <div class="form-floating input_container">
           <input class="form-control custom_input" type="password" id="contrasena" placeholder="Ingresa la contraseña del usuario" maxlength="50">
           <label for="contrasena">Contraseña</label>       
        </div>
           <div class="form-floating input_container">
            <select class="form-select custom_input" id="nivel">
              <option value="0">Selecciona</option>
              <option value="1">Administrador</option>
              <option value="2">Cajera</option>
              <option value="3">Recamarera</option>
              <option value="4">Mantenimiento</option>
              <option value="5">Supervision</option>
              <option value="6">Restaurante</option>
              <option value="7">Reservaciones</option>
              <option value="8">Ama Llaves</option>
              <option value="9">Indefinido</option>
            </select>  
            <label for="categoria">Categoria</label>     
          </div>
        </div>      
           <div class="inputs_form_container">
            <div class="form-floating input_container">
            <input class="form-control custom_input" type="password" id="recontrasena" placeholder="Ingresa nuevamente la contraseña" maxlength="50">
            <label for="contrasena">Contraseña</label>       
          </div>
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="puesto" placeholder="Ingresa el puesto del usuario" maxlength="40">
            <label for="puesto">Puesto</label>     
          </div>
        </div>
           <div class="inputs_form_container">
            <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="celular" placeholder="Ingresa el celular del usuario" maxlength="20">
            <label for="celular">Celular</label>       
          </div>
            <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="correo" placeholder="Ingresa el correo del usuario" maxlength="70">
            <label for="Correo">Celular</label>       
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Dirección:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" placeholder="Ingresa la dirección del usuario">
          </div>
          </div>
          <div class="col-sm-4"></div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_usuario()">Guardar</button>
          </div>
          </div>
        </div>
      </div>';
?>

