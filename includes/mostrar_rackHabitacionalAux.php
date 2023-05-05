

<?php

include_once('consulta.php');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_ES");

class RackHabitacional extends ConexionMYSql{
function mostrar($id){
include_once("clase_cuenta.php");
include('clase_movimiento.php');

$cuenta= NEW Cuenta(0);
$movimiento= NEW movimiento(0);
$cronometro=0;

//Se utiliza la misma consulta para el rack de operaciones
$sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre 
AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id 
LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 ORDER BY id";
$comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
$consulta= $this->realizaConsulta($sentencia,$comentario);


echo '
<!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
<!--tabla operativa--->

    <div class="headTable justify-content-center align-items-center">
        <div style="text-align:center;">
        <div>
            <h3>Marzo 2023<button id="btn-mes">▾</button></h3>
        </div>
        </div>
    </div>


<!-- DISPLAY USER-->
<div class="table-responsive" style="margin-left: -10px !important;">
    <div id="cal-largo">
    <div class="cal-sectionDiv">

        <table class="tableRack table-striped table-bordered" id="tablaTotal">
        <thead class="cal-thead">
            <tr>
            <th class="cal-viewmonth" id="changemonth"></th>';
            $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD
            $fecha_final = date('Y-m-d', strtotime('+32 days')); // Obtiene la fecha actual más 32 días en formato YYYY-MM-DD
            $fecha = $fecha_actual; // Se guarda la fecha actual en una nueva variable
            $contador = 0;
            $total_dias = 32;   //En una nueva variable guardamos el total de dias
            $yesterday =  date('j', strtotime('-1 day'));

            $diaAnterior = date('d-m-Y',strtotime('-1 day'));
            $diaAnteriorString  = strtotime('-1 day');
            $fechaFinalString = strtotime('+32 days');
            echo($diaAnteriorString) . "\n";
            echo $fechaFinalString;
            // echo $daybefore;

            $dia = date('N', strtotime($fecha));

            $diaanterior = date('N', strtotime('-1 day'));

            switch ($diaanterior) {
                case 1:
                    echo "<th class='cal-dia'> LUNES ". $yesterday ."</th>";
                break;

                case 2:
                    echo "<th class='cal-dia'> MARTES ". $yesterday ."</th>";
                break;

                case 3:
                    echo "<th class='cal-dia'> MIERCOLES ". $yesterday ."</th>";
                break;

                case 4:
                    echo "<th class='cal-dia'> JUEVES ". $yesterday ."</th>";
                break;

                case 5:
                    echo "<th class='cal-dia'> VIERNES ". $yesterday ."</th>";
                break;

                case 6:
                    echo "<th class='cal-dia'> SABADO ". $yesterday ."</th>";
                break;

                case 7:
                    echo "<th class='cal-dia'> DOMINGO ". $yesterday ."</th>";
                break;

                default:
                    # code...
                    break;
            }
	    $aux_fecha_final = date('Y-m-d',strtotime($fecha_final . '+1 day'));
            while ($fecha <= $aux_fecha_final) {
            switch ($dia) {
                case 1:
                    echo "<th class='cal-dia'> LUNES ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 2:
                    echo "<th class='cal-dia'> MARTES ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 3:
                    echo "<th class='cal-dia'> MIERCOLES ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 4:
                    echo "<th class='cal-dia'> JUEVES ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 5:
                    echo "<th class='cal-dia'> VIERNES ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 6:
                    echo "<th class='cal-dia'> SABADO ". date('j', strtotime($fecha)) ."</th>";
                break;

                case 7:
                    echo "<th class='cal-dia'> DOMINGO ". date('j', strtotime($fecha)) ."</th>";
                break;

                default:
                    # code...
                    break;
            }

            $fecha = date('Y-m-d', strtotime($fecha . ' +1 day'));	
	    $dia = date('N', strtotime($fecha));
            $contador++;

            }
            echo'
            </tr>
        </thead>';
        $contador_row=0;
        //Ciclo while que nos mostrara todas las habitaciones habilitadas y los estados de estas
        while ($fila = mysqli_fetch_array($consulta))
        {

        //obtener todos los movimientos de esa habitación en base al día anterior y hasta el 'ultimo' día.

    

        //Se definen los estados de las habitaciones
        $total_faltante= 0.0;
        $estado="no definido";
        switch($fila['estado']) {
            case 0:
            $estado= "Disponible limpia";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 1:
            $estado= "Ocupado";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            break;

            case 2:
            $estado= "Vacia sucia";
            $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
            break;

            case 3:
            $estado= "Vacia limpia";
            $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            break;

            case 4:
            $estado= "Sucia ocupada";
            $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
            break;

            case 5:
            $estado="Ocupada limpieza";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            break;

            case 6:
            $estado="Reserva pagada";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 7:
            $estado= "Reserva pendiente";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 8:
            $estado= "Uso casa";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 9:
            $estado="Mantenimiento";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            case 10:
            $estado="Bloqueo";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            default:
            //echo "Estado indefinido";
            break;
        }
        echo "crono " . $cronometro;
        $movimientosHabiles = $movimiento->saberMovimientosHabiles($diaAnteriorString,$cronometro);
        //Se añade en el cuerpo de la tabla la numeracion de las habitaciones
        if($fila['tipo']>0){
        echo'
        <tbody class="cal-tbody">
            <tr id="u1">
                <td class="cal-userinfo">';
                    echo'Habitación ';
                    if($fila['id']<100){
                        echo $fila['nombre'];
                    }else{
                        echo $fila['comentario'];
                    }
        echo'
                </td>';

// Se decide por las habitaciones vacias
    $fecha_salida= $movimiento->ver_fecha_salida($fila['moviemiento']);

    $fecha_salidaAux=$fecha_salida;
    $fecha_entradaAux = $movimiento->ver_fecha_entrada($fila['moviemiento']);
    $fecha_salidaAux = date('d-m-Y',strtotime($fecha_salidaAux));
    $fecha_entradaAux= date('d-m-Y',strtotime($fecha_entradaAux));




        if ($fila['estado'] == 0) {
            echo'
            <td class="celdaCompleta">
                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >
                    <div class="medioDia">
                    <section class="task task--disponible-limpia" >
                        <a> '. $estado . '<br></a>
                    </section>
                    </div>
                    <div class="medioDia">
                    <section class="task task--disponible-limpia" >
                        <a> '. $estado . '<br> </a>
                    </section>
                    </div>
                </div>
            </td>
            ';
        }elseif($fecha_salida < 0){
            echo'
            <td class="celdaCompleta">

            </td>
            ';
        }
        elseif($fecha_salida > 0){
            // print_r($fecha_entrada);
            // print_r($fecha_salida);
            //  die();
            $cw=0;
    $aux_fecha_actual = date('d-m-Y',strtotime($fecha_actual));
   echo $daybefore;
   echo $fecha_salidaAux;
    
while(strtotime($daybefore)<= strtotime($fecha_salidaAux)) {
while ($habil = mysqli_fetch_array($movimientosHabiles)) {
}
   
    // die("si");
    // echo $fecha;
    // echo $fecha_entrada;
    if($fecha_entradaAux==$daybefore || $fecha_salidaAux == $daybefore) {
      
       
        // }



        // for ($i=0; $i < $total_dias+2; $i++) {
        # code...
        echo'
                <td class="celdaCompleta">';
        //Segunda columna que muesta los estados de las habitaciones
        //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
        echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
        //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
        switch($estado) {
            case "Vacia limpia":
                echo'<section class="task task--limpieza-vacia">';
                break;

            case "Vacia sucia":
                echo'<section class="task task--vacia-sucia" title="aqui mas informacion">';
                break;

            case "Ocupado":
                echo'<section class="task task--ocupadoH">';
                break;

            case "Sucia ocupada":
                echo'<section class="task task--ocupada-sucia">';
                break;

            case "Ocupada limpieza":
                echo'<section class="task task--limpieza-ocupada">';
                break;

            case "Reserva pagada":
                echo'<section class="task task--reserva-pagada">';
                break;

            case "Reserva pendiente":
                echo'<section class="task task--reserva-pendiente-pago ajuste">';
                break;

            case "Uso casa":
                echo'<section class="task task--uso-casa">';
                break;

            case "Mantenimiento":
                echo'<section class="task task task--mantenimiento ajuste-2dias">';
                break;

            case "Bloqueo":
                echo'<section class="task task--bloqueado">';
                break;

            default:
                //echo "Estado indefinido";
                break;
        }
        echo '<a> '. $estado .'<br> </a>';
        echo '<a> '. substr($fecha_salida, 0, -8) .'<br> </a>';

        //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
        echo '</section>
                    </div>
                </td>';
        
            $daybefore = date('d-m-Y', strtotime($daybefore.'+1 day'));
            $fecha_entradaAux = date('d-m-Y', strtotime($fecha_entradaAux.'+1 day'));
        

      
       
      
    }else{
        // if($cw>0){
        //     echo "??";
        //     die();
        // }
        // echo "no es igual";
        
        echo'
        <td class="celdaCompleta">

        </td>
        ';
    
             $daybefore = date('d-m-Y', strtotime($daybefore.'+1 day'));
            // echo $aux_fecha_actual;
          
            
           
           
       
    }
    $cw++;
}
        }
                echo '
            </tr>
        </tbody>';
        }else{
            //echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
        }

        $daybefore = date('d-m-Y',strtotime('-1 day')); 
        $fecha_salidaAux="";
        $fecha_entradaAux="";
        $contador_row++;
        // echo $contador_row;
            }
        echo'</table>
        </div>
    </div>
</div>';
        }
    }

    $c = new RackHabitacional();
    // $c->mostrar(0);


