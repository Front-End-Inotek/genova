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
            <script src="js/rackHabitacional.js"></script>
            <script src="js/navDesplegable.js"></script>
            <script src="js/scriptBotones.js"></script>
            <script src="js/sweetalert.min.js"></script>
            <!--link css-->
            <link rel="stylesheet" href="styles/index.css" />
            <link rel=stylesheet href="styles/graficas.css" type="text/css">
            <link rel=stylesheet href="styles/configColorsHab.css" type="text/css">
            <link rel="stylesheet" href="styles/asidenav.css" />
            <link rel=stylesheet href="styles/estilos.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/rackHabitacional.css" type="text/css">
            <link rel=stylesheet href="styles/pronosticos.css" type="text/css">
            <link rel="stylesheet" href="css/stylesform.css" />
            <script src="js/events.js"></script>
            <script src="js/contenido_inicio.js"></script>
            <script src="js/main.js"></script>
            <script src="js/inactivity.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
            <script src="js/graficas.js"></script>
            <!-- <script src="js/rack.js"></script> -->

            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
            
          </head>
    <body  onload="sabernosession()">

      <!-- menu de navegacion -->
      <div class="menu"></div>
      ';
      //var_dump($_SESSION["imprimir"]) ;
      echo '

      <!-- Area de trabajo en donde todo se renderiza -->
      <div id="area_trabajo" class="main"></div>
      <div id="area_trabajo_menu" class="main"></div>

      <!-- Modal -->
      <div id="caja_herramientas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content" id="mostrar_herramientas"></div>
        </div>
      </div>

      <!-- footer -->
      <footer id="pie" class="footerContainer">
      </footer>

      <!-- chat -->
      <section class="fab_container" onclick="show_chat()">
        <img class="fab_img" src="./assets/chat.svg">
        <span style="display: none;" class="fab_img_notification"></span>
      </section>

      <section id="chat" class="chat_container" style="display: none;">
        <div class="chat_encabezado">
            <p> Chat - General</p>
            <img src="./assets/close.svg" onclick="show_chat()" />
        </div>
        <div id="chat_content" class="chat_body"></div>
          <div class="chat_input">
            <input autofocus id="chat_message" class="chat_input_text" type="text" placeholder="Type a message" onkeyup="handleSendMessage(event)" maxlength="255"/>
            <button class="button_send" type="button" onclick="send_message(0)">
                <img  src="./assets/send.svg" />
            </button>
        </div>
      </section>

      <section id="notification" class="notification_container" style="display: none;">
        <div class="notification_header" >
          <p>Nuevo mensaje global</p>
          <p>justo ahora</p>
        </div>
        <div class="notification_body">
          <p id="nombre_notificacion"></p>
          <p id="mensaje_notificacion"></p>
        </div>
      </section>
    </body>
  ';
?>
