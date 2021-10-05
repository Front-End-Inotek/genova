<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR HUESPED</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" value="'.$huesped->nombre.'" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Apellido:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="apellido" value="'.$huesped->apellido.'" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Direccion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" value="'.$huesped->direccion.'" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Ciudad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="ciudad" value="'.$huesped->ciudad.'" maxlength="30">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Estado:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="estado" value="'.$huesped->estado.'" maxlength="30">
          </div>
          </div>
          <div class="col-sm-2">Codigo postal:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo_postal" value="'.$huesped->codigo_postal.'" maxlength="20">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Telefono:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="telefono" value="'.$huesped->telefono.'" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" value="'.$huesped->correo.'" maxlength="200">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Contrato Socio:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="contrato" value="'.$huesped->contrato.'" maxlength="40">
          </div>
          </div>
          <div class="col-sm-2">Cupón:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="cupon" value="'.$huesped->cupon.'" maxlength="40">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Preferencias del huésped:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="preferencias" value="'.$huesped->preferencias.'">
          </div>
          </div>
          <div class="col-sm-2">Comentarios adicionales:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="comentarios" value="'.$huesped->comentarios.'">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6"><h4 class="text-dark  margen-1">DATOS TARJETA:</h4></div>
          <div class="col-sm-6"></div>
        </div>
        <div class="row">
          <div class="col-sm-2">Titular de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="titular_tarjeta" value="'.$huesped->titular_tarjeta.'" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Tipo de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="form-control" id="tipo_tarjeta">';
              if($huesped->tipo_tarjeta == "Debito"){echo '
                <option value="Debito">'.$huesped->tipo_tarjeta.'</option>
                <option value="Credito">Credito</option>';
              }elseif ($huesped->tipo_tarjeta == "") {echo '
                <option value="Debito">Debito</option>
                <option value="Credito">Credito</option>';
              }else{ echo '
                <option value="Credito">'.$huesped->tipo_tarjeta.'</option>
                <option value="Debito">Debito</option>';
              }echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Numero de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->numero_tarjeta.'" maxlength="16">
          </div>
          </div>
          <div class="col-sm-2">Fecha de vencimiento:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="vencimiento_mes">';
              if($huesped->vencimiento_mes == "01"){echo '
                <option value="01">'.$huesped->vencimiento_mes.'</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == ""){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "02"){echo '
                <option value="01">01</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "03"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "04"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "05"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "06"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "07"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "08"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "09"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "10"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "11"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="12">12</option>';
              }else{ echo '
                <option value="12">'.$huesped->vencimiento_mes.'</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>';
              }echo '
            </select>
          </div>
          </div>
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="text" id="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->vencimiento_ano.'" maxlength="2">
          </div>
          </div>
          <div class="col-sm-1">mes/año</div>
        </div>
        <div class="row">
          <div class="col-sm-2">Codigo Seguridad:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="text" id="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->cvv.'" maxlength="3">
          </div>
          </div>
          <div class="col-sm-5"></div>
          <div class="col-sm-2">
          <div id="boton_huesped">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_huesped('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_huesped()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
        </div>  
      </div>';
?>
