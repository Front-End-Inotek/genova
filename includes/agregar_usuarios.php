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
           <input class="form-control custom_input" type="password" id="recontrasena" placeholder="Ingresa nuevamente la contraseña" maxlength="50">
           <label for="contrasena">Confirmar contraseña</label>       
      </div>
      </div>
      <div class="inputs_form_container">
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
            <label for="correo">Correo</label>       
            </div>
          </div>
             <div class="form-floating input_container">
             <input class="form-control custom_input" type="text" id="direccion" placeholder="Ingresa la dirección del usuario">
             <label for="direccion">Dirección</label>       
          </div>
          <div class="inputs_form_container">
          <div class="container_btn">
          <button type="submit" class="btn btn-primary btn-lg btn-block" value="Guardar" onclick="guardar_usuario()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
              <path d="M11 2H9v3h2z"/>
              <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
            </svg>
            Guardar
          </button>
          </div>
          </div>
      </div>';
?>

