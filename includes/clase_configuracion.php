<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Configuracion extends ConexionMYSql{
    
    /*public $activacion;
    public $nombre;

    function __construct()
    {
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1 ";
      $comentario="Obtener todos los valores de la configuracion ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           
           $this->activacion= $fila['activacion'];
           $this->nombre= $fila['nombre'];
      }
    }*/
    public $corte;
    public $nombre;
    public $imagen;
    public $pre_ver_corte;
    public $activacion;//
    public $motel;
    public $hospedaje;
    public $placas;
    public $efectivo_caja;
    public $automatizacion;
    public $luz;
    public $credencial_auto;
    public $cortinas;
    public $teclado;
    public $auto_cortinas;
    public $auto_luz;
    public $cancelado;
    public $medio_tiempo;
    public $horas_extra;
    public $canc_antes;
    public $canc_despues;
    public $doble_limpieza;
    public $inventario_corte;
    public $detallado_ticket;
    public $ticket_restaurante;
    public $pantalla_on_off;
    public $puntos;
    public $autocobro;
    public $checkin;

    function __construct()
    {
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1";
      $comentario="Obtener todos los valores de la configuracion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $this->corte= $fila['corte'];
           $this->nombre= $fila['nombre'];
           $this->imagen= $fila['imagen'];
           $this->pre_ver_corte= $fila['pre_ver_corte'];
           $this->activacion= $fila['activacion'];
           $this->motel= $fila['motel'];
           $this->hospedaje= $fila['hospedaje'];
           $this->cancelado= $fila['cancelado'];
           $this->placas= $fila['placas'];
           $this->efectivo_caja= $fila['efectivo_caja'];
           $this->automatizacion= $fila['automatizacion'];
           $this->luz= $fila['luz'];
           $this->credencial_auto= $fila['credencial_auto'];
           $this->cortinas= $fila['cortinas'];
           $this->teclado= $fila['teclado'];
           $this->auto_cortinas= $fila['auto_cortinas'];
           $this->auto_luz= $fila['auto_luz'];
           $this->medio_tiempo= $fila['medio_turno'];
           $this->horas_extra= $fila['horas_extras'];
           $this->canc_antes= $fila['canc_antes'];
           $this->canc_despues= $fila['canc_despues'];
           $this->doble_limpieza= $fila['doble_limpieza'];
           $this->inventario_corte= $fila['inventario_corte'];
           $this->detallado_ticket= $fila['detallado_ticket'];
           $this->ticket_restaurante= $fila['ticket_restaurante'];
           $this->pantalla_on_off= $fila['pantalla_on_off'];
           $this->puntos= $fila['puntos'];
           $this->autocobro= $fila['autocobro'];
           $this->checkin= $fila['checkin'];
      }
    }
    // Guardar la foto de inicio
    function guardar_foto($nombre){
      $sentencia = "UPDATE `configuracion` SET
      `imagen` = '$nombre'
      WHERE `id` = '1';";
      $comentario="Modificar la foto de inicio";
      $this->realizaConsulta($sentencia,$comentario);
    }
    // Guardar el nombre del sistema
    function guardar_nombre($nombre){
      $sentencia = "UPDATE `configuracion` SET
      `nombre` = '$nombre'
      WHERE `id` = '1';";
      $comentario="Modificar el nombre del sistema";
      $this->realizaConsulta($sentencia,$comentario);
    }
    
  }
?>
