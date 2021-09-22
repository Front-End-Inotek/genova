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
    <li class="nav-item">
                    <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">Reports</span></a>
                    <div class="collapse" id="submenu1" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">
                            <li class="nav-item"><a class="nav-link py-0" href="#"><span>Orders</span></a></li>
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub1"><span>Habitaciones</span></a>
                                <div class="collapse" id="submenu1sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">
                                        <li class="nav-item">
                                            <a class="nav-link p-1 text-truncate" href="#">
                                                <i class="fa fa-fw fa-clock-o"></i> Daily </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-1 text-truncate" href="#">
                                                <i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-1 text-truncate" href="#">
                                                <i class="fa fa-fw fa-bar-chart"></i> Charts </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-1 text-truncate" href="#">
                                                <i class="fa fa-fw fa-compass"></i> Areas </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
    <a href="#">Habitaciones</a>
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