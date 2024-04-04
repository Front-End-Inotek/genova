<?php
    include_once("clase_cuenta.php");
    $cuenta= NEW Cuenta(0);
    date_default_timezone_set('America/Mexico_City');
    $cargos = $_POST["cargos"];
    $abono = $_POST["abonos"];
    $folio_casa = $_POST["folio_c"];

    /* echo $cargos;
    echo "*********************************************************************";
    echo $abono;
    echo "*********************************************************************";
    echo $folio_casa; */
    if(!empty($_POST['cargos'])){

        foreach ($_POST['cargos'] as $key => $cargo) {
            $cuenta->cambiar_hab_cuentas_seleccionadas($_POST["folio_c"],$cargo['cargo_id']);
        }
    
    }
    if(!empty($_POST['abonos'])){
    
        foreach ($_POST['abonos'] as $key => $abono) {
            $cuenta->cambiar_hab_cuentas_seleccionadas($_POST["folio_c"],$abono['abono_id']);
        }
    }

    echo 'SI';
?>