<form id="formcancelar" enctype="multipart/form-data">
    <div class="row" style="margin-top:50px; margin-left:auto; margin-right: auto; position: inherit;">
<!--         Columna 1  Datos del usuario-->
        <div class="col-xl-3">
            <div class="control" id="control">
<!--             Imput archivo xml -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" style="width: 105px; font-size: 12px;">Archvio XML</span>
                </div>
                <div class="custom-file">
                <input type="file" id="file" name="file" class="custom-file-input" style="font-size: 12px;">
                <label class="custom-file-label" for="inputGroupFile01" style="font-size: 12px;"></label>
            </div>
            </div>

<!--             Imput Motivo de cancelacion -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Motivo</label>
                </div>
                <select id="motivo" name ="motivo" class="custom-select" style="font-size: 12px;" required>
                <option value="01">“01” Comprobantes emitidos con errores con relación.</option>
                <option value="02">“02” Comprobantes emitidos con errores sin relación.</option>
                <option value="03">“03” No se llevó a cabo la operación.</option>
                <option value="04">“04” Operación nominativa relacionada en una factura global.</option>
                </select>

            </div>
            </div>
        </div>
<!--         Columna 2 Datos del documento a facturar-->
        <div class="dinamic col-xl-9" id="dinamic" style="max-height:460px; overflow-y: scroll;">
        <div class="form-row" >
            </div>
        </div>

    </div>
    <br>
    <center><button class="btn btn-danger" id="animacion_cancelar" type="button" style="margin-left: 180px; width: 550px; display:none">
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Cargando...
</button></center>
    <center><button type="button" class="btn btn-danger" id="cancelar" name ="cancelar" onclick="validar_c_cancelacion()" style="margin-left: 180px; width: 550px;">Cancelar&nbsp;Factura</button></center>
    <!--<center><button type="submit" class="btn btn-secondary btn-lg" style="width: 550px;">Timbrar&nbsp;Factura</button></center>-->
</form>