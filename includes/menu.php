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
    <div id="sideNavigation" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="#">Reservaciones</a>
          <li class="nav-item">';
          
          //$permisos_habitaciones=$usuario->usuario_ver+$usuario->usuario_agregar;  AQUI ES NORMAL SIN SUBMENU
          /*$permisos_habitaciones=1;
          if($permisos_habitaciones>0){
            echo '
            <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">Habitaciones</span></a>
              <div class="collapse" id="submenu1" aria-expanded="false">
                <ul class="flex-column pl-2 nav">';
                if($usuario->usuario_ver==1){
                  echo '
                    <li class="nav-item"><a class="nav-link py-0" href="#" onclick="agregar_tipo()"><span>Tipo</span></a></li>';
                }
                if($usuario->usuario_ver==1){
                  echo '
                    <li class="nav-item"><a class="nav-link py-0" href="#"><span>Tarifas</span></a></li>';
                }
                if($usuario->usuario_ver==1){
                  echo '
                    <li class="nav-item"><a class="nav-link py-0" href="#"><span>Habitacion</span></a></li>';
                }
          }*/
     
                  $permisos_habitaciones=1;
                  if($permisos_habitaciones>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">Habitaciones</span></a>
                      <div class="collapse" id="submenu1" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          if($permisos_habitaciones>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub1"><span>Tipo</span></a>
                                <div class="collapse" id="submenu1sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_tipos()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Tipos</a>
                                          </li>';
                                        }
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_tipos()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Tipo</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_habitaciones=1;
                          if($permisos_habitaciones>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub2" data-toggle="collapse" data-target="#submenu1sub2"><span>Tarifa</span></a>
                                <div class="collapse" id="submenu1sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Tarifas</a>
                                          </li>';
                                        }
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Tarifa</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_habitaciones=1;
                          if($permisos_habitaciones>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub3" data-toggle="collapse" data-target="#submenu1sub3"><span>Habitacion</span></a>
                                <div class="collapse" id="submenu1sub3" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Habitaciones</a>
                                          </li>';
                                        }
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Habitacion</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }
                  }
                  
                echo ' 
                </ul>
              </div>
          </li>
      <a href="#">Reportes</a>
      <a href="#">Clientes</a>
    </div>

    <nav class="topnav">
      <a href="#" onclick="openNav()">
        <svg width="30" height="30" id="icoOpen">
            <path d="M0,5 30,5" stroke="#000" stroke-width="5"/>
            <path d="M0,14 30,14" stroke="#000" stroke-width="5"/>
            <path d="M0,23 30,23" stroke="#000" stroke-width="5"/>
        </svg>
      </a>
    </nav>
    
    <div id="main">
    <!-- Add all your websites page content here  -->
    </div>
    ';
  }else{
    echo 'Su sesion a espirado o su cuenta ha sido abierta desde otro dispositivo , es necesario iniciar sesion nuevamente ';
    echo "<script>";
    echo "salida_automatica();";
    echo "</script>";
  }   
?>