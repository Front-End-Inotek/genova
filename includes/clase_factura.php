<?php
  /**
   *
   */
   date_default_timezone_set('America/Mexico_City');
   include_once('consulta.php');
   include_once('clase_usuario.php');


  class factura extends ConexionMYSql
  {

    function __construct()
    {
      // code...
    }
    function busqueda_reporte($metodo, $inicial, $final){
      if($metodo==0){
        $sentencia = "SELECT * FROM facturas WHERE folio >= $inicial AND folio <= $final";
      }else{
        $sentencia = "SELECT * FROM facturas WHERE fecha >= $inicial AND fecha <= $final";

      }
      $comentario="obtener las facturas registradas ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function regimen_fiscal(){
      $sentencia = "SELECT * FROM regimen_fiscal";
      $comentario="regimen_fiscal ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function uso_cfdi(){
      $sentencia = "SELECT * FROM uso_cfdi";
      $comentario="uso_cfdi ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function metodo_pago(){
      $sentencia = "SELECT * FROM metodo_pago_factura";
      $comentario="metodo_pago ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function obtener_primer_rfc(){
      $sentencia = "SELECT * FROM rfc WHERE id = '1' ";
      $comentario="obtener el primer rfc ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function obtener_folio(){
      $sentencia = "SELECT folio FROM facturas ORDER BY id DESC LIMIT 1 ";
      $comentario="obtener el folio ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function consultar_rfc($rfc){
      $sentencia ="SELECT * FROM rfc WHERE rfc = '$rfc'";
      
      $comentario="consultar rfc ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function registrar_rfc($regimenfiscal,$rfc,$codigopostal,$email){
      $sentencia ="INSERT INTO rfc (`regimen_fiscal`,`rfc`,`nombre`,`produccion`,`codigo_postal`,`email`,`cer`,`key`,`passkey`,`usuariopac`,`passpac`,`impresora`,`telefono`,`notas`)
      VALUES ('$regimenfiscal','$rfc[0]','$rfc[1]','','$codigopostal','$email','','','','','','','','')";
      
      $comentario="registrar rfc ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function forma_pago(){
      $sentencia = "SELECT * FROM forma_pago_factura";
      $comentario="forma_pago ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function consulta_rfc($rfc){
      $sentencia = "SELECT * FROM rfc WHERE rfc = '$rfc'";
      //echo $sentencia;
      $comentario="periocidad ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function periocidad(){
      $sentencia = "SELECT * FROM periocidad";
      $comentario="periocidad ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function rfc_propio(){
      $sentencia="SELECT * FROM rfc WHERE id = '1'  ";

      $comentario="rfc_propio ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;

    }
    function guardar_factura($rfc,$rimporte,$riva,$rish,$folios,$nombre,$fecha,$forma_pago,$id,$nombre_hab,$pax,$notas){
      $sentencia="INSERT INTO facturas (`rfc`,`importe`,`iva`,`ish`,`folio`,`estado`,`nombre`,`fecha`,`forma_pago`,`folio_casa`,`nombre_hab`,pax_extras,`notas` )
      VALUES ('$rfc','$rimporte','$riva','$rish','$folios','0','$nombre','$fecha','$forma_pago','$id',$nombre_hab,$pax,'$notas')";
      $comentario="rfc_propio ";
      //echo $sentencia;
      //echo $sentencia;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function ultima_factura(){
      $sentencia="SELECT * FROM `facturas` ORDER BY fecha DESC LIMIT 1";
      $comentario="sacar la vactura ";
      //echo $sentencia;
      //echo $sentencia;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;

    }
    function guardar_uuid($folio, $uuid){
      $sentencia="UPDATE `facturas` SET `uuid`='$uuid' WHERE `folio`='$folio'";
      $comentario="guardar uuid ";
      //echo $sentencia;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function obtener_uuid($folio){
      $uuid="";
      $sentencia="SELECT `uuid` FROM `facturas` WHERE `folio`='$folio'";
      $comentario="obtener uuid ";
      //echo $sentencia;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $uuid=$fila['uuid'];
      }
      return $uuid;
    }
    function obtener_folio_factura(){
      $folio=0;
      $sentencia="SELECT folio FROM facturas ORDER BY id DESC LIMIT 1";
      $comentario="rfc_propio ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $folio=$fila['folio']+1;
      }
      return $folio;
    }
    function folio(){
      $sentencia = "SELECT folio FROM facturas ORDER BY id DESC LIMIT 1 ";
      $comentario="sacar el ultimo folio ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function estado_cancelar_factura($folio){
      $sentencia = "UPDATE facturas SET estado = 1 WHERE folio = '$folio'";
      $comentario="cambiar estado de factura a cancelado ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
    }
    function mes(){
      $sentencia = "SELECT * FROM mes";
      $comentario="mes ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$fila = mysqli_fetch_array($consulta);
      return $consulta;
    }
    function busqueda($metodo, $inicial, $final){
      if($metodo==0){
        $sentencia = "SELECT * FROM facturas WHERE folio >= $inicial AND folio <= $final";
      }else{
        $inicial=strtotime($inicial);
        $final=strtotime($final)+86400;
        $sentencia = "SELECT * FROM facturas WHERE fecha >= $inicial AND fecha <= $final";

      }
      $comentario="obtener las facturas registradas ";
      $contador=0;
      $iva=0;
      $importe=0;
      $ish=0;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $c=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($contador==0){
          echo'
          <br>
          <br>
          <div class="table-responsive table-hover" style="max-height:560px; overflow-y: scroll;">
          <table class="table table_expansion" >
            
            <thead>
              <tr>
              <th>Folio</th>
              <th>RFC</th>
              <th>Importe</th>
              <th>IVA</th>
              <th>ISH</th>
              <th>Total</th>
              <th>Estado</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Forma de pago</th>
              <th><span class=" glyphicon glyphicon-cog"></span> XML</th>
              <th><span class=" glyphicon glyphicon-cog"></span> PDF</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>';
            }
            $sub_total=$fila['importe']+$fila['iva']+$fila['ish'];
        echo'
            <tbody>
            <tr>
            <td>' .$fila['folio'].   '</td>
            <td>' .$fila['rfc'].     '</td>
            <td>' .$fila['importe']. '</td>
            <td>' .$fila['iva'].     '</td>
            <td>' .$fila['ish'].     '</td>
            <td>' .$sub_total.       '</td>
        ';

            if($fila['estado']==0){
                echo '<th>Activa</th>';
                $iva=$iva+$fila['iva'];
                $importe=$importe+$fila['importe'];
                $ish=$ish+$fila['ish'];
              }
              else{
                echo '<th>Cancelada</th>';
              }
              echo '<th>'.$fila['nombre'].'</th>
              <th>'.date("F j, Y, g:i a",($fila['fecha']+21600)).'</th>';
              switch ($fila['forma_pago']) {
                case 1:
                   echo '<th>Efectivo</th>';
                  break;
                case 2:
                   echo '<th>Cheque</th>';
                  break;
                case 3:
                   echo '<th>Trasferemcia</th>';
                  break;
                case 4:
                   echo '<th>Tarjeta de credito</th>';
                  break;
                case 5:
                   echo '<th>Monedero electronico</th>';
                  break;
                case 6:
                   echo '<th>Dinero electronico</th>';
                  break;
                case 8:
                   echo '<th>Vales de despensa</th>';
                  break;
                case 28:
                   echo '<th>Debito</th>';
                  break;
                case 29:
                   echo '<th>Tarjeta de servicios</th>';
                  break;
                case 99:
                   echo '<th>Por definir</th>';
                  break;
                default:
                  echo '<th>Desconocido</th>';
                  break;
              }
              $numero= $fila['folio'];
              $file="../facturas/{$numero}_cfdi_factura.xml";
              $ruta="facturas/{$numero}_cfdi_factura.xml";
              if(file_exists( $file )){
                echo '<th><a href="'.$ruta.'" target="_blank"><span class=" glyphicon glyphicon-file"></span> XML</a></th>';
              }else{
                  echo '<th>-</th>';
              }

              $file="../facturas/{$numero}_Factura.pdf";
              $ruta="facturas/{$numero}_Factura.pdf";
              if(file_exists( $file )){
                echo '<th><a href="'.$ruta.'" target="_blank"><span class=" glyphicon glyphicon-file"></span> PDF</a></th>';
              }else{
                  echo '<th>-</th>';
                }
                $contador++;
                if(file_exists( $file )){
                  echo '
                    <th>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ver mas
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="reenviar_factura(' . htmlspecialchars($fila['folio']) . ', \'' . htmlspecialchars($fila['nombre']) . '\')">Reenviar</a>
                        <a class="dropdown-item" href="#" onclick="factura_cancelarbtn('.$fila['folio'].')">Cancelar</a>
                      </div>
                    </div>
                    </th>';
                }else {
                  echo '<th>-</th>';
                }
              //echo'<th><button type="button" class="btn btn-outline-primary"  onclick="reenviar_factura('.$fila['folio'] .','. $fila['nombre'].')" >Reenviar</button></th>';
            }
              if($contador==0){
                echo "Sin Facturas para mostrar";
              }else{
                $totales=$importe+$iva+$ish;

              echo '  </tr>';

            echo'
            </tr>
            </tbody>
          </table>
          </div>
          <br>
          <br>';

          echo'
          <div class="row col-xl-12">
          <div class="row col-md-4"><br><button type="button" class="btn btn-success" onclick="reporte_facturacio('.$metodo.','.$inicial.','.$final.')" style="width: 400px;">Exportar</button><br><br></div>
          <div class="row col-md-8" style="font-weight: bold;">
              <div class="col-xl-3"><label for="">Importe:</label> <input type="text" name="rimporte" class="form-control" value="'.$importe.'" disabled></div>
              <div class="col-xl-3"><label for="">I.V.A.</label>  <input type="text" name="riva" class="form-control" value="'.$iva.'" disabled></div>
              <div class="col-xl-3"><label for="">I.S.H.</label><input type="text" name="rish" class="form-control" value="'.$ish.'" disabled></div>
              <div class="col-xl-3"><label for="">Total:</label><input type="text" name="rtotal" class="form-control" value="'.$totales.'" disabled></div>
          </div>
          </div>';
          echo '';
      $c=$c+1;
      }
    }

    function busqueda_folio_casa($folio){
      $sentencia = "SELECT * FROM facturas WHERE folio_casa= $folio";
      $comentario="obtener las facturas registradas ";
      $contador=0;
      $iva=0;
      $importe=0;
      $ish=0;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $c=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($contador==0){
          echo'
          <br>
          <br>
          <div class="table-responsive table-hover" style="max-height:560px; overflow-y: scroll;">
          <table class="table table_expansion" >
            
            <thead>
              <tr>
              <th>Folio</th>
              <th>RFC</th>
              <th>Importe</th>
              <th>IVA</th>
              <th>ISH</th>
              <th>Total</th>
              <th>Estado</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Forma de pago</th>
              <th><span class=" glyphicon glyphicon-cog"></span> XML</th>
              <th><span class=" glyphicon glyphicon-cog"></span> PDF</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>';
            }
            $sub_total=$fila['importe']+$fila['iva']+$fila['ish'];
        echo'
            <tbody>
            <tr>
            <td>' .$fila['folio'].   '</td>
            <td>' .$fila['rfc'].     '</td>
            <td>' .$fila['importe']. '</td>
            <td>' .$fila['iva'].     '</td>
            <td>' .$fila['ish'].     '</td>
            <td>' .$sub_total.       '</td>
        ';

            if($fila['estado']==0){
                echo '<th>Activa</th>';
                $iva=$iva+$fila['iva'];
                $importe=$importe+$fila['importe'];
                $ish=$ish+$fila['ish'];
              }
              else{
                echo '<th>Cancelada</th>';
              }
              echo '<th>'.$fila['nombre'].'</th>
              <th>'.date("F j, Y, g:i a",($fila['fecha']+21600)).'</th>';
              switch ($fila['forma_pago']) {
                case 1:
                   echo '<th>Efectivo</th>';
                  break;
                case 2:
                   echo '<th>Cheque</th>';
                  break;
                case 3:
                   echo '<th>Trasferemcia</th>';
                  break;
                case 4:
                   echo '<th>Tarjeta de credito</th>';
                  break;
                case 5:
                   echo '<th>Monedero electronico</th>';
                  break;
                case 6:
                   echo '<th>Dinero electronico</th>';
                  break;
                case 8:
                   echo '<th>Vales de despensa</th>';
                  break;
                case 28:
                   echo '<th>Debito</th>';
                  break;
                case 29:
                   echo '<th>Tarjeta de servicios</th>';
                  break;
                case 99:
                   echo '<th>Por definir</th>';
                  break;
                default:
                  echo '<th>Desconocido</th>';
                  break;
              }
              $numero= $fila['folio'];
              $file="../facturas/{$numero}_cfdi_factura.xml";
              $ruta="facturas/{$numero}_cfdi_factura.xml";
              if(file_exists( $file )){
                echo '<th><a href="'.$ruta.'" target="_blank"><span class=" glyphicon glyphicon-file"></span> XML</a></th>';
              }else{
                  echo '<th>-</th>';
              }

              $file="../facturas/{$numero}_Factura.pdf";
              $ruta="facturas/{$numero}_Factura.pdf";
              if(file_exists( $file )){
                echo '<th><a href="'.$ruta.'" target="_blank"><span class=" glyphicon glyphicon-file"></span> PDF</a></th>';
              }else{
                  echo '<th>-</th>';
                }
                $contador++;
                if(file_exists( $file )){
                  echo '
                    <th>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ver mas
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="reenviar_factura(' . htmlspecialchars($fila['folio']) . ', \'' . htmlspecialchars($fila['nombre']) . '\')">Reenviar</a>
                        <a class="dropdown-item" href="#" onclick="factura_cancelarbtn('.$fila['folio'].')">Cancelar</a>
                      </div>
                    </div>
                    </th>';
                }else {
                  echo '<th>-</th>';
                }
              //echo'<th><button type="button" class="btn btn-outline-primary"  onclick="reenviar_factura('.$fila['folio'] .','. $fila['nombre'].')" >Reenviar</button></th>';
            }
              if($contador==0){
                echo "Sin Facturas para mostrar";
              }else{
                $totales=$importe+$iva+$ish;

              echo '  </tr>';

            echo'
            </tr>
            </tbody>
          </table>
          </div>
          <br>
          <br>';

          echo'
          <div class="row col-xl-12">
          <div class="row col-md-8" style="font-weight: bold;">
              <div class="col-xl-3"><label for="">Importe:</label> <input type="text" name="rimporte" class="form-control" value="'.$importe.'" disabled></div>
              <div class="col-xl-3"><label for="">I.V.A.</label>  <input type="text" name="riva" class="form-control" value="'.$iva.'" disabled></div>
              <div class="col-xl-3"><label for="">I.S.H.</label><input type="text" name="rish" class="form-control" value="'.$ish.'" disabled></div>
              <div class="col-xl-3"><label for="">Total:</label><input type="text" name="rtotal" class="form-control" value="'.$totales.'" disabled></div>
          </div>
          </div>';
          echo '';
      $c=$c+1;
      }
    }
  }

