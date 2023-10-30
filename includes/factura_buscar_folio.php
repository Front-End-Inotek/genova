<?php

echo '
    <div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Buscar factura por folio</h2></div>
        <br>
        <div class="row">
            <div class="col-sm-2 form-floating mb-3">
                <input type="number" class="form-control" id="inicial" placeholder="Factura inicial">
                <label for="inicial" style="padding-left: 25px;" >Folio inicial de la Factura</label>
            </div>
            <div class="col-sm-2 form-floating mb-3">
                <input type="number" class="form-control" id="final" placeholder="Factura final">
                <label for="final" style="padding-left: 25px;" >Folio final de la factura</label>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-block btn-default" onclick="buscar_factura_folio()" > Buscar </button>
            </div>
        </div>
        <div class="row" id="contenedor-facturas">
        </div>
    </div>
';

?>