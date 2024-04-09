<?php
$hoy = date("Y-m-d");
echo '
    <div class="main_container">
        <header class="main_container_title">
            <h2 >Buscar factura por fecha</h2>
        </header>

        <div class="inputs_form_container justify-content-start">

            <div class="form-floating input_container_date">
                <input class="form-control custom_input" type="date" placeholder="Fecha inicial de la factura" id="inicial" value="' . $hoy . '" />
                <label for="inicial">Fecha inicial</label>
            </div>

            <div class="form-floating input_container_date">
                <input class="form-control custom_input" type="date" placeholder="Fecha final de la factura" id="final" value="' . $hoy . '" />
                <label for="final" >Fecha final</label>
            </div>

            <div class="form-floating input_container_date">
                <button class="btn btn-primary btn-block btn-default" onclick="buscar_factura_fecha()" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </button>
            </div>

        </div>

        <div id="contenedor-facturas" class="contenedor-facturas">
        </div>
    </div>
';

?>