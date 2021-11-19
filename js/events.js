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
    var huesped_ver= document.getElementById("huesped_ver").checked;
    var huesped_agregar= document.getElementById("huesped_agregar").checked;
    var huesped_editar= document.getElementById("huesped_editar").checked;
    var huesped_borrar= document.getElementById("huesped_borrar").checked;
    var tipo_ver= document.getElementById("tipo_ver").checked;
    var tipo_agregar= document.getElementById("tipo_agregar").checked;
    var tipo_editar= document.getElementById("tipo_editar").checked;
    var tipo_borrar= document.getElementById("tipo_borrar").checked;
    var tarifa_ver= document.getElementById("tarifa_ver").checked;
    var tarifa_agregar= document.getElementById("tarifa_agregar").checked;
    var tarifa_editar= document.getElementById("tarifa_editar").checked;
    var tarifa_borrar= document.getElementById("tarifa_borrar").checked;
    var hab_ver= document.getElementById("hab_ver").checked;
    var hab_agregar= document.getElementById("hab_agregar").checked;
    var hab_editar= document.getElementById("hab_editar").checked;
    var hab_borrar= document.getElementById("hab_borrar").checked;
    var reservacion_ver= document.getElementById("reservacion_ver").checked;
    var reservacion_agregar= document.getElementById("reservacion_agregar").checked;
    var reservacion_editar= document.getElementById("reservacion_editar").checked;
    var reservacion_borrar= document.getElementById("reservacion_borrar").checked;
    var reporte_ver= document.getElementById("reporte_ver").checked;
    var forma_pago_ver= document.getElementById("forma_pago_ver").checked;
    var forma_pago_agregar= document.getElementById("forma_pago_agregar").checked;
    var forma_pago_editar= document.getElementById("forma_pago_editar").checked;
    var forma_pago_borrar= document.getElementById("forma_pago_borrar").checked;
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

    // Convertir huesped permisos
    if(huesped_ver){
        huesped_ver = 1;
    }else{
        huesped_ver = 0;
    }
    if(huesped_agregar){
        huesped_agregar = 1;
    }else{
        huesped_agregar = 0;
    }
    if(huesped_editar){
        huesped_editar = 1;
    }else{
        huesped_editar = 0;
    }
    if(huesped_borrar){
        huesped_borrar = 1;
    }else{
        huesped_borrar = 0;
    }

    // Convertir tipo permisos
    if(tipo_ver){
        tipo_ver = 1;
    }else{
        tipo_ver = 0;
    }
    if(tipo_agregar){
        tipo_agregar = 1;
    }else{
        tipo_agregar = 0;
    }
    if(tipo_editar){
        tipo_editar = 1;
    }else{
        tipo_editar = 0;
    }
    if(tipo_borrar){
        tipo_borrar = 1;
    }else{
        tipo_borrar = 0;
    }

    // Convertir tarifa permisos
    if(tarifa_ver){
        tarifa_ver = 1;
    }else{
        tarifa_ver = 0;
    }
    if(tarifa_agregar){
        tarifa_agregar = 1;
    }else{
        tarifa_agregar = 0;
    }
    if(tarifa_editar){
        tarifa_editar = 1;
    }else{
        tarifa_editar = 0;
    }
    if(tarifa_borrar){
        tarifa_borrar = 1;
    }else{
        tarifa_borrar = 0;
    }

    // Convertir hab permisos
    if(hab_ver){
        hab_ver = 1;
    }else{
        hab_ver = 0;
    }
    if(hab_agregar){
        hab_agregar = 1;
    }else{
        hab_agregar = 0;
    }
    if(hab_editar ){
        hab_editar = 1;
    }else{
        hab_editar = 0;
    }
    if(hab_borrar){
        hab_borrar = 1;
    }else{
        hab_borrar = 0;
    }

    // Convertir reservacion permisos
    if(reservacion_ver){
        reservacion_ver = 1;
    }else{
        reservacion_ver = 0;
    }
    if(reservacion_agregar){
        reservacion_agregar = 1;
    }else{
        reservacion_agregar = 0;
    }
    if(reservacion_editar){
        reservacion_editar = 1;
    }else{
        reservacion_editar = 0;
    }
    if(reservacion_borrar){
        reservacion_borrar = 1;
    }else{
        reservacion_borrar = 0;
    }

    // Convertir reporte permisos
    if(reporte_ver){
        reporte_ver = 1;
    }else{
        reporte_ver = 0;
    }
    
    // Convertir forma_pago permisos
    if(forma_pago_ver){
        forma_pago_ver = 1;
    }else{
        forma_pago_ver = 0;
    }
    if(forma_pago_agregar){
        forma_pago_agregar = 1;
    }else{
        forma_pago_agregar = 0;
    }
    if(forma_pago_editar){
        forma_pago_editar = 1;
    }else{
        forma_pago_editar = 0;
    }
    if(forma_pago_borrar){
        forma_pago_borrar = 1;
    }else{
        forma_pago_borrar = 0;
    }
    

	if(usuario.length >0 && nivel.length >0){
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
                  "huesped_ver": huesped_ver,
                  "huesped_agregar": huesped_agregar,
                  "huesped_editar": huesped_editar,
                  "huesped_borrar": huesped_borrar,
                  "tipo_ver": tipo_ver,
                  "tipo_agregar": tipo_agregar,
                  "tipo_editar": tipo_editar,
                  "tipo_borrar": tipo_borrar,
                  "tarifa_ver": tarifa_ver,
                  "tarifa_agregar": tarifa_agregar,
                  "tarifa_editar": tarifa_editar,
                  "tarifa_borrar": tarifa_borrar,
                  "hab_ver": hab_ver,
                  "hab_agregar": hab_agregar,
                  "hab_editar": hab_editar,
                  "hab_borrar": hab_borrar,
                  "reservacion_ver": reservacion_ver,
                  "reservacion_agregar": reservacion_agregar,
                  "reservacion_editar": reservacion_editar,
                  "reservacion_borrar": reservacion_borrar,
                  "reporte_ver": reporte_ver,
                  "forma_pago_ver": forma_pago_ver,
                  "forma_pago_agregar": forma_pago_agregar,
                  "forma_pago_editar": forma_pago_editar,
                  "forma_pago_borrar": forma_pago_borrar,
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

//* Edo. Cuenta

// Muestra el estado de cuenta de una habitacion
function estado_cuenta(hab_id,estado){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/estado_cuenta.php?hab_id="+hab_id+"&estado="+estado); 
	$('#caja_herramientas').modal('hide');
}

// Agregar un abono al cargo por habitacion //-- Abonar
function agregar_abono(hab_id,estado,faltante){
	$("#mostrar_herramientas").load("includes/agregar_abono.php?hab_id="+hab_id+"&estado="+estado+"&faltante="+faltante);
}

// Guardar un abono al cargo por habitacion
function guardar_abono(hab_id,estado,faltante){
    var usuario_id=localStorage.getItem("id");
    var descripcion= encodeURI(document.getElementById("descripcion").value);
    var forma_pago= document.getElementById("forma_pago").value;
    var cargo= document.getElementById("cargo").value;
    var abono= document.getElementById("abono").value;
    

    if(descripcion.length >0 && forma_pago >0 && abono >0){
        //$('#boton_abono').hide();
            $("#boton_abono").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "hab_id": hab_id,
              "estado": estado,
              "faltante": faltante,
              "descripcion": descripcion,
              "forma_pago": forma_pago,
              "cargo": cargo,
              "abono": abono,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/guardar_abono.php",
              data:datos,
              //beforeSend:loaderbar,
              success:recibe_datos_abono,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Recibe los datos para efectuar agregar un abono
function recibe_datos_abono(datos){
    //alert(datos);
    var res = datos.split("/");
    $('#caja_herramientas').modal('hide');
    estado_cuenta(res[0] , res[1]);
}

// Modal de herramientas de cargos en estado de cuenta
function herramientas_cargos(ciclo,id,hab_id,estado,usuario,cargo){
    $("#mostrar_herramientas").load("includes/modal_herramientas_cargos.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&usuario="+usuario+"&cargo="+cargo);
}

// Modal de editar cargo en estado de cuenta
function editar_herramientas_cargo(ciclo,id,hab_id,estado,cargo){
    $("#mostrar_herramientas").load("includes/modal_editar_herramientas_cargo.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&cargo="+cargo);
}

// Editar un cargo en estado de cuenta
function modificar_herramientas_cargo(ciclo,id,hab_id,estado){
	var usuario_id=localStorage.getItem("id");
    var cargo= document.getElementById("cargo").value;


    if(id >0){
        //$('#boton_cargo').hide();
			$("#boton_cargo").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "ciclo": ciclo,
              "hab_id": hab_id,
              "estado": estado,
			  "cargo": cargo,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_herramientas_cargo.php",
              data:datos,
              //beforeSend:loaderbar,
              success:recibe_datos_abono,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Modal de borrar cargo en estado de cuenta
function aceptar_borrar_herramientas_cargo(ciclo,id,hab_id,estado,cargo){
    $("#mostrar_herramientas").load("includes/modal_borrar_herramientas_cargo.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&cargo="+cargo);
}

// Borrar un cargo en estado de cuenta
function borrar_herramientas_cargo(ciclo,id,hab_id,estado){
	var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');

    if(id >0){
        var datos = {
              "id": id,
              "ciclo": ciclo,
              "hab_id": hab_id,
              "estado": estado,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/borrar_herramientas_cargo.php",
              data:datos,
              //beforeSend:loaderbar,
              success:recibe_datos_abono,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

//--
// Modal de herramientas de abonos en estado de cuenta
function herramientas_abonos(ciclo,id,hab_id,estado,usuario,abono){
    $("#mostrar_herramientas").load("includes/modal_herramientas_abonos.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&usuario="+usuario+"&abono="+abono);
}

// Modal de editar abono en estado de cuenta
function editar_herramientas_abono(ciclo,id,hab_id,estado,abono){
    $("#mostrar_herramientas").load("includes/modal_editar_herramientas_abono.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&abono="+abono);
}

// Editar un abono en estado de cuenta
function modificar_herramientas_abono(ciclo,id,hab_id,estado){
	var usuario_id=localStorage.getItem("id");
    var abono= document.getElementById("abono").value;


    if(id >0){
        //$('#boton_abono').hide();
			$("#boton_abono").html('<div class="spinner-border text-primary"></div>');
        var datos = {
              "id": id,
              "ciclo": ciclo,
              "hab_id": hab_id,
              "estado": estado,
			  "abono": abono,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/aplicar_editar_herramientas_abono.php",
              data:datos,
              //beforeSend:loaderbar,
              success:recibe_datos_abono,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}

// Modal de borrar abono en estado de cuenta
function aceptar_borrar_herramientas_abono(ciclo,id,hab_id,estado,abono){
    $("#mostrar_herramientas").load("includes/modal_borrar_herramientas_abono.php?ciclo="+ciclo+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&abono="+abono);
}

// Borrar un abono en estado de cuenta
function borrar_herramientas_abono(ciclo,id,hab_id,estado){
	var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');

    if(id >0){
        var datos = {
              "id": id,
              "ciclo": ciclo,
              "hab_id": hab_id,
              "estado": estado,
              "usuario_id": usuario_id,
            };
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/borrar_herramientas_abono.php",
              data:datos,
              //beforeSend:loaderbar,
              success:recibe_datos_abono,
              //success:problemas_sistema,
              timeout:5000,
              error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }    
}