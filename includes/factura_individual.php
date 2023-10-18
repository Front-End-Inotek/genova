<?php
    include 'clase_factura.php';
    $fact = NEW factura();

    if(isset($_GET['fila'])){
        $contador = $_GET['fila'];
    }else{
        $contador = 15;
    }
    
    if(empty($contador)){
        $contador = 15;
    }
    intval($contador);
?>

<div class="container-fluid blanco">
        <div class="col-12 text-center"><h2 class="text-dark">Factura individual</h2></div>
        <br>
       
   
<form id="formfactura" autocomplete="off" accept-charset="utf-8">
    <div class="row" style="margin-top:50px; margin-left:auto; margin-right: auto; position: inherit;">
<!--         Columna 1  Datos del usuario-->
        <div class="col-sm-3" style="background-color:#33475b" >
            <div class="control" id="control">
            <div class="input-group mb-3" style="display: none;">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Agregar fila</span>
                </div>
                <input type="number" id="filas" name="filas" class="form-control" oninput="agregar_filas()" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;" value="<?php echo $contador ?>">
            </div>
<!--             Imput RFC -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 12px;">RFC </span>
                </div>
                <input type="text" id="rfc" name ="rfc[]" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" oninput="buscar_rfc()" style="font-size: 12px;" >
            </div>
<!--             Imput Nombre -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Nombre</span>
                </div>
                <input type="text" id="nombre" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;" value="">
            </div>
<!--             Imput Codigo postal -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Codigo Postal</span>
                </div>
                <input type="text" id="cp" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;" value="">
            </div>
<!--             Imput Uso de CFDI -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Régimen Fiscal</label>
                </div>
                <select id="regimen" name ="rfc[]" class="custom-select" id="inputGroupSelect01" style="font-size: 12px;">
                <?php

                $resulta=$fact->regimen_fiscal();
               /*$sqal="SELECT * FROM regimen_fiscal";
               $resulta=mysqli_query($con,$sqal);*/
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
            <!--   Imput Uso de CFDI -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Uso de CFDI</label>
                </div>
                <select id="cfdi" name ="rfc[]" class="custom-select" id="inputGroupSelect01" style="font-size: 12px;">
                <?php
               $sqal="SELECT * FROM uso_cfdi";
               $resulta=mysqli_query($con,$sqal);
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
<!--             Imput Correo Electronico -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">E-Mail</span>
                </div>
                <input type="text" id="correo" name="rfc[]" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;">
            </div>
<!--             Imput Metodo de Pago -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Metodo de Pago</label>
                </div>
                <select id="metodopago" name="rfc[]" class="custom-select" id="inputGroupSelect01" style="font-size: 12px;">
                <?php
               $sqal="SELECT * FROM metodo_pago";
               $resulta=mysqli_query($con,$sqal);
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
<!--             Imput Forma de Pago -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Forma de Pago</label>
                </div>
                <select id="forma_pago" name="rfc[]" class="custom-select" id="inputGroupSelect01" style="font-size: 12px;">
                <?php
               $sqal="SELECT * FROM forma_pago";
               $resulta=mysqli_query($con,$sqal);
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
<!--             Textarea  Notas -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Notas</span>
                </div>
                <textarea id="notas" name="rfc[]" class="form-control" id="exampleFormControlTextarea1" rows="3" style="font-size: 12px;"></textarea>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 160px; font-size: 12px;">Agregar a factura global</span>
                    <div class="input-group-text">
                    <input type="checkbox" id="checkfacturaglobal" aria-label="Checkbox for following text input" onclick="factura_global()">
                    </div>
                </div>
            </div>
            </div>
        </div>
<!--         Columna 2 Datos del documento a facturar-->
        <center>
        <div id="animacion_formulario" class="spinner-border" style="width: 24rem; height: 24rem; margin-left:50%; margin-right: 50%; display:none; align-items: center;" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </center>

        <div class="dinamic col-sm-9" id="dinamic" style="max-height:460px; overflow-y: scroll; background-color:#33225b"  >
        <div class="form-row" >
        <!--             Imput Uso de CFDI -->
        <div id ="input_periocidad" class="input-group col-xl-4" style="margin-bottom: 15px; display:none;">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Periodicidad</label>
                </div>
                <select id="periocidad" name ="rfc[]" class="custom-select" id="inputGroupSelect01" style="width: 105px; font-size: 12px;">
                <?php
               $sqal="SELECT * FROM periocidad";
               $resulta=mysqli_query($con,$sqal);
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
<!--             Imput Nombre -->
            <div id ="input_mes" class="input-group col-xl-4" style="margin-bottom: 15px; display:none;">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 105px; font-size: 12px;">Mes</label>
                </div>
                <select id="mes" name ="rfc[]" class="custom-select" id="inputGroupSelect01" style="width: 105px; font-size: 12px;">
                <?php
               $sqal="SELECT * FROM mes";
               $resulta=mysqli_query($con,$sqal);
                while ($vara=mysqli_fetch_array($resulta)) {  ?>
                  <option value="<?php echo $vara[1] ?>"> <?php echo ("$vara[1] $vara[2]") ?></option>
              <?php } ?>
                </select>
            </div>
