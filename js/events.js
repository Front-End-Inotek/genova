x=$(document);
x.ready(inicio);

//Evaluamos el inicio de sesion
function inicio(){
	var x=$("#login");
	x.click(evaluar);
}

// Evaluamos las credenciales para generar el acceso
function evaluar(){
	var user=$("#user").val();
	var pass=$("#pass").val();
	var datos = {
		  "usuario": user,
		  "password": pass,
		};
	 $.ajax({
		  async:true,
		  type: "POST",
		  dataType: "html",
		  contentType: "application/x-www-form-urlencoded",
		  url:"includes/evaluar.php",
		  data:datos,
		  beforeSend:inicioEnvio,
		  success:recibir,
		  timeout:5000,
		  error:problemas
		});
	return false;
}

// Mensaje que se muentra mientras evaluamos
function inicioEnvio(){
    $("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-info"><span class="glyphicon glyphicon-resize-small"></span> Estamos evaluando datos</strong>');
}

// Mensaje que se muestra si ocuerre algun error durante la evaluacion
function problemas(){
$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-danger" ><span class="glyphicon glyphicon-wrench"></span> Problemas en el servidor.</strong>');
}

// Recibimos la info
function recibir(datos){
	//alert(datos);
	//var id=parseInt(datos);
	var res = datos.split("-");
	if(res[0]>0){
		localStorage.setItem("id",res[0]);
		localStorage.setItem("tocken",res[1]);
		document.location.href='inicio.php';
	}else{
		$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-warning"><span class="glyphicon glyphicon-remove"></span> Creo que has escrito mal tu usuario o contraseña </strong>');
	}
}

// Evaluar si la session no a iniciado
function sabernosession(){
	var id=localStorage.getItem("id");
	var token=localStorage.getItem("tocken");
	if(id==null){
		document.location.href='index.php';
	}else{
		id=parseInt(id);
		if(id>0){
			$(".menu").load("includes/menu.php?id="+id+"&token="+token);
			$("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);			
		}
		else{
			document.location.href='index.php';
		}
	}
}

// Salida automatica cuando terminan credenciales
function salida_automatica(){
    salirsession();
    setTimeout("recargar_pagina()",50000);
   // alert("Estamos saliendo ");
}

// Recarga automatica de pagina
function recargar_pagina(){
    location.reload();
}

// Evaluar si la session  
function sabersession(){ 
	var id=localStorage.getItem("id");
	if(id==null){
		$('#entrada_formulario').show();
	}else{
		id=parseInt(id);
		if(id>0){
			document.location.href='inicio.php'; 

		}
	}
}

// Salir de la session 
function salirsession(){
	localStorage.removeItem('id');
    localStorage.removeItem('tocken');
	document.location.href='index.php';
}

// Barra de progreso
function loaderbar(){
	$("#area_trabajo").load("includes/barra_progreso.php");
}

// Barra de progreso en menu
function loaderbar_menu(){
	$("#area_trabajo_menu").load("includes/barra_progreso.php");
}

// Si existe un problema en el proceso
function problemas_sistema(datos){
	alert("Ocurrio algun error en el proceso.  Inf: "+datos.toString());
}



function openNav() {
    document.getElementById("sideNavigation").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("sideNavigation").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

//Habitaciones

// Agregar un tipo
function agregar_tipos(id){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_tipos.php?id="+id); 
    $(".navbar-collapse").collapse('hide');
}

// Guardar una herramienta
function guardar_herramienta(){
    var id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
    var marca= encodeURI(document.getElementById("marca").value);
	var modelo= encodeURI(document.getElementById("modelo").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
    var cantidad_almacen= document.getElementById("cantidad_almacen").value;
    var cantidad_prestadas= document.getElementById("cantidad_prestadas").value;
	

	if(nombre.length >0 && marca.length >0 && modelo.length >0  && cantidad_almacen >=0 && cantidad_prestadas >=0){
			//$('#boton_herramienta').hide();
			$("#boton_herramienta").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
				  "marca": marca,
                  "modelo": modelo,
			      "descripcion": descripcion,
                  "cantidad_almacen": cantidad_almacen,
                  "cantidad_prestadas": cantidad_prestadas,
                  "id": id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_herramienta.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_herramientas,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra las herramientas de la bd
function ver_herramientas(){
    var id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_herramientas.php?id="+id);
    $(".navbar-collapse").collapse('hide');
}

// Muestra la paginacion de las herramientas
function ver_herramientas_paginacion(buton,posicion){
    //alert(id);
    var id=localStorage.getItem("id");
    $("#paginacion_herramientas").load("includes/ver_herramientas_paginacion.php?posicion="+posicion+"&id="+id);   
}

// Barra de diferentes busquedas en ver herramientas
function buscar_herramienta(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_herramienta").load("includes/buscar_herramienta.php?a_buscar="+a_buscar+"&id="+id);  
}

// Editar una herramienta
function editar_herramienta(id){
    $("#area_trabajo_menu").load("includes/editar_herramienta.php?id="+id);
}

// Editar una herramienta
function modificar_herramienta(id){
    var herramienta_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
    var marca= encodeURI(document.getElementById("marca").value);
    var modelo= encodeURI(document.getElementById("modelo").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
    var cantidad_almacen= document.getElementById("cantidad_almacen").value;
    var cantidad_prestadas= document.getElementById("cantidad_prestadas").value;
   

    if(id >0){
        //$('#boton_herramienta').hide();
			$("#boton_herramienta").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
			  "marca": marca,
              "modelo": modelo,
			  "descripcion": descripcion,
              "cantidad_almacen": cantidad_almacen,
              "cantidad_prestadas": cantidad_prestadas,
              "herramienta_id": herramienta_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_herramienta.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_herramientas,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Generar reporte de herramienta
function reporte_herramienta(){
	var id=localStorage.getItem("id");
    window.open("includes/reporte_herramienta.php?id="+id);
}

// Borrar una herramienta
function borrar_herramienta(id){
    var herramienta_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
                "herramienta_id": herramienta_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_herramienta.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_herramientas,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar herramienta
function aceptar_borrar_herramienta(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_herramienta.php?id="+id);
}

// Regresar a la pagina anterior de editar herramienta
function regresar_editar_herramienta(){
    var id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_herramientas.php?id="+id);
}