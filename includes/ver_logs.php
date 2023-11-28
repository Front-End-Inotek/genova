<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  
  echo ' <div class="main_container"> 
                <header class="main_container_title">
                        <h2>LOGS</h2>
                </header>
          
          <div class="inputs_form_container justify-content-start">
                <div class="form-floating input_container_date">
                        <input class="form-control custom_input" type="date"  id="inicial"  placeholder="Log inicial" autofocus="autofocus" placeholder="Fecha inicial"/>
                        <label for="inicial" >Fecha inicial</label>
                </div>
                <div class="form-floating input_container_date">
                        <input class="form-control custom_input" type="date" id="final" placeholder="Log final" autofocus="autofocus" placeholder="Fecha final" />
                        <label for="final">Fecha final</label>
                </div>
                <div id="form-floating input_container_date">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" value="Guardar" onclick="busqueda_logs('.$_GET['usuario_id'].')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                Buscar
                        </button>
                </div>
          </div><br>
         </div>';
?>
