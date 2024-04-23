<?php
  session_start();
  include_once('includes/clase_configuracion.php');
  $config = NEW Configuracion();
  $timepo = time();
  $activo= $config->activacion- $timepo;
  $imagenHotel = './images/'.$config->imagen.'';
  echo '
    <!DOCTYPE html>
      <html lang="es">
          <head>
            <title>'.$config->nombre.'</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8">
            <meta http-equiv="Expires" content="0">
            <meta http-equiv="Last-Modified" content="0">
            <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
            <meta http-equiv="Pragma" content="no-cache">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
            <link rel="icon" href="favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <link rel="stylesheet" href="styles/login.css" />
            <script src="js/events.js"></script>
          </head>
    <body class="context" id="animacion" onload="sabersession()" >
    <div class="color">
      </div>';

          //<center><h1 class="text-primary">'.$config->nombre.'</h1></center>
        echo '</div>

     ';
      if( $activo > 0 ){
          echo '
          <main class="formulario_login">

            <header class="formulario_login_header">
              <div class="formulario_login_logo">
                <p class="formulario_login_logo_text" >VISIT</p>
                <img  class="formulario_login_logo_img" src="./images/nuve.png"  alt="logo visit"/>
              </div>
              <picture>
                <img class="formulario_login_logo_hotel" src="'.$imagenHotel.'" />
              </picture>
            </header>

            <form id="form" class="formulario_login_container">
              <p class="formulario_login_title"> Iniciar sesión</p>

              <hr class="formulario_login_divider"/>

              <div class="input-container">
                <input class="input-field" pattern="[A-Za-z0-9]+" type="text"  id="user"  placeholder="Usuario" maxlength="20" required/>
                <label for="user" class="input-label">Usuario</label>
                <span class="input-highlight"></span>
              </div>

              <div class="input-container">
                <input class="input-field" type="password" id="pass" placeholder="Contraseña" maxlength="20" required/>
                <label for="pass" class="input-label">Contraseña</label>
                <span class="input-highlight"></span>
              </div>

              <input type="submit" class="formulario_login_button" name="login" id="login">
                <span class="glyphicon glyphicon-user"></span>
              </input>

              <div id="renglon_entrada_mensaje" class="formulario_login_alert_box" ></div>
              ';
              if($activo < 518400){
                echo '
                <div class="formulario-warning">
                  <p class="formulario-warning-text">El uso del sistema vencera el dia <strong>'.date("d/m/y ",$config->activacion ).'</strong> Contacte a su proveedor.</p>
                  <img class="formulario-warning-icon" src="./assets/alert-circle.svg" />
                </div>';
              };
              echo '
            </form>
            </main>
            ';
      }else{
        echo '
        <main class="formulario_login">

        <header class="formulario_login_header">
          <div class="formulario_login_logo">
            <p class="formulario_login_logo_text" >VISIT</p>
            <img  class="formulario_login_logo_img" src="./images/nuve.png"  alt="logo visit"/>
          </div>
          <picture>
            <img class="formulario_login_logo_hotel" src="'.$imagenHotel.'" />
          </picture>
        </header>

        <form id="form" class="formulario_login_container">
          <p class="formulario_login_title"> Iniciar sesión</p>

          <hr class="formulario_login_divider"/>

          <div class="input-container">
            <input class="input-field" pattern="[A-Za-z0-9]+" type="text"  id="user"  placeholder="Usuario" maxlength="20" disabled/>
            <label for="user" class="input-label">Usuario</label>
            <span class="input-highlight"></span>
          </div>

          <div class="input-container">
            <input class="input-field" type="password" id="pass" placeholder="Contraseña" maxlength="20" disabled/>
            <label for="pass" class="input-label">Contraseña</label>
            <span class="input-highlight"></span>
          </div>

          <input type="submit" class="formulario_login_button" name="login" id="login" disabled>
            <span class="glyphicon glyphicon-user"></span>
          </input>
          <div class="formulario-warning">
            <p class="formulario-warning-text"><strong>Sistema deshabilitado</strong> Contacte a su proveedor.</p>
            <img class="formulario-warning-icon" src="./assets/alert-circle.svg" />
          </div>
        </form>
        </main>
          
          </div>';
      }
  echo '
    <div class="container ">
      <div class="row hidden-xs " id="tecaldo">
      </div>
    </div>
  </body>
  </html>
  ';
?>
