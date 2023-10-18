<?php
    include 'datos_servidor.php'; //conexion con la base de datos

    $campo = $_GET["inputRFC"];
    $consulta="SELECT * FROM rfc ";
    $consulta.= "WHERE rfc = '$campo' ";
    $resultado=mysqli_query($con,$consulta);
    $row=mysqli_fetch_array($resultado);
    echo $row["nombre"].'/'.$row["email"].'/'.$row["notas"].'/'.$row["codigo_postal"].'/'.$row["regimen_fiscal"].'/'.$row["626"];
?>