<?php

echo '
    <div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Cancelar factura</h2></div>
        <br>
        <div class="container">
            <form id="formcancelar" enctype="multipart/form-data">
                <div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Archivo XML</label>
                        <input class="form-control form-control-lg" type="file" id="file">
                    </div>
                </div>
                <div class="form-floating">
                    <select class="form-select" id="motivo" name="motivo"  aria-label="Floating label select example">
                        <option selected disable >Selecciona un motivo</option>
                        <option value="01">“01” Comprobantes emitidos con errores con relación.</option>
                        <option value="02">“02” Comprobantes emitidos con errores sin relación.</option>
                        <option value="03">“03” No se llevó a cabo la operación.</option>
                        <option value="06">“04” Operación nominativa relacionada en una factura global.</option>
                    </select>
                    <label for="motivo">Motivo</label>
                </div>
                <div>
                    <button class="btn btn-danger" id="animacion_cancelar" type="button" style="margin-left: 180px; width: 550px; display:none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-danger" id="cancelar" name ="cancelar" onclick="validar_c_cancelacion()" style="margin-left: 180px; width: 550px;">Cancelar&nbsp;Factura</button>
                </div>
            </form>
        </div>
        <div class="row" id="contenedor-facturas">
        </div>
    </div>
';

?>