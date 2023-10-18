<form id="formconsulta" enctype="multipart/form-data">
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
                <input type="file" id="archivo_xml" name="archivo_xml" class="custom-file-input" style="font-size: 12px;">
                <label class="custom-file-label" for="inputGroupFile01" style="font-size: 12px;"></label>
            </div>
            </div>

            </div>
        </div>
<!--         Columna 2 Datos del documento a facturar-->
        <div class="dinamic col-xl-9" id="dinamic" style="max-height:460px; overflow-y: scroll;">
        <div class="form-row" >
        <table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Estatus</th>
							<th>Estatus de cancelacion</th>
							<th>Estado CFDI</th>
						</tr>
					</thead>
					<tbody id="tabla_contenido">

					</tbody>
				</table>
            </div>
        </div>
        
    </div>
    <br>
    <center><button class="btn btn-primary" id="animacion_consultar" type="button" style="margin-left: 180px; width: 550px; display:none">
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Cargando...
</button></center>
    <center><button type="button" class="btn btn-primary" id="consultar" name ="consultar" onclick="validar_c_consulta()" style="margin-left: 180px; width: 550px;">Consultar&nbsp;Factura</button></center>
    <!--<center><button type="submit" class="btn btn-secondary btn-lg" style="width: 550px;">Timbrar&nbsp;Factura</button></center>-->
</form>