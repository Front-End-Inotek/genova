  <div class="container texto_entrada" style="margin-top:50px; margin-left:auto; margin-right: auto; position: inherit;">
        <div class="form-group">
        <h2>Buscar factura por folio</h2>
        <label for="inicial">
        Folio incial de la Factura:
        </label>
    <input class="form-control" type="number"  id="inicial" name="inicial" placeholder="Factura inicial"/>
        </div>
        <div class="form-group">
        <label for="final">
        Folio final de la Factura:
        </label>
        <input class="form-control" type="number" id="final" name="final" placeholder="Factura final"/>
        </div>
        <br>
        <br>
        <center><button type="button" class="btn btn-secondary btn-lg" onclick="buscar_factura_folio()" style="margin-left: 180px; width: 550px;">Buscar&nbsp;Factura</button></center>
    </div>