?>


<!DOCTYPE html>
      <html lang="es">
          <head>
            
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
            <link rel="icon" href="favicon.ico" type="image/x-icon">

            <!-- bootstrap 5  -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />

            <!-- BOX ICONS CSS-->
            <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet"/>

            <link rel=stylesheet href="styles/nuevo/estilosBotones.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/navDesplegable.css" type="text/css">
            <link rel=stylesheet href="styles/nuevo/rackHabitacional.css" type="text/css">

            <script src="js/rackHabitacional.js"></script>
            <script src="js/navDesplegable.js"></script>
            <script src="js/scriptBotones.js"></script>
            <script src="js/sweetalert.min.js"></script>

            <!--link css-->
            <link rel=stylesheet href="styles/estilos.css" type="text/css">
            <link rel=stylesheet href="styles/estado0.css" type="text/css">
            <link rel=stylesheet href="styles/estado1.css" type="text/css">
            <link rel=stylesheet href="styles/estado2.css" type="text/css">
            <link rel=stylesheet href="styles/estado3.css" type="text/css">
            <link rel=stylesheet href="styles/estado4.css" type="text/css">
            <link rel=stylesheet href="styles/estado5.css" type="text/css">
            <link rel=stylesheet href="styles/estado6.css" type="text/css">
            <link rel=stylesheet href="styles/subestados.css" type="text/css">


            <script src="js/events.js"></script>


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

          </head>
    <body class="context" onload="sabernosession()">
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
      </ul>
</div >
    
      <div class="menu"></div>
      
      <div id="pie" class="footer"></div>
      <div id="area_trabajo" class="container-fluid"></div>
      <div id="area_trabajo_menu" class="container-fluid">
      </div>
      

      


    </div>
    
      <!-- Modal -->
              <div id="caja_herramientas" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content" id="mostrar_herramientas">

                  </div>

                </div>
              </div>
    </body>