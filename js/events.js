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

//
function mostrar_herramientas(hab_id,estado,nombre){ 
	var id=localStorage.getItem("id");
	$("#mostrar_herramientas").load("includes/mostrar_herramientas.php?hab_id="+hab_id+"&id="+id+"&estado="+estado+"&nombre="+nombre+"&id="+id);
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
	var codigo= encodeURI(document.getElementById("codigo").value);
	

	if(nombre.length >0){
			//$('#boton_tipo').hide();
			$("#boton_tipo").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
				  "codigo": codigo,
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
	var codigo= encodeURI(document.getElementById("codigo").value);


    if(id >0){
        //$('#boton_tipo').hide();
			$("#boton_tipo").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
			  "codigo": codigo,
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
	var precio_adulto= document.getElementById("precio_adulto").value;
	var precio_junior= document.getElementById("precio_junior").value;
	var precio_infantil= document.getElementById("precio_infantil").value;
	var tipo= document.getElementById("tipo").value;
	

	if(nombre.length >0 && precio_hospedaje >0 && cantidad_hospedaje >0 && precio_adulto >0 && tipo >0){
			//$('#boton_tarifa').hide();
			$("#boton_tarifa").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "nombre": nombre,
				  "precio_hospedaje": precio_hospedaje,
				  "cantidad_hospedaje": cantidad_hospedaje,
				  "precio_adulto": precio_adulto,
				  "precio_junior": precio_junior,
				  "precio_infantil": precio_infantil,
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
	var precio_adulto= document.getElementById("precio_adulto").value;
	var precio_junior= document.getElementById("precio_junior").value;
	var precio_infantil= document.getElementById("precio_infantil").value;
	var tipo= document.getElementById("tipo").value;


    if(id >0 && precio_hospedaje >0 && cantidad_hospedaje >0 && precio_adulto >0 && tipo >0){
        //$('#boton_tarifa').hide();
			$("#boton_tarifa").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "nombre": nombre,
			  "precio_hospedaje": precio_hospedaje,
			  "cantidad_hospedaje": cantidad_hospedaje,
			  "precio_adulto": precio_adulto,
			  "precio_junior": precio_junior,
			  "precio_infantil": precio_infantil,
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

// Agregar una reservacion
function agregar_reservaciones(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_reservaciones.php"); 
	closeNav();
}

// Calculamos la cantidad de noches de una reservacion
function calcular_noches(){
    var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
    document.getElementById("noches").value = noches;
}

// Calculo para obtener la cantidad de noches de una reservacion
function calculo_noches(fecha_entrada,fecha_salida){
	var noches= 0;
	var fecha_entrada = new Date(fecha_entrada);
    var fecha_salida = new Date(fecha_salida);
	var dias_en_milisegundos = 86400000;
	var diff_en_milisegundos = fecha_salida - fecha_entrada;
	noches= diff_en_milisegundos / dias_en_milisegundos;
    return Number(noches);
}

// Conseguimos la cantidad de adultos permitidos por tarifa hospedaje
function cambiar_adultos(hab_id){
    var tarifa= document.getElementById("tarifa").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= document.getElementById("numero_hab").value;
    $(".div_adultos").html('<div class="spinner-border text-primary"></div>');
    $(".div_adultos").load("includes/cambiar_tarifa.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&hab_id="+hab_id);  
    //alert("Cambiando tarifa "+tarifa);
}

// Calculamos el total de una reservacion
function calcular_total(precio_hospedaje,total_adulto,total_junior,total_infantil){
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= document.getElementById("numero_hab").value;
	var tarifa= document.getElementById("tarifa").value;
    var extra_adulto= document.getElementById("extra_adulto").value;
	var extra_junior= document.getElementById("extra_junior").value;
	var extra_infantil= document.getElementById("extra_infantil").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var descuento= Number(document.getElementById("descuento").value);
    
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;

	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	var total= total_hab + total_suplementos;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	document.getElementById("total_hab").value= total_hab;
	document.getElementById("total").value= calculo_descuento;
}

// Realiza un descuento de nuestros calculos
function descuento_total(total,descuento){
    var calculo_descuento= (descuento*total) / 100;
	calculo_descuento= total - calculo_descuento;
    return Number(calculo_descuento);
}

// Redondea los decimales de nuestros calculos
function redondearDecimales(numero,decimales){
    numeroRegexp= new RegExp('\\d\\.(\\d){' + decimales + ',}'); // Expresion regular para numeros con un cierto numero de decimales o mas
    if(numeroRegexp.test(numero)) { // Ya que el numero tiene el numero de decimales requeridos o mas, se realiza el redondeo
        return Number(numero.toFixed(decimales));
    }else{
		return Number(numero.toFixed(decimales)) === 0 ? 0 : numero; // En valores muy bajos, se comprueba si el numero es 0 (con el redondeo deseado), si no lo es se devuelve el numero otra vez.
    }
}

// Modal para asignar huesped en una reservacion
function asignar_huesped(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
    $("#mostrar_herramientas").load("includes/modal_asignar_huesped.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil);
}

// Busco el huesped asignar a la reservacion
function buscar_asignar_huesped(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
	$("#tabla_huesped").load("includes/buscar_asignar_huesped.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil+"&a_buscar="+a_buscar);
}

// Aceptar asignar un huesped en una reservacion
function aceptar_asignar_huesped(id,funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
	$('#caja_herramientas').modal('hide');
	document.getElementById("id_huesped").value= id;
	//document.getElementById("nombre_huesped").value= nombre;
	if(funcion == 0){// Corresponde a agregar una reservacion
		calcular_total(precio_hospedaje,total_adulto,total_junior,total_infantil);
	}else{// Corresponde a editar una reservacion
		calcular_total_editar(precio_hospedaje,total_adulto,total_junior,total_infantil);
	}
	$('.div_datos').show();
	$('.boton_datos').show();
	$('.div_container').hide();
}

// Mostrar u ocultar los datos de un huesped en una reservacion
function mostrar_datos(){
	$('.div_datos').hide();
	$('.boton_datos').hide();
	//$('.div_oculto').show();
	var id_huesped= document.getElementById("id_huesped").value;
	var id= id_huesped;
	$(".div_oculto").html('<div class="spinner-border text-primary"></div>');
    $(".div_oculto").load("includes/editar_huesped_reservar.php?id="+id); 
}

// Guardar una reservacion
function guardar_reservacion(precio_hospedaje,total_adulto,total_junior,total_infantil,cantidad_hospedaje,hab_id){
    var usuario_id=localStorage.getItem("id");
	var id_huesped= document.getElementById("id_huesped").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= Number(document.getElementById("numero_hab").value);
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
	var extra_junior= Number(document.getElementById("extra_junior").value);
	var extra_infantil=Number(document.getElementById("extra_infantil").value);
	var extra_menor= Number(document.getElementById("extra_menor").value);
	var tarifa= Number(document.getElementById("tarifa").value);
	var nombre_reserva= encodeURI(document.getElementById("nombre_reserva").value);
	var acompanante= encodeURI(document.getElementById("acompanante").value);
	var forma_pago= document.getElementById("forma_pago").value;
	var limite_pago= document.getElementById("limite_pago").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var forzar_tarifa= Number(document.getElementById("forzar_tarifa").value);
	var descuento= Number(document.getElementById("descuento").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	var total= total_hab + total_suplementos;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	total= calculo_descuento;
	//console.log(fecha_entrada);
	/*alert(fecha_entrada);
	alert(fecha_salida);
	alert(noches);
	alert(numero_hab);
	alert(tarifa);
	alert(cantidad_hospedaje);
	alert(extra_adulto);
	alert(extra_junior);
	alert(extra_infantil);
	alert(extra_menor);
	alert(suplementos);
	alert(total_suplementos);
	alert(total_hab);
	alert(forzar_tarifa);
	alert(descuento);
	alert(total);*/
	

	if(id_huesped >0 && fecha_entrada.length >0 && fecha_salida.length >0 && noches >0 && numero_hab >0 && tarifa >0 && nombre_reserva.length >0 && forma_pago >0 && limite_pago >0 && descuento >-0.01 && descuento <100){
			//$('#boton_reservacion').hide();
			$("#boton_reservacion").html('<div class="spinner-border text-primary"></div>');
			var datos = {
			      "id_huesped": id_huesped,
				  "fecha_entrada": fecha_entrada,
				  "fecha_salida": fecha_salida,
				  "noches": noches,
				  "numero_hab": numero_hab,
				  "precio_hospedaje": precio_hospedaje,
				  "cantidad_hospedaje": cantidad_hospedaje,
				  "extra_adulto": extra_adulto,
				  "extra_junior": extra_junior,
				  "extra_infantil": extra_infantil,
				  "extra_menor": extra_menor,
				  "tarifa": tarifa,
				  "nombre_reserva": nombre_reserva,
				  "acompanante": acompanante,
				  "forma_pago": forma_pago,
				  "limite_pago": limite_pago,
				  "suplementos": suplementos,
				  "total_suplementos": total_suplementos,
				  "total_hab": total_hab,
				  "forzar_tarifa": forzar_tarifa,
				  "descuento": descuento,
				  "total": total,
				  "hab_id": hab_id,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_reservacion.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_reservaciones,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos o descuento no permitido");
			}
}

// Muestra las reservaciones de la bd
function ver_reservaciones(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id);
	closeNav();
}

// Muestra la paginacion de las reservaciones
function ver_reservaciones_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_reservaciones").load("includes/ver_reservaciones_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Barra de diferentes busquedas en ver reservaciones*
function buscar_reservacion(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/buscar_reservacion.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);  
}

// Busqueda por fecha en ver reservaciones
function busqueda_reservacion(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    var id=localStorage.getItem("id");
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/busqueda_reservacion.php?inicial="+inicial+"&final="+final+"&id="+id);
}

// Editar una reservacion
function editar_reservacion(id){
    $("#area_trabajo_menu").load("includes/editar_reservacion.php?id="+id);
}

// Conseguimos la cantidad de adultos permitidos por tarifa hospedaje al editarla
function cambiar_adultos_editar(id){
    var tarifa= document.getElementById("tarifa").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= document.getElementById("numero_hab").value;
    $(".div_adultos_editar").html('<div class="spinner-border text-primary"></div>');
    $(".div_adultos_editar").load("includes/cambiar_tarifa_editar.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&id="+id);  
}

// Calculamos el total de una reservacion al editarla
function calcular_total_editar(precio_hospedaje,total_adulto,total_junior,total_infantil){
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= document.getElementById("numero_hab").value;
	var tarifa= document.getElementById("tarifa").value;
    var extra_adulto= document.getElementById("extra_adulto").value;
	var extra_junior= document.getElementById("extra_junior").value;
	var extra_infantil= document.getElementById("extra_infantil").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var descuento= Number(document.getElementById("descuento").value);
    
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;

	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	var total= total_hab + total_suplementos;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	/*document.getElementById("noches").value= noches;
	document.getElementById("tarifa").value= tarifa;
	document.getElementById("numero_hab").value= numero_hab;*/
	document.getElementById("total_hab").value= total_hab;
	document.getElementById("total").value= calculo_descuento;
}

// Editar una reservacion
function modificar_reservacion(id,precio_hospedaje,total_adulto,total_junior,total_infantil,cantidad_hospedaje){
	var usuario_id=localStorage.getItem("id");
	var id_huesped= document.getElementById("id_huesped").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= Number(document.getElementById("numero_hab").value);
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
	var extra_junior= Number(document.getElementById("extra_junior").value);
	var extra_infantil=Number(document.getElementById("extra_infantil").value);
	var extra_menor= Number(document.getElementById("extra_menor").value);
	var tarifa= Number(document.getElementById("tarifa").value);
	var nombre_reserva= encodeURI(document.getElementById("nombre_reserva").value);
	var acompanante= encodeURI(document.getElementById("acompanante").value);
	var forma_pago= document.getElementById("forma_pago").value;
	var limite_pago= document.getElementById("limite_pago").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var forzar_tarifa= Number(document.getElementById("forzar_tarifa").value);
	var descuento= Number(document.getElementById("descuento").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	var total= total_hab + total_suplementos;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	total= calculo_descuento;


	if(id >0 && id_huesped >0 && fecha_entrada.length >0 && fecha_salida.length >0 && noches >0 && numero_hab >0 && tarifa >0 && nombre_reserva.length >0 && forma_pago.length >0 && limite_pago >0 && descuento >-0.01 && descuento <100){
        //$('#boton_reservacion').hide();
			$("#boton_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
			  "id": id,
			  "id_huesped": id_huesped,
              "fecha_entrada": fecha_entrada,
			  "fecha_salida": fecha_salida,
			  "noches": noches,
			  "numero_hab": numero_hab,
			  "precio_hospedaje": precio_hospedaje,
			  "cantidad_hospedaje": cantidad_hospedaje,
			  "extra_adulto": extra_adulto,
			  "extra_junior": extra_junior,
			  "extra_infantil": extra_infantil,
			  "extra_menor": extra_menor,
			  "tarifa": tarifa,
			  "nombre_reserva": nombre_reserva,
			  "acompanante": acompanante,
			  "forma_pago": forma_pago,
			  "limite_pago": limite_pago,
			  "suplementos": suplementos,
			  "total_suplementos": total_suplementos,
			  "total_hab": total_hab,
			  "forzar_tarifa": forzar_tarifa,
			  "descuento": descuento,
			  "total": total,
			  "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_reservacion.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_reservaciones,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos o descuento no permitido");
    }    
}

// Borrar una reservacion
function borrar_reservacion(id){
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
                url:"includes/borrar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_reservaciones,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar una reservacion
function aceptar_borrar_reservacion(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_reservacion.php?id="+id);
}

// Regresar a la pagina anterior de editar un reservacion
function regresar_editar_reservacion(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id);
}

// Agregar un huesped
function agregar_huespedes(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_huespedes.php"); 
	closeNav();
}

// Guardar un huesped
function guardar_huesped(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var apellido= encodeURI(document.getElementById("apellido").value);
	var direccion= encodeURI(document.getElementById("direccion").value);
	var ciudad= encodeURI(document.getElementById("ciudad").value);
	var estado= encodeURI(document.getElementById("estado").value);
	var codigo_postal= encodeURI(document.getElementById("codigo_postal").value);
	var telefono= encodeURI(document.getElementById("telefono").value);
	var correo= encodeURI(document.getElementById("correo").value);
	var contrato= encodeURI(document.getElementById("contrato").value);
	var cupon= encodeURI(document.getElementById("cupon").value);
	var preferencias= encodeURI(document.getElementById("preferencias").value);
	var comentarios= encodeURI(document.getElementById("comentarios").value);
	var titular_tarjeta= encodeURI(document.getElementById("titular_tarjeta").value);
	var tipo_tarjeta= encodeURI(document.getElementById("tipo_tarjeta").value);
	var numero_tarjeta= encodeURI(document.getElementById("numero_tarjeta").value);
	var vencimiento_mes= encodeURI(document.getElementById("vencimiento_mes").value);
	var vencimiento_ano= encodeURI(document.getElementById("vencimiento_ano").value);
	var cvv= encodeURI(document.getElementById("cvv").value);
	

	if(nombre.length >0 && apellido.length >0 && direccion.length >0 && ciudad.length >0 && estado.length >0 && codigo_postal.length >0 && telefono.length >0 && correo.length >0 && preferencias.length >0 && comentarios.length >0){
			//$('#boton_huesped').hide();
			$("#boton_huesped").html('<div class="spinner-border text-primary"></div>');
			var datos = {
			 	  "nombre": nombre,
				  "apellido": apellido,
				  "direccion": direccion,
				  "ciudad": ciudad,
				  "estado": estado,
				  "codigo_postal": codigo_postal,
				  "telefono": telefono,
				  "correo": correo,
				  "contrato": contrato,
				  "cupon": cupon,
				  "preferencias": preferencias,
				  "comentarios": comentarios,
				  "titular_tarjeta": titular_tarjeta,
				  "tipo_tarjeta": tipo_tarjeta,
				  "numero_tarjeta": numero_tarjeta,
				  "vencimiento_mes": vencimiento_mes,
				  "vencimiento_ano": vencimiento_ano,
				  "cvv": cvv,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_huesped.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_huespedes,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos o descuento no permitido");
			}
}

// Muestra los huespedes de la bd
function ver_huespedes(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_huespedes.php?usuario_id="+usuario_id);
	closeNav();
}

// Muestra la paginacion de los huespedes
function ver_huespedes_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_huespedes").load("includes/ver_huespedes_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Barra de diferentes busquedas en ver huespedes
function buscar_huesped(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_huesped").load("includes/buscar_huesped.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);  
}

// Busqueda por fecha en ver huespedes
function busqueda_huesped(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    var id=localStorage.getItem("id");
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_huesped").load("includes/busqueda_huesped.php?inicial="+inicial+"&final="+final+"&id="+id);
}

// Editar un huesped
function editar_huesped(id){
    $("#area_trabajo_menu").load("includes/editar_huesped.php?id="+id);
}

// Editar un huesped
function modificar_huesped(id){
	var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
    var apellido= encodeURI(document.getElementById("apellido").value);
    var direccion= encodeURI(document.getElementById("direccion").value);
    var ciudad= encodeURI(document.getElementById("ciudad").value);
    var estado= encodeURI(document.getElementById("estado").value);
    var codigo_postal= encodeURI(document.getElementById("codigo_postal").value);
    var telefono= encodeURI(document.getElementById("telefono").value);
    var correo= encodeURI(document.getElementById("correo").value);
    var contrato= encodeURI(document.getElementById("contrato").value);
	var cupon= encodeURI(document.getElementById("cupon").value);
	var preferencias= encodeURI(document.getElementById("preferencias").value);
	var comentarios= encodeURI(document.getElementById("comentarios").value);
	var titular_tarjeta= encodeURI(document.getElementById("titular_tarjeta").value);
	var tipo_tarjeta= encodeURI(document.getElementById("tipo_tarjeta").value);
	var numero_tarjeta= encodeURI(document.getElementById("numero_tarjeta").value);
	var vencimiento_mes= encodeURI(document.getElementById("vencimiento_mes").value);
	var vencimiento_ano= encodeURI(document.getElementById("vencimiento_ano").value);
	var cvv= encodeURI(document.getElementById("cvv").value);


	if(id >0){
        //$('#boton_huesped').hide();
			$("#boton_huesped").html('<div class="spinner-border text-primary"></div>');
        var datos = {
			  "id": id,
              "nombre": nombre,
              "apellido": apellido,
              "direccion": direccion,
              "ciudad": ciudad,
              "estado": estado,
              "codigo_postal": codigo_postal,
              "telefono": telefono,
              "correo": correo,
              "contrato": contrato,
			  "cupon": cupon,
			  "preferencias": preferencias,
			  "comentarios": comentarios,
			  "titular_tarjeta": titular_tarjeta,
			  "tipo_tarjeta": tipo_tarjeta,
			  "numero_tarjeta": numero_tarjeta,
			  "vencimiento_mes": vencimiento_mes,
			  "vencimiento_ano": vencimiento_ano,
			  "cvv": cvv,
			  "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_huesped.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_huespedes,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos o descuento no permitido");
    }    
}

// Borrar un huesped
function borrar_huesped(id){
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
                url:"includes/borrar_huesped.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_huespedes,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar un huesped
function aceptar_borrar_huesped(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_huesped.php?id="+id);
}

// Regresar a la pagina anterior de editar un huesped
function regresar_editar_huesped(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_huespedes.php?usuario_id="+usuario_id);
}

//***// ESTADOS DE RACKS //***//

// Agregar una reservacion en la habitacion
function disponible_asignar(hab_id,estado){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_reservaciones.php?hab_id="+hab_id+"&estado="+estado); 
	$('#caja_herramientas').modal('hide');
}

//*//
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

// Generar reporte de cargo por noche
function reporte_cargo_noche(id){
	var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_cargo_noche.php?usuario_id="+usuario_id);
	closeNav();
}

// * //

// Agregar una forma de pago
function agregar_formas_pago(){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_formas_pago.php"); 
	closeNav();
}

// Guardar una forma de pago
function guardar_forma_pago(){
    var usuario_id=localStorage.getItem("id");
	var descripcion= encodeURI(document.getElementById("descripcion").value);
	

	if(descripcion.length >0){
			//$('#boton_forma').hide();
			$("#boton_forma").html('<div class="spinner-border text-primary"></div>');
			var datos = {
				  "descripcion": descripcion,
                  "usuario_id": usuario_id,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_forma_pago.php",
				  data:datos,
				  beforeSend:loaderbar,
				  success:ver_formas_pago,
				  timeout:5000,
				  error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra las formas de pago de la bd
function ver_formas_pago(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_formas_pago.php?usuario_id="+usuario_id);
	closeNav();
}

// Editar una forma de pago
function editar_forma_pago(id){
    $("#area_trabajo_menu").load("includes/editar_forma_pago.php?id="+id);
}

// Editar una forma de pago
function modificar_forma_pago(id){
	var usuario_id=localStorage.getItem("id");
	var descripcion= encodeURI(document.getElementById("descripcion").value);


    if(id >0){
        //$('#boton_forma').hide();
			$("#boton_forma").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "descripcion": descripcion,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_forma_pago.php",
              data:datos,
              //beforeSend:loaderbar,
              success:ver_formas_pago,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Borrar una forma de pago
function borrar_forma_pago(id){
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
                url:"includes/borrar_forma_pago.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_formas_pago,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar una forma de pago
function aceptar_borrar_forma_pago(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_forma_pago.php?id="+id);
}

// Regresar a la pagina anterior de editar una forma de pago
function regresar_editar_forma_pago(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_formas_pago.php?usuario_id="+usuario_id);
}

// Agregar un usuario
function agregar_usuarios(id){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_usuarios.php?id="+id); 
    $(".navbar-collapse").collapse('hide');
	closeNav();
}

// Guardar un usuario
function guardar_usuario(){
    var id=localStorage.getItem("id");
    var usuario= encodeURI(document.getElementById("usuario").value);
    var contrasena= document.getElementById("contrasena").value;
    var recontrasena= document.getElementById("recontrasena").value;
    var nivel= document.getElementById("nivel").value;
    var nombre_completo= encodeURI(document.getElementById("nombre_completo").value);
    var puesto= encodeURI(document.getElementById("puesto").value);
    var celular= encodeURI(document.getElementById("celular").value);
    var correo= encodeURI(document.getElementById("correo").value);
    var direccion= encodeURI(document.getElementById("direccion").value);


    if(usuario.length >0 && contrasena.length >0 && nivel >0){
        if(contrasena == recontrasena){
            //$('#boton_usuario').hide();
            $("#boton_usuario").html('<div class="spinner-border text-primary"></div>');
            var datos = {
                  "usuario": usuario,
                  "contrasena": contrasena,
                  "recontrasena": recontrasena,
                  "nivel": nivel,
                  "nombre_completo": nombre_completo,
                  "puesto": puesto,
                  "celular": celular,
                  "correo": correo,
                  "direccion": direccion,
                  "id":id,
                };
            $.ajax({
                  async:true,
                  type: "POST",
                  dataType: "html",
                  contentType: "application/x-www-form-urlencoded",
                  url:"includes/guardar_usuario.php",
                  data:datos,
                  beforeSend:loaderbar,
                  success:ver_usuarios,
                  timeout:5000,
                  error:problemas_sistema
                });
            return false;
        }else{
            alert("Las contraseñas no coinciden");
        }
    }else{ 
        alert("Campos incompletos");
    }
}

// Muestra los usuarios de la bd
function ver_usuarios(){
    var id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_usuarios.php?id="+id);
    $(".navbar-collapse").collapse('hide');
	closeNav();
}

// Muestra la paginacion de los usuarios
function ver_usuarios_paginacion(buton,posicion){
    //alert(id);
    var id=localStorage.getItem("id");
    $("#paginacion_usuarios").load("includes/ver_usuarios_paginacion.php?posicion="+posicion+"&id="+id);    
}

// Editar un usuario
function editar_usuario(id){
    $("#area_trabajo_menu").load("includes/editar_usuario.php?id="+id);
}

// Editar un usuario
function modificar_usuario(id){
    var usuario_id=localStorage.getItem("id");
	var usuario= encodeURI(document.getElementById("usuario").value);
    //var contrasena= document.getElementById("contrasena").value;
    //var recontrasena= document.getElementById("recontrasena").value;
    var nivel= document.getElementById("nivel").value;
    var nombre_completo= encodeURI(document.getElementById("nombre_completo").value);
    var puesto= encodeURI(document.getElementById("puesto").value);
    var celular= encodeURI(document.getElementById("celular").value);
    var correo= encodeURI(document.getElementById("correo").value);
	var direccion= encodeURI(document.getElementById("direccion").value);
    var usuario_ver= document.getElementById("usuario_ver").checked;
    var usuario_agregar= document.getElementById("usuario_agregar").checked;
    var usuario_editar= document.getElementById("usuario_editar").checked;
    var usuario_borrar= document.getElementById("usuario_borrar").checked;
    var cliente_ver= document.getElementById("cliente_ver").checked;
    var cliente_agregar= document.getElementById("cliente_agregar").checked;
    var cliente_editar= document.getElementById("cliente_editar").checked;
    var cliente_borrar= document.getElementById("cliente_borrar").checked;
    var inventario_ver= document.getElementById("inventario_ver").checked;
    var inventario_agregar= document.getElementById("inventario_agregar").checked;
    var inventario_editar= document.getElementById("inventario_editar").checked;
    var inventario_borrar= document.getElementById("inventario_borrar").checked;
    var requisicion_ver= document.getElementById("requisicion_ver").checked;
    var requisicion_agregar= document.getElementById("requisicion_agregar").checked;
    var requisicion_editar= document.getElementById("requisicion_editar").checked;
    var requisicion_borrar= document.getElementById("requisicion_borrar").checked;
    var salida_ver= document.getElementById("salida_ver").checked;
    var salida_agregar= document.getElementById("salida_agregar").checked;
    var salida_editar= document.getElementById("salida_editar").checked;
    var salida_borrar= document.getElementById("salida_borrar").checked;
    var salida_aprobar= document.getElementById("salida_aprobar").checked;
    var regreso_ver= document.getElementById("regreso_ver").checked;
    var regreso_agregar= document.getElementById("regreso_agregar").checked;
    var regreso_editar= document.getElementById("regreso_editar").checked;
    var regreso_borrar= document.getElementById("regreso_borrar").checked;
    var necesidades_ver= document.getElementById("necesidades_ver").checked;
    var necesidades_agregar= document.getElementById("necesidades_agregar").checked;
    var necesidades_editar= document.getElementById("necesidades_editar").checked;
    var necesidades_borrar= document.getElementById("necesidades_borrar").checked;
    var cotizaciones_ver= document.getElementById("cotizaciones_ver").checked;
    var cotizaciones_agregar= document.getElementById("cotizaciones_agregar").checked;
    var cotizaciones_editar= document.getElementById("cotizaciones_editar").checked;
    var cotizaciones_borrar= document.getElementById("cotizaciones_borrar").checked;
    var servicio_ver= document.getElementById("servicio_ver").checked;
    var desperdicio_entrada_ver= document.getElementById("desperdicio_entrada_ver").checked;
    var desperdicio_entrada_agregar= document.getElementById("desperdicio_entrada_agregar").checked;
    var desperdicio_entrada_editar= document.getElementById("desperdicio_entrada_editar").checked;
    var desperdicio_entrada_borrar= document.getElementById("desperdicio_entrada_borrar").checked;
    var desperdicio_salida_ver= document.getElementById("desperdicio_salida_ver").checked;
    var desperdicio_salida_agregar= document.getElementById("desperdicio_salida_agregar").checked;
    var desperdicio_salida_editar= document.getElementById("desperdicio_salida_editar").checked;
    var desperdicio_salida_borrar= document.getElementById("desperdicio_salida_borrar").checked;
    var logs_ver= document.getElementById("logs_ver").checked;
    var proveedor_ver= document.getElementById("proveedor_ver").checked;
    var proveedor_agregar= document.getElementById("proveedor_agregar").checked;
    var proveedor_editar= document.getElementById("proveedor_editar").checked;
    var proveedor_borrar= document.getElementById("proveedor_borrar").checked;
    var herramienta_ver= document.getElementById("herramienta_ver").checked;
    var herramienta_agregar= document.getElementById("herramienta_agregar").checked;
    var herramienta_editar= document.getElementById("herramienta_editar").checked;
    var herramienta_borrar= document.getElementById("herramienta_borrar").checked;
    var servicio_login= document.getElementById("servicio_login").checked;
    var factura_ver= document.getElementById("factura_ver").checked;
    var factura_agregar= document.getElementById("factura_agregar").checked;
    var factura_editar= document.getElementById("factura_editar").checked;
    var factura_borrar= document.getElementById("factura_borrar").checked;
    var orden_ver= document.getElementById("orden_ver").checked;
    var orden_agregar= document.getElementById("orden_agregar").checked;
    var orden_editar= document.getElementById("orden_editar").checked;
    var orden_borrar= document.getElementById("orden_borrar").checked;
    // Convertir usuario permisos
    if(usuario_ver){
        usuario_ver=1;
    }else{
        usuario_ver=0;
    }
    //alert(usuario_ver);
    if(usuario_agregar){
        usuario_agregar = 1;
    }else{
        usuario_agregar = 0;
    }
    if(usuario_editar){
        usuario_editar = 1;
    }else{
        usuario_editar = 0;
    }
    if(usuario_borrar){
        usuario_borrar = 1;
    }else{
        usuario_borrar = 0;
    }

    // Convertir cliente permisos
    if(cliente_ver){
        cliente_ver = 1;
    }else{
        cliente_ver = 0;
    }
    if(cliente_agregar){
        cliente_agregar = 1;
    }else{
        cliente_agregar = 0;
    }
    if(cliente_editar){
        cliente_editar = 1;
    }else{
        cliente_editar = 0;
    }
    if(cliente_borrar){
        cliente_borrar = 1;
    }else{
        cliente_borrar = 0;
    }

    // Convertir inventario permisos
    if(inventario_ver){
        inventario_ver = 1;
    }else{
        inventario_ver = 0;
    }
    if(inventario_agregar){
        inventario_agregar = 1;
    }else{
        inventario_agregar = 0;
    }
    if(inventario_editar){
        inventario_editar = 1;
    }else{
        inventario_editar = 0;
    }
    if(inventario_borrar){
        inventario_borrar = 1;
    }else{
        inventario_borrar = 0;
    }

    // Convertir requisicion permisos
    if(requisicion_ver){
        requisicion_ver = 1;
    }else{
        requisicion_ver = 0;
    }
    if(requisicion_agregar){
        requisicion_agregar = 1;
    }else{
        requisicion_agregar = 0;
    }
    if(requisicion_editar){
        requisicion_editar = 1;
    }else{
        requisicion_editar = 0;
    }
    if(requisicion_borrar){
        requisicion_borrar = 1;
    }else{
        requisicion_borrar = 0;
    }

    // Convertir salida permisos
    if(salida_ver){
        salida_ver = 1;
    }else{
        salida_ver = 0;
    }
    if(salida_agregar){
        salida_agregar = 1;
    }else{
        salida_agregar = 0;
    }
    if(salida_editar ){
        salida_editar = 1;
    }else{
        salida_editar = 0;
    }
    if(salida_borrar){
        salida_borrar = 1;
    }else{
        salida_borrar = 0;
    }
    if(salida_aprobar){
        salida_aprobar = 1;
    }else{
        salida_aprobar = 0;
    }

    // Convertir regreso permisos
    if(regreso_ver){
        regreso_ver = 1;
    }else{
        regreso_ver = 0;
    }
    if(regreso_agregar){
        regreso_agregar = 1;
    }else{
        regreso_agregar = 0;
    }
    if(regreso_editar){
        regreso_editar = 1;
    }else{
        regreso_editar = 0;
    }
    if(regreso_borrar){
        regreso_borrar = 1;
    }else{
        regreso_borrar = 0;
    }

    // Convertir necesidades permisos
    if(necesidades_ver){
        necesidades_ver = 1;
    }else{
        necesidades_ver = 0;
    }
    if(necesidades_agregar){
        necesidades_agregar = 1;
    }else{
        necesidades_agregar = 0;
    }
    if(necesidades_editar){
        necesidades_editar = 1;
    }else{
        necesidades_editar = 0;
    }
    if(necesidades_borrar){
        necesidades_borrar = 1;
    }else{
        necesidades_borrar = 0;
    }
    
    // Convertir cotizaciones permisos
    if(cotizaciones_ver){
        cotizaciones_ver = 1;
    }else{
        cotizaciones_ver = 0;
    }
    if(cotizaciones_agregar){
        cotizaciones_agregar = 1;
    }else{
        cotizaciones_agregar = 0;
    }
    if(cotizaciones_editar){
        cotizaciones_editar = 1;
    }else{
        cotizaciones_editar = 0;
    }
    if(cotizaciones_borrar){
        cotizaciones_borrar = 1;
    }else{
        cotizaciones_borrar = 0;
    }

    // Convertir servicio permisos
    if(servicio_ver){
        servicio_ver = 1;
    }else{
        servicio_ver = 0;
    }
    if(servicio_login){
        servicio_login = 1;
    }else{
        servicio_login = 0;
    }

    // Convertir desperdicio entrada permisos
    if(desperdicio_entrada_ver){
        desperdicio_entrada_ver = 1;
    }else{
        desperdicio_entrada_ver = 0;
    }
    if(desperdicio_entrada_agregar){
        desperdicio_entrada_agregar = 1;
    }else{
        desperdicio_entrada_agregar = 0;
    }
    if(desperdicio_entrada_editar){
        desperdicio_entrada_editar = 1;
    }else{
        desperdicio_entrada_editar = 0;
    }
    if(desperdicio_entrada_borrar){
        desperdicio_entrada_borrar = 1;
    }else{
        desperdicio_entrada_borrar = 0;
    }

    // Convertir desperdicio salida permisos
    if(desperdicio_salida_ver){
        desperdicio_salida_ver = 1;
    }else{
        desperdicio_salida_ver = 0;
    }
    if(desperdicio_salida_agregar){
        desperdicio_salida_agregar = 1;
    }else{
        desperdicio_salida_agregar = 0;
    }
    if(desperdicio_salida_editar){
        desperdicio_salida_editar = 1;
    }else{
        desperdicio_salida_editar = 0;
    }
    if(desperdicio_salida_borrar){
        desperdicio_salida_borrar = 1;
    }else{
        desperdicio_salida_borrar = 0;
    }

    // Convertir logs permisos
    if(logs_ver){
        logs_ver = 1;
    }else{
        logs_ver = 0;
    }

    // Convertir proveedor permisos
    if(proveedor_ver){
        proveedor_ver = 1;
    }else{
        proveedor_ver = 0;
    }
    if(proveedor_agregar){
        proveedor_agregar = 1;
    }else{
        proveedor_agregar = 0;
    }
    if(proveedor_editar){
        proveedor_editar = 1;
    }else{
        proveedor_editar = 0;
    }
    if(proveedor_borrar){
        proveedor_borrar = 1;
    }else{
        proveedor_borrar = 0;
    }

    // Convertir herramienta permisos
    if(herramienta_ver){
        herramienta_ver = 1;
    }else{
        herramienta_ver = 0;
    }
    if(herramienta_agregar){
        herramienta_agregar = 1;
    }else{
        herramienta_agregar = 0;
    }
    if(herramienta_editar){
        herramienta_editar = 1;
    }else{
        herramienta_editar = 0;
    }
    if(herramienta_borrar){
        herramienta_borrar = 1;
    }else{
        herramienta_borrar = 0;
    }

    // Convertir factura permisos
    if(factura_ver){
        factura_ver = 1;
    }else{
        factura_ver = 0;
    }
    if(factura_agregar){
        factura_agregar = 1;
    }else{
        factura_agregar = 0;
    }
    if(factura_editar ){
        factura_editar = 1;
    }else{
        factura_editar = 0;
    }
    if(factura_borrar){
        factura_borrar = 1;
    }else{
        factura_borrar = 0;
    }

    // Convertir orden de servicio permisos
    if(orden_ver){
        orden_ver = 1;
    }else{
        orden_ver = 0;
    }
    if(orden_agregar){
        orden_agregar = 1;
    }else{
        orden_agregar = 0;
    }
    if(orden_editar){
        orden_editar = 1;
    }else{
        orden_editar = 0;
    }
    if(orden_borrar){
        orden_borrar = 1;
    }else{
        orden_borrar = 0;
    }
    

	if(usuario.length >0  && nivel.length >0){
        //if(contrasena == recontrasena){
            //$('#boton_usuario').hide();
            $("#boton_usuario").html('<div class="spinner-border text-primary"></div>');
            var datos = {
                  "id": id,
                  "usuario": usuario,
                  //"contrasena": contrasena,
                  //"recontrasena": recontrasena,
                  "nivel": nivel,
                  "nombre_completo": nombre_completo,
                  "puesto": puesto,
                  "celular": celular,
                  "correo": correo,
				  "direccion": direccion,
                  "usuario_ver": usuario_ver,
                  "usuario_agregar": usuario_agregar,
                  "usuario_editar": usuario_editar,
                  "usuario_borrar": usuario_borrar,
                  "cliente_ver": cliente_ver,
                  "cliente_agregar": cliente_agregar,
                  "cliente_editar": cliente_editar,
                  "cliente_borrar": cliente_borrar,
                  "inventario_ver": inventario_ver,
                  "inventario_agregar": inventario_agregar,
                  "inventario_editar": inventario_editar,
                  "inventario_borrar": inventario_borrar,
                  "requisicion_ver": requisicion_ver,
                  "requisicion_agregar": requisicion_agregar,
                  "requisicion_editar": requisicion_editar,
                  "requisicion_borrar": requisicion_borrar,
                  "salida_ver": salida_ver,
                  "salida_agregar": salida_agregar,
                  "salida_editar": salida_editar,
                  "salida_borrar": salida_borrar,
                  "salida_aprobar": salida_aprobar,
                  "regreso_ver": regreso_ver,
                  "regreso_agregar": regreso_agregar,
                  "regreso_editar": regreso_editar,
                  "regreso_borrar": regreso_borrar,
                  "necesidades_ver": necesidades_ver,
                  "necesidades_agregar": necesidades_agregar,
                  "necesidades_editar": necesidades_editar,
                  "necesidades_borrar": necesidades_borrar,
                  "cotizaciones_ver": cotizaciones_ver,
                  "cotizaciones_agregar": cotizaciones_agregar,
                  "cotizaciones_editar": cotizaciones_editar,
                  "cotizaciones_borrar": cotizaciones_borrar,
                  "servicio_ver": servicio_ver,
                  "desperdicio_entrada_ver": desperdicio_entrada_ver,
                  "desperdicio_entrada_agregar": desperdicio_entrada_agregar,
                  "desperdicio_entrada_editar": desperdicio_entrada_editar,
                  "desperdicio_entrada_borrar": desperdicio_entrada_borrar,
                  "desperdicio_salida_ver": desperdicio_salida_ver,
                  "desperdicio_salida_agregar": desperdicio_salida_agregar,
                  "desperdicio_salida_editar": desperdicio_salida_editar,
                  "desperdicio_salida_borrar": desperdicio_salida_borrar,
                  "logs_ver": logs_ver,
                  "proveedor_ver": proveedor_ver,
                  "proveedor_agregar": proveedor_agregar,
                  "proveedor_editar": proveedor_editar,
                  "proveedor_borrar": proveedor_borrar,
                  "herramienta_ver": herramienta_ver,
                  "herramienta_agregar": herramienta_agregar,
                  "herramienta_editar": herramienta_editar,
                  "herramienta_borrar": herramienta_borrar,
                  "servicio_login": servicio_login,
                  "factura_ver": factura_ver,
                  "factura_agregar": factura_agregar,
                  "factura_editar": factura_editar,
                  "factura_borrar": factura_borrar,
                  "orden_ver": orden_ver,
                  "orden_agregar": orden_agregar,
                  "orden_editar": orden_editar,
                  "orden_borrar": orden_borrar,
                  "usuario_id": usuario_id,
                  
			};
		$.ajax({
			  async:true,
			  type: "POST",
			  dataType: "html",
			  contentType: "application/x-www-form-urlencoded",
			  url:"includes/aplicar_editar_usuario.php",
			  data:datos,
			  //beforeSend:loaderbar,
              success:ver_usuarios,
              //success:problemas_sistema,
			  timeout:5000,
			  error:problemas_sistema
			});
            return false;
        /*}else{
            alert("Las contraseñas no coinciden");
        }*/
    }else{ 
        alert("Campos incompletos");
    }
}

// Borrar un usuario
function borrar_usuario(id){
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
                url:"includes/borrar_usuario.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_usuarios,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar usuario
function aceptar_borrar_usuario(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_usuario.php?id="+id); 
}

// Regresar a la pagina anterior de editar usuario
function regresar_editar_usuario(){
    var id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_usuarios.php?id="+id);
}





