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
                      <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1181.000000">
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
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub3" data-toggle="collapse" data-target="#submenu1sub3"><span>Habitación</span></a>
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
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Habitación</a>
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

          <li class="nav-item">';
                  $permisos_reservaciones=$usuario->reservacion_ver+$usuario->reservacion_agregar+$usuario->huesped_ver+$usuario->huesped_agregar;
                  if($permisos_reservaciones>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu2" data-toggle="collapse" data-target="#submenu2"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1147.000000">
                        <g transform="translate(0.000000,1147.000000) scale(0.100000,-0.100000)">
                        <path d="M1703 11456 c-128 -31 -242 -119 -291 -223 l-27 -58 -3 -969 c-3 -1050 -3 -1037 51 -1123 34 -53 106 -117 166 -147 104 -53 301 -72 442 -42 137 29 257 117 308 226 l26 55 0 1000 0 1000 -32 65 c-17 36 -47 79 -65 97 -54 52 -145 101 -218 117 -83 19 -282 20 -357 2z"/>
                        <path d="M4750 11463 c-133 -22 -261 -110 -318 -218 l-27 -50 -3 -1002 -2 -1001 21 -59 c16 -41 39 -74 78 -114 104 -104 234 -144 431 -136 188 8 307 60 392 172 71 93 68 40 68 1126 0 965 0 979 -21 1034 -42 114 -179 219 -318 245 -52 10 -250 12 -301 3z"/>
                        <path d="M7740 11460 c-124 -26 -247 -119 -301 -227 l-24 -48 -3 -992 c-2 -979 -2 -992 18 -1046 62 -165 211 -255 440 -264 253 -11 428 74 508 245 l27 57 0 985 c0 914 -1 989 -18 1035 -35 100 -135 195 -249 235 -52 19 -88 23 -208 26 -80 1 -165 -1 -190 -6z"/>
                        <path d="M10743 11456 c-129 -32 -241 -117 -291 -224 l-27 -57 0 -1000 0 -1000 28 -56 c32 -67 113 -147 185 -183 150 -76 417 -74 570 3 72 37 145 110 180 181 l27 55 0 1000 0 1000 -32 65 c-17 36 -47 79 -65 97 -54 52 -145 101 -218 117 -83 19 -282 20 -357 2z"/>
                        <path d="M380 9909 c-178 -23 -334 -168 -370 -344 -7 -34 -9 -1513 -8 -4640 l3 -4590 37 -77 c48 -102 114 -168 216 -216 l77 -37 6030 -3 c4584 -2 6043 0 6085 9 164 35 292 158 336 324 11 41 14 836 14 4620 0 4099 -2 4577 -16 4630 -46 178 -193 303 -384 326 -48 5 -241 9 -445 7 l-360 -3 -5 -425 -5 -425 -25 -48 c-54 -107 -199 -207 -359 -248 -99 -26 -332 -36 -460 -20 -220 27 -386 120 -470 261 l-26 45 -5 430 -5 430 -825 0 -825 0 -5 -425 c-6 -493 -2 -473 -113 -577 -119 -111 -263 -160 -497 -170 -308 -12 -509 46 -648 188 -23 24 -52 64 -65 89 -21 44 -22 55 -27 470 l-5 425 -825 0 -825 0 -5 -425 c-5 -415 -6 -426 -28 -471 -12 -25 -43 -67 -70 -93 -138 -138 -337 -195 -642 -183 -235 10 -377 59 -497 170 -111 104 -107 84 -113 577 l-5 425 -825 0 -825 0 -5 -430 -5 -430 -27 -45 c-84 -144 -255 -237 -480 -261 -135 -15 -350 -5 -449 20 -160 41 -305 141 -359 248 l-25 48 -5 425 -5 425 -380 1 c-209 1 -409 -2 -445 -7z m11402 -2030 c113 -24 201 -90 244 -183 l24 -51 0 -3401 c0 -2552 -3 -3410 -12 -3435 -31 -92 -114 -167 -220 -201 -58 -17 -235 -18 -5418 -18 -5183 0 -5360 1 -5418 18 -106 34 -189 109 -220 201 -9 25 -12 883 -12 3435 l0 3401 24 51 c42 90 122 153 231 180 69 17 10696 20 10777 3z"/>
                        <path d="M4625 7658 c-3 -7 -4 -292 -3 -633 l3 -620 838 -3 837 -2 0 635 0 635 -835 0 c-659 0 -837 -3 -840 -12z"/>
                        <path d="M6430 7035 l0 -635 838 2 837 3 0 630 0 630 -837 3 -838 2 0 -635z"/>
                        <path d="M8240 7035 l0 -635 835 0 835 0 0 635 0 635 -835 0 -835 0 0 -635z"/>
                        <path d="M10040 7035 l0 -635 840 0 840 0 -2 633 -3 632 -837 3 -838 2 0 -635z"/>
                        <path d="M1010 5640 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M2820 5640 l0 -630 835 0 835 0 0 630 0 630 -835 0 -835 0 0 -630z"/>
                        <path d="M4620 5640 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M6430 5640 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M8240 5640 l0 -630 835 0 835 0 0 630 0 630 -835 0 -835 0 0 -630z"/>
                        <path d="M10040 5640 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M1010 4260 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M2820 4260 l0 -630 835 0 835 0 0 630 0 630 -835 0 -835 0 0 -630z"/>
                        <path d="M4620 4260 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M6430 4260 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M8240 4260 l0 -630 835 0 835 0 0 630 0 630 -835 0 -835 0 0 -630z"/>
                        <path d="M10040 4260 l0 -630 840 0 840 0 0 630 0 630 -840 0 -840 0 0 -630z"/>
                        <path d="M1014 3511 c-2 -2 -4 -287 -4 -633 l0 -628 840 0 840 0 -2 630 -3 630 -833 3 c-459 1 -836 0 -838 -2z"/>
                        <path d="M3653 3513 l-833 -3 0 -630 0 -630 835 0 835 0 0 635 c0 349 -1 634 -2 633 -2 -2 -378 -4 -835 -5z"/>
                        <path d="M4624 3511 c-2 -2 -4 -287 -4 -633 l0 -628 840 0 840 0 0 630 0 630 -836 2 c-460 2 -838 1 -840 -1z"/>
                        <path d="M7263 3512 l-833 -2 0 -630 0 -630 840 0 840 0 0 629 c0 347 -3 631 -7 633 -5 2 -383 2 -840 0z"/>
                        <path d="M10873 3512 l-833 -2 0 -630 0 -630 840 0 840 0 0 629 c0 347 -3 631 -7 633 -5 2 -383 2 -840 0z"/>
                        <path d="M8240 2880 l0 -630 835 0 835 0 0 630 0 630 -835 0 -835 0 0 -630z"/>
                        <path d="M1012 1488 l3 -633 835 0 835 0 3 633 2 632 -840 0 -840 0 2 -632z"/>
                        <path d="M2820 1485 l0 -635 835 0 835 0 0 635 0 635 -835 0 -835 0 0 -635z"/>
                        <path d="M4622 1488 l3 -633 838 -3 837 -2 0 635 0 635 -840 0 -840 0 2 -632z"/>
                        <path d="M6432 1488 l3 -633 835 0 835 0 3 633 2 632 -840 0 -840 0 2 -632z"/>
                        <path d="M8240 1485 l0 -635 835 0 835 0 0 635 0 635 -835 0 -835 0 0 -635z"/>
                        </g>
                      </svg> Reservaciones</span>
                    </a>
                      <div class="collapse" id="submenu2" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          $permisos_reservar=$usuario->reservacion_ver+$usuario->reservacion_agregar;
                          if($permisos_reservar>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu2sub1" data-toggle="collapse" data-target="#submenu2sub1"><span>Reservar</span></a>
                                <div class="collapse" id="submenu2sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->reservacion_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_reservaciones()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Reservaciones</a>
                                          </li>';
                                        }
                                        if($usuario->reservacion_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_reservaciones()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Reservación</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_huesped=$usuario->huesped_ver+$usuario->huesped_agregar;
                          if($permisos_huesped>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu2sub2" data-toggle="collapse" data-target="#submenu2sub2"><span>Huéspedes</span></a>
                                <div class="collapse" id="submenu2sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->huesped_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_huespedes()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Huéspedes</a>
                                          </li>';
                                        }
                                        if($usuario->huesped_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_huespedes()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Huésped</a>
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

          <li class="nav-item">';
                  $permisos_reportes=$usuario->reporte_ver+$usuario->reservacion_agregar;
                  if($permisos_reportes>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu3" data-toggle="collapse" data-target="#submenu3"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1147.000000">
                        <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
                        <path d="M6575 12780 c-121 -10 -344 -27 -495 -39 -151 -11 -572 -43 -935 -71 -363 -27 -781 -59 -930 -70 -405 -31 -699 -53 -1720 -130 -511 -39 -1049 -79 -1195 -90 -681 -52 -1051 -77 -1113 -77 -37 0 -72 -4 -77 -9 -11 -11 -54 -611 -75 -1044 -51 -1073 -45 -2061 21 -3025 127 -1871 484 -3523 1029 -4755 92 -207 109 -250 104 -254 -2 -2 -151 -20 -331 -40 -180 -20 -338 -41 -352 -47 -71 -33 -33 -67 239 -214 497 -268 535 -291 535 -321 0 -17 -53 -31 -164 -45 -145 -18 -172 -38 -120 -89 37 -35 864 -484 922 -499 36 -10 65 -8 190 14 81 14 159 30 173 34 31 10 19 29 116 -189 72 -160 96 -223 85 -216 -8 5 -602 -58 -656 -70 -65 -14 -74 -49 -23 -88 68 -52 882 -486 923 -492 42 -6 591 87 626 106 14 8 20 4 32 -18 30 -59 107 -244 104 -248 -3 -2 -150 -20 -329 -40 -178
                        -20 -339 -42 -356 -50 -40 -16 -42 -35 -7 -67 30 -28 849 -474 908 -494 26 -10 58 -13 88 -9 26 4 793 144 1705 312 912 167 2329 428 3150 579 821 151 1514 282 1540 291 79 27 77 54 -5 78 l-46 13 115 21 c64 12 123 22 132 22 24 0 21 12 -14 72 -123 208 -324 664 -451 1023 -365 1030 -613 2209 -753 3587 -30 293 -30 361 -2 401 10 16 22 26 25 23 7 -7 32 13 32 26 0 6 -8 4 -17 -3 -16 -13 -17 -12 -4 3 7 10 17 16 21 13 4 -3 263 345 576 772 544 746 568 779 565 818 -7 133 -167 298 -338 350 -64 20 -157 20 -176 0 -9 -8 -186 -250 -394 -537 l-378 -522 -7 114 c-6 108 -14 950 -10 996 1 12 10 28 20 35 15 13 16 12 4 -3 -8 -10 -12 -22 -10 -29 6 -19 288 376 288 404 0 103 -125 264 -255 327 l-40 19 7 198 c4 109 14 339 24 511 9 172 14 316 10 319 -3 3 -179 -7 -390
                        -23 l-384 -29 -59 24 c-34 14 -87 26 -130 29 l-73 5 1 96 c0 53 8 236 18 406 10 171 16 312 15 314 -2 2 -191 -10 -420 -28 -229 -17 -418 -30 -419 -29 -3 6 15 457 30 729 8 153 15 290 15 306 l0 28 -260 -19 c-143 -10 -263 -17 -265 -14 -3 3 2 124 10 269 17 297 18 370 8 368 -5 -1 -107 -10 -228 -19z m2628 -3717 c-4 -10 -9 -20 -13 -23 -3 -3 -14 -18 -24 -35 -21 -32 -32 -47 -58 -76 -10 -10 -18 -23 -18 -29 0 -5 -4 -10 -10 -10 -5 0 -10 -8 -11 -17 0 -11 -3 -13 -6 -6 -4 10 133 213 143 213 2 0 0 -8 -3 -17z m147 -87 c0 -2 -7 -7 -16 -10 -8 -3 -12 -2 -9 4 6 10 25 14 25 6z m-50 -60 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-80 -110 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m764 -388 c-5 -7 -50 -71 -102 -141 -51 -71
                        -91 -131 -88 -134 33 -33 222 -159 225 -150 3 8 140 203 188 266 2 2 6 1 10 -3 4 -4 0 -12 -10 -17 -9 -6 -17 -16 -17 -23 0 -8 -11 -24 -25 -37 -13 -13 -25 -30 -25 -37 0 -7 -7 -15 -15 -18 -8 -4 -15 -12 -15 -20 0 -8 -4 -14 -10 -14 -5 0 -10 -6 -10 -13 0 -7 -13 -26 -28 -43 -16 -16 -32 -37 -35 -47 -8 -20 -9 -20 -167 96 -61 45 -78 53 -90 44 -8 -7 -3 4 11 23 14 19 65 90 114 158 49 67 90 122 92 122 3 0 1 -6 -3 -12z m366 -262 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-30 -40 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-440 -72 c0 -3 -13 4 -30 16 -16 12 -30 24 -30 26 0 3 14 -4 30 -16 17 -12 30 -24 30 -26z m-94 8 c-17 -16 -18 -16 -5 5 7 12 15 20 18 17 3 -2 -3 -12 -13 -22z m125 -29 c13 -16 12 -17 -3 -4 -10 7 -18 15
                        -18 17 0 8 8 3 21 -13z m-141 3 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m220 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-30 -40 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m170 -46 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-220 -20 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m190 -24 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m280 0 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-500 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17
                        -12 -4 4 13 16 21 21 21 13z m170 -46 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m100 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-320 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m500 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-310 -40 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m170 -46 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-220 -20 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m500 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-310 -40 c0 -2 -8
                        -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m170 -46 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m100 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-320 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m480 -10 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-290 -14 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m480 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-310 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13
                        -16 -30z m-220 -20 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m480 -10 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-290 -14 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m480 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-310 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m100 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-320 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m480 -14 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-290 -10 c0 -2 -8 -10 -17 -17
                        -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-220 -20 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m480 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-310 -36 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-226 -27 c-71 -96 -64 -93 -62 -27 1 57 1 58 7 15 l6 -44 33 47 c18 25 36 46 39 46 3 0 -7 -17 -23 -37z m486 -7 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-290 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m100 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m190 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50
                        -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-270 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m290 6 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-270 16 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-49 -65 c-12 -17 -22 -47 -23 -73 l-1 -43 -4 43 c-3 31 1 50 17 72 12 17 24 30 26 30 3 0 -4 -13 -15 -29z m99 15 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m190 -10 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0
                        4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-30 -44 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z m-50 -66 c-12 -16 -24 -30 -26 -30 -3 0 4 14 16 30 12 17 24 30 26 30 3 0 -4 -13 -16 -30z m-30 -44 c0 -2 -8 -10 -17 -17 -16 -13 -17 -12 -4 4 13 16 21 21 21 13z"/>
                        <path d="M9166 6524 c-10 -14 -16 -28 -13 -30 2 -3 12 7 21 22 10 14 16 28 13 30 -2 3 -12 -7 -21 -22z"/>
                        </g>
                      </svg> Reportes</span>
                    </a>
                      <div class="collapse" id="submenu3" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          $permisos_reportes_diarios=$usuario->reporte_ver+$usuario->reporte_agregar;
                          if($permisos_reportes_diarios>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu3sub1" data-toggle="collapse" data-target="#submenu3sub1"><span>Diarios</span></a>
                                <div class="collapse" id="submenu3sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->reporte_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_cargo_noche()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Cargo por noche</a>
                                          </li>';
                                        }
                                        if($usuario->reporte_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                          <a class="nav-link p-1 text-truncate" href="#" onclick="mostrar_cargo_noche()">
                                              <i class="fa fa-fw fa-clock-o"></i> &nbsp; Aplicar Cargo por noche</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_surtir=$usuario->inventario_surtir;
                          if($permisos_surtir>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu3sub2" data-toggle="collapse" data-target="#submenu3sub2"><span>Surtir</span></a>
                                <div class="collapse" id="submenu3sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->inventario_surtir==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_surtir()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Surtir Reportes</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          } 

                          /*$permisos_huesped=$usuario->huesped_ver+$usuario->huesped_agregar;
                          if($permisos_huesped>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu3sub3" data-toggle="collapse" data-target="#submenu3sub3"><span>Huéspedes</span></a>
                                <div class="collapse" id="submenu3sub3" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->huesped_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_huespedes()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Huéspedes</a>
                                          </li>';
                                        }
                                        if($usuario->huesped_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_huespedes()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Huésped</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }*/
                  }
                  
                echo ' 
                </ul>
              </div>
          </li>

          <li class="nav-item">';
                  $permisos_herramientas=$usuario->usuario_ver+$usuario->usuario_agregar+$usuario->forma_pago_ver+$usuario->forma_pago_agregar;
                  if($permisos_herramientas>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu4" data-toggle="collapse" data-target="#submenu4"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1147.000000">
                        <g transform="translate(0.000000,1112.000000) scale(0.100000,-0.100000)">
                        <path d="M6800 11114 c-377 -28 -726 -85 -1100 -182 -74 -19 -147 -37 -162 -40 -16 -2 -28 -8 -28 -12 0 -15 75 -17 125 -4 111 28 287 38 432 25 522 -48 1088 -272 1565 -621 149 -108 387 -349 471 -476 108 -163 158 -289 177 -449 17 -144 -5 -254 -84 -415 l-51 -105 0 -115 c0 -68 6 -136 14 -165 16 -57 65 -161 89 -188 15 -17 13 -20 -19 -51 -19 -19 -496 -457 -1060 -974 l-1027 -940 -778 675 c-429 371 -792 686 -807 699 l-28 24 45 182 c143 575 385 1555 388 1570 2 13 -68 59 -287 189 -1010 599 -1819 1082 -1970 1178 -66 41 -125 76 -132 77 -9 2 -360 -314 -635 -572 l-67 -63 527 -483 c668 -612 776 -711 834 -764 l46 -43 -60 -193 c-33 -106 -68 -220 -78 -253 -37 -121 -119 -381 -127 -404 -9 -23 -45 -33 -483 -147 -453 -118 -475 -123 -494 -106 -10 9 -328 299
                        -704 645 l-685 627 -26 -23 c-377 -343 -610 -560 -614 -571 -3 -8 146 -209 370 -497 386 -497 658 -851 1032 -1346 118 -156 220 -283 228 -283 13 0 79 11 328 55 50 9 141 25 203 36 61 10 163 28 225 39 61 10 164 28 227 39 63 11 167 29 230 40 63 11 167 29 230 40 63 11 169 30 235 41 66 12 143 25 170 30 l50 8 125 -122 c124 -122 951 -926 1023 -995 l37 -37 -437 -384 c-241 -212 -723 -636 -1073 -944 -349 -307 -833 -732 -1074 -945 -893 -785 -1227 -1078 -1452 -1277 -128 -112 -257 -231 -287 -264 -119 -129 -156 -274 -103 -413 29 -78 65 -135 138 -219 60 -69 902 -842 986 -905 70 -53 193 -114 292 -145 61 -19 97 -23 195 -23 139 0 196 14 294 72 63 38 150 121 1456 1383 226 218 489 472 585 565 170 164 292 281 1175 1135 629 609 863 832 870 831 5 0 815 -787 1415
                        -1376 124 -121 495 -484 825 -805 330 -322 787 -767 1015 -990 707 -689 743 -724 810 -772 135 -95 241 -147 390 -188 111 -31 343 -35 458 -7 255 61 473 205 633 417 53 69 132 234 153 320 71 280 -16 562 -241 781 -65 64 -3593 3128 -4362 3789 -132 113 -239 210 -239 215 0 6 276 262 612 570 336 308 806 738 1045 957 l433 397 78 -55 c91 -63 197 -115 290 -140 98 -27 313 -25 449 4 127 27 203 28 305 2 194 -49 340 -165 634 -503 l120 -138 -98 -95 c-79 -77 -103 -108 -131 -167 -32 -67 -34 -79 -34 -172 0 -85 4 -110 28 -170 53 -135 164 -252 302 -316 95 -45 158 -59 266 -59 111 0 192 22 273 74 51 33 892 795 973 882 132 141 149 356 43 535 -53 90 -161 189 -252 233 -104 49 -150 60 -263 60 -103 0 -164 -14 -249 -56 l-38 -19 -25 23 c-50 45 -196 225 -255 313 -33 50
                        -109 187 -168 305 -125 250 -150 295 -233 410 -100 140 -323 397 -428 495 -114 105 -508 474 -594 555 -131 124 -831 778 -890 831 -101 93 -231 192 -369 284 -420 279 -861 438 -1421 511 -116 15 -618 27 -745 18z m4361 -9815 c90 -25 181 -89 234 -161 59 -79 79 -143 79 -248 0 -77 -3 -92 -37 -161 -63 -132 -173 -213 -335 -247 -103 -21 -204 -7 -307 43 -87 42 -120 75 -146 150 -61 174 -17 416 100 547 50 57 105 84 191 96 80 11 135 6 221 -19z"/>
                        </g>
                      </svg> Herramientas</span>
                    </a>
                      <div class="collapse" id="submenu4" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          $permisos_usuario=$usuario->usuario_ver+$usuario->usuario_agregar;
                          if($permisos_usuario>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu4sub1" data-toggle="collapse" data-target="#submenu4sub1"><span>Usuarios</span></a>
                                <div class="collapse" id="submenu4sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->usuario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_usuarios()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Usuarios</a>
                                          </li>';
                                        }
                                        if($usuario->usuario_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_usuarios()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Usuario</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          } 
                                        
                          $permisos_forma_pago=$usuario->forma_pago_ver;
                          if($permisos_forma_pago>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu4sub2" data-toggle="collapse" data-target="#submenu4sub2"><span>Formas Pago</span></a>
                                <div class="collapse" id="submenu4sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->forma_pago_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_formas_pago()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Ver Forma Pago</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_cupon=$usuario->cupon_ver+$usuario->cupon_agregar;
                          if($permisos_cupon>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu4sub3" data-toggle="collapse" data-target="#submenu4sub3"><span>Cupones</span></a>
                                <div class="collapse" id="submenu4sub3" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->cupon_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_cupones()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Cupones</a>
                                          </li>';
                                        }
                                        if($usuario->cupon_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_cupones()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Cupón</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          }

                          $permisos_configuracion= $usuario->nivel;
                          if($permisos_configuracion==0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu4sub4" data-toggle="collapse" data-target="#submenu4sub4"><span>Configuración</span></a>
                                <div class="collapse" id="submenu4sub4" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($permisos_configuracion==0){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="cambiar_imagen()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Cambiar Configuración</a>
                                          </li>';
                                        }
                                        if($permisos_configuracion==0){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="cambiar_archivo()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Cambiar Color</a>
                                          </li>';
                                        }
                                        if($permisos_configuracion==0){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="cambiar_fondo()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Cambiar Fondo</a>
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

          <li class="nav-item">';
                  $permisos_restaurantes=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->restaurante_ver+$usuario->restaurante_agregar;
                  if($permisos_restaurantes>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu5" data-toggle="collapse" data-target="#submenu5"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="18.000000pt" viewBox="0 0 1280.000000 1147.000000">
                        <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
                        <path d="M6620 12781 c-359 -98 -717 -600 -954 -1338 -170 -531 -261 -1116 -273 -1743 -8 -416 13 -603 93 -852 115 -356 300 -596 698 -907 186 -145 255 -211 284 -273 21 -43 22 -57 22 -364 0 -723 -41 -1680 -110 -2554 -29 -357 -61 -698 -135 -1415 -104 -1008 -119 -1175 -137 -1593 -12 -295 -2 -598 28 -831 19 -145 67 -388 95 -472 90 -274 276 -431 514 -432 147 0 261 48 370 158 109 109 161 240 204 515 41 263 46 343 45 785 -1 498 -6 582 -114 1770 -124 1367 -158 1843 -195 2710 -17 404 -40 1511 -33 1624 8 139 69 214 301 372 240 163 374 273 471 389 193 230 299 483 353 836 36 235 19 871 -32 1271 -149 1151 -568 2031 -1088 2288 -148 73 -278 91 -407 56z"/>
                        <path d="M2750 12747 c-69 -155 -152 -890 -205 -1812 -32 -563 -39 -801 -39 -1325 -1 -466 2 -563 17 -667 21 -147 54 -258 113 -376 58 -115 95 -169 261 -378 150 -189 210 -277 253 -374 74 -164 91 -316 71 -596 -7 -90 -46 -515 -87 -944 -151 -1583 -188 -2028 -233 -2780 -41 -678 -46 -830 -46 -1505 0 -731 8 -889 60 -1256 47 -327 99 -468 215 -584 36 -36 88 -78 116 -92 295 -157 652 22 762 382 24 78 66 324 88 510 21 184 29 691 15 964 -17 318 -34 520 -111 1296 -158 1587 -203 2272 -231 3470 -14 602 -9 909 15 995 38 135 93 226 256 420 175 210 286 398 358 610 70 203 87 455 79 1165 -6 502 -10 629 -42 1145 -56 899 -155 1779 -200 1767 -33 -9 -51 -255 -80 -1122 -35 -1048 -60 -1434 -106 -1664 -24 -121 -42 -158 -72 -154 -76 11 -113 387 -137 1388 -30 1273
                        -42 1507 -84 1548 -44 44 -64 -206 -91 -1123 -32 -1072 -56 -1447 -110 -1680 -40 -178 -110 -179 -150 -3 -47 206 -63 544 -75 1572 -12 979 -23 1218 -60 1241 -44 27 -70 -253 -110 -1170 -35 -815 -51 -1083 -76 -1335 -29 -301 -63 -440 -105 -440 -50 0 -82 135 -109 460 -19 229 -30 618 -40 1407 -12 874 -22 1083 -52 1083 -5 0 -18 -19 -28 -43z"/>
                        <path d="M604 12690 c-94 -22 -172 -140 -237 -360 -85 -282 -133 -672 -173 -1392 -21 -366 -30 -2277 -15 -3238 12 -821 16 -860 131 -1291 74 -278 80 -325 80 -603 0 -618 -47 -1445 -120 -2131 -31 -285 -62 -531 -134 -1055 -116 -847 -130 -981 -130 -1320 -1 -294 12 -415 63 -626 54 -218 104 -320 203 -409 239 -215 667 -165 842 99 65 97 114 291 143 556 27 255 8 608 -62 1145 -13 105 -40 309 -59 455 -90 686 -147 1302 -181 1960 -20 406 -38 1099 -33 1340 l4 205 36 105 c20 58 99 238 176 400 192 403 262 584 326 835 85 336 100 603 76 1340 -58 1796 -279 3196 -591 3741 -101 176 -235 271 -345 244"/>
                        </g>
                      </svg> Restaurante</span>
                    </a>
                      <div class="collapse" id="submenu5" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">';

                          $permisos_inventario=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->categoria_ver;
                          if($permisos_inventario>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu5sub1" data-toggle="collapse" data-target="#submenu5sub1"><span>Inventario</span></a>
                                <div class="collapse" id="submenu5sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->inventario_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_inventario()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Inventario</a>
                                          </li>';
                                        }
                                        if($usuario->inventario_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_inventario()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Inventario</a>
                                          </li>';
                                        }
                                        if($usuario->categoria_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_categorias()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Categorias</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          } 

                          $permisos_surtir=$usuario->inventario_surtir;
                          if($permisos_surtir>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu5sub2" data-toggle="collapse" data-target="#submenu5sub2"><span>Surtir</span></a>
                                <div class="collapse" id="submenu5sub2" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        /*if($usuario->inventario_surtir==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_surtir()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Surtir Reportes</a>
                                          </li>';
                                        }*/
                                        if($usuario->inventario_surtir==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="surtir_inventario()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Surtir Inventario</a>
                                          </li>';
                                        }
                                        echo '
                                    </ul>
                                </div>
                            </li>'; 
                          } 
                                        
                          $permisos_restaurante=$usuario->restaurante_ver+$usuario->restaurante_agregar;
                          if($permisos_restaurante>0){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu5sub3" data-toggle="collapse" data-target="#submenu5sub3"><span>Restaurante</span></a>
                                <div class="collapse" id="submenu5sub3" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        /*if($usuario->restaurante_ver==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_restaurante()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Restaurante</a>
                                          </li>';
                                        }*/
                                        if($usuario->restaurante_agregar==1){
                                          echo '
                                          <li class="nav-item">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_restaurante(0,0)">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Restaurante</a>
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

      <a href="#">Otros</a>
         
      <a href="#">
        <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 8 8">
          <path d="M4 0c-1.1 0-2 1.12-2 2.5s.9 2.5 2 2.5 2-1.12 2-2.5-.9-2.5-2-2.5zm-2.09 5c-1.06.05-1.91.92-1.91 2v1h8v-1c0-1.08-.84-1.95-1.91-2-.54.61-1.28 1-2.09 1-.81 0-1.55-.39-2.09-1z"/>
        </svg> '.$usuario->usuario.'
      </a>
          
      <a href="#ventanasalir" data-toggle="modal">
        <svg id="icono_sidenav" class="svg-color" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 8 8">
          <path d="M3 0v1h4v5h-4v1h5v-7h-5zm1 2v1h-4v1h4v1l2-1.5-2-1.5z"/>
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
      <a class="nav-item" href="inicio.php"><span class="glyphicon  glyphicon-cloud"></span> '.$config->nombre.' </a>
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
    /*
    <svg class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1202.000000 1280.000000">
    <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
    <path d="M513 12497 l-512 -302 -1 -6097 0 -6098 5255 0 5255 0 0 545 0 545 751 0 751 0 -79 83 c-167 177 -301 378 -446 667 -260 518 -401 1056 -484 1835 -16 148 -17 509 -20 4643 l-3 4482 -4978 0 -4977 0 -512 -303z m517 -4692 c0 -2764 4 -4244 10 -4358 43 -714 162 -1259 365 -1672 91 -187 175 -313 284 -428 104 -109 182 -170 280 -219 l76 -38 3887 0 3888 0 0 -200 0 -200 -4565 0 -4565 0 0 5554 0 5554 162 96 c89 53 165 96 170 96 4 0 8 -1883 8 -4185z m2540 1550 l0 -965 -925 0 -925 0 0 965 0 965 925 0 925 0 0 -965z m2310 0 l0 -965 -1005 0 -1005 0 0 965 0 965 1005 0 1005 0 0 -965z m2310 0 l0 -965 -1005 0 -1005 0 0 965 0 965 1005 0 1005 0 0 -965z m2095 0 l0 -960 -897 -3 -898 -2 0 965 0 965 898 -2 897 -3 0 -960z m-6715 -2220 l0 -965 -925 0 -925 0 0 965 0 965 925 0 925 0 0 -965z m2310 0 l0 -965 -1005 0 -1005 0 0 958 c0 527 3 962 7 965 3 4 456 7 1005 7 l998 0 0 -965z m2310 0 l0 -965 -1005 0 -1005 0 0 965 0 965 1005 0 1005 0 0 -965z m2095 0 l0 -960 -897 -3 -898 -2 0 965 0 965 898 -2 897 -3 0 -960z m-6715 -1992 c0 -401 3 -833 7 -960 l6 -233 -931 0 -932 0 0 960 0 960 925 0 925 0 0 -727z m2310 -90 c0 -450 3 -882 7 -960 l6 -143 -1005 0 -1005 0 -7 92 c-3 50 -6 482 -6 960 l0 868 1005 0 1005 0 0 -817z m2310 -66 c0 -486 3 -918 6 -960 l7 -77 -1005 0 -1005 0 -7 53 c-3 28 -6 460 -6 960 l0 907 1005 0 1005 0 0 -883z m2100 -77 l0 -960 -897 2 -898 3 -3 958 -2 957 900 0 900 0 0 -960z m-6686 -1302 c3 -24 10 -92 17 -153 63 -632 242 -1224 478 -1582 l61 -93 -970 0 -969 0 -48 60 c-253 312 -409 920 -446 1743 l-3 67 937 0 938 0 5 -42z m2306 25 c0 -103 69 -572 115 -780 90 -405 246 -794 411 -1025 l34 -48 -958 0 -958 0 -46 48 c-314 324 -530 950 -603 1750 l-7 72 1006 0 c951 0 1006 -1 1006 -17z m2324 -155 c67 -665 245 -1256 487 -1615 27 -40 49 -76 49 -78 0 -3 -429 -5 -954 -5 l-954 0 -64 68 c-242 257 -432 722 -528 1297 -29 172 -60 418 -60 475 l0 30 1003 0 1003 0 18 -172z m2063 107 c18 -413 101 -977 198 -1330 29 -108 123 -393 150 -457 7 -17 -32 -18 -733 -18 l-740 0 -47 48 c-107 107 -225 290 -310 480 -150 339 -248 769 -298 1305 l-3 37 891 -2 890 -3 2 -60z"/>
    </g>
    </svg> Reservaciones</span>*/
  }   
?>