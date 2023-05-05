<?php
    include_once('mostrar_rackHabitacional.php');
    $rack_hab= NEW RackHabitacional(0); 
    $tiempo_inicial=time();
    $rack_hab->mostrar($_GET['usuario_id'], $tiempo_inicial);
?>
