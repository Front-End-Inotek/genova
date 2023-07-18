<?php
  session_start();
  include_once('includes/clase_configuracion.php');
  $config = NEW Configuracion();
  $timepo = time();
  $activo= $config->activacion- $timepo;

 
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
            <link rel=stylesheet href="styles/nuevo/estilosBotones.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/navDesplegable.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/rackHabitacional.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/logIn.css" type="text/css">

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
           
            <script src="js/events.js"></script>
          </head>
    <body class="context" id="animacion" onload="sabersession()" >
    <div class="color">
    <!---
    <ul class="circles">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
      </ul>
      --->
      </div>';
          //<center><h1 class="text-primary">'.$config->nombre.'</h1></center>
        echo '</div>
      </header>
     ';
      if($activo>0){
        
          echo '
          <div class="container efecto" height="260" width="380">
          <form id="form">
          <header class="titulo">
          <h2 class="user"> Inicio de Sesión</h2>
          <br>
          <center><img src="images/login/'.$config->imagen.'" height="160" width="180"/></center>
            <div class="form-group texto_entrada">
            <br>
            <input class="form-control" pattern="[A-Za-z0-9]+" type="text"  id="user"  placeholder="Usuario" maxlength="20" />
          </div>
            <div class="form-group texto_entrada">
              
              <input class="form-control" type="password" id="pass" placeholder="Contraseña"   maxlength="20"/>
            </div>
            <input type="submit" class="fadeIn fourth" name="login" id="login">
              <span class="glyphicon glyphicon-user"></span>
            </input>
            <div id="formFooter">
          </div>
          </form>
          
          </div>
          </div>
          </br>
          </br>
          </div>
            <div class="container "  id="renglon_entrada_mensaje">
        
              ';
            if($activo<518400){
              echo '<div class="alert alert-warning">
                <strong>El uso del sistema vencera el dia '.date("d/m/y ",$config->activacion ).'</strong> Contacte a su proveedor.
              </div>';
            }
          echo'</div>';
      }else{
        echo '<div class="container">
        <form>
        <div class="container">
        </div>
          <div class="form-group texto_entrada">
          <label for="user">
            Usuario:
          </label>
          <input class="form-control" type="text"  id="user"  placeholder="Usuario"  disabled />
        </div>
          <div class="form-group texto_entrada">
            <label for=""pass">
              Contraseña:
            </label>
            <input class="form-control" type="password" id="pass" placeholder="Contraseña" disabled />
          </div>
          <button class="btn btn-block btn-default btn-lg" name="login" id="login" disabled>
            <span class="glyphicon glyphicon-user"></span> Iniciar sesión
          </button>
        </form>
        </br>
        </br>
        </div>
          <div class="container "  id="renglon_entrada_mensaje">
          <div class="alert alert-danger">
            <strong>Sistema deshabilitado </strong> Contacte a su proveedor.
          </div>
          </div>';
      }

  echo '
    <div class="container ">
      <div class="row hidden-xs " id="tecaldo">

      </div>
    </div>
  </body>
  ';


?>
