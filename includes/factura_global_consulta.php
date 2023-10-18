<?php
    include_once('clase_ticket.php');
    include_once("clase_hab.php");
    include_once("clase_forma_pago.php");
    $Tickets= NEW Ticket(0);

    $Concepto=NEW Concepto(0);
    $hab=NEW Hab(0);
    $forma_pago=NEW Forma_pago(0);
    $fechaInicio = $_POST['fechaInio'];
    $fechaFin=$_POST['fechaFin'];
    $fechaInicioUnix=strtotime($fechaInicio);
    $fechaFinUnix=strtotime($fechaFin)+(60*24);
    $lista_tickets=$Tickets->tickets_por_fecha($fechaInicioUnix,$fechaFinUnix);
    $lista_Id_tickets=array();
    $Diccionario_Conseptos_Hospedajes = array();
    $Diccionario_Conseptos_Restaurante = array();
    $contador=1;
    //Primera tabla
    echo '<div class="contenedor_tablas_1_facturas">
          <h2 class="titulo_tabla_facturas">Facturas en habitacion</h2>
    ';
    foreach ($lista_tickets as $fila) {
      if($fila['facturado'] == 0 && $fila["id_hab"]!=0) {
      echo '
      <div class="card text-center ticket_container">';
        /*if($id_ticket!=$listconceptos["id"]){
          $id_ticket=$listconceptos["id"];
          $bandera=true;*/
          echo '
            <div class="ticket_container_header">
              <div class="ticket_container_header_input">
                <input type="checkbox" checked/>
              </div>
              <div class="ticket_container_header_info">
                <div class="ticket_container_header_info_fecha">
                  <p class="ticket_container_header_info_fecha_fecha">Fecha : '. $fila["fecha"].' </p>
                  <p class="ticket_container_header_info_fecha_fecha">Ticket #'. $fila["id"].'</p>
                </div>
                <div class="ticket_container_header_info_more">
                  <div>
                    <p class="ticket_info_p ticket_info_n">'.$hab->mostrar_nombre_hab($fila["id_hab"]).'</p>
                    <p class="ticket_info_p ticket_info_n"><input class="d-none" type="number" id="leer_id_'.$contador.'" value="'. $fila["id_hab"].'"/></p>
                  </div>
                  <div class="ticket_container_header_info_more_items">
                  <p class="ticket_info_p">Forma de pago: <spam class="ticket_spam" >'.$forma_pago->obtener_descripcion($fila["forma_pago"]).'</spam></p>
                  <p class="ticket_info_p">Total: <spam class="ticket_spam ticket_info_price" >$'.$fila["total"].'</spam></p>
                  </div>
                </div>
              </div>
            </div>';
            $contador++;
        array_push($lista_Id_tickets, $fila['id']);
        $result=$Concepto->info_concepto($fila['id']);
        $nombre_hab=$hab->mostrar_nombre_hab($fila['id_hab']);
        $contador=0;
            foreach ($result as $columnas) {
              echo'
              
              <table class="table table-sm table-fixed">';

              if($contador==0){
                echo '<thead>
                <tr>
                  <th scope="col" class="ticket_colum_color">Concepto</th>
                  <th scope="col" class="ticket_colum_color">Cantidad</th>
                  <th scope="col" class="ticket_colum_color">Precio</th>
                  <th scope="col" class="ticket_colum_color">Total</th>
                </tr>
              </thead>';
              }

                  echo'
                  <tbody>
                    <tr>
                      <td class="ticket_colum_color">' . $columnas["nombre"] . '</td>
                      <td class="ticket_colum_color">' . $columnas["cantidad"] . '</td>
                      <td class="ticket_colum_color">$' . $columnas["precio"] . '</td>
                      <td class="ticket_colum_color">$' . $columnas["total"] . '</td>
                    </tr>
                  </tbody>
              </table>
              ';
              $contador++;
            }
            echo '</div>';
        }
    
      }
    echo "</div>";
      //Segunda tabla aqui se retornaria el contenido de la tabla derecha

    echo '<div class="contenedor_tablas_2_facturas">
          <h2 class="titulo_tabla_facturas">Facturas en restaurante</h2>
    ';
    foreach ($lista_tickets as $fila) {
      if($fila['facturado'] == 0&& $fila["id_hab"]==0) {
      echo '
      <div class="card text-center ticket_container">';
        /*if($id_ticket!=$listconceptos["id"]){
          $id_ticket=$listconceptos["id"];
          $bandera=true;*/
          echo '
            <div class="ticket_container_header">
              <div class="ticket_container_header_input">
                <input type="checkbox" checked/>
              </div>
              <div class="ticket_container_header_info">
                <div class="ticket_container_header_info_fecha">
                  <p class="ticket_container_header_info_fecha_fecha">Fecha : '. $fila["fecha"].' </p>
                  <p class="ticket_container_header_info_fecha_fecha">Ticket #'. $fila["id"].'</p>
                </div>
                <div class="ticket_container_header_info_more">
                  <div>
                    <p class="ticket_info_p ticket_info_n">'.$hab->mostrar_nombre_hab($fila["id_hab"]).'</p>
                    <p class="ticket_info_p ticket_info_n"><input class="d-none" type="number" id="leer_id_'.$contador.'" value="'. $fila["id_hab"].'"/></p>
                  </div>
                  <div class="ticket_container_header_info_more_items">
                  <p class="ticket_info_p">Forma de pago: <spam class="ticket_spam" >'.$forma_pago->obtener_descripcion($fila["forma_pago"]).'</spam></p>
                  <p class="ticket_info_p">Total: <spam class="ticket_spam ticket_info_price" >$'.$fila["total"].'</spam></p>
                  </div>
                </div>
              </div>
            </div>';
            $contador++;
        array_push($lista_Id_tickets, $fila['id']);
        $result=$Concepto->info_concepto($fila['id']);
        $nombre_hab=$hab->mostrar_nombre_hab($fila['id_hab']);
        $contador=0;
            foreach ($result as $columnas) {
              echo'
              
              <table class="table table-sm table-fixed">';

              if($contador==0){
                echo '<thead>
                <tr>
                  <th scope="col" class="ticket_colum_color">Concepto</th>
                  <th scope="col" class="ticket_colum_color">Cantidad</th>
                  <th scope="col" class="ticket_colum_color">Precio</th>
                  <th scope="col" class="ticket_colum_color">Total</th>
                </tr>
              </thead>';
              }

                  echo'
                  <tbody>
                    <tr>
                      <td class="ticket_colum_color">' . $columnas["nombre"] . '</td>
                      <td class="ticket_colum_color">' . $columnas["cantidad"] . '</td>
                      <td class="ticket_colum_color">$' . $columnas["precio"] . '</td>
                      <td class="ticket_colum_color">$' . $columnas["total"] . '</td>
                    </tr>
                  </tbody>
              </table>
              ';
              $contador++;
            }
            echo '</div>';
        }
    
      }
    echo '</div>';
?>