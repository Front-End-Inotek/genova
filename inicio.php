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

            <!-- bootstrap 5  -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />

            <!-- BOX ICONS CSS-->
            <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet"/>

            <link rel=stylesheet href="styles/nuevo/estilosBotones.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/navDesplegable.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/rackHabitacional.css" type="text/css">

            <script src="js/rackHabitacional.js"></script>
            <script src="js/navDesplegable.js"></script>
            <script src="js/scriptBotones.js"></script>
            <script src="js/sweetalert.min.js"></script>

            <!--link css-->
            <link rel=stylesheet href="styles/estilos.css" type="text/css">
            <link rel=stylesheet href="styles/estado0.css" type="text/css">
            <link rel=stylesheet href="styles/estado1.css" type="text/css">
            <link rel=stylesheet href="styles/estado2.css" type="text/css">
            <link rel=stylesheet href="styles/estado3.css" type="text/css">
            <link rel=stylesheet href="styles/estado4.css" type="text/css">
            <link rel=stylesheet href="styles/estado5.css" type="text/css">
            <link rel=stylesheet href="styles/estado6.css" type="text/css">
            <link rel=stylesheet href="styles/subestados.css" type="text/css">
            <link rel=stylesheet href="styles/graficas.css" type="text/css">
            <link rel=stylesheet href="styles/pronosticos.css" type="text/css">
            <link rel=stylesheet href="styles/configColorsHab.css" type="text/css">
            <link rel="stylesheet" href="styles/credito.css">

            <script src="js/events.js"></script>



            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>

            <script src="js/graficas.js"></script>
          </head>
    <body  onload="sabernosession()">

      <div class="menu"></div>
      <div id="pie" class="footer"></div>
      <div id="area_trabajo" class="container-fluid"></div>
      <div id="area_trabajo_menu" class="container-fluid">
      </div>
      <!-- Modal -->
              <div id="caja_herramientas" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <!-- Modal content-->
                  <div class="modal-content" id="mostrar_herramientas">
                  </div>
                </div>
              </div>
              </div>
    </div>
    </body>
  ';


?>
