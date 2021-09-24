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

// Abre la sidebar
function openNav(){
    document.getElementById("sideNavigation").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

// Cierra la sidebar
function closeNav(){
    document.getElementById("sideNavigation").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

//Habitaciones

// Agregar un tipo de habitacion
function agregar_tipos(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_tipos.php"); 
	closeNav();
}

// Guardar un tipo de habitacion
function guardar_tipo(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	

	if(nombre.length >0){
			//$('#boton_tipo').hide();
			$("#boton_tipo").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_tipo.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_tipos,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra las tipos de habitaciones de la bd
function ver_tipos(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_tipos.php?usuario_id="+usuario_id);
	closeNav();
}

// Editar un tipo de habitacion
function editar_tipo(id){
    $("#area_trabajo_menu").load("includes/editar_tipo.php?id="+id);
}

// Editar un tipo de habitacion
function modificar_tipo(id){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);


    if(id >0){
        //$('#boton_tipo').hide();
			$("#boton_tipo").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_tipo.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_tipos,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Borrar un tipo de habitacion
function borrar_tipo(id){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_tipo.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_tipos,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar un tipo de habitacion
function aceptar_borrar_tipo(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

// Regresar a la pagina anterior de editar un tipo de habitacion
function regresar_editar_tipo(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_tipos.php?usuario_id="+usuario_id);
}

// Agregar una tarifa hospedaje
function agregar_tarifas(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_tarifas.php"); 
	closeNav();
}

// Guardar una tarifa hospedaje
function guardar_tarifa(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var precio_hospedaje= document.getElementById("precio_hospedaje").value;
	var cantidad_hospedaje= document.getElementById("cantidad_hospedaje").value;
	var precio_persona= document.getElementById("precio_persona").value;
	var tipo= document.getElementById("tipo").value;
	

	if(nombre.length >0 && precio_hospedaje >0 && cantidad_hospedaje >0 && precio_persona >0 && tipo >0){
			//$('#boton_tarifa').hide();
			$("#boton_tarifa").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
				  "precio_hospedaje": precio_hospedaje,
				  "cantidad_hospedaje": cantidad_hospedaje,
				  "precio_persona": precio_persona,
				  "tipo": tipo,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_tarifa.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_tarifas,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra las tarifas hospedaje de la bd
function ver_tarifas(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_tarifas.php?usuario_id="+usuario_id);
	closeNav();
}

// Editar una tarifa hospedaje
function editar_tarifa(id){
    $("#area_trabajo_menu").load("includes/editar_tarifa.php?id="+id);
}

// Editar una tarifa hospedaje
function modificar_tarifa(id){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);
	var precio_hospedaje= document.getElementById("precio_hospedaje").value;
	var cantidad_hospedaje= document.getElementById("cantidad_hospedaje").value;
	var precio_persona= document.getElementById("precio_persona").value;
	var tipo= document.getElementById("tipo").value;


    if(id >0 && precio_hospedaje >0 && cantidad_hospedaje >0 && precio_persona >0 && tipo >0){
        //$('#boton_tarifa').hide();
			$("#boton_tarifa").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
			  "precio_hospedaje": precio_hospedaje,
			  "cantidad_hospedaje": cantidad_hospedaje,
			  "precio_persona": precio_persona,
			  "tipo": tipo,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_tarifa.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_tarifas,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Borrar una tarifa hospedaje
function borrar_tarifa(id){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_tarifa.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_tarifas,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar una tarifa hospedaje
function aceptar_borrar_tarifa(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_tarifa.php?id="+id);
}

// Regresar a la pagina anterior de editar un tarifa hospedaje
function regresar_editar_tarifa(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_tarifas.php?usuario_id="+usuario_id);
}

// Agregar una habitacion
function agregar_hab(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_hab.php"); 
	closeNav();
}

// Guardar una habitacion
function guardar_hab(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var tipo= document.getElementById("tipo").value;
	var comentario= encodeURI(document.getElementById("comentario").value);
	

	if(nombre.length >0 && tipo >0){
			//$('#boton_hab').hide();
			$("#boton_hab").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
				  "tipo": tipo,
				  "comentario": comentario,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_hab.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_hab,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra las habitaciones de la bd
function ver_hab(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_hab.php?usuario_id="+usuario_id);
	closeNav();
}

// Editar una habitacion
function editar_hab(id){
    $("#area_trabajo_menu").load("includes/editar_hab.php?id="+id);
}

// Editar una habitacion
function modificar_hab(id){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);
	var tipo= document.getElementById("tipo").value;
	var comentario= encodeURI(document.getElementById("comentario").value);


    if(id >0 && tipo >0){
        //$('#boton_hab').hide();
			$("#boton_hab").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
			  "tipo": tipo,
			  "comentario": comentario,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_hab.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_hab,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Borrar una habitacion
function borrar_hab(id){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_hab.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_hab,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar una habitacion
function aceptar_borrar_hab(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_hab.php?id="+id);
}

// Regresar a la pagina anterior de editar una habitacion
function regresar_editar_hab(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_hab.php?usuario_id="+usuario_id);
}

//
// Muestra la paginacion de los hab de habitaciones
function ver_hab_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_hab").load("includes/ver_tarifas_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Generar reporte de un tarifa hospedaje
function reporte_herramienta(){
	var id=localStorage.getItem("id");
    window.open("includes/reporte_herramienta.php?id="+id);
}

// Barra de diferentes busquedas en ver herramientas
function buscar_herramienta(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_herramienta").load("includes/buscar_herramienta.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);  
}