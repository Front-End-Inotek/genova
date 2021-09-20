<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  include_once('clase_usuario.php');
  $config = NEW Configuracion(0);
  $usuario =  NEW Usuario($_GET['id']);
  $usuario->datos($_GET['id']);
  $tiempo=time();
  if($_GET['token']== $usuario->token & $usuario->fecha_vencimiento>=$tiempo & $usuario->activo=1 ){
        echo '
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="navbar-brand" href="inicio.php"><img src="images/sighersa_logo.png" height="38" width="45"/></a>
            </li>
            <li class="nav-item dropdown">
              <a class="navbar-brand" href="inicio.php">'.$config->nombre.'</a>
            </li>';
            

            echo'</ul>';

            echo '
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  &nbsp;&nbsp;
                  <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 8 8">
                    <path d="M4 0c-1.1 0-2 1.12-2 2.5s.9 2.5 2 2.5 2-1.12 2-2.5-.9-2.5-2-2.5zm-2.09 5c-1.06.05-1.91.92-1.91 2v1h8v-1c0-1.08-.84-1.95-1.91-2-.54.61-1.28 1-2.09 1-.81 0-1.55-.39-2.09-1z" />
                  </svg> '.$usuario->usuario.'
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#ventanasalir" data-toggle="modal">
                  &nbsp;&nbsp;
                  <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 8 8">
                    <path d="M3 0v1h4v5h-4v1h5v-7h-5zm1 2v1h-4v1h4v1l2-1.5-2-1.5z" />
                  </svg> Salir
                </a>
              </li>
            </ul>

          <div class="modal fade" id="ventanasalir">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><p><a href="#" class="text-primary">Sighersa -> Salir</a></p></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div><br>

                <div class="modal-body">
                  <p><a href="#" class="text-dark">¿';echo ''.$usuario->usuario.' estas seguro de salir de la aplicación?</a></p>
                </div><br>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger btn-lg" data-dismiss="modal"> Cancelar</button>
                  <button type="button" class="btn btn-outline-primary btn-lg" onclick="salirsession()">Salir</button>
                </div>
              </div>
            </div>
          </div>

          </div>
        </nav>';
  }else{
    echo 'Su sesion a espirado o su cuenta ha sido abierta desde otro dispositivo , es necesario iniciar sesion nuevamente ';
    echo "<script>";
    echo "salida_automatica();";
    echo "</script>";
  }   
?>