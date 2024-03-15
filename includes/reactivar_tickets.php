<?php
	date_default_timezone_set('America/Mexico_City');
  echo ' 
  <div class="main_container">
    <div class="main_container_title">
        <h2>Reactivar tickets</h2>
    </div>

    <div class="inputs_form_container justify-content-start">
        <div class="form-floating">
            <input type="text" id="id_ticket" class="form-control custom_input" autofocus/>
            <label for="id_ticket">ID del ticket</label>
        </div>
        <div class="form-floating ">
            <button class="btn btn-primary" onclick="buscar_ticket_reactivar()">
                Buscar ticket
            </button>
        </div>
    </div>


    </div>
          
';
?>
