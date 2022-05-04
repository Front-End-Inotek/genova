<?php
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  $total= $_GET['total'];
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Cargar pago del Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      //echo '<div class="edo_cuenta btn-square-lg-doble" onclick="pedir_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')">';
      echo '<div class="row">
        <div class="col-sm-3">Habitación:</div>
        <div class="col-sm-9">
        <div class="form-group">
          <input class="form-control" type="text"  id="hab" placeholder="Ingresa la habitación que tendra el cargo" onkeyup="filtrar_huesped()" maxlength="20">
        </div>
        </div>
      </div><br>
      <div class="div_huesped">
        <div class="row">
          <div class="col-sm-3" >Nombre del  huesped:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="Nombre del huesped" disabled/>
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-3" >Apellido del huesped:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="apellido" value="Apellido del huesped" disabled/>
          </div>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-sm-3">Número de INE/IFE:</div>
        <div class="col-sm-9">
        <div class="form-group">
          <input class="form-control" type="text"  id="credencial" placeholder="Ingresa el numero de la credencia para votar" maxlength="40">
        </div>
        </div>
      </div><br>
    <div>     

    <div class="modal-footer" id="boton_cargo">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="aplicar_rest_cobro_hab('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')"> Aceptar</button>
    </div>
  </div>';
  // Codigo de identificacion
  //aplicar_rest_cobro_hab
  //modal_cargar_rest_cobro
?>