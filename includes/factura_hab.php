<?php
    include("clase_factura.php");
    $fact = NEW factura ();
    if(isset($_GET['fila'])){
        $contador = $_GET['fila'];
    }else{
        $contador = 15;
    }
    
    if(empty($contador)){
        $contador = 15;
    }
    intval($contador);
    echo'
    <div class="container-fluid blanco">
        <div class="col-12 text-center">
            <h2 class="text-dark">Factura de habitación</h2>
        </div>
        <form id="formfactura" autocomplete="off" accept-charset="utf-8">
        <div class="row" >
    <!--         Columna 1  Datos del usuario-->
            <div class="col-2"  >
                <div class="control" id="control">
                    <div class="input-group mb-3" style="display: none;">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Agregar fila</span>
                        </div>
                        <input type="number" id="filas" name="filas" class="form-control" oninput="agregar_filas()" aria-label="Default" aria-describedby="inputGroup-sizing-default" value='.$contador.'>
                    </div>
    <!--             Imput RFC -->
                    <div class="form-floating mb-2">
                        <input type="text" id="rfc" name ="rfc[]" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" oninput="buscar_rfc()" placeholder="RFC" >
                        <label  for="rfc"  id="inputGroup-sizing-default"  >RFC </label>
                    </div>
    <!--             Imput Nombre -->
                    <div class="form-floating mb-2">
                        <input type="text" id="nombre" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Nombre">
                        <label for="rfc" id="inputGroup-sizing-default">Nombre</label>
                    </div>
    <!--             Imput Codigo postal -->
                    <div class="form-floating mb-2">
                        <input type="text" id="cp" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Codigo Postal">
                        <label for="cp "id="inputGroup-sizing-default">Codigo Postal</label>
                    </div>
    <!--             Imput Uso de CFDI -->
                    <div class="form-floating mb-2">
                        <select id="regimen" name ="rfc[]" class="form-select" id="inputGroupSelect01">
                            <option selected disabled>Selecciona una opciónn</option>
                            ';
                                $resulta=$fact->regimen_fiscal();
                                while ($vara=mysqli_fetch_array($resulta)) {
                                    echo '<option value='.$vara[1].'> '.$vara[1]. $vara[2].'</option>';
                                }
                        echo'</select>
                        <label  for="regimen" >Régimen Fiscal</label>
                    </div>
                    <!--   Imput Uso de CFDI -->
                    <div class="form-floating mb-2">
                        <select id="cfdi" name ="rfc[]" class="form-select" id="inputGroupSelect01">
                            <option selected disabled>Selecciona una opción</option>
                            ';
                                $resulta=$fact->uso_cfdi();
                                while ($vara=mysqli_fetch_array($resulta)) {
                                    echo'<option value='.$vara[1].'> '.$vara[1].$vara[2].' </option>';
                                }
                            echo '</select>
                        <label for="cfdi">Uso de CFDI</label>
                    </div>
                    <!--             Imput Correo Electronico -->
                    <div class="form-floating mb-2">
                        <input type="text" id="correo" name="rfc[]" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="E-Mail">
                        <label for="correo" id="inputGroup-sizing-default" >E-Mail</label>
                    </div>
                    <!--             Imput Metodo de Pago -->
                    <div class="form-floating mb-2">
                        <select id="metodopago" name="rfc[]" class="form-select" id="inputGroupSelect01">
                            <option selected disabled>Selecciona una opción</option>
                            ';
                                $resulta=$fact->metodo_pago();
                                while ($vara=mysqli_fetch_array($resulta)) {
                                    echo'<option value='.$vara[1].'>  '.$vara[1]. $vara[2].'</option>';
                                    }
                                echo '</select>
                                <label for="metodopago" >Metodo de Pago</label>
                            </div>
    <!--             Imput Forma de Pago -->
                    <div class="form-floating mb-2">
                        <select id="forma_pago" name="rfc[]" class="form-select" id="inputGroupSelect01">
                            <option selected disabled>Selecciona una opción</option>
                            ';
                                $resulta=$fact->forma_pago();
                                while ($vara=mysqli_fetch_array($resulta)) {
                            echo'<option value='.$vara[1].'> '.$vara[1].$vara[2].' </option>';
                            }
                        echo '</select>
                        <label for="forma_pago">Forma de Pago</label>
                    </div>
                    <!--             Textarea  Notas -->
                    <div class="form-floating mb-2">
                        <textarea id="notas" name="rfc[]" class="form-control" id="exampleFormControlTextarea1" placeholder="Notas" style="height: 80px"></textarea>
                        <label for="notas" id="inputGroup-sizing-default">Notas</label>
                    </div>
                    <hr style="color: black; display: block" />
                    <div class="input-group">
                        <span  id="inputGroup-sizing-default" >Agregar a factura global</span>
                        <input type="checkbox" id="checkfacturaglobal" aria-label="Checkbox for following text input" onclick="factura_global()" style="margin-left: 1rem;">
                    </div>
                </div>
            </div>
            <div class="dinamic col-10" id="dinamic" >
                <div class="col-12">
                                <div class="row col-12" >
                                    <div class="col-2 form-floating">
                                        <input type="text" name="rimporte" class="form-control" id="rimporte" readonly placeholder="Importe:">
                                        <label for="rimporte" style="padding-left: 25px;">Importe:</label>
                                    </div>
                                    <div class="col-2 form-floating">
                                        <input type="text" name="riva" class="form-control" id="riva" readonly placeholder="I.V.A">
                                        <label for="riva" style="padding-left: 25px;">I.V.A.</label>  
                                    </div>
                                    <div class="col-2 form-floating">
                                        <input type="text" name="rish" class="form-control" id="rish" readonly placeholder="I.S.H">
                                        <label for="rish" style="padding-left: 25px;">I.S.H.</label>
                                    </div>
                                    <div class="col-2 form-floating">
                                        <input type="text" name="rtotal" class="form-control" id="rtotal" readonly placeholder="Total:">
                                        <label for="rtotal" style="padding-left: 25px;">Total:</label>
                                    </div>
                                    <button type="button" class="btn btn-info col-2" id="timbrar" name ="timbrar" onclick="timbrar_factura()" >
                                        Timbrar&nbsp;Factura
                                    </button>
                                </div>
                        </div>
                <div class="form-row row" style="max-height:590px; overflow-y: scroll;">
                    <div class="row col-12 mb-2">
                        <!--             Imput Uso de CFDI -->
                            <div id ="input_periocidad" class="form-floating col-3" style="display: none;">
                                <select id="periocidad" name ="rfc[]" class="form-select" id="inputGroupSelect01">
                                <option selected disabled>Selecciona una opción</option>
                                ';
                                $resulta=$fact->periocidad();
                                while ($vara=mysqli_fetch_array($resulta)) {
                                    echo'<option value='.$vara[1].'> '.$vara[1]. $vara[2].'</option>';
                                }
                            echo'</select>
                            <label for="periocidad">Periodicidad</label>
                            </div>
                        <!--             Imput Nombre -->
                        <div id ="input_mes" class="form-floating col-3" style="display: none;">
                            <select id="mes" name ="rfc[]" class="form-select" id="inputGroupSelect01" >
                                <option selected disabled>Selecciona una opción</option>
                                ';
                                    $resulta=$fact->mes();
                                    while ($vara=mysqli_fetch_array($resulta)) {
                                echo'<option value='.$vara[1].'> '.$vara[1]. $vara[2].'</option>';
                                }
                            echo'</select>
                            <label for="mes">Mes</label>
                        </div>
                        <!--             Imput Codigo postal -->
                        <div id ="input_año" class="form-floating col-3" style="display: none;">
                            <input type="text" id="año" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"  value="" placeholder="Año">
                            <label  for="año">Año</label>
                        </div>
                    </div>
                    
                ';
    
                    for ($i=1; $i <= $contador ; $i++) {
                        echo '
                        
                        <div class="form-floating col-1 mb-2">
                            <input type="text" name="cantidad['.$i.']" class="form-control" id="cantidad['.$i.']" oninput="cal()" value="" placeholder="Cantidad">
                            <label for="inputCity" style="padding-left: 25px;">Cantidad</label>
                        </div>
        <!--             Imput Unidad -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="unidad['.$i.']" class="form-control" id="unidad['.$i.']" value="SER" placeholder="Unidad">
                        <label for="inputCity" style="padding-left: 25px;">Unidad</label>
                    </div>
        <!--             Imput Clave/Unidad -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="claveunidad['.$i.']" class="form-control" id="claveunidad['.$i.']" value="E48" placeholder="Clave/Unidad">
                        <label for="inputCity" style="padding-left: 25px;">Clave/Unidad </label>
                    </div>
        <!--             Imput Clave -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="clave['.$i.']" class="form-control" id="clave['.$i.']" value="90111500" placeholder="Clave">
                        <label for="inputCity" style="padding-left: 25px;">Clave</label>
                    </div>
        <!--             Imput Id -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="id['.$i.']" class="form-control" id="id['.$i.']" value="" placeholder="ID">
                        <label for="inputCity" style="padding-left: 25px;">ID</label>
                    </div>
        <!--             Imput Producto -->
                    <div class="form-floating col-2 mb-2">
                        <input type="text" name="producto['.$i.']" class="form-control" id="producto['.$i.']" value="HOSPEDAJE" placeholder="Producto">
                        <label for="inputCity" style="padding-left: 25px;">Producto</label>
                    </div>
        <!--             Imput Imp Unitario -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="importeuni['.$i.']" class="form-control" id="importeuni['.$i.']" oninput="cal()" value="" placeholder="Imp.&nbsp;Unitario">
                        <label for="inputCity" style="padding-left: 25px;">Imp.&nbsp;Unitario</label>
                    </div>
        <!--             Imput Importe -->
                    <div class="form-floating col-1 mb-2">
                        <input type="text" name="importe['.$i.']" class="form-control" id="importe['.$i.']" value="" readonly placeholder="Importe">
                        <label for="inputCity" style="padding-left: 25px;">Importe</label>
                    </div>
        <!--             Imput IVA -->
                    <div class="form-floating col-1 mb-2">
                        <input name="iva['.$i.']" type="text" class="form-control" id="iva['.$i.']" oninput="cal()" value="" readonly placeholder="IVA">
                        <label for="inputCity" style="padding-left: 25px;">IVA</label>
                    </div>
                <!--             Imput ISH -->
                        <div class="form-floating col-1 mb-2">
                            <input type="text" name="ish['.$i.']" class="form-control" id="ish['.$i.']" oninput="cal()" value="" readonly placeholder="ISH"> 
                            <label for="inputCity" style="padding-left: 25px;">ISH</label>
                        </div>
        <!--             Checkbox ISH -->
                    <div class="form-group col-1">
                            <input name="checisah['.$i.']" class="form-check-input" type="checkbox" id="checisah['.$i.']" oninput="cal()" checked> 
                    </div>
                    ';
                    }
                    echo'
                    </div>
            </div>
            <div class="row col-xl-12">
                <div class="col-md-4"><!-- Espacio en blanco --></div>
            </div>
        </div>
        <center><button class="btn btn-secondary" id="animacion_timbrar" type="button" style="margin-left: 180px; width: 550px; display:none">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Cargando...
                </button></center>
        <center></center>
        <!--<center><button type="submit" class="btn btn-secondary btn-lg" style="width: 550px;">Timbrar&nbsp;Factura</button></center>-->
    </form>
            </div>

            <!--         Columna 2 Datos del documento a facturar-->
             <div>
                <div id="animacion_formulario" class="spinner-border" style="width: 24rem; height: 24rem; margin-left:50%; margin-right: 50%; display:none; align-items: center;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
    ';
?>
