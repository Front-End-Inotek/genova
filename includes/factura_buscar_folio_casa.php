<?php
echo '
    <div class="main_container">
        <header class="main_container_title">
            <h2>Buscar factura por folio casa</h2>
        </header>

        <div class="inputs_form_container justify-content-start">

            <div class="form-floating input_container2">
                <input type="number" class="form-control custom_input" id="folio" placeholder="Folio casa" />
                <label for="folio">Folio casa</label>
            </div>
            <form>
                <input type="radio" id="todas" name="estado_facturas" value="todas" checked>
                <label for="todas">Todas</label><br>

                <input type="radio" id="activas" name="estado_facturas" value="activas">
                <label for="activas">Activas</label><br>

                <input type="radio" id="canceladas" name="estado_facturas" value="canceladas">
                <label for="canceladas">Canceladas</label><br>
            </form>

            <div class="form-floating input_container">
                <button class="btn btn-primary btn-block " onclick="buscar_factura_folio_casa()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </button>
            </div>

        </div>

        <div id="resultado_folio_casa"></div>
    </div>

';

?>