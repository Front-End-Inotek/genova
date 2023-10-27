<?php

echo '
    <div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Buscar factura por fecha</h2></div>
        <br>
        <div class="row">
            <div class="col-sm-2">
                <label><h6>Fecha inicial</h6></label>
                <input class="form-control" type="date" placeholder="Fecha inicial de la factura" id="inicial"/>
            </div>
            <div class="col-sm-2">
                <label><h6>Fecha final</h6></label>
                <input class="form-control" type="date" placeholder="Fecha final de la factura" id="final"/>
            </div>
            <div class="col-sm-2">
                <label class="col-12"><h6>Hacer busqueda</h6></label>
                <button class="btn btn-primary btn-block btn-default" onclick="buscar_factura_fecha()" > Buscar </button>
            </div>
        </div>
        <div class="row" id="contenedor-facturas">
        </div>
    </div>
';

?>