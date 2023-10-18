<?php
    include("clase_factura.php");
    $fact = NEW factura ();

    $campo = $_GET["inputRFC"];
    $nombre="";
    $email="";
    $notas="";
    $codigo_postal="";
    $regimen_fiscal="";
    $resultado= $fact->consulta_rfc($campo);
    while ($fila = mysqli_fetch_array($resultado))
      {
        $nombre=$fila["nombre"];
        $email=$fila["email"];
        $notas=$fila["notas"];
        $codigo_postal=$fila["codigo_postal"];
        $regimen_fiscal=$fila["regimen_fiscal"];
      }
    $row=mysqli_fetch_array($resultado);
    //try { count($row)>0;
        echo $nombre.'/'.$email.'/'.$notas.'/'.$codigo_postal.'/'.$regimen_fiscal;
   // } catch (\Throwable $th) {
    //    echo "".'/'."".'/'."".'/'."".'/'."".'/'."";
    //}

?>