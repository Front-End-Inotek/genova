<?php

include_once('enviar_rack.php');
$rack = new Rack();
$tiempo_inicial=time();
$rack->mostrar($_GET['hab_id'],$tiempo_inicial);