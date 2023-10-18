<?php

echo '
    <div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Factura global</h2></div>
        <br>
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-2">
                <label><h6>Fecha inicial</h6></label>
                <input class="form-control" type="date" placeholder="Fecha de inicio" id="fecha_inicio_factura"/>
            </div>
            <div class="col-sm-2">
                <label><h6>Fecha final</h6></label>
                <input class="form-control" type="date" placeholder="Fecha de inicio" id="fecha_fin_factura"/>
            </div>
            <div class="col-sm-1">
                <label class="col-12"><h6>Hacer busqueda</h6></label>
                <button class="btn btn-primary btn-block btn-default" onclick="manejo_facturas()" >
                 Buscar
                </button>
            </div>
            <div class="col-sm-1">
                <label class="col-12"><h6>Facturas</h6></label>
                <button class="btn btn-primary btn-block btn-default" onclick="generar_facturas_global()" >
                 Generar
                </button>
            </div>
        </div>
        <div id="contenedor-facturas" class="contenedor_columnas_tablas">
        </div>
    </div>
';

?>