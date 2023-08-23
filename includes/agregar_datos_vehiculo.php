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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            &times;
        </button>
        </div>
        <div class="modal-body">
        <div class="row flex-wrap">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text asterisco" id="inputGroup-sizing-default"  > Matrícula </span>
            </div>
            <input value="'.$matricula.'" required type="text" id="matricula" name ="matricula" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text asterisco" id="inputGroup-sizing-default"> Marca </span>
            </div>
            <input value="'.$marca.'" required type="text" id="marca" name="marca" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"> Modelo </span>
            </div>
            <input value="'.$modelo.'" type="text" id="modelo" name="modelo" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text asterisco" id="inputGroup-sizing-default" > Año </span>
            </div>
            <input value="'.$year.'" required type="text" id="year" name="year" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"> Color del vehiculo </span>
            </div>
            <input value="'.$color.'" type="text" id="color" name="color" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Propietario/conductor </span>
            </div>
            <input value="'.$propietario.'" type="text" id="propietario" name="propietario" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-12">
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"> Observaciones </span>
            <textarea id="observaciones" class="form-control">'.$observaciones.'</textarea>
        </div>
        </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <div id="boton_tipo">
        <button type="button" class="btn btn-success btn-block" onclick="guardar_datos_vehiculo('.$reservacion.','.$id_huesped.')">
        Guardar
        </button>
        </div>
        </div>
        </form>
    </div>';
?>
