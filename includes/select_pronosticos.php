<?php 
    echo '
        <div class="main_containner">
            <header class="main_container_title">
                <h2>PRONOSTICO DE OCUPACIÓN</h2>
            </header>

            <div class="inputs_form_container justify-content-start">
                <div class="form-floating">
                    <div class="form-floating">
                        <input type="month" name="fecha" id="mesanio" class="form-control custom_input"  maxlength="7" minlength="7" value="2023-01" pattern="^(20\d{2})-(0[1-9]|1[0-2])$" title="Formato inválido. Utiliza YYYY-MM">
                        <label for="mesanio">Mes del reporte</label>
                    </div>
                </div>
                <div class="form-floating">
                    <button class="btn btn-primary" onclick="generarReporte()" id="buscar_reporte">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                        Buscar
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-center" style="visibility: hidden;" id="loader_pronosticos">
                    <div class="spinner-border text-primary" role="status">
                        
                    </div>
                </div>

                <div id="contenedor_para_pronosticos"></div>
        </div>
    ';
?>