<?php
    session_start();
    $_SESSION['nombre_usuario']=0;
    $_SESSION['extra_junior']=0;
    $_SESSION['extra_junior']=0;
    $total = $_GET["total"];
    $listaId = $_GET["listaId"];
    $tipo=$_GET["tipo"];
    $lista_totales=$_GET["lista_totales"];
    $lista_tipo=$_GET["lista_tipo"];
    $mov=$_GET["mov"];
    $_SESSION['lista_id_ticket'] = explode(",",$listaId);
    $lista_totales=explode(",",$lista_totales);
    $lista_tipo=explode(",",$lista_tipo);
    $mov=explode(",",$mov);
    //echo $tipo;
    include("clase_factura.php");
    $fact = NEW factura ();
    if(isset($_GET['fila'])){
        $contador = $_GET['fila'];
    }else{
        $contador = count($_SESSION['lista_id_ticket']);
    }
    
    if(empty($contador)){
        $contador = 15;
    }
    intval($contador);
    echo'
    <div class="main_container">
        <div class="main_container_title">
            <h2 >Factura global</h2>
            <button type="button" class="btn btn-primary" id="timbrar" name ="timbrar" onclick="timbrar_factura()" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                    <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/>
                </svg>
                Timbrar Factura
            </button>
        </div>

        
        <form id="formfactura" class="contenedor_facturas"  autocomplete="off" accept-charset="utf-8">
    <!--         Columna 1  Datos del usuario-->
                <section class="contenedor_facturas_datos" id="control">
                    <div class="input-group mb-3" style="display: none;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default" style="width: 105px; font-size: 12px;">Agregar fila</span>
                        </div>
                        <input type="number" id="filas" name="filas" class="form-control" oninput="agregar_filas()" aria-label="Default" aria-describedby="inputGroup-sizing-default" value='.$contador.'>
                    </div>
    <!--             Imput RFC -->
                    <div class="inputs_form_container noMargin_input">';
                        if($tipo==1){
                            echo'
                            <div class="form-floating input_container">
                                <input type="text" id="rfc" name ="rfc[]" class="form-control custom_input" aria-label="Default" aria-describedby="inputGroup-sizing-default" oninput="buscar_rfc()" value="XAXX010101000" placeholder="RFC" >
                                <label  for="rfc"  id="inputGroup-sizing-default"  >RFC </label>
                            </div>
                            ';
                        }else{
                            echo'
                            <div class="form-floating input_container">
                                <input type="text" id="rfc" name ="rfc[]" class="form-control custom_input" aria-label="Default" aria-describedby="inputGroup-sizing-default" oninput="buscar_rfc()"  placeholder="RFC" >
                                <label  for="rfc"  id="inputGroup-sizing-default"  >RFC </label>
                                </div>
                            ';
                        }
                        echo'
                    </div>
    <!--             Imput Nombre -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <input type="text" id="nombre" name="rfc[]" maxlength="100" class="form-control custom_input" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Nombre">
                            <label for="rfc" id="inputGroup-sizing-default">Nombre</label>
                        </div>
                    </div>
    <!--             Imput Codigo postal -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <input type="text" id="cp" name="rfc[]" maxlength="100" class="form-control custom_input" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Codigo Postal">
                            <label for="cp "id="inputGroup-sizing-default">Codigo Postal</label>
                        </div>
                    </div>
    <!--             Imput Uso de CFDI -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <select id="regimen" name ="rfc[]" class="form-select custom_input" id="inputGroupSelect01">
                                <option selected disabled>Selecciona una opciónn</option>
                                ';
                                    $resulta=$fact->regimen_fiscal();
                                    while ($vara=mysqli_fetch_array($resulta)) {
                                        echo '<option value='.$vara[1].'> '.$vara[1]. $vara[2].'</option>';
                                    }
                            echo'</select>
                            <label  for="regimen" >Régimen Fiscal</label>
                        </div>
                    </div>
                    <!--   Imput Uso de CFDI -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <select id="cfdi" name ="rfc[]" class="form-select custom_input" id="inputGroupSelect01">
                                <option selected disabled>Selecciona una opción</option>
                                ';
                                    $resulta=$fact->uso_cfdi();
                                    while ($vara=mysqli_fetch_array($resulta)) {
                                        echo'<option value='.$vara[1].'> '.$vara[1].$vara[2].' </option>';
                                    }
                                echo '</select>
                            <label for="cfdi">Uso de CFDI</label>
                        </div>
                    </div>
                    <!--             Imput Correo Electronico -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <input type="text" id="correo" name="rfc[]" class="form-control custom_input" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="E-Mail">
                            <label for="correo" id="inputGroup-sizing-default" >E-Mail</label>
                        </div>
                    </div>
                    <!--             Imput Metodo de Pago -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <select id="metodopago" name="rfc[]" class="form-select custom_input" id="inputGroupSelect01">
                            <option selected disabled>Selecciona una opción</option>
                            ';
                                $resulta=$fact->metodo_pago();
                                while ($vara=mysqli_fetch_array($resulta)) {
                                    echo'<option value='.$vara[1].'>  '.$vara[1]. $vara[2].'</option>';
                                    }
                            echo '</select>
                            <label for="metodopago" >Metodo de Pago</label>
                        </div>
                    </div>
    <!--             Imput Forma de Pago -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <select id="forma_pago" name="rfc[]" class="form-select custom_input" id="inputGroupSelect01">
                                <option selected disabled>Selecciona una opción</option>
                                ';
                                    $resulta=$fact->forma_pago();
                                    while ($vara=mysqli_fetch_array($resulta)) {
                                echo'<option value='.$vara[1].'> '.$vara[1].$vara[2].' </option>';
                                }
                            echo '</select>
                            <label for="forma_pago">Forma de Pago</label>
                        </div>
                    </div>
                    <!--             Textarea  Notas -->
                    <div class="inputs_form_container noMargin_input">
                        <div class="form-floating input_container">
                            <textarea id="notas" name="rfc[]" class="form-control custom_input" id="exampleFormControlTextarea1" placeholder="Notas" style="height: 80px"></textarea>
                            <label for="notas" id="inputGroup-sizing-default">Notas</label>
                        </div>
                    </div>
                    <div class="inputs_form_container">
                        <div class="input-group">
                        ';
                        if($tipo==1){
                            echo '
                            <span  id="inputGroup-sizing-default" >Agregar a factura global</span>
                            <input type="checkbox" id="checkfacturaglobal" aria-label="Checkbox for following text input" onclick="factura_global()" >
                            ';
                        }else{
                            echo '
                            <span  id="inputGroup-sizing-default" >Agregar a factura global</span>
                            <input type="checkbox" id="checkfacturaglobal" disabled aria-label="Checkbox for following text input" onclick="factura_global()" >
                            ';
                        }
                        echo '
                        </div>
                    </div>
                </section>
            <!--         Columna 2 Datos del documento a facturar-->
           

            <div class="contenedor_facturas_inputs" id="dinamic" >
                <div id="animacion_formulario" class="col-10" style="display: none;">
                    <span class="loader"></span>
                </div>
                <div class="header_facturas">
                                <div class="form-floating input_container">
                                    <input type="text" name="rimporte" class="form-control custom_input" id="rimporte" readonly placeholder="Importe:">
                                    <label for="rimporte" >Importe:</label>
                                </div>
                                <div class="form-floating input_container">
                                    <input type="text" name="riva" class="form-control custom_input" id="riva" readonly placeholder="I.V.A">
                                    <label for="riva" >I.V.A.</label>  
                                </div>
                                <div class="form-floating input_container">
                                    <input type="text" name="rish" class="form-control custom_input" id="rish" readonly placeholder="I.S.H">
                                    <label for="rish" >I.S.H.</label>
                                </div>
                                <div class="form-floating input_container">
                                    <input type="text" name="rtotal" class="form-control custom_input" id="rtotal" readonly placeholder="Total:">
                                    <label for="rtotal" >Total:</label>
                                </div>
                        </div>
                <div class="header_facturas">
                        <!--             Imput Uso de CFDI -->
                            <div id ="input_periocidad" class="form-floating input_container" style="display: none;">
                                <select id="periocidad" name ="rfc[]" class="form-select custom_input" id="inputGroupSelect01">
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
                        <div id ="input_mes" class="form-floating input_container" style="display: none;">
                            <select id="mes" name ="rfc[]" class="form-select custom_input" id="inputGroupSelect01" >
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
                        <div id ="input_año" class="form-floating input_container" style="display: none;">
                            <input type="text" id="año" name="rfc[]" maxlength="100" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"  value="" placeholder="Año">
                            <label  for="año">Año</label>
                        </div>
                    </div>
                    
                ';
    
                    for ($i=1; $i <= $contador ; $i++) {
                        echo '
                    <div class="inputs_form_container justify-content-start">
                        <div class="form-floating">
                        <input type="text" name="cantidad['.$i.']" class="form-control custom_input maxWidthInput" id="cantidad['.$i.']" oninput="cal()" value="1" placeholder="Cantidad">
                        <label for="inputCity" >Cantidad</label>
                        </div>
        <!--             Imput Unidad -->
                    <div class="form-floating">
                        <input type="text" name="unidad['.$i.']" class="form-control custom_input maxWidthInput" id="unidad['.$i.']" value="SER" placeholder="Unidad">
                        <label for="inputCity" >Unidad</label>
                    </div>
        <!--             Imput Clave/Unidad -->
                    <div class="form-floating">
                        <input type="text" name="claveunidad['.$i.']" class="form-control custom_input maxWidthInput" id="claveunidad['.$i.']" value="E48" placeholder="Clave/Unidad">
                        <label for="inputCity" >Clave/Unidad </label>
                    </div>
        <!--             Imput Clave -->
                    <div class="form-floating">
                        <input type="text" name="clave['.$i.']" class="form-control custom_input maxWidthInput" id="clave['.$i.']" value="90111500" placeholder="Clave">
                        <label for="inputCity" >Clave</label>
                    </div>
        <!--             Imput Id -->
                    <div class="form-floating">
                        <input type="text" name="id['.$i.']" class="form-control custom_input maxWidthInput" id="id['.$i.']" value="'.$mov[$i-1].'" placeholder="ID">
                        <label for="inputCity" >ID</label>
                    </div>
        <!--             Imput Producto -->
                    <div class="form-floating">
                        <input type="text" name="producto['.$i.']" class="form-control custom_input maxWidthInput" id="producto['.$i.']" value="HOSPEDAJE" placeholder="Producto">
                        <label for="inputCity" >Producto</label>
                    </div>
        <!--             Imput Imp Unitario -->
                    <div class="form-floating">
                        ';
                        echo'
                        <input type="text" name="importeuni['.$i.']" class="form-control custom_input maxWidthInput" id="importeuni['.$i.']" onload="cal() "oninput="cal()" value='.$lista_totales[$i-1].' placeholder="Imp.&nbsp;Unitario">
                        <label for="inputCity" >Imp.&nbsp;Unitario</label>
                        ';
                        
                        echo'
                    </div>
        <!--             Imput Importe -->
                    <div class="form-floating">
                        <input type="text" name="importe['.$i.']" class="form-control custom_input maxWidthInput" id="importe['.$i.']" value="" readonly placeholder="Importe">
                        <label for="inputCity" >Importe</label>
                    </div>
        <!--             Imput IVA -->
                    <div class="form-floating">
                        <input name="iva['.$i.']" type="text" class="form-control custom_input maxWidthInput" id="iva['.$i.']" oninput="cal()" value="" readonly placeholder="IVA">
                        <label for="inputCity" >IVA</label>
                    </div>
                <!--             Imput ISH -->
                        <div class="form-floating">
                            <input type="text" name="ish['.$i.']" class="form-control custom_input maxWidthInput" id="ish['.$i.']" oninput="cal()" value="" readonly placeholder="ISH"> 
                            <label for="inputCity" >ISH</label>
                        </div>
        <!--             Checkbox ISH -->
                    <div >';
                        if ( $lista_tipo[$i-1]==1){
                            echo '<input name="checisah['.$i.']" class="form-check-input" type="checkbox" id="checisah['.$i.']" oninput="cal()" checked>';
                        }else{
                            echo '<input name="checisah['.$i.']" class="form-check-input" type="checkbox" id="checisah['.$i.']" oninput="cal()">';
                        }
                    echo'
                    </div>
                    </div>
                    ';
                    }
                    echo'
            </div>
            <div class="row col-xl-12 d-none">
                <div class="col-md-4"><!-- Espacio en blanco --></div>
            </div>


        <!--<center><button type="submit" class="btn btn-secondary btn-lg" style="width: 550px;">Timbrar&nbsp;Factura</button></center>-->

    </form>
            </div>
        <script>
            buscar_rfc()
            cal()
        </script>
    ';
?>
