<?php

date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class PlanesAlimentos extends ConexionMYSql
{
    
    public $id;
    public $nombre;
    public $costo;
    public $estado;

    // Constructor
    function __construct($id)
    {
      if($id==0){
        $this->id= 0;
        $this->nombre= 0;
        $this->costo= 0;
        $this->estado= 0;
      }else{
        $sentencia = "SELECT * FROM planes_alimentos WHERE id = $id AND estado_plan=1 LIMIT 1 ";
        $comentario="Obtener todos los valores de los planes de alimentos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $this->id= $fila['id'];
            $this->nombre= $fila['nombre_plan'];
            $this->costo= $fila['costo_plan'];
            $this->estado= $fila['estado_plan'];
        }
      }
    }

    function mostrar_planes_select($id=0){
        $sentencia = "SELECT* from planes_alimentos WHERE estado_plan= 1";
        $comentario = "Consulta todos los planes de alimentos disponibles";
        $consulta = $this->realizaConsulta($sentencia, $comentario);
  
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($id==$fila['id']){
            echo '<option selected data-costoplan='.$fila['costo_plan'].' value="'.$fila['id'].'">'.$fila['nombre_plan'].' $'.$fila['costo_plan'].'</option>';
          }else{
            echo '<option data-costoplan='.$fila['costo_plan'].' value="'.$fila['id'].'">'.$fila['nombre_plan'].' $'.$fila['costo_plan'].'</option>';
          }
        }
      }
}