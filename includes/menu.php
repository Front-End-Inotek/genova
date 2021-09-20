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
              <a class="navbar-brand" href="inicio.php"><img src="images/marca_logo.png" height="38" width="45"/></a>
            </li>
            <li class="nav-item dropdown">
              <a class="navbar-brand" href="inicio.php">'.$config->nombre.'</a>
            </li>';
            

            $permisos_usuario=$usuario->usuario_ver+$usuario->usuario_agregar;
            if($permisos_usuario>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reservaciones
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->usuario_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_usuarios()" >Ver Reservaciones</a>';
                    }
                    if($usuario->usuario_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_usuarios()">Agregar Reservacion</a>';
                    }
                    echo '
                  </div>
                </li>';
            }

            $permisos_usuario=$usuario->usuario_ver+$usuario->usuario_agregar;
            if($permisos_usuario>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuario
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->usuario_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_usuarios()" >Ver Usuarios</a>';
                    }
                    if($usuario->usuario_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_usuarios()">Agregar Usuario</a>';
                    }
                    echo '
                  </div>
                </li>';
            }

            $permisos_inventario=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->desperdicio_entrada_ver+$usuario->desperdicio_entrada_agregar+$usuario->desperdicio_salida_ver+$usuario->desperdicio_salida_agregar+$usuario->requisicion_ver+$usuario->requisicion_agregar+$usuario->salida_ver+$usuario->salida_agregar+$usuario->regreso_ver+$usuario->regreso_agregar;
            if($permisos_inventario>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Inventario
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->inventario_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_inventario()">Ver Inventario</a>';
                    }
                    if($usuario->inventario_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_inventario()">Agregar Inventario</a>';
                    }
                    $permisos_productos=$usuario->inventario_ver+$usuario->inventario_agregar;
                    $permisos_requisicion=$usuario->requisicion_ver+$usuario->requisicion_agregar;
                    if($permisos_productos>0 AND $permisos_requisicion>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->requisicion_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_requisiciones()" >Ver Requisiciones</a>';
                    }
                    if($usuario->requisicion_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_requisiciones()">Agregar Requisicion</a>';
                    }
                    $permisos_salida=$usuario->salida_ver+$usuario->salida_agregar;
                    if($permisos_requisicion>0 AND $permisos_salida>0 OR $permisos_productos>0 AND $permisos_salida>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->salida_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_salidas()" >Ver Salidas</a>';
                    }
                    if($usuario->salida_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_salidas()">Agregar Salida</a>';
                    }
                    if($usuario->salida_aprobar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="aprobar_salidas()">Aprobar Salida</a>';
                    }
                    $permisos_regreso=$usuario->regreso_ver+$usuario->regreso_agregar;
                    if($permisos_salida>0 AND $permisos_regreso OR $permisos_requisicion>0 AND $permisos_regreso>0 OR $permisos_productos>0 AND $permisos_regreso>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->regreso_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_regresos()" >Ver Regresos</a>';
                    }
                    if($usuario->regreso_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_regresos(0)">Agregar Regreso</a>';
                    }
                    $permisos_herramienta=$usuario->herramienta_ver+$usuario->herramienta_agregar;
                    if($permisos_regreso>0 AND $permisos_herramienta OR $permisos_salida>0 AND $permisos_herramienta>0 OR $permisos_requisicion>0 AND $permisos_herramienta>0 OR $permisos_productos>0 AND $permisos_herramienta>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->herramienta_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_herramientas()" >Ver Herramientas</a>';
                    }
                    if($usuario->herramienta_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_herramientas()">Agregar Herramienta</a>';
                    }
                    $permisos_desperdicios_entrada=$usuario->desperdicio_entrada_ver+$usuario->desperdicio_entrada_agregar;
                    if($permisos_herramienta>0 AND $permisos_desperdicios_entrada>0 OR $permisos_regreso>0 AND $permisos_desperdicios_entrada>0 OR $permisos_salida>0 AND $permisos_desperdicios_entrada>0 OR $permisos_requisicion>0 AND $permisos_desperdicios_entrada>0 OR $permisos_productos>0 AND $permisos_desperdicios_entrada>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->desperdicio_entrada_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_desperdicios_entrada()">Ver Entrada Desperdicios</a>';
                    }
                    if($usuario->desperdicio_entrada_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_desperdicios_entrada()">Agregar Entrada Desperdicio</a>';
                    }
                    $permisos_desperdicios_salida=$usuario->desperdicio_salida_ver+$usuario->desperdicio_salida_agregar;
                    if($permisos_desperdicios_entrada>0 AND $permisos_desperdicios_salida>0 OR $permisos_herramienta>0 AND $permisos_desperdicios_salida>0 OR $permisos_regreso>0 AND $permisos_desperdicios_salida>0 OR $permisos_salida>0 AND $permisos_desperdicios_salida>0 OR $permisos_requisicion>0 AND $permisos_desperdicios_salida>0 OR $permisos_productos>0 AND $permisos_desperdicios_salida>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->desperdicio_salida_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_desperdicios_salida()">Ver Salida Desperdicios</a>';
                    }
                    if($usuario->desperdicio_salida_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_desperdicios_salida()">Agregar Salida Desperdicio</a>';
                    }
                    echo '
                  </div>
                </li>';
            }

            $permisos_empresa=$usuario->cliente_ver+$usuario->cliente_agregar+$usuario->proveedor_ver+$usuario->proveedor_agregar+$usuario->necesidades_ver+$usuario->necesidades_agregar+$usuario->necesidades_ver+$usuario->necesidades_agregar;
            if($permisos_empresa>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cliente
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->cliente_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_clientes()" >Ver Clientes</a>';
                    }
                    if($usuario->cliente_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_clientes()">Agregar Cliente</a>';
                    }
                    $permisos_cliente=$usuario->cliente_ver+$usuario->cliente_agregar;
                    $permisos_proveedor=$usuario->proveedor_ver+$usuario->proveedor_agregar;
                    if($permisos_cliente>0 AND $permisos_proveedor>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->proveedor_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_proveedores()" >Ver Proveedores</a>';
                    }
                    if($usuario->proveedor_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_proveedores()">Agregar Proveedor</a>';
                    }
                    $permisos_necesidades=$usuario->necesidades_ver+$usuario->necesidades_agregar;
                    if($permisos_proveedor>0 AND $permisos_necesidades>0 OR $permisos_cliente>0 AND $permisos_necesidades>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->necesidades_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_necesidades()" >Ver Requerimientos</a>';
                    }
                    if($usuario->necesidades_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_necesidades()">Agregar Requerimiento</a>';
                    }
                    $permisos_cotizaciones=$usuario->cotizaciones_ver+$usuario->cotizaciones_agregar;
                    if($permisos_necesidades>0 AND $permisos_cotizaciones>0 OR $permisos_proveedor>0 AND $permisos_cotizaciones>0 OR $permisos_cliente>0 AND $permisos_cotizaciones>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->cotizaciones_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_cotizaciones()" >Ver Cotizaciones</a>';
                    }
                    if($usuario->cotizaciones_agregar==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="agregar_cotizaciones(0)">Agregar Cotizacion</a>';
                    }
                    echo '
                  </div> 
                </li>';
            }

            $permisos_reporte=$usuario->servicio_ver+$usuario->logs_ver;
            if($permisos_reporte>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reportes
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->servicio_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_servicios()" >Ver Reportes</a>';
                    }
                    $permisos_servicio=$usuario->servicio_ver;
                    $permisos_logs=$usuario->logs_ver;
                    if($permisos_servicio>0 AND $permisos_logs>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->logs_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_logs()" >Ver Logs</a>';
                    }
                    echo '
                  </div>
                </li>';
            }

            $permisos_reporte=$usuario->servicio_ver+$usuario->logs_ver;
            if($permisos_reporte>0){
              echo '
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Informacion
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if($usuario->servicio_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_servicios()" >Ultimo mes</a>';
                    }
                    $permisos_servicio=$usuario->servicio_ver;
                    $permisos_logs=$usuario->logs_ver;
                    if($permisos_servicio>0 AND $permisos_logs>0){
                      echo '   
                      <div class="dropdown-divider"></div>';
                    }
                    if($usuario->logs_ver==1){
                      echo '
                      <a class="dropdown-item" href="#" onclick="ver_logs()" >Empresa</a>';
                    }
                    echo '
                  </div>
                </li>';
            }
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
                    <h3 class="modal-title"><p><a href="#" class="text-primary">Marca -> Salir</a></p></h3>
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