<?php
    include_once("clase_cuenta.php");
    include_once("clase_hab.php");
    include_once("clase_movimiento.php");
    $cuenta= NEW Cuenta(0);
    $hab= NEW Hab(0);
    $movimiento= NEW Movimiento(0);
    $ocupadas= $hab->obtener_ocupadas();
    $disponibles= $hab->obtener_disponibles();
    $salidas= $movimiento->saber_salidas();
    echo '
    <div class="container-fluid Alin-center">';
        $cuenta->resumen_actual($ocupadas,$disponibles,$salidas);
        //($info_ticket->ticket_ini(),$info_ticket->ticket_fin());
    echo '</div>';  
?>