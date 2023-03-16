<?php
  session_start();
  include_once('includes/clase_configuracion.php');
  $config = NEW Configuracion();
  echo '  <!DOCTYPE html>
      <html lang="es">
          <head>
            <title>'.$config->nombre.'</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
            <link rel="icon" href="favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel=stylesheet href="styles/fondo.css" type="text/css">
            <link rel=stylesheet href="styles/estilos.css" type="text/css">
            <link rel=stylesheet href="styles/estado0.css" type="text/css">
            <link rel=stylesheet href="styles/estado1.css" type="text/css">
            <link rel=stylesheet href="styles/estado2.css" type="text/css">
            <link rel=stylesheet href="styles/estado3.css" type="text/css">
            <link rel=stylesheet href="styles/estado4.css" type="text/css">
            <link rel=stylesheet href="styles/estado5.css" type="text/css">
            <link rel=stylesheet href="styles/estado6.css" type="text/css">
            <link rel=stylesheet href="styles/subestados.css" type="text/css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="js/events.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          </head>
    <body onload="sabernosession()">
      <div class="menu"></div>
      <div id="pie" class="footer"></div>
      <div id="area_trabajo" class="container-fluid"></div>
      <div id="area_trabajo_menu" class="container-fluid"></div>
      
      
    </div>
      <!-- Modal -->
              <div id="caja_herramientas" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content" id="mostrar_herramientas">


                     
                  </div>

                </div>
              </div>
    </body>
  ';


?>
