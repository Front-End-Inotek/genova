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
    $Diccionario_Conseptos = array();
    foreach ($lista_tickets as $fila) {
        array_push($lista_Id_tickets, $fila['id']);
        $result=$Concepto->info_concepto($fila['id']);
        $nombre_hab=$hab->mostrar_nombre_hab($fila['id_hab']);
        foreach ($result as $columnas){
          $consepto = array(
            "id" => $fila['id'],
            "fecha"=>$fila['fecha'],
            "forma_pago"=>$forma_pago->obtener_descripcion($fila['forma_pago']),
            "habitacion"=>$nombre_hab,
            "totalTicket"=>$fila['total'],

            "nombre"=>$columnas['nombre'],
            "cantidad"=>$columnas['cantidad'],
            "precio"=>$columnas['precio'],
            "total" => $columnas['total']
          );

        }
        $Diccionario_Conseptos[]=$consepto;
    }
    $id_ticket="";
    $bandera=false;
    foreach ($Diccionario_Conseptos as $listconceptos) {
      echo '
        <div class="card text-center ticket_container">';
          if($id_ticket!=$listconceptos["id"]){
            $id_ticket=$listconceptos["id"];
            $bandera=true;
            echo '
              <div class="ticket_container_header">
                <div class="ticket_container_header_input">
                  <input type="checkbox" checked/>
                </div>
                <div class="ticket_container_header_info">
                  <div class="ticket_container_header_info_fecha">
                    <p class="ticket_container_header_info_fecha_fecha">Fecha : '.$listconceptos["fecha"].' </p>
                    <p class="ticket_container_header_info_fecha_fecha">Ticket #'.$listconceptos["id"].'</p>
                  </div>
                  <div class="ticket_container_header_info_more">
                    <div>
                      <p class="ticket_info_p ticket_info_n">'.$listconceptos["habitacion"].'</p>
                    </div>
                    <div class="ticket_container_header_info_more_items">
                    <p class="ticket_info_p">Forma de pago: <spam class="ticket_spam" >'.$listconceptos["forma_pago"].'</spam></p>
                    <p class="ticket_info_p">Total: <spam class="ticket_spam ticket_info_price" >$'.$listconceptos["totalTicket"].'</spam></p>
                    </div>
                  </div>
                </div>
              </div>';
          }
          echo'
          <div class="ticket_tabla_contenedor">
            <table class="table table-sm">
            <table class="table">
                ';
                if($bandera==true){
                  $bandera=false;
                  echo'
                  <thead>
                    <tr>
                      <th scope="col" class="ticket_colum_color">Concepto</th>
                      <th scope="col" class="ticket_colum_color">Cantidad</th>
                      <th scope="col" class="ticket_colum_color">Precio</th>
                      <th scope="col" class="ticket_colum_color">Total</th>
                    </tr>
                  </thead>';
                }
                echo'
                
                  <tr>
                    <th scope="row" class="ticket_colum_color">'.$listconceptos["nombre"].'</th>
                    <td class="ticket_colum_color">'.$listconceptos["cantidad"].'</td>
                    <td class="ticket_colum_color">$'.$listconceptos["precio"].'</td>
                    <td class="ticket_colum_color">$'.$listconceptos["total"].'</td>
                  </tr>
                
              </table>
          </div>
        </div>
        ';
      /*echo "id: ".$listconceptos["id"]."<br>";
      echo "fecha: ".$listconceptos["fecha"]."<br>";
      echo "forma_pago: ".$listconceptos["forma_pago"]."<br>";
      echo "habitacion: ".$listconceptos["habitacion"]."<br>";
      echo "Total Ticket: ".$listconceptos["totalTicket"]."<br>";
      echo "nombre: ".$listconceptos["nombre"]."<br>";
      echo "cantidad: ".$listconceptos["cantidad"]."<br>";
      echo "precio: ".$listconceptos["precio"]."<br>";
      echo "total: ".$listconceptos["total"]."<br><br>";*/
    }
    
?>