<?php
    date_default_timezone_set('America/Mexico_City');
    include_once('clase_huesped.php');
    $reservacion= $_GET['id_reserva'];
    $id_huesped = $_GET['id_huesped'];
    $huesped = new Huesped(0);
    $datos_vehiculo = $huesped->existe_vehiculo($id_huesped,$reservacion);

if(sizeof($datos_vehiculo)>0) {
    $matricula = $datos_vehiculo['matricula'];
    $marca = $datos_vehiculo['marca'];
    $modelo = $datos_vehiculo['modelo'];
    $year = $datos_vehiculo['year'];
    $color = $datos_vehiculo['color'];
    $propietario = $datos_vehiculo['propietario'];
    $ingreso = date('Y-m-d', $datos_vehiculo['fecha_ingreso']);
    $salida = empty($datos_vehiculo['fecha_salida']) ? "" : date('Y-m-d',$datos_vehiculo['fecha_salida']);
    $observaciones = $datos_vehiculo['observaciones'];
}else{
    $matricula ="";
    $marca = "";
    $modelo = "";
    $year = "";
    $color = "";
    $propietario ="";
    $ingreso = "";
    $salida = "";
    $observaciones = "";
}

echo '
    <!-- Modal -->
        <div class="modal-content" >
        <form id="form-vehiculo">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Datos vehiculo</h4>
        <button type="button" class="btn btn-light" data-dismiss="modal">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
				<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
			</svg>
		</button>

        </div>
        <div class="modal-body">

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="matricula" value="'.$matricula.'" name="matricula" autocomplete="off" placeholder="Matricula"   required >
                <label for="matricula">Matricula</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="marca" value="'.$marca.'" name="marca" autocomplete="off" placeholder="Matricula"   required >
                <label for="marca">Marca</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="modelo" value="'.$modelo.'" name="modelo" autocomplete="off" placeholder="Matricula"   required >
                <label for="modelo">Marca</label>
            </div>

            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="year" value="'.$year.'" name="year" autocomplete="off" placeholder="Matricula"   required >
                <label for="year">Año</label>
            </div>
        </div>


        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="color" value="'.$color.'" name="color" autocomplete="off" placeholder="Matricula"   required >
                <label for="color">Color del vehiculo</label>
            </div>

            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="propietario" value="'.$propietario.'" name="propietario" autocomplete="off" placeholder="Matricula"   required >
                <label for="propietario">Propietario / conductor</label>
            </div>
        </div>

        <div class="form-floating input_container">
            <textarea class="form-control custom_input" name="observaciones" placeholder="Leave a comment here" id="observaciones" style="height: 100px"></textarea>
            <label for="observaciones">'; isset($observaciones) ? $observaciones : 'Observaciones'; echo '</label>
        </div>


        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <div id="boton_tipo">
                <button type="button" class="btn btn-primary btn-block" onclick="guardar_datos_vehiculo('.$reservacion.','.$id_huesped.')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg>
                    Guardar
                </button>
            </div>
        </div>
        </form>
    </div>';
?>
