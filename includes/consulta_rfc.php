<?php
    include("clase_factura.php");
    $fact = NEW factura ();

    $campo = $_GET["inputRFC"];

    $resultado= $fact->consulta_rfc($campo);
    $row=mysqli_fetch_array($resultado);
    echo $row["nombre"].'/'.$row["email"].'/'.$row["notas"].'/'.$row["codigo_postal"].'/'.$row["regimen_fiscal"].'/'.$row["regimen_fiscal"];
?>