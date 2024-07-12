<?php
//Copyright Inotek 2024, by Rafael Flores Galvan;
//For a more indepth understanding of the following pipeline please refer to: plaza_genova/includes/guardar_reservas_externas.php



#region Headers / object declaration
    include_once("consulta.php");
    include_once("class_mail.php");
    $conexion = new ConexionMYSql();
    $emailSender = new EmailSender();

#endregion



#region Variables
    $datosJSON = file_get_contents('php://input');
    $datos = json_decode($datosJSON, true);
    $id = $datos['id'];
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $correo = $datos['correo'];
    $llegada = strtotime($datos['llegada']);
    $salida = strtotime($datos['salida']);
    $telefono = $datos['telefono'];
    $huespedes = $datos['huespedes'];
    $tarifa = $datos['tarifa'];
    $totalCargo = $datos['cargo'];

    echo $telefono;

#endregion



#region Check for pricing
    $query = "SELECT precio_hospedaje FROM tarifa_hospedaje WHERE id = $tarifa";
    $response = $conexion->realizaConsulta($query, '');
    if ($results = mysqli_fetch_array($response)){
        $daily_charge= $results[0];
    } 
    
#endregion


#region Main logic 

    //Check if guest's email exists and return their ID, if not create a new guest and return ID;
    $guest_id = GuestExists($conexion, $correo) ?: CreateGuest($conexion, $nombre, $apellido, $correo, $telefono);

    //Create new Reserve and return ID;
    $reserve_id = CreateReserve($conexion, date('Y-m-d', $llegada), date('Y-m-d', $salida));

    //Create new Movement and return ID;
    $movement_id = CreateMovement($conexion, $guest_id, $llegada, $salida, $tarifa);

    //Return label ticket no. from label and update ID;
    $label_no = CreateLabel($conexion);

    //Create ticket and return ID;
    $ticket_id = CreateTicket($conexion, $movement_id, $label_no);

    //Create "cuenta" and return ID ;
    $account_id = CreateAccount($conexion, $ticket_id, $movement_id, $llegada, $totalCargo);

    //Create reservation
    $reservation_id = CreateReservation($conexion, $reserve_id, $guest_id, $account_id, $tarifa, $llegada, $salida, $totalCargo, $huespedes, $movement_id, $daily_charge);

    //Send mail to Guest & Hotel
    $emailSender->sendEmail($correo, "Detalles de tu Reserva en Plaza Genova", $nombre, "" , $reservation_id, $llegada, $salida, $tarifa, $totalCargo, true);
    $emailSender->sendEmail("soporte@inotek.mx", "Nueva reserva en Plaza Genova", $nombre, $telefono , $reservation_id, $llegada, $salida, $tarifa, $totalCargo);


#endregion



#region Methods
    function GuestExists($conexion, $correo){
        $query = "SELECT id from huesped where correo = '$correo';";
        $response = $conexion->realizaConsulta($query, "");
        if ($results = mysqli_fetch_array($response)){
            return $results[0];
             
        } 
        return false;
    }

    function CreateGuest($conexion, $nombre, $apellido, $correo, $telefono){
        $query = "INSERT INTO huesped (nombre, apellido, correo, telefono, estado_huesped) VALUES (
                        '$nombre', 
                        '$apellido', 
                        '$correo', 
                        '$telefono',
                        1 
                        );
                    ";
        $response = $conexion->RetrieveLast($query);
        return $response;
    }

    function CreateReserve($conexion, $checkinDate, $checkoutDate){
        $query = "INSERT INTO reserva (numero_hab, fecha_entrada, fecha_salida, nombre_reserva) VALUES (
                            1,
                            '$checkinDate',
                            '$checkoutDate',
                            'RESERVA SISTEMA'
                        );
                    ";
        $response = $conexion->RetrieveLast($query);
        return $response;
    }

    function CreateMovement($conexion, $guest_id, $checkinDate, $checkoutDate, $tarifa){
        $time = time();
        $query = "INSERT INTO movimiento (id_hab, id_huesped, inicio_hospedaje, fin_hospedaje, tarifa, motivo, detalle_manda, detalle_inicio) VALUES (
                            0, 
                            '$guest_id',
                            '$checkinDate',
                            '$checkoutDate',
                            '$tarifa',
                            'reservar',
                            5,
                            $time

                        );
        ";
        $response = $conexion->RetrieveLast($query);
        return $response;
    }

    function CreateLabel($conexion){
        $query = "UPDATE labels SET ticket = ticket + 1";
        $response = $conexion->realizaConsulta($query, '');
        if($response){
            $query = "SELECT ticket FROM labels";
            $response = $conexion->realizaConsulta($query, '');
            if($result = mysqli_fetch_array($response)){
                return $result[0] - 1;
            }
        }
    }

    function CreateTicket($conexion, $movement_id, $label_no){
        $date = date("Y-m-d H:i");
        $time= time();
        $query = " INSERT INTO ticket (etiqueta, mov, fecha, tiempo, id_usuario, estado) VALUES (
                    '$label_no', 
                    '$movement_id', 
                    '$date', 
                    '$time', 
                    5, 
                    0
                );
        ";
        $response = $conexion->RetrieveLast($query);
        return $response; 

    }

    function CreateAccount($conexion, $ticket_id, $movement_id, $checkinDate, $totalPayment){
        $query = "INSERT INTO cuenta (id_usuario, id_ticket, mov, descripcion, fecha, cargo, abono, estado) VALUES (
                        5,
                        '$ticket_id',
                        '$movement_id',
                        'Cuenta reserva', 
                        '$checkinDate',
                        '$totalPayment', 
                        '$totalPayment', 
                        1
                    );
                ";
        $response = $conexion->RetrieveLast($query);
        return $response;
    }

    function CreateReservation($conexion, $reserve_id, $guest_id, $account_id, $room_type, $checkinDate, $checkoutDate, $totalPayment, $guestCount, $movement_id, $daily_charge){
        //Check how many days based off check in date & check out date
        $date1 = (new DateTime())->setTimestamp($checkinDate);
        $date2 = (new DateTime())->setTimestamp($checkoutDate);
        $interval = $date1->diff($date2);
        $days = $interval->days;

        //Continue with insertion
        $query = "INSERT INTO reservacion (id_reserva, id_usuario, id_huesped, id_cuenta, tipo_hab, fecha_entrada, fecha_salida, noches, numero_hab,
                                    precio_hospedaje, cantidad_hospedaje, nombre_reserva, total_hab, estado, canal_reserva, tipo_reservacion,
                                    estado_interno, adultos, total, tarifa, suplementos, forma_pago ) VALUES (
                        '$reserve_id', 
                        5, 
                        '$guest_id',
                        '$account_id', 
                        $room_type, 
                        $checkinDate, 
                        $checkoutDate,
                        $days, 
                        1, 
                        $daily_charge, 
                        0,
                        'RESERVA SISTEMA',
                        $totalPayment, 
                        1, 
                        'SISTEMA',
                        'individual', 
                        'garantizada',
                        $guestCount,
                        '$totalPayment',
                        '$room_type',
                        0,
                        19
                    );
                ";
        $response = $conexion->RetrieveLast($query);
        $query = "UPDATE movimiento SET id_reservacion = $response WHERE id = $movement_id";
        $conexion->realizaConsulta($query, '');
        return $response;
    }

#endregion