<!--             Imput Codigo postal -->
            <div id ="input_año" class="input-group col-xl-4" style="margin-bottom: 15px; display:none;">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Año</span>
                </div>
                <input type="text" id="año" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="width: 105px; font-size: 12px;" value="">
            </div>

        <?php

            for ($i=1; $i <= $contador ; $i++) {
                echo '<div class="form-group col-xl-1">
                <label for="inputCity">Cantidad</label>
                <input type="text" name="cantidad['.$i.']" class="form-control" id="cantidad['.$i.']" oninput="cal()" value="" style="font-size: 12px;">
            </div>
<!--             Imput Unidad -->
            <div class="form-group col-xl-1">
                <label for="inputCity">Unidad</label>
                <input type="text" name="unidad['.$i.']" class="form-control" id="unidad['.$i.']" value="SER" style="font-size: 12px;">
            </div>
<!--             Imput Clave/Unidad -->
            <div class="form-group col-xl-1">
                <label for="inputCity">Clave/Unidad </label>
                <input type="text" name="claveunidad['.$i.']" class="form-control" id="claveunidad['.$i.']" value="E48" style="font-size: 12px;">
            </div>
<!--             Imput Clave -->
            <div class="form-group col-xl-1">
                <label for="inputCity">Clave</label>
                <input type="text" name="clave['.$i.']" class="form-control" id="clave['.$i.']" value="90111500" style="font-size: 12px;">
            </div>
<!--             Imput Id -->
            <div class="form-group col-xl-1">
                <label for="inputCity">ID</label>
                <input type="text" name="id['.$i.']" class="form-control" id="id['.$i.']" value="" style="font-size: 12px;">
            </div>
<!--             Imput Producto -->
            <div class="form-group col-xl-2">
                <label for="inputCity">Producto</label>
                <input type="text" name="producto['.$i.']" class="form-control" id="producto['.$i.']" value="HOSPEDAJE" style="font-size: 12px;">
            </div>
<!--             Imput Imp Unitario -->
            <div class="form-group col-xl-1">
                <label for="inputCity" >Imp.&nbsp;Unitario</label>
                <input type="text" name="importeuni['.$i.']" class="form-control" id="importeuni['.$i.']" oninput="cal()" value="" style="font-size: 12px;">
            </div>
<!--             Imput Importe -->
            <div class="form-group col-xl-1">
                <label for="inputCity">Importe</label>
                <input type="text" name="importe['.$i.']" class="form-control" id="importe['.$i.']" value="" readonly style="font-size: 12px;">
            </div>
<!--             Imput IVA -->
            <div class="form-group col-xl-1">
                <label for="inputCity">IVA</label>
                <input name="iva['.$i.']" type="text" class="form-control" id="iva['.$i.']" oninput="cal()" value="" readonly style="font-size: 12px;">
            </div>
<!--             Checkbox ISH -->
            <div class="form-group" style="margin-top:35px;">
                <div class="form-check">
                    <input name="checisah['.$i.']" class="form-check-input" type="checkbox" id="checisah['.$i.']" oninput="cal()" checked> 
                </div>
            </div>
<!--             Imput ISH -->
            <div class="form-group col-xl-1">
                <label for="inputCity">ISH</label>
                <input type="text" name="ish['.$i.']" class="form-control" id="ish['.$i.']" oninput="cal()" value="" readonly style="font-size: 12px;"> 
            </div>';
            }
            ?>
            </div>
        </div>
        <div class="row col-xl-12">
            <div class="col-md-4"><!-- Espacio en blanco --></div>
            <div class="row col-md-8" style="font-weight: bold;">
                <div class="col-xl-3"><label for="">Importe:</label> <input type="text" name="rimporte" class="form-control" id="rimporte" readonly></div>
                <div class="col-xl-3"><label for="">I.V.A.</label>  <input type="text" name="riva" class="form-control" id="riva" readonly></div>
                <div class="col-xl-3"><label for="">I.S.H.</label><input type="text" name="rish" class="form-control" id="rish" readonly></div>
                <div class="col-xl-3"><label for="">Total:</label><input type="text" name="rtotal" class="form-control" id="rtotal" readonly></div>
            </div>
        </div>
    </div>
    <br>
    <center><button class="btn btn-secondary" id="animacion_timbrar" type="button" style="margin-left: 180px; width: 550px; display:none">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Cargando...
            </button></center>
    <center><button type="button" class="btn btn-secondary btn-lg" id="timbrar" name ="timbrar" onclick="timbrar_factura()" style="margin-left: 180px; width: 550px;">Timbrar&nbsp;Factura</button></center>
    <!--<center><button type="submit" class="btn btn-secondary btn-lg" style="width: 550px;">Timbrar&nbsp;Factura</button></center>-->
</form>
        </div>