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
                  $permisos_reservaciones=$usuario->reservacion_ver+$usuario->reservacion_agregar;
                  if($permisos_reservaciones>0){
                    echo '
                    <a class="nav-link collapsed text-truncate" href="#submenu2" data-toggle="collapse" data-target="#submenu2"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">
                      <svg class="svg-color" xmlns="http://www.w3.org/2000/svg"  width="20.000000pt" height="15.000000pt" viewBox="0 0 1280.000000 1147.000000">
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
                            <li class="nav-item" id="submenu2">
                                <a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub1"><span>Reservar</span></a>
                                <div class="collapse" id="submenu1sub1" aria-expanded="false">
                                    <ul class="flex-column nav pl-4">';
                                        if($usuario->reservacion_ver==1){
                                          echo '
                                          <li class="nav-item" id="submenu2">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="ver_reservaciones()">
                                                  <i class="fa fa-fw fa-clock-o"></i> &nbsp; Ver Reservaciones</a>
                                          </li>';
                                        }
                                        if($usuario->reservacion_agregar==1){
                                          echo '
                                          <li class="nav-item" id="submenu2">
                                              <a class="nav-link p-1 text-truncate" href="#" onclick="agregar_reservacioness()">
                                                  <i class="fa fa-fw fa-dashboard"></i> &nbsp; Agregar Reservación</a>
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