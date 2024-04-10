<?php
include("clase_factura.php");
$fact = NEW factura ();
$folio="";
if($_GET['folio']){
    $folio=$_GET['folio'];
    $id_factura=$_GET['id_factura'];
    $uuid= $fact->obtener_uuid($folio);
};

echo '
    <div class="main_container">
        <header class="main_container_title">
            <h2 >Cancelar factura</h2>
        </header>
        
            <form id="formcancelar" class="inputs_form_container justify-content-start" enctype="multipart/form-data">
                <!-- <div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Archivo XML</label>
                        <input class="form-control form-control-lg" type="file" id="file">
                    </div>
                </div> --> 

                <div class="form-floating input_container2">
                    <input type="number" class="d-none" id="folio" value="'.$folio.'" disabled>
                    <input type="number" class="d-none" id="id_factura" value="'.$id_factura.'" disabled>
                    <input type="text" class="form-control custom_input" id="uuid" placeholder="UUID" min-length="1" maxlength="36" value="'.$uuid.'" required >
                    <label for="uuid">UUID</label>
                </div>

                <div class="form-floating input_container2" >
                    <select class="form-control custom_input" id="motivo" name="motivo"  aria-label="Floating label select example">
                        <option selected disable >Selecciona un motivo</option>
                        <option value="01">“01” Comprobantes emitidos con errores con relación.</option>
                        <option value="02">“02” Comprobantes emitidos con errores sin relación.</option>
                        <option value="03">“03” No se llevó a cabo la operación.</option>
                        <option value="06">“04” Operación nominativa relacionada en una factura global.</option>
                    </select>
                    <label for="motivo">Motivo</label>
                </div>

                <div class="form-floating ">
                    <button type="button" class="btn btn-danger" id="cancelar" name="cancelar" onclick="validar_c_cancelacion()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-x-fill" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M6.854 7.146 8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 1 1 .708-.708"/>
                        </svg>
                        Cancelar
                    </button>
                </div>
            </form>

            <button class="btn btn-primary" id="animacion_cancelar" type="button" style="margin-left: 180px; width: 550px; display:none">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
        

    </div>
';

?>