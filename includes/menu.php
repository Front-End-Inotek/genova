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
     
                  $permisos_habitaciones=$usuario->tipo_ver+$usuario->tipo_agregar+$usuario->tarifa_ver+$usuario->tarifa_agregar+$usuario->hab_ver+$usuario->hab_agregar;
                  if($permisos_habitaciones>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1181.000000">
                        <g transform="translate(0.000000,1181.000000) scale(0.100000,-0.100000)">
                        <path d="M6315 11785 c-38 -13 -275 -87 -525 -165 -420 -131 -735 -229 -1525 -475 -165 -51 -475 -148 -690 -215 -214 -67 -525 -164 -690 -215 -329 -103 -825 -257 -1525 -475 -250 -78 -538 -168 -640 -200 -102 -31 -305 -95 -452 -140 l-268 -84 0 -452 0 -452 183 58 c100 31 192 60 205 64 l22 7 0 -4520 0 -4521 130 0 130 0 2 4562 3 4561 265 83 c311 96 1488 463 1940 604 173 54 621 193 995 310 374 117 822 256 995 310 628 196 1226 382 1376 429 l153 48 168 -53 c92 -29 373 -116 623 -194 250 -78 591 -184 758 -236 166 -52 439 -137 607 -189 168 -52 441 -137 608 -189 1007 -314 2301 -717 2790 -869 l197 -62 0 -4557 0 -4558 130 0 130 0 0 4515 c0 2483 3 4515 8 4515 4 0 91 -27 195 -59 l187 -59 0 452 0 452 -67 21 c-38 12 -273 85 -523 163 -250 78 -628 196 -840 262 -699 217 -986 307 -1295 403 -168 52 -441 137 -607 189 -167 52 -512 160 -768 239 -1176 367 -1404 438 -1837 573 -254 79 -466 144 -470 143 -4 0 -39 -11 -78 -24z"/>
                        <path d="M2357 5981 c-142 -47 -237 -147 -295 -310 -15 -42 -17 -273 -19 -2858 l-3 -2813 460 0 460 0 0 710 0 710 3490 0 3490 0 0 -705 0 -705 450 0 450 0 -2 2188 c-3 2103 -4 2189 -22 2242 -23 69 -61 145 -95 189 -41 54 -136 119 -208 141 -215 66 -429 -36 -529 -254 -52 -114 -53 -140 -54 -1083 l0 -873 -3495 0 -3494 0 -3 1523 c-3 1446 -4 1525 -22 1577 -48 144 -133 246 -252 302 -87 41 -217 49 -307 19z"/>
                        <path d="M3855 5383 c-464 -40 -803 -472 -754 -958 46 -460 419 -795 859 -772 121 6 208 30 321 88 157 81 274 204 359 374 110 220 126 456 49 691 -86 259 -289 463 -540 543 -53 17 -231 45 -249 39 -3 -1 -23 -3 -45 -5z"/>
                        <path d="M5071 4764 c-128 -46 -217 -151 -256 -301 -12 -46 -15 -138 -15 -480 l0 -423 -662 0 c-709 0 -727 -1 -834 -51 -72 -34 -149 -111 -186 -187 -31 -63 -33 -72 -33 -177 0 -103 2 -114 32 -177 55 -117 164 -200 297 -228 34 -7 352 -10 961 -8 l910 3 57 27 c71 33 146 102 181 166 57 104 57 109 57 813 0 398 -4 667 -10 700 -25 130 -104 242 -212 300 -56 29 -73 33 -153 36 -64 2 -103 -1 -134 -13z"/>
                        <path d="M5690 3750 l0 -1010 2025 0 2026 0 -3 713 c-4 704 -4 713 -26 785 -70 228 -209 384 -415 466 -147 58 -70 56 -1913 56 l-1694 0 0 -1010z"/>
                        </g>
                      </svg> Habitaciones</span>
                    </a>
                      <div class="collapse" id="submenu1" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          $permisos_tipo=$usuario->tipo_ver+$usuario->tipo_agregar;
                          if($permisos_tipo>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub1"><span>Tipo</span></a>
                                <div class="collapse" id="submenu1sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->tipo_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_tipos()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Tipos</a>
                                          </li>';
                                        }
                                        if($usuario->tipo_agregar==1){
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

                          $permisos_tarifa=$usuario->tarifa_ver+$usuario->tarifa_agregar;
                          if($permisos_tarifa>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub2" data-toggle="collapse" data-target="#submenu1sub2"><span>Tarifa</span></a>
                                <div class="collapse" id="submenu1sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->tarifa_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_tarifas()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Tarifas</a>
                                          </li>';
                                        }
                                        if($usuario->tarifa_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_tarifas()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Tarifa</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_hab=$usuario->hab_ver+$usuario->hab_agregar;
                          if($permisos_hab>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub3" data-toggle="collapse" data-target="#submenu1sub3"><span>Habitacion</span></a>
                                <div class="collapse" id="submenu1sub3" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->hab_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_hab()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Habitaciones</a>
                                          </li>';
                                        }
                                        if($usuario->hab_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_hab()">
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
         
      <a href="#">
        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 8 8">
          <path d="M4 0c-1.1 0-2 1.12-2 2.5s.9 2.5 2 2.5 2-1.12 2-2.5-.9-2.5-2-2.5zm-2.09 5c-1.06.05-1.91.92-1.91 2v1h8v-1c0-1.08-.84-1.95-1.91-2-.54.61-1.28 1-2.09 1-.81 0-1.55-.39-2.09-1z" />
        </svg> '.$usuario->usuario.'
      </a>
          
      <a href="#ventanasalir" data-toggle="modal">
        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 8 8">
          <path d="M3 0v1h4v5h-4v1h5v-7h-5zm1 2v1h-4v1h4v1l2-1.5-2-1.5z" />
        </svg> Salir
      </a>
    
    </div>

    <div class="modal fade" id="ventanasalir">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title"><p><a href="#" class="text-dark">Reservaciones -> Salir</a></p></h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div><br>

          <div class="modal-body">
            <p><a href="#" class="text-dark">¿';echo ''.$usuario->usuario.' estas seguro de salir de la aplicación?</a></p>
          </div><br>
                
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
            <button type="button" class="btn btn-success" onclick="salirsession()">Salir</button>
          </div>
        </div>
      </div>
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