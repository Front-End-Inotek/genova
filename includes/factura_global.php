<?php

echo '
    <div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Factura global</h2></div>
        <br>
        <div class="row">
            <div class="col-sm-2">
                <label><h6>Fecha inicial</h6></label>
                <input class="form-control" type="date" placeholder="Fecha de inicio" id="fecha_inicio_factura"/>
            </div>
            <div class="col-sm-2">
                <label><h6>Fecha final</h6></label>
                <input class="form-control" type="date" placeholder="Fecha de inicio" id="fecha_fin_factura"/>
            </div>
            <div class="col-sm-2">
                <label class="col-12"><h6>Fecha final</h6></label>
                <button class="btn btn-primary btn-block btn-default" onclick="manejo_facturas()" > Buscar </button>
            </div>
        </div>
        <div id="contenedor-facturas">
        </div>
    </div>
';

?>