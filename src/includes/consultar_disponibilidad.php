<?php
#region Migrations
    //ALTER TABLE configuracion ADD COLUMN motor_reservas_activado INT(11) DEFAULT 1;
/* CREATE TABLE `reservas_bloqueos` (
    `tipo_hab` int(11) NOT NULL,
    `fecha` date DEFAULT NULL,
    `precio` int(11) NOT NULL,
    `disponibles` int(11) DEFAULT NULL,
    `canal` int(11) DEFAULT NULL,
    `extra_adulto_tipo_1` int(11) DEFAULT NULL,
    `extra_adulto_tipo_2` int(11) DEFAULT NULL
  ) */
#endregion



#region Headers/ Objects 
    include_once("consulta.php");
    $conexion = new ConexionMYSql();

#endregion



#region Main variables 
    $initialDateUnix = strtotime($_GET['initial']);
    $endDateUnix = strtotime($_GET['end']);       
    $initialDate = $_GET['initial'];
    $endDate = $_GET['end'];

    $initial = new DateTime($initialDate);
    $end =  new DateTime($endDate);
    $allowanceDays = $initial->diff($end)->days;
    $end->modify('-1 day');
    $endDate = $end->format('Y-m-d');

    $cantidadPersonas = $_GET['guests']; 
    $hayDisponibles = false;
    
#endregion


#region Main Logic
    //Check if engine is enabled from visit, if not, close script
    if(!CheckIfEngineIsOpen($conexion)) {
        echo ' <div class="card" style="width: 18rem;"> <h1>No hay disponibilidad, contactenos para mas informacion</h1> </div> ';
        die();  
    }    
    //Execute price query logic (see consultar_precio.php)
    include_once("consultar_precios.php");

    //Check if there's rooms availables 
    foreach ($roomData as $roomId => $data) {
        if($data['available'] > 0){
            $hayDisponibles = true;
        }
    }


#endregion



#region print HTML
if ($hayDisponibles) {
    foreach ($roomData as $roomId => $data) {
        if($data['available'] < 1){
            continue;
        }
    echo '
        <label for="'. $data['name'] .'" class="card_hab">
                    <div class="card_hab_header">
                        <img src="./public/roomDescription/'.$data['img'].'" loading="lazy" />
                    </div>
                    <div class="card_body">
                        <h5>' .$data['name'].'</h5>
                        <h6> '.$data['descripcion'].' </h6> 
                        <h6>Total estancia <span class="card_money" >$'.number_format($data['price'], 1).'</span> </h6>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/air.svg" />
                            <p>Aire acondionado</p>
                        </div>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/tv.svg" />
                            <p>TV</p>
                        </div>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/wifi.svg" />
                            <p>Wifi gratis</p>
                        </div>
                        <label  class="btn_select" >
                            <input type="radio" name="hab" id="'.$roomId .'" value="'. $roomId.'" onclick="selectCard(this)" />
                            Seleccionar
                        </label>
                    </div>
                </label>';
            }   
        }
            else {
                echo ' <div class="card" style="width: 18rem;"> <h1>Sin habitaciones disponibles</h1> </div>
    ';
}

#endregion



#region Methods
    function CheckIfEngineIsOpen($conexion){
        $sentencia3 = "SELECT motor_reservas_activado FROM configuracion";
        $puedeReservar = mysqli_fetch_array($conexion->realizaConsulta($sentencia3, ""))['motor_reservas_activado'];
        return $puedeReservar;
    }



#endregion