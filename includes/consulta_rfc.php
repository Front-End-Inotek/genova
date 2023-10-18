<?php
    include("clase_factura.php");
    $fact = NEW factura ();

    $campo = $_GET["inputRFC"];
    $nombre="";
    $email="";
    $resultado= $fact->consulta_rfc($campo);
    while ($fila = mysqli_fetch_array($consulta))
      {
        $nombre=$fila["nombre"];
      }
    $row=mysqli_fetch_array($resultado);
    //try { count($row)>0;
        echo $nombre.'/'.$row["email"].'/'.$row["notas"].'/'.$row["codigo_postal"].'/'.$row["regimen_fiscal"].'/'.$row["regimen_fiscal"];
   // } catch (\Throwable $th) {
    //    echo "".'/'."".'/'."".'/'."".'/'."".'/'."";
    //}

?>