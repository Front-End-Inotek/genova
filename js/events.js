var teclado = ['user', 'pass','efectivo','monto','folio','descuento','comentario'];
var hab = [];
var hab_ultimo_mov = [];
var siguiente_vista=0;


// Asignamos la función inicio al evento ready de $(document)
/* $(function () {
    inicio();
}); */

function toggleBotones() {
    var botones = document.getElementById("botones");
        botones.classList.add("botones-mostrados");
        botones.classList.remove("botones-ocultos");
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
	if(res[1]!="0"){
		localStorage.setItem("id",res[0]);
		localStorage.setItem("tocken",res[1]);
        if(res[2]==0){
            localStorage.setItem('vista',3);
        }else{
            localStorage.setItem('vista',0);
        }
		document.location.href='inicio.php';
	}else{
		$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-warning"><span class="glyphicon glyphicon-remove"></span> Creo que has escrito mal tu usuario o contraseña </strong>');
	}
}

// Evaluar si la session no a iniciado
function sabernosession(){
	var id=localStorage.getItem("id");
	var token=localStorage.getItem("tocken");
    var vista = localStorage.getItem("vista");
    txt_vista = localStorage.setItem("txt_vista", "Rack Operaciones");
	if(id==null){
		document.location.href='index.php';
	}else{
		id=parseInt(id);
        // console.log(vista)
        // return
		if(id>0){
            obtener_datos_hab_inicial ();
			$(".menu").load("includes/menu.php?id="+id+"&token="+token,function(){
                if(vista==3){
                    var usuario_id=localStorage.getItem("id");
                    graficas()
                }
                if(vista==0){
                    // localStorage.setItem("txt_vista", "Rack Operaciones");
                    // txt_vista =localStorage.getItem("txt_vista");
                    /* var menu_vista = document.getElementById("vista");
                    menu_vista.innerHTML="Rack Operaciones" */
                    console.log("rack de operaciones "+vista);
                    var usuario_id=localStorage.getItem("id");
                    $("#area_trabajo").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
                    siguiente_vista=1
                }
                if(vista==1){
                    /* var menu_vista = document.getElementById("vista");
                    menu_vista.innerHTML="Rack Habitacional" */
                    console.log("rack de operaciones "+vista);
                    var id=localStorage.getItem("id");
                    var token=localStorage.getItem("tocken");
                    $("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);
                }
            });
            cargar_area_trabajo();
		}
		else{
			document.location.href='index.php';
		}
	}
}
function obtener_datos_hab() {
    //código de la función
    var id=localStorage.getItem("id_knife");
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        // console.log(this.responseText);
        const hab_info =JSON.parse(this.responseText);
          //console.log(hab_info);
        var i;
            for(i in hab_info){
                if(hab_info[i]instanceof Object){
                    /*console.log(hab_info[i]);
                    /*console.log(hab_info[i]['id']+"-"+hab_info[i]['ultimo_mov']);*/
                    if(hab[hab_info[i]['id']]<hab_info[i]['ultimo_mov']){
                        console.log('hab_'+hab_info[i]['id']);
                        hab[hab_info[i]['id']]=hab_info[i]['ultimo_mov'];
                        hab_ultimo_mov[hab_info[i]['id']]=hab_info[i]['mov'];
                        $("#hab_"+hab_info[i]['id']).load("includes/mostrar_cambios_hab.php?hab_id="+hab_info[i]['id'],function(res){
                        });
                        /*const collection = document.getElementById("hab_"+hab_info[i]['id']);
                        collection.innerHTML = '<button id="submit">Submit</button>';*/
                        //console.log(hab_info[i]['id']+"-"+hab[hab_info[i]['id']]+"-"+hab_ultimo_mov[hab_info[i]['id']]);
                    }
                    else{
                        // console.log("sin cambio en la habitacion con id "+hab_info[i]['id']);
                    }
                }
            }
         // console.log(hab_info.length);
        }
    };
    xhttp.open("GET", "includes/api_info_hab.php", true);
    xhttp.send();
}

function obtener_datos_hab_inicial () {
    //código de la función
    var id=localStorage.getItem("id_knife");
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
        const hab_info =JSON.parse(this.responseText);
          //console.log(hab_info);
        var i;
            for(i in hab_info){
                if(hab_info[i]instanceof Object){
                    /*console.log(hab_info[i]);
                    /*console.log(hab_info[i]['id']+"-"+hab_info[i]['ultimo_mov']);*/
                    hab[hab_info[i]['id']]=hab_info[i]['ultimo_mov'];
                    hab_ultimo_mov[hab_info[i]['id']]=hab_info[i]['mov'];
                   // console.log(hab_info[i]['id']+"-"+hab[hab_info[i]['id']]+"-"+hab_ultimo_mov[hab_info[i]['id']]);
                }
            }
         // console.log(hab_info.length);
        }
    };
    xhttp.open("GET", "includes/api_info_hab.php", true);
    xhttp.send();
}
// Se carga el area de trabajo
function cargar_area_trabajo(){
    // console.log(vista);
    obtener_datos_hab();
	var id=localStorage.getItem("id");
	var token=localStorage.getItem("tocken");
    /* if(vista==0){
        console.log("rack de habitaciones "+vista);
        var usuario_id=localStorage.getItem("id");
        $("#area_trabajo").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
        //closeNav();
    }else{
        console.log("rack de operaciones "+vista);
        var id=localStorage.getItem("id");
        var token=localStorage.getItem("tocken");
        $("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);
    }*/
	//$("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);
    $("#pie").load("includes/pie.php?id="+id);
    setTimeout('cargar_area_trabajo()',3000);//5500
}

    function pregunta_salir(){
    swal({
        title: "¿Estás de acuerdo en cerrar la sesión?",
        text: "¡Podrás iniciar sesión siempre que quieras y tus credenciales sean correctas!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("Tu sesion esta a punto de cerrar!", "Visit te desea un excelente día!", "success");
            setTimeout(function(){
                salirsession();
            }, 3000);
        } else {
            swal("Tu sesion sigue activo!", "", "success");
        }
        });
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
	let usuario_id = localStorage.getItem("id");
    localStorage.removeItem('id');
    localStorage.removeItem('tocken');
    localStorage.removeItem('vista');
    localStorage.removeItem('txt_vista');
    //remover el token de la db?
    include="includes/remover_token.php?usuario="+usuario_id
    $.ajax({
        async:true,
        type: "GET",
        dataType: "HTML",
        contentType: "application/json",
        url:include,
        beforeSend:loaderbar,
        //una vez eliminado el token de la bd, se redirecciona.
        success:function(res){
            document.location.href='index.php';
        },
        //success:problemas_sistema,
        timeout:5000,
        error:function(err){
            console.log(err)
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    });
}

// Barra de progreso
function loaderbar(){
	$("#area_trabajo").load("includes/barra_progreso.php");
}

// Barra de progreso en menu
function loaderbar_menu(){
	$("#area_trabajo_menu").load("includes/barra_progreso.php");
}

// Notifica un error o problema en el proceso
function problemas_sistema(datos){
	console.log("Ocurrio algun error en el proceso.  Inf: "+datos.toString());
}

// Muestra los subestados de las habitaciones
function mostrar_herramientas(hab_id,estado,nombre,entrada=0,salida=0,mov=0,reserva_id=""){
	var id=localStorage.getItem("id");
    nombre = encodeURI(nombre)
    include="includes/mostrar_herramientas.php?hab_id="+hab_id+"&id="+id+"&estado="+estado+"&nombre="+nombre+"&id="+id+"&entrada="+entrada+"&salida="+salida+"&mov="+mov+"&reserva_id="+reserva_id
    //console.log(include)
	$("#mostrar_herramientas").load(include);
}


//cerrar el modal cuando se navega a otra 'vista'
function closeModal(){
    $('#caja_herramientas').modal('hide');
}

// Abre la sidebar
function openNav(){
    if( document.getElementById("sideNavigation") != null){
        document.getElementById("sideNavigation").style.width = "250px";
    }
    document.getElementById("main").style.marginLeft = "250px";
}

// Cierra la sidebar
function closeNav(){
    if(document.getElementById("sideNavigation") != null){
        document.getElementById("sideNavigation").style.width = "0";
    }
    if(document.getElementById("main") != null){
        document.getElementById("main").style.marginLeft = "0";
    }
}

// Agregar una politica de reservacion
function agregar_politicas_reservacion(){
	$("#mostrar_herramientas").load("includes/agregar_politicas_reservacion.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

// Agregar un plan de alimentacion
function agregar_tipos_abonos(){
	$("#mostrar_herramientas").load("includes/agregar_tipos_abonos.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}
///////////////////////////////////////////////////////////
function mostrar_info_custom(){
    console.log("mostrar info")
    /* $("#mostrar_herramientas").load("includes/info.php"); */
    $("#mostrar_herramientas").load("includes/info.php");
}

//* Tipo hab *//

// Agregar un plan de alimentacion
function agregar_planes_alimentos(){
	$("#mostrar_herramientas").load("includes/agregar_planes_alimentos.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

//Guardar el cargo adicional
function guardar_cargo_adicional(id,mov){
    nombre = $("#nombre").val()
    monto = $("#monto").val()
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(monto === null || monto === ''){
        swal("Campo monto vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    aplicar_rest_cobro_hab(monto, 0,0,mov,nombre,id)
}

//Agregar un cargo adicional.
function agregar_cargo_adicional(id,mov){
	$("#mostrar_herramientas").load("includes/agregar_cargo_adicional.php?id="+id+"&mov="+mov);
}
// Agregar una cuenta maestra
function agregar_cuentas_maestras(){
	$("#mostrar_herramientas").load("includes/agregar_cuentas_maestras.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

// Agregar un tipo de habitacion
function agregar_tipos(){
	$("#mostrar_herramientas").load("includes/agregar_tipos.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

function guardar_politica_reservacion(){
    var nombre= encodeURI(document.getElementById("nombre").value);
	var codigo= encodeURI(document.getElementById("codigo").value);
    var descripcion = encodeURI(document.getElementById("descripcion").value);
    // console.log(nombre,codigo,descripcion)
    // return
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(codigo === null || codigo === ''){
        swal("Campo codigo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(descripcion === null || descripcion === ''){
        swal("Campo descripcion vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    guardar_politicaReservacion(nombre,codigo,descripcion)
}

function guardar_politicaReservacion(nombre,codigo,descripcion){
    let usuario_id=localStorage.getItem("id");
    let xhttp;
    xhttp = new XMLHttpRequest();
    var parametros = "nombre="+nombre+"&codigo="+codigo+"&descripcion="+descripcion+"&usuario_id="+usuario_id
    xhttp.open("POST","includes/guardar_politica_reservacion.php",true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.responseText)
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_politicas_reservacion()
                swal("Nueva política de reservación agregada!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send(parametros);
}

function guardar_tipos_abonos() {
    let usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
    let descripcion= encodeURI(document.getElementById("descripcion").value);
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    let xhttp;
    xhttp = new XMLHttpRequest();
    var parametros = "nombre="+nombre+"&descripcion="+descripcion+"&usuario_id="+usuario_id
    xhttp.open("POST","includes/guardar_tipo_abono.php",true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tipos_abonos()
                swal("Nuevo tipo  de abono agregado!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send(parametros);
}

function guardar_planes_alimentos() {
	var nombre= encodeURI(document.getElementById("nombre").value);
	var costo= encodeURI(document.getElementById("codigo").value);
    var costo_menores = encodeURI(document.getElementById("costo_menores").value);
    // console.log(nombre,costo)
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(costo === null || costo === ''){
        swal("Campo costo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(costo_menores === null || costo_menores === ''){
        swal("Costo para menores vario!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    guardar_planAlimentos()
}

function guardar_planAlimentos(){
    let usuario_id=localStorage.getItem("id");
	let nombre= encodeURI(document.getElementById("nombre").value);
	let costo= encodeURI(document.getElementById("codigo").value);
    let costo_menores = encodeURI(document.getElementById("costo_menores").value);
    var descripcion= encodeURI(document.getElementById("descripcion").value);
    let xhttp;
    xhttp = new XMLHttpRequest();
    //Aqui se modifico el url para mandarlo al back
    let parametros="nombre="+nombre+"&costo="+costo+"&usuario_id="+usuario_id+"&descripcion="+descripcion+"&costo_menores="+costo_menores
    xhttp.open("POST","includes/guardar_plan_alimentos.php",true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.responseText);
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_planes_alimentos()
                swal("Nuevo plan de alimentos agregado!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send(parametros);
}

function guardar_tipo() {
	var nombre= encodeURI(document.getElementById("nombre").value);
	var codigo= encodeURI(document.getElementById("codigo").value);
    //const color = encodeURI(document.getElementById("colorHab").value);
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(codigo === null || codigo === ''){
        swal("Campo codigo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    guardar_habitacion()
}

function guardar_cuenta_maestra() {
	var nombre= encodeURI(document.getElementById("nombre").value);
	var codigo= encodeURI(document.getElementById("codigo").value);
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(codigo === null || codigo === ''){
        swal("Campo codigo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    guardar_cuenta_m(nombre,codigo)
}

function guardar_cuenta_m(nombre,codigo){
    let usuario_id=localStorage.getItem("id");
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_cuenta_maestra.php?nombre="+nombre+"&codigo="+codigo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.responseText);
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_cuenta_maestra()
                swal("Nueva cuenta maestra agregada!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intentelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

// Guardar un tipo de habitacion
function guardar_habitacion(){
    //debugger
   // $('#caja_herramientas').modal('hide');
    let usuario_id=localStorage.getItem("id");
	let nombre= encodeURI(document.getElementById("nombre").value);
	let codigo= encodeURI(document.getElementById("codigo").value);
    const colorHab = encodeURI(document.getElementById("colorHab").value);
    let color_hab = colorHab.replace("#","")
    color_hab= encodeURI(color_hab)
    let datos = {
        "nombre": nombre,
        "codigo": codigo,
        "usuario_id": usuario_id,
        "colorHab": colorHab,
    };
    // console.log(colorHab)
    // return
    let xhttp;
    xhttp = new XMLHttpRequest();
    let include = "includes/guardar_tipo.php?nombre="+nombre+"&codigo="+codigo+"&color="+color_hab+"&usuario_id="+usuario_id
    console.log(include)
    xhttp.open("GET",include,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
            console.log(response)
            if (response == 'NO') {
                $('#caja_herramientas').modal('hide');
                swal("Nuevo tipo de habitacion agregado!", "Excelente trabajo!", "success");
                ver_tipos()
                return false;
            }else if(response== 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

// Muestra las politicas de reservacion existentes.
function ver_politicas_reservacion(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_politicas_reservacion.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra los tipos de abonos existentes
function ver_tipos_abonos(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_tipos_abonos.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra los tipos de planes de alimentos existentes
function ver_planes_alimentos(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_planes_alimentos.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra las tipos de habitaciones de la bd
function ver_tipos(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_tipos.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

function config_colores_hab(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/configcoloreshab.php");
    closeModal();
	closeNav();
}

// Editar una politica de reservacion
function editar_politica_reservacion(id){
    include = "includes/editar_politica_reservacion.php?id="+id
    $("#mostrar_herramientas").load(include);
}

// Editar un plan de alimentos
function editar_tipo_abono(id,nombre,descripcion){
    nombre = encodeURIComponent(nombre)
    descripcion = encodeURIComponent(descripcion)
    include = "includes/editar_tipo_abono.php?id="+id+"&nombre="+nombre+"&descripcion="+descripcion
    $("#mostrar_herramientas").load(include);
}

// Editar un plan de alimentos
function editar_plan_alimentos(id,nombre,costo,descripcion,costo_menores){
    nombre = encodeURIComponent(nombre)
    descripcion = encodeURIComponent(descripcion)
    include = "includes/editar_plan_alimentos.php?id="+id+"&nombre="+nombre+"&costo="+costo+"&descripcion="+descripcion+"&costo_menores="+costo_menores;
    $("#mostrar_herramientas").load(include);
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

// Editar un tipo de habitacion
function editar_cuenta_maestra(id){
    $("#mostrar_herramientas").load("includes/editar_cuenta_maestra.php?id="+id);
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

// Editar un tipo de habitacion
function editar_tipo(id){
    $("#mostrar_herramientas").load("includes/editar_tipo.php?id="+id);
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
}

function mostrar_estadorack(estatus_hab) {
    console.log(estatus_hab);
    if(estatus_hab!="99"){
        localStorage.setItem('estatus_hab',estatus_hab)
    }else{
        localStorage.removeItem('estatus_hab')
    }
    estatus_hab=localStorage.getItem('estatus_hab')
    $("#area_trabajo").load("includes/area_trabajo.php?id="+0+"&token="+0+"&estatus_hab="+estatus_hab);
    return;
    var datos = {"estatus_hab":estatus_hab}
    //Declaramos una variable con nuestra perticion xmlhttprequest
        var xhttp = new XMLHttpRequest();
    //Abrimos las conexion hacia el archivo validar
        xhttp.open('POST', 'includes/informacion.php?estatus_hab='+estatus_hab, true);
    //Con el evento de escuchar se decidira que mensaje o a que pagina se nos va a redireccionar
        xhttp.addEventListener('load', e =>{
    //Escuchamos los estados que responda el servidor
        if(e.target.readyState == 4 && e.target.status == 200){
    //Si la respuesta fue para el usuario se va a redirigir a la pagina correspondiente
            console.log(e.target.response);
            if(e.target.response == "validar_usa"){
                console.log(e.target.response);
                location.href = 'src/main_user.php';
    //Si la respues fue administrador se va redirigir a la pagina correspindiente
            }if(e.target.response == "validar_admin"){
                console.log(e.target.response);
                location.href = 'src/main_admin.php';
    //Si no nos mostrara un mensaje de error
            }else{
                swal("Datos incorrectos!", "Intentelo nuevamente", "warning");
            }
    //Encaso que que el servidor no responda se le notifica al usuario
        }else{
            swal("Error del servidor!", "Intentelo nuevamente o contacte con soporte tecnico!", "error");
        }
        });
        xhttp.send();
}

function modificar_politica_reservacion(id){
    // Editar un tipo de plan de alimentación
	let usuario_id = localStorage.getItem("id");
    let nombre = encodeURI(document.getElementById("nombre").value);
	let codigo = encodeURI(document.getElementById("codigo").value);
    let descripcion = encodeURI(document.getElementById("descripcion").value);
    datos ={
        "nombre":nombre,
        "codigo":codigo,
        "id":id,
        "usuario_id":usuario_id,
        "descripcion":descripcion,
    }
    include = "includes/aplicar_editar_politica_reservacion.php";
    $.ajax({
        async:true,
        type: "POST",
        url:include,
        data:datos,
        beforeSend:loaderbar,
        success:function(res){
            console.log(res)
            if(res=="NO"){
                $('#caja_herramientas').modal('hide');
                ver_politicas_reservacion()
                swal("Actualizo la política de reservación!", "Excelente trabajo!", "success");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        },
        //success:problemas_sistema,
        timeout:5000,
        error:function(err){
            console.log(err)
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    });
}

function modificar_tipo_abono(id){
    // Editar un tipo de plan de alimentación
	let usuario_id = localStorage.getItem("id");
    let id_abono = id;
    let nombre = encodeURI(document.getElementById("nombre").value);
	let descripcion = encodeURI(document.getElementById("descripcion").value);
    let xhttp;
    xhttp = new XMLHttpRequest();
    var parametros = "nombre="+nombre+"&descripcion="+descripcion+"&usuario_id="+usuario_id+"&id_abono="+id_abono
    console.log(parametros)
    xhttp.open("POST","includes/aplicar_editar_tipo_abono.php",true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            // console.log(e.target.responseText)
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tipos_abonos()
                swal("Actualizó el tipo de abono!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send(parametros);
}

function modificar_plan_alimentos(id){
    // Editar un tipo de plan de alimentación
	let usuario_id = localStorage.getItem("id");
    let id_plan = id;
    let nombre = encodeURI(document.getElementById("nombre").value);
	let costo = encodeURI(document.getElementById("codigo").value);
    let descripcion=encodeURI(document.getElementById("descripcion").value);
    let costo_menores = encodeURI(document.getElementById("costo_menores").value);
    include = "includes/aplicar_editar_plan_alimentacion.php?nombre="+nombre+"&costo="+costo+"&id_tipo="+id_plan+"&usuario_id="+usuario_id+"&descripcion="+descripcion+"&costo_menores="+costo_menores;
    $.ajax({
        async:true,
        type: "GET",
        dataType: "HTML",
        contentType: "application/json",
        url:include,
        beforeSend:loaderbar,
        success:function(res){
            $('#caja_herramientas').modal('hide');
            ver_planes_alimentos()
            swal("Actualizo el plan de alimentación!", "Excelente trabajo!", "success");
        },
        //success:problemas_sistema,
        timeout:5000,
        error:function(err){
            console.log(err)
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    });
}

// Editar una cuenta maestra
function modificar_cuenta_maestra(id){
    //$('#caja_herramientas').modal('hide');
	let usuario_id = localStorage.getItem("id");
    let id_tipo = id;
    let nombre = encodeURI(document.getElementById("nombre").value);
	let codigo = encodeURI(document.getElementById("codigo").value);
        let datos = {
            "id_tipo": id_tipo,
            "nombre": nombre,
			"codigo": codigo,
            "usuario_id": usuario_id,
        };
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/aplicar_editar_cuenta_maestra.php?nombre="+nombre+"&codigo="+codigo+"&id_tipo="+id_tipo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_cuenta_maestra()
                swal("Actualizo cuenta maestra!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

function mostrar_info(){
    let usuario_id = localStorage.getItem("id");
    $("#info_here").load("includes/mostrar_info.php?usuario_id="+usuario_id)
}

// Editar un tipo de habitacion
function modificar_tipo(id){
    //$('#caja_herramientas').modal('hide');
	let usuario_id = localStorage.getItem("id");
    let id_tipo = id;
    let nombre = encodeURI(document.getElementById("nombre").value);
	let codigo = encodeURI(document.getElementById("codigo").value);
    let color = encodeURI(document.getElementById("colorHab").value);
    color = color.replace("#","")
    color_hab= encodeURI(color)
        let datos = {
            "id_tipo": id_tipo,
            "nombre": nombre,
			"codigo": codigo,
            "color": colorHab,
            "usuario_id": usuario_id,
        };
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/aplicar_editar_tipo.php?nombre="+nombre+"&codigo="+codigo+"&id_tipo="+id_tipo+"&color="+color_hab+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            // console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tipos()
                swal("Actualizó tipo de habitación!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

function borrar_politica_reservacion(id, nombre, codigo){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = codigo;
    let usuario_id=localStorage.getItem("id");
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id política</td>
        <td>Nombre de la política</td>
        <td>Código</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    swal({
        title: "Antes de continuar por favor verifique los datos de la política de reservación  a eliminar",
        text: "Antes de continuar por favor verifique los datos de la política de reservación a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        include="includes/borrar_politica_reservacion.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id
        $.ajax({
            async:true,
            type: "GET",
            dataType: "HTML",
            contentType: "application/json",
            url:include,
            beforeSend:loaderbar,
            success:function(res){
                console.log(res)
                if(res=="NO"){
                    $('#caja_herramientas').modal('hide');
                    ver_politicas_reservacion()
                    swal("Se elimino la política de reservación!", "Excelente trabajo!", "success");
                }else{
                    swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
                }
            },
            //success:problemas_sistema,
            timeout:5000,
            error:function(err){
                console.log(err)
                swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
            }
        });
    } else {
        swal("Se cancelo eliminar el plan de alimentación!", "Por favor verifique los datos antes de eliminarlos!", "success")
    }
    });
}
function borrar_tipo_abono(id, nombre, descripcion ){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = descripcion;
    let usuario_id=localStorage.getItem("id");
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id abono</td>
        <td>Nombre del abono</td>
        <td>Descripción</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    swal({
        title: "Antes de continuar por favor verifique los datos del tipo de abono a eliminar",
        text: "Antes de continuar por favor verifique los datos del tipo de abono a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        include="includes/borrar_tipo_abono.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id
        $.ajax({
            async:true,
            type: "GET",
            dataType: "HTML",
            contentType: "application/json",
            url:include,
            beforeSend:loaderbar,
            success:function(res){
                // console.log(res)
                // return
                if(res=="NO"){
                    $('#caja_herramientas').modal('hide');
                    ver_tipos_abonos()
                    swal("Se elimino el tipo de abono!", "Excelente trabajo!", "success");
                }else{
                    swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
                }
            },
            //success:problemas_sistema,
            timeout:5000,
            error:function(err){
                console.log(err)
                swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
            }
        });
    } else {
        swal("Se cancelo eliminar el tipo de abono!", "Por favor verifique los datos antes de eliminarlos!", "success")
    }
    });
}

function borrar_plan_alimentacion(id, nombre, codigo ){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = codigo;
    let usuario_id=localStorage.getItem("id");
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id plan</td>
        <td>Nombre del plan</td>
        <td>Costo</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    swal({
        title: "Antes de continuar por favor verifique los datos del plan de alimentación a eliminar",
        text: "Antes de continuar por favor verifique los datos del plan de alimentación a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        include="includes/borrar_plan_alimentacion.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id
        $.ajax({
            async:true,
            type: "GET",
            dataType: "HTML",
            contentType: "application/json",
            url:include,
            beforeSend:loaderbar,
            success:function(res){
                if(res=="NO"){
                    $('#caja_herramientas').modal('hide');
                    ver_planes_alimentos()
                    swal("Se elimino el plan de alimentación!", "Excelente trabajo!", "success");
                }else{
                    swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
                }
            },
            //success:problemas_sistema,
            timeout:5000,
            error:function(err){
                console.log(err)
                swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
            }
        });
    } else {
        swal("Se cancelo eliminar el plan de alimentación!", "Por favor verifique los datos antes de eliminarlos!", "success")
    }
    });
}

function cerrar_cuenta_maestra(id, nombre, codigo , mov){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = codigo;
    let usuario_id=localStorage.getItem("id");
    let datos = {
        "id_tipo": id_tipo,
        "usuario_id": usuario_id
    };
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id</td>
        <td>Nombre Cuenta Maestra</td>
        <td>Codigo</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    var xhttp;
    xhttp = new XMLHttpRequest();
    swal({
        title: "Antes de continuar por favor verifique los datos de la cuenta maestra a cerrar",
        text: "Antes de continuar por favor verifique los datos de la cuenta maestra a cerrar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    xhttp.open("GET","includes/cerrar_cuenta_maestra.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id+"&mov="+mov,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response)
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_cuenta_maestra()
                swal("Cuenta maestra cerrada correctamente!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Accion no realizada!", "Error de transferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
                } else {
        swal("Operación omitida!", "Por favor verifique los datos antes de cancelar la cuenta!", "success")
        }
    });
}

function borrar_cuenta_maestra(id, nombre, codigo ){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = codigo;
    let usuario_id=localStorage.getItem("id");
    let datos = {
        "id_tipo": id_tipo,
        "usuario_id": usuario_id
    };
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id</td>
        <td>Nombre Cuenta Maestra</td>
        <td>Codigo</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    var xhttp;
    xhttp = new XMLHttpRequest();
    swal({
        title: "Antes de continuar por favor verifique los datos de la cuenta maestra a eliminar",
        text: "Antes de continuar por favor verifique los datos de la cuenta maestra a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    xhttp.open("GET","includes/borrar_cuenta_maestra.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            // console.log(e.target.response);
            // return
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_cuenta_maestra()
                swal("Se elimino la cuenta maestra!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Accion no realizada!", "Error de transferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
                } else {
        swal("Se cancelo eliminar la cuenta maestra!", "Por favor verifique los datos antes de eliminarlos!", "success")
        }
    });
}

function borrar_tipo(id, nombre, codigo ){
    let nombre_tipo = nombre;
    let id_tipo = id;
    let codigo_tipo = codigo;
    let usuario_id=localStorage.getItem("id");
    let datos = {
        "id_tipo": id_tipo,
        "usuario_id": usuario_id
    };
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id tipo</td>
        <td>Nombre de habitacion</td>
        <td>Codigo</td>
        </tr>
        <tr>
        <td>${id_tipo}</td>
        <td>${nombre_tipo}</td>
        <td>${codigo_tipo}</td>
        </tr>
    </table> <br>`;
    var xhttp;
    xhttp = new XMLHttpRequest();
    swal({
        title: "Antes de continuar por favor verifique los datos del tipo de habitación a eliminar",
        text: "Antes de continuar por favor verifique  los datos del tipo de habitación a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    xhttp.open("GET","includes/borrar_tipo.php?id_tipo="+id_tipo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tipos()
                swal("Se elimino tipo de habitacion!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Accion no realizada!", "Error de transferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
                } else {
        swal("Se cancelo eliminar tipo de habitacion!", "Por favor verifique los datos antes de eliminarlos!", "success")
        }
    });
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

//* Tarifa hospedaje *//

// Agregar una tarifa hospedaje
function agregar_tarifas(){
	$("#mostrar_herramientas").load("includes/agregar_tarifas.php");
}

function guardar_tarifa(){
    let nombre= encodeURI(document.getElementById("nombre").value);
	let precio_hospedaje= document.getElementById("precio_hospedaje").value;
	let cantidad_hospedaje= document.getElementById("cantidad_hospedaje").value;
    let cantidad_maxima= document.getElementById("cantidad_maxima").value;
	let precio_adulto= document.getElementById("precio_adulto").value;
	// let precio_junior= document.getElementById("precio_junior").value;
	let precio_infantil= document.getElementById("precio_infantil").value;
    let tipo= document.getElementById("tipo").value;
    let leyenda= encodeURI(document.getElementById("leyenda").value);
    // console.log(tipo)
    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    console.log(precio_hospedaje.length)
    if(precio_hospedaje.length > 15){
        swal("Campo precio_hospedaje demasiado grande!", "El campo no debe superar los 15 caracteres!", "warning");
        return false;
    }
    if(precio_hospedaje === null || precio_hospedaje === ''){
        swal("Campo precio_hospedaje vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(cantidad_hospedaje === null || cantidad_hospedaje === ''){
        swal("Campo cantidad_hospedaje vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(cantidad_maxima === null || cantidad_maxima === ''){
        swal("Campo cantidad_maxima vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(precio_adulto === null || precio_adulto === ''){
        swal("Campo precio_adulto vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    // if(precio_junior === null || precio_junior === ''){
    //     swal("Campo precio_junior vacio!", "Verifique los datos correctamente por favor!", "warning");
    //     return false;
    // }
    // if(precio_infantil === null || precio_infantil === ''){
    //     swal("Campo precio_infantil vacio!", "Verifique los datos correctamente por favor!", "warning");
    //     return false;
    // }
    if(tipo === null || tipo === '' || tipo==0){
        swal("Campo tipo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(leyenda === null || leyenda === ''){
        swal("Campo leyenda vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    guardar_tarifa_nueva()
}

// Guardar una tarifa hospedaje
function guardar_tarifa_nueva(){
    //debugger
	let usuario_id=localStorage.getItem("id");
    let nombre= encodeURI(document.getElementById("nombre").value);
	let precio_hospedaje= document.getElementById("precio_hospedaje").value;
	let cantidad_hospedaje= document.getElementById("cantidad_hospedaje").value;
    let cantidad_maxima= document.getElementById("cantidad_maxima").value;
	let precio_adulto= document.getElementById("precio_adulto").value;
	//let precio_junior= document.getElementById("precio_junior").value;
	let precio_infantil= document.getElementById("precio_infantil").value;
    let tipo= document.getElementById("tipo").value;
    let leyenda= encodeURI(document.getElementById("leyenda").value);
    let datos = {
        "usuario_id": usuario_id,
        "nombre": nombre,
        "precio_hospedaje": precio_hospedaje,
        "cantidad_hospedaje": cantidad_hospedaje,
        "cantidad_maxima": cantidad_maxima,
        "precio_adulto": precio_adulto,
        // "precio_junior": precio_junior,
        "precio_infantil": precio_infantil,
        "tipo": tipo,
        "leyenda": leyenda,
    };
    let xhttp;
    xhttp = new XMLHttpRequest();
    //xhttp.open("GET","includes/guardar_tarifa.php?nombre="+nombre+"&precio_hospedaje="+precio_hospedaje+"&cantidad_hospedaje="+cantidad_hospedaje+"&cantidad_maxima="+cantidad_maxima+"&precio_adulto="+precio_adulto+"&precio_junior="+precio_junior+"&precio_infantil="+precio_infantil+"&tipo="+tipo+"&leyenda="+leyenda+"&usuario_id="+usuario_id,true);
    var parametros = "nombre="+nombre+"&precio_hospedaje="+precio_hospedaje+"&cantidad_hospedaje="+cantidad_hospedaje+"&cantidad_maxima="+cantidad_maxima+"&precio_adulto="+precio_adulto+"&precio_infantil="+precio_infantil+"&tipo="+tipo+"&leyenda="+leyenda+"&usuario_id="+usuario_id
    xhttp.open("POST","includes/guardar_tarifa.php",true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
            console.log(response)
            if (response == "NO") {
                $('#caja_herramientas').modal('hide');
                swal("Nuevo tipo de tarifa agregada!", "Excelente trabajo!", "success");
                ver_tarifas()
                return false;
            }else if(response == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send(parametros);
}

// Muestra las tarifas hospedaje de la bd
function ver_tarifas(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_tarifas.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Editar una tarifa hospedaje
function editar_tarifa(id){
    $("#mostrar_herramientas").load("includes/editar_tarifa.php?id="+id);
}

// Editar una tarifa hospedaje
function modificar_tarifa(id){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);
	var precio_hospedaje= document.getElementById("precio_hospedaje").value;
	var cantidad_hospedaje= document.getElementById("cantidad_hospedaje").value;
    var cantidad_maxima= document.getElementById("cantidad_maxima").value;
	var precio_adulto= document.getElementById("precio_adulto").value;
	var precio_infantil= document.getElementById("precio_infantil").value;
    var tipo= document.getElementById("tipo").value;
    var leyenda= encodeURI(document.getElementById("leyenda").value);
    var datos = {
        "id": id,
        "usuario_id": usuario_id,
        "nombre": nombre,
        "precio_hospedaje": precio_hospedaje,
        "cantidad_hospedaje": cantidad_hospedaje,
        "cantidad_maxima": cantidad_maxima,
        "precio_adulto": precio_adulto,
        "precio_infantil": precio_infantil,
        "tipo": tipo,
        "leyenda": leyenda
    };
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/aplicar_editar_tarifa.php?id="+id+"&nombre="+nombre+"&precio_hospedaje="+precio_hospedaje+"&cantidad_hospedaje="+cantidad_hospedaje+"&cantidad_maxima="+cantidad_maxima+"&precio_adulto="+precio_adulto+"&precio_infantil="+precio_infantil+"&tipo="+tipo+"&leyenda="+leyenda+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tarifas()
                swal("Actualizo tarifas de hospedaje!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

// Borrar una tarifa hospedaje
function borrar_tarifa(id, nom, precio_hospedaje, cantidad_hospedaje, cantidad_maxima, precio_adulto, precio_junior, precio_infantil, habitacion, leyenda ){
    let usuario_id=localStorage.getItem("id");
    let nombre = nom;
    let precio = precio_hospedaje;
    let habitaciones = habitacion;
    let leyendas = leyenda;
    let datos = {
        "id": id,
        "usuario_id": usuario_id,
    };
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td>Precio</td>
        <td>Tipo Habitacion</td>
        <td>Leyenda Habitacion</td>
        </tr>
        <tr>
        <td>${id}</td>
        <td>${nombre}</td>
        <td>${precio}</td>
        <td>${habitaciones}</td>
        <td>${leyendas}</td>
        </tr>
    </table> <br>`;
    var xhttp;
    xhttp = new XMLHttpRequest();
    swal({
        title: "Antes de continuar por favor verifique datos de la tarifa a eliminar",
        text: "Antes de continuar por favor verifique datos de la tarifa a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    xhttp.open("GET","includes/borrar_tarifa.php?id="+id+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tarifas()
                swal("Se elimino tipo de habitacion!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Accion no realizada!", "Error de transferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
                } else {
                    $('#caja_herramientas').modal('hide');
        swal("Se cancelo eliminar tipo de habitacion!", "Por favor verifique los datos antes de eliminarlos!", "success")
        }
    });
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

//* Habitacion *//

// Agregar una habitacion
function agregar_hab(){
	$("#mostrar_herramientas").load("includes/agregar_hab.php");
}

// Guardar una habitacion
function guardar_hab(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var tipo= document.getElementById("tipo").value;
	var comentario= encodeURI(document.getElementById("comentario").value);

    var datos = {
        "nombre": nombre,
        "tipo": tipo,
        "comentario": comentario,
        "usuario_id": usuario_id,
    };

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_hab.php?nombre="+nombre+"&tipo="+tipo+"&comentario="+comentario+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
            if (response == 'NO') {
                $('#caja_herramientas').modal('hide');
                swal("Nuevo tipo de habitacion agregado!", "Excelente trabajo!", "success");
                ver_hab()
                return false;
            }else if(response == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

// Muestra las habitaciones de la bd
function ver_hab(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_hab.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Editar una habitacion
function editar_hab(id){
    $("#mostrar_herramientas").load("includes/editar_hab.php?id="+id);
}

// Editar una habitacion
function modificar_hab(id){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);
	var tipo= document.getElementById("tipo").value;
	var comentario= encodeURI(document.getElementById("comentario").value);
    var datos = {
        "id": id,
        "nombre": nombre,
        "tipo": tipo,
        "comentario": comentario,
        "usuario_id": usuario_id,
    };
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/aplicar_editar_hab.php?id="+id+"&nombre="+nombre+"&tipo="+tipo+"&comentario="+comentario+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.responseText);
            if (e.target.responseText == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_hab()
                swal("Datos de habitación actualizados!", "Excelente trabajo!", "success");
                return false;
            }else if(e.target.responseText == 'NO_valido'){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
            }else{
                swal("Los datos no se agregaron!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
}

// Borrar una habitacion
function borrar_hab(ID, nom, habitacion, comentario){
    let usuario_id=localStorage.getItem("id");
    let datos = {
        "ID": ID,
        "usuario_id": usuario_id,
    };
    let tabla = document.createElement("div");
    tabla.innerHTML += `
    <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td>Tipo Habitacion</td>
        </tr>
        <tr>
        <td>${ID}</td>
        <td>${nom}</td>
        <td>${habitacion}</td>
        <td>${comentario}</td>
        </tr>
    </table> <br>`;
    let xhttp;
    xhttp = new XMLHttpRequest();
    swal({
        title: "Antes de continuar por favor verifique los datos de la habitación a eliminar",
        text: "Antes de continuar por favor verifique los datos de la habitación a eliminar ",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    xhttp.open("GET","includes/borrar_hab.php?ID="+ID+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_hab()
                swal("Se eliminó la habitacion del sistema!", "Excelente trabajo!", "success");
            }else if (e.target.response == 'NO_valido'){
                swal("Accion no realizada!", "Error de transferencia de datos!", "error");
            }else{
                swal("Accion no realizada!", "Error de conexion a base de datos!", "error");
            }
        }else{
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();
                } else {
                    $('#caja_herramientas').modal('hide');
        swal("Se cancelo eliminar la habitacion!", "Por favor verifique los datos antes de eliminarlos!", "success")
        }
    });
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

//* Reservacion *//

// Agregar una reservacion
function agregar_check(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregarCheck.php?");
    closeModal();
	closeNav();
}

// Agregar una reservacion
function agregar_reservaciones(hab_id=0){
	$('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_reservacionNew.php?hab_id="+hab_id);
    closeModal();
	closeNav();
    $('#pie').hide();
}
function graficas(){
    var usuario_id=localStorage.getItem("id");
    localStorage.setItem('vista',3)
    $('#area_trabajo').hide();
    $('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/graficas.php?usuario_id="+usuario_id);
    $('#pie').show();
    closeModal();
    closeNav();
}
function pronosticos(){
    $('#area_trabajo').hide();
    $('#area_trabajo_menu').show();
    //$("#area_trabajo_menu").load("includes/pronosticos_de_ocupacion.php");
    $("#area_trabajo_menu").load("includes/select_pronosticos.php");
    $('#pie').show();
    closeModal();
    closeNav();
}
function generarReporte() {
    const mes = document.getElementById("mesanio").value
    const contenedor = document.getElementById("contenedor_para_pronosticos")
    const loader = document.getElementById("loader_pronosticos");
    const btnBuscar = document.getElementById("buscar_reporte")
    if( mes == "" || null ){
        contenedor.innerHTML = "<p>Selecciona una fecha valida</p>"
        return
    }
    btnBuscar.disabled = true;
    loader.style.visibility = "visible";
    contenedor.innerHTML = "";

    let datos = {
        "fecha" : mes
    }
    $.ajax({
        async: true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: "includes/pronosticos_de_ocupacion.php",
        data: datos,
        success: function(res){
            loader.style.visibility = "hidden";
            contenedor.innerHTML = res;
            btnBuscar.disabled = false;
        }
    })

}

function ver_reporte_pronostico() {
    console.log("Reporte generado")
    const mes = document.getElementById("mesanio").value
    let datos = {
        "fecha" : mes
    }
    window.open("includes/generar_reporte_pronosticos.php?fecha="+mes,"Pronostico");
    
    /*$.ajax({
        async: true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: "includes/generar_reporte_pronosticos.php",
        data: datos,
        succes: function(res){
            console.log("Mirando el reporte" + res)
        }
    })*/
}
//Función que calcula las fechas entre 2 fechas.
function getDatesInRange(date, endDate) {
    const dates = [];
    // dates.push(date)
    inicioDate = new Date(date)
    while (inicioDate < endDate) {
    fecha_rango = new Date(inicioDate)
    fecha_rango = fecha_rango.toISOString().split('T')[0];
    dates.push(fecha_rango);
    inicioDate.setDate(inicioDate.getDate() + 1);
    }
    return dates;
}

function manejarReservacion(control){
    if(control == 0){
        document.getElementById('numero_hab').disabled=true;
        document.getElementById('tarifa').disabled=true;
    }else{
        document.getElementById('tarifa').disabled=false;
        // document.getElementById('numero_hab').disabled=false;
    }
}

function calcular_nochesChek(){
    hab_id = $("#habitacion_checkin :selected").data("habid")
    console.log(hab_id)
    calcular_noches(hab_id)
}

function editarTotalEstancia(event){
    console.log("👨")
    forzar_tarifa = $("#forzar-tarifa").val()
    console.log("Forzar tarifa: "+forzar_tarifa)
    extra_adultos = $("#extra_adulto").val();
    console.log("Extra adultos: "+extra_adultos)
    extra_infantil =  $("#extra_infantil").val();
    console.log("Extra infantil: "+extra_infantil)
    cantidad_hospedaje =$("#cantidad_hospedaje").val()
    console.log("Cantidad hospedaje: "+cantidad_hospedaje)
    cantidad_maxima =Number($("#cantidad_maxima").val())
    console.log("cantidad Maxima: "+cantidad_maxima)
    var pax_extra= Number(document.getElementById("pax-extra").value);
    console.log("Pax extra: "+pax_extra)
    noches = $("#noches").val();
    console.log("Noches: "+noches)
    numero_hab = $("#numero_hab").val();
    console.log("NUmero hab: "+numero_hab)
    suma_extra = Number(extra_adultos) + Number(extra_infantil)
    console.log("Suma extra: "+suma_extra)
    console.log("-----------------------------------")
    preasignada = $("#preasignada")
    // console.log(suma_extra,cantidad_maxima)
    diff_extra=0
    if( numero_hab > 1 ){
        console.log("Ya no se puede preasignar una habitacion")
        preasignada.prop("disabled" , true);
        //preasignada.val("")
        preasignada.val(null)
    } else {
        console.log("Ahora si ya se puede agregar mas habitaciones");
        preasignada.prop("disabled", false)
    }
    if(cantidad_maxima!=0){
        if(suma_extra >cantidad_maxima){
            alert("Ha superado la cantidad máxima de personas de la habitación")
            $("#extra_adulto").val(0);
            $("#extra_infantil").val(0);
            return
        }
    }
    if(suma_extra>cantidad_hospedaje){
        diff_extra = suma_extra - cantidad_hospedaje
        extra_adultos = diff_extra
    }else{
        extra_adultos=0
    }
    if(event!=null){
        var costoplan = event.target.options[event.target.selectedIndex].dataset.costoplan;
        // console.log(costoplan)
        if(costoplan!=undefined){
            costo_plan=Number(costoplan)
            $('#costoplan').val(costo_plan)
        }else{
            costo_plan=0;
        }
    }else{
        costo_plan = Number($("#costoplan").val()) * suma_extra
        console.log(costo_plan)
    }
    if(pax_extra!=0){
        pax_extra= pax_extra * numero_hab * noches
    }
    if(costoplan!=undefined){
        costo_plan = costoplan * suma_extra
    }
    console.log(diff_extra)
    tarifa_adultos = $("#tarifa_adultos").val();
    tarifa_infantil = $("#tarifa_menores").val();
    tarifa_base = $("#tarifa_base").val()
    if(forzar_tarifa!="" || forzar_tarifa!=0  ){
        aux_total = $("#tarifa_base").val()
        aux_total = forzar_tarifa * noches * numero_hab
        tarifa_base=forzar_tarifa
        tarifa_adultos  = tarifa_base
        tarifa_infantil=tarifa_base
        total = Number(aux_total) + pax_extra + costo_plan
        $("#total").val(total)
        return //no calcula nada.
    }
    // tarifa_base =123;
    adicional_adulto=0;
    adicional_infantil=0;
    if(extra_adultos!=0){
       adicional_adulto = extra_adultos * tarifa_adultos *  noches;
    }
    // if(extra_infantil!=0){
    //     adicional_infantil = extra_infantil * tarifa_infantil*  noches;
    // }
    // console.log(tarifa_base,noches, numero_hab)
    aux_total = tarifa_base * noches * numero_hab
    //Adicionales
    total = aux_total + adicional_adulto + adicional_infantil + pax_extra + costo_plan
    $("#total").val(total);
}

// Calculamos la cantidad de noches de una reservacion
function calcular_noches(hab_id=0,preasignada=0, uso_casa=0){
    var tipo_hab=0;
    var fecha_salida= document.getElementById("fecha_salida")
    var fecha_entrada= document.getElementById("fecha_entrada");
    fecha_entrada_value = fecha_entrada.value
    fecha_salida_value = fecha_salida.value
    selectedDate = new Date(fecha_entrada_value)
    auxSelectedDate = selectedDate.toISOString().split('T')[0];
    min_salida = selectedDate.setDate(selectedDate.getDate()+1)
    min_salida = selectedDate.toISOString().split('T')[0];
    fecha_salida.setAttribute('min', min_salida)
    const dateSalida = new Date(fecha_salida_value);
	var noches= calculo_noches(fecha_entrada_value,fecha_salida_value)
    if(isNaN(noches)){
        document.getElementById("noches").value = 0
    }else{
        document.getElementById("noches").value = noches
    }
    var elemento = document.getElementById("tarifa");
    elemento_opcion = elemento.options[elemento.selectedIndex]
    if(elemento_opcion!=undefined){
        tipo_hab = elemento.options[elemento.selectedIndex].getAttribute('data-tipo')
        if(tipo_hab == null){
            tipo_hab=0
        }
    }
    forzar_tarifa= document.getElementById("forzar-tarifa").value;
    if(noches!=0 && forzar_tarifa!=0){
        precio_hospedaje  = forzar_tarifa/noches;
        // document.getElementById("precio_hospedaje").value = precio_hospedaje
    }
    //Si cambia el numero de noches y ya existen tarifas se calcula el total de la instancia.
    tarifa_base = $("#tarifa_base").val()
    if(fecha_entrada_value!="" && fecha_salida_value!=""){
    if( fecha_entrada_value >= fecha_salida_value ){
    fecha_salida.value=""
    }else{
        fechas = (getDatesInRange(auxSelectedDate,dateSalida))
        ultima_fecha = fechas[fechas.length-1]
        if(tarifa_base!=0 || tarifa_base!=""){
            editarTotalEstancia()
        }else{
            cambiar_adultosNew("",hab_id)
        }
        include = "includes/consultar_reservacion_disponible.php?fecha_entrada="+fecha_entrada.value+"&fecha_salida="+fecha_salida.value+"&hab_id="+hab_id+"&preasignada="+preasignada+"&uso_casa="+uso_casa+"&tipo_hab="+tipo_hab;
        if(hab_id!=0){
            $(".div_adultos").load(include,function(res){
                // console.log(res)
            });
        }
        $("#preasignada").load(include,function(res){
            // console.log(res)
        });
    }
    }
}

function sobreVenderHab(e){
    //Si se sobrevende todas la habitaciones están disponibles.
    /* if (e.currentTarget.checked) {
        // alert('checked');
    } else {
        // alert('not checked');
    } */
    console.log(e)
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

function comprobarExisteNoches(){

}

// Conseguimos la cantidad de adultos permitidos por tarifa hospedaje
function cambiar_adultosNew(event=null,hab_id){
    //si hay un select entonces se lee el evento del select para extraer el hab_id, desde reservaciones.
    //se verifica que el evento no sea nulo para obtener el id del tipo de la habitación desde el tipo de tarifa selccionada.
    var tipo_hab=0;
    if(event!=0){
        tipo_hab = event.target.options[event.target.selectedIndex].dataset.tipo;
        if(tipo_hab!=undefined){
            $("#tipo-habitacion").val(tipo_hab)
            $("#tipo-habitacion").attr("disabled",true);
        }
    }
    var forzar_tarifa = $("#forzar-tarifa").val()
    var tarifa= document.getElementById("tarifa").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
    var numero_hab= Number(document.getElementById("numero_hab").value);
    // $(".div_adultos").load("includes/cambiar_tarifaNew.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&hab_id="+hab_id);  
    url_data ="includes/cambiar_tarifaNew.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&hab_id="+hab_id
    if(!isNaN(noches) && forzar_tarifa=="" && tarifa!=""){
        $("#tarifa").attr('required',true);
        $.ajax({
            async:true,
            type: "GET",
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            url:url_data,
            beforeSend:loaderbar,
            success:function(res){
            console.log(res)
            $("#total").val(res.precio_hab)
            $("#tarifa_base").val(res.precio_hospedaje)
            $("#tarifa_menores").val(res.precio_infantil)
            $("#tarifa_adultos").val(res.precio_adulto)
            $("#precio_hospedaje").val(res.precio_hospedaje)
            $("#cantidad_hospedaje").val(res.cantidad_hospedaje)
            $("#cantidad_maxima").val(res.cantidad_maxima)
            calcular_noches(0,0, 0)
            editarTotalEstancia()
            },
            //success:problemas_sistema,
            timeout:5000,
            error:function(err){
                console.log(err)
            }
        });
    }else{
        //no consulta la tarifa de la bd.
        //  console.log("forzando:" + noches +" t:"+forzar_tarifa)
        if(forzar_tarifa!=""){
            $("#tipo-habitacion").removeAttr("disabled");
            $("#tarifa").attr('required',false);
            // $("#tarifa_base").val(forzar_tarifa)
            total = forzar_tarifa * noches * numero_hab
            $("#total").val(forzar_tarifa * noches * numero_hab)
            // $("#tarifa_base").val(total)
            precio_hospedaje = forzar_tarifa/ noches
            // $("#precio_hospedaje").val(precio_hospedaje)
            editarTotalEstancia()
        }else{
            var tarifa= document.getElementById("tarifa")
            if(tarifa.options.length!=0){
                $("#tarifa").attr('required',true);
            }
        }
    }
    //alert("Cambiando tarifa "+tarifa);
}

// Conseguimos la cantidad de adultos permitidos por tarifa hospedaje
function cambiar_adultos(hab_id){
    //si hay un select entonces se lee el evento del select para extraer el hab_id, desde reservaciones.
    var tarifa= document.getElementById("tarifa").value;
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
    var numero_hab= Number(document.getElementById("numero_hab").value);
    $(".div_adultos").html('<div class="spinner-border text-primary"></div>');
    $(".div_adultos").load("includes/cambiar_tarifa.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&hab_id="+hab_id);  
    //alert("Cambiando tarifa "+tarifa);
}

// Calculamos el total de una reservacion
function calcular_total(precio_hospedaje,total_adulto,total_junior,total_infantil){
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= Number(document.getElementById("numero_hab").value);
	var tarifa= Number(document.getElementById("tarifa").value);
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
	var extra_junior= Number(document.getElementById("extra_junior").value);
	var extra_infantil= Number(document.getElementById("extra_infantil").value);
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var descuento= Number(document.getElementById("descuento").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	//var total= total_hab + total_suplementos;
    var total= total_hab;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	document.getElementById("total_hab").value= total_hab;
	document.getElementById("total").value= calculo_descuento + total_suplementos;
}

function obtener_garantia(event=null){
    garantia_id = $("#forma-garantia").val()
    if(event!=0){
        var garantia = event.target.options[event.target.selectedIndex].dataset.garantia;
        var efectivo = event.target.options[event.target.selectedIndex].text
        efectivo_txt = efectivo.toLowerCase()
        console.log(efectivo_txt)
        if(garantia!=undefined && garantia == 1){
            if((efectivo_txt !="efectivo") && efectivo_txt!="tarjeta" && efectivo_txt!="tarjeta de credito" && efectivo_txt!="tarjeta de debito"){
                $("#voucher").attr("required",false)
                $("#voucher").attr("disabled",false)
            }else{
                $("#voucher").attr("disabled",true)
                $("#voucher").removeAttr("required")
            }
            $("#garantia_monto").attr("required",true)
            $("#garantia_monto").attr("disabled",false)
            $("#estadotarjeta").val(2)
        }else{
            $("#garantia_monto").attr("required",false)
            $("#garantia_monto").attr("disabled",true)
            $("#garantia_monto").val("")
            $("#voucher").attr("disabled",true)
            $("#voucher").removeAttr("required")
            $("#estadotarjeta").val("")
        }
    }
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

//modal para mostrar la información de la tarjeta del husped
function mostrar_modal_garantia(){
    id_huesped = $("#tomahuespedantes").val()
    estado_tarjeta=$("#estadotarjeta").val()
    estado_credito=$("#estadocredito").val()
    console.log(estado_credito)
    $("#mostrar_herramientas").load('includes/modal_mostrar_garantia.php?huesped='+id_huesped+"&estadotarjeta="+estado_tarjeta,function(){
        if(estado_tarjeta!=""){
            $(":radio[value="+estado_tarjeta+"]").prop("checked","true");
        }
        if(estado_credito!=""){
            $(":radio[value="+estado_credito+"]").prop("checked","true");
        }
    })
}

function aceptar_asignar_huesped_maestra(id_huesped,id_maestra,mov){
    //se debe actualizar el movimiento y la cuenta maestra.
    var usuario_id=localStorage.getItem("id");
    console.log("asignando husped a cuenta maestra", id_huesped)
    datos ={
        "usuario_id":usuario_id,
        "huesped":id_huesped,
        "id_maestra":id_maestra,
        "mov":mov,
    }
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"includes/guardar_huesped_maestra.php",
        data:datos,
        beforeSend:loaderbar,
        success:function(res){
            console.log(res)
        if(res=="SI"){
            swal("Húesped asignado correctamente a cuenta maestra", "El húesped seleccionado se ha agregado correctamente a la cuenta maestra elegida", "success");
            ver_cuenta_maestra()
        }else{
            swal("Debe llenar los campos requeridos para el húesped", "Verifique que los campos no estén vacíos", "error");
        }
    },
        timeout:5000,
        error:problemas_sistema
    });

}

function cambiar_huesped(){
    
}

// Modal para asignar huesped desde cuenta maestra
function asignar_huesped_maestra(maestra=0,mov=0){
    $("#mostrar_herramientas").load("includes/modal_asignar_huespedNew.php?maestra="+maestra+"&mov="+mov);
}

// Modal para asignar huesped en una reservacion nueva
function asignar_huespedNew(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
    $("#mostrar_herramientas").load("includes/modal_asignar_huespedNew.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil);
}

// Modal para asignar huesped en una reservacion
function asignar_huesped(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
    $("#mostrar_herramientas").load("includes/modal_asignar_huesped.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil);
}
// Busco el huesped asignar a la reservacion
function buscar_asignar_huespedNew(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil,id_maestra=0,mov=0){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
	$("#tabla_huesped").load("includes/buscar_asignar_huespedNew.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil+"&a_buscar="+a_buscar+"&id_maestra="+id_maestra+"&mov="+mov);
}

// Busco el huesped asignar a la reservacion
function buscar_asignar_huesped(funcion,precio_hospedaje,total_adulto,total_junior,total_infantil){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
	$("#tabla_huesped").load("includes/buscar_asignar_huesped.php?funcion="+funcion+"&precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil+"&a_buscar="+a_buscar);
}

function aceptar_asignar_huespedNew(id,nombre,apellido,empresa,telefono,pais,estado,ciudad,direccion,estado_tarjeta,tipo_tarjeta,titular_tarjeta,numero_tarjeta,vencimiento_mes,vencimiento_ano,ccv,correo,voucher, estado_credito, limite_credito, nombre_tarjeta){
    // console.log(id,nombre,apellido,empresa,telefono,pais,estado,ciudad,direccion,estado_tarjeta,tipo_tarjeta,titular_tarjeta,numero_tarjeta,vencimiento_mes,vencimiento_ano,ccv, voucher)
    $("#nombre").val(nombre)
    $("#apellido").val(apellido)
    $("#empresa").val(empresa)
    $("#telefono").val(telefono)
    $("#pais").val(pais)
    $("#estado").val(estado)
    $("#ciudad").val(ciudad)
    $("#direccion").val(direccion)
    $("#estadotarjeta").val(estado_tarjeta)
    $("#nut").val(numero_tarjeta)
    $("#nt").val(titular_tarjeta)
    $("#ccv").val(ccv)
    $("#mes").val(vencimiento_mes)
    $("#year").val(vencimiento_ano)
    $("#limitecredito").val(limite_credito)
    $("#estadocredito").val(estado_credito)
    $("#nombre_tarjeta").val(nombre_tarjeta)
    $("#correo").val(correo)
    if(estado_tarjeta==2){
        $("#garantia_monto").attr("disabled",false);
        $("#garantia_monto").attr("required",true);
    }else{
        $("#garantia_monto").attr("disabled",true);
        $("#garantia_monto").attr("required",false);
        $("#garantia_monto").val("")
    }
    if(tipo_tarjeta=="Efectivo" || tipo_tarjeta==1){
        $("#forma-garantia option[value=1]").prop("selected", true);
    }
    if(tipo_tarjeta=="Debito" || tipo_tarjeta=="Credito" || tipo_tarjeta==2){
        $("#forma-garantia option[value=2]").prop("selected", true);
        $("#btngarantia").text("Ver tarjeta")
        $("#btngarantia").removeAttr("disabled");
    }
    if(tipo_tarjeta=="Transferencia" || tipo_tarjeta==3){
        $("#forma-garantia option[value=3]").prop("selected", true);
        $("#btngarantia").text("Ver tarjeta")
        $("#btngarantia").removeAttr("disabled");
    }
    if(voucher!=""){
        $("#div_voucher").attr("disabled",false);
        $('#voucher').val(voucher)
        $("#forma-garantia option[value="+tipo_tarjeta+"]").prop("selected", true);
    }else{
        $("#div_voucher").attr("disabled",true);
    }
    $("#tomahuespedantes").val(id)
    //cargar los datos de la tarjeta igualmente.
	$('#caja_herramientas').modal('hide');
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
function mostrar_datos(hab_id,id_reservacion){
	$('.div_datos').hide();
	$('.boton_datos').hide();
	//$('.div_oculto').show();
	var id_huesped= document.getElementById("id_huesped").value;
	var id= id_huesped;
	$(".div_oculto").html('<div class="spinner-border text-primary"></div>');
    $(".div_oculto").load("includes/editar_huesped_reservar.php?id="+id+"&hab_id="+hab_id+"&id_reservacion="+id_reservacion);  
}

// Ocultar los datos de un huesped en una reservacion
function ocultar_datos(hab_id,id_reservacion){
	//$('.div_oculto').hide();
    if(hab_id != -1){
        cambiar_adultos(hab_id);
    }else{
        cambiar_adultos_editar(id_reservacion);
    }
}

// Modal para ver los datos de un cupon en una reservacion
function datos_cupon(){
    var codigo_descuento= encodeURI(document.getElementById("codigo_descuento").value);
    $("#mostrar_herramientas").load("includes/modal_datos_cupon.php?codigo_descuento="+codigo_descuento);
}

// Modal para aplicar un cupon en una reservacion
function aplicar_cupon(precio_hospedaje,total_adulto,total_junior,total_infantil){
    var codigo_descuento= encodeURI(document.getElementById("codigo_descuento").value);
    $("#mostrar_herramientas").load("includes/modal_aplicar_cupon.php?precio_hospedaje="+precio_hospedaje+"&total_adulto="+total_adulto+"&total_junior="+total_junior+"&total_infantil="+total_infantil+"&codigo_descuento="+codigo_descuento);
}

// Calculamos aplicando un cupon el total de una reservacion
function calcular_total_cupon(precio_hospedaje,total_adulto,total_junior,total_infantil,cantidad,tipo){
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= Number(document.getElementById("numero_hab").value);
	var tarifa= Number(document.getElementById("tarifa").value);
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
	var extra_junior= Number(document.getElementById("extra_junior").value);
	var extra_infantil= Number(document.getElementById("extra_infantil").value);
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var descuento_cupon= cantidad;
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil;
	//var total= total_hab + total_suplementos;
    var total= total_hab;
    if(tipo == 0){
        var calculo_descuento= descuento_total(total,descuento_cupon);
    }else{
        var calculo_descuento= total - descuento_cupon;
    }
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	document.getElementById("total_hab").value= total_hab;
	document.getElementById("total").value= calculo_descuento + total_suplementos;
}

function guardarReservacion(id_huesped,hab_id=0,id_cuenta=0,id_reservacion=0){
    var usuario_id=localStorage.getItem("id");
    var numero_hab= Number(document.getElementById("numero_hab").value);
    var noches= Number(document.getElementById("noches").value);
    var tarifa= Number(document.getElementById("tarifa").value);
    var ruta_regreso="";
    var preasignada=0;
    var sobrevender=0;
    var canal_reserva=0;
    var tipo_reservacion=0;
    var persona_reserva="";
    var estado = 1;
    var titutlo =""
    //todos los campos que solo están "disponibles en reservaciones."
    if(hab_id==0){
        preasignada= (document.getElementById("preasignada").value);
        sobrevender = document.getElementById('sobrevender').checked
        console.log("A ver que show " + sobrevender)
        canal_reserva = (document.getElementById("canal-reserva").value);
        tipo_reservacion = (document.getElementById("tipo-reservacion").value);
        titulo="RESERVACIÓN"
        var persona_reserva= (document.getElementById("persona-reserva").value);
        ruta_regreso="ver_reservaciones()"
    }else{
        estado=2;
        persona_reserva="checkin"
        titulo="CHECK-IN"
        ruta_regreso="principal()"
    }

    var forzar_tarifa = $("#forzar-tarifa").val()
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
    var extra_infantil= Number(document.getElementById("extra_infantil").value);
    let adultos = extra_adulto
    let infantiles = extra_infantil
    var pax_extra= Number(document.getElementById("pax-extra").value);
    var tipo_hab= (document.getElementById("tipo-habitacion").value);
    var total= (document.getElementById("total").value);
    var plan_alimentos = (document.getElementById("plan-alimentos").value);
    // var estado = preasignada!="" ? 4 : 2;
    // estado = 1;
    var forma_pago= (document.getElementById("forma-garantia").value);
    var fecha_entrada= (document.getElementById("fecha_entrada").value);
    var fecha_salida= (document.getElementById("fecha_salida").value);
    var noches = (document.getElementById("noches").value);
    var numero_hab = (document.getElementById("numero_hab").value);
    var precio_hospedaje = (document.getElementById("tarifa").value);
    var total_hospedaje= precio_hospedaje * noches * numero_hab;
    var total_hab= total_hospedaje + extra_adulto  + extra_infantil + pax_extra;
    var precio_hospedaje = document.getElementById('precio_hospedaje').value
    total_hab = precio_hospedaje * noches * numero_hab
    var total_hospedaje = document.getElementById('total').value
    sobrevender = sobrevender ? 1 : 0 ;
    total_pago = document.getElementById('garantia_monto').value;
    //verifica si hay una tarifa (forzada o no)
    var tarifa_existe = 0;
    if($("#forzar-tarifa").val()==""){
        tarifa_existe = tarifa;
        forzar_tarifa=0;
    }else{
        tarifa_existe=forzar_tarifa;
        total_hospedaje = forzar_tarifa
        // total = forzar_tarifa
        precio_hospedaje = forzar_tarifa
        total_hab = precio_hospedaje * noches * numero_hab
        $("#tarifa").removeAttr('required');
    }
    ruta="includes/guardar_reservacionNew.php";
    if(id_cuenta!=0 || id_reservacion!=0){
        ruta="includes/aplicar_editar_reservacionNew.php";
    }
    var voucher =document.getElementById('voucher').value
    var estado_tarjeta=document.getElementById('estadotarjeta').value
    estado_credito = $("#estadocredito").val()
    limite_credito = $("#limitecredito").val()
    limite_credito = limite_credito == "" ? 0 : limite_credito
    suma_extra = Number(extra_adulto) + Number(extra_infantil)
    diff_extra=0
    if(suma_extra>cantidad_hospedaje){
        diff_extra = suma_extra - cantidad_hospedaje
        extra_adulto = diff_extra
        extra_infantil=0
    }else{
        extra_adulto=0
        extra_infantil=0
    }
    let adicionales = obtener_adicionales()
    adicionales = adicionales.length== 0 ? 0: adicionales
    var datos = {
        "id":id_reservacion,
        "id_huesped": id_huesped,
        "fecha_entrada": fecha_entrada,
        "fecha_salida": fecha_salida,
        "noches": noches,
        "numero_hab": numero_hab,
        "precio_hospedaje": precio_hospedaje,
        "cantidad_hospedaje": extra_adulto,
        "pax_extra":pax_extra,
        "extra_adulto": extra_adulto,
        "extra_junior": 0,
        "extra_infantil": extra_infantil,
        "extra_menor": 0,
        "tarifa": tarifa,
        "nombre_reserva": persona_reserva,
        "acompanante": '',
        "forma_pago": forma_pago,
        "limite_pago": 0,
        "suplementos": 0,
        "total_suplementos": 0,
        "total_hab": total_hab,
        "forzar_tarifa":forzar_tarifa,
        "descuento": 0,
        "codigo_descuento": 0,
        "total": total,
        "total_pago": total_pago,
        "hab_id": Number(hab_id),
        "tipo_hab": tipo_hab,
        "estado": estado,
        "usuario_id": usuario_id,
        "plan_alimentos" : plan_alimentos,
        "canal_reserva" : canal_reserva,
        "tipo_reservacion":tipo_reservacion,
        "sobrevender":sobrevender,
        "preasignada" : Number(preasignada),
        "voucher":voucher,
        "estado_tarjeta":estado_tarjeta,
        "estado_credito":estado_credito,
        "limite_credito":limite_credito,
        "adicionales":adicionales,
        "adultos":adultos,
        "infantiles":infantiles,
        "id_ticket":0
    };
    // console.log(datos, ruta)
    // return
    var correo = $("#correo").val()
    if(fecha_entrada.length >0 && fecha_salida.length >0 && noches >0  && tarifa_existe >0 && persona_reserva.length >0 && forma_pago !="" && total_hab >=0){
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:ruta,
            data:datos,
            beforeSend:loaderbar,
            //success:ver_reservaciones,
            success:function(res){
                // return
                //recibo el id de la reservacion creada.
                //Aquí en teoría ya se guardo/hizo la reservación y es momento de mandar el correo con el pdf de confirmación
                // console.log(res)
                // return
                /* confirarmNo = document.getElementById('no')
                if(confirarmNo!=null){
                    confirarmNo = confirarmNo.checked
                    if(!confirarmNo && correo!=""){
                        //alert("enviar correo")
                        enviar_reserva_correo(res,correo,false);
                    }
                }
                ver_reporte_reservacion(res,ruta_regreso,titulo,correo) */
                confirarmNo = document.getElementById("confirmacion").checked;
                //onsole.log("switch para confirmar " +  confirarmNo)
                if (confirarmNo && correo != "") {
                    //alert("enviar correo");
                    enviar_reserva_correo(res, correo, false);
                }
                //console.log("Ya salio")
                ver_reporte_reservacion(res, ruta_regreso, titulo, correo);
            },
            timeout:5000,
            error:problemas_sistema
        });
        return false;
    }else{
        alert("Campos incompletos o descuento no permitido");
    }
}

//Auditoria

function ver_auditoria(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_auditoria.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

function ver_nuevo_rack() {
    $('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/rack.php");
    closeModal();
    closeNav()
}

function enviar_transacciones_correo(mov,abono,descripcion,forma_pago){
    var usuario_id=localStorage.getItem("id");
    var datos = {
        "mov": mov,
        "abono":abono,
        "descripcion":descripcion,
        "forma_pago":forma_pago,
    };
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"includes/enviar_correo_transacciones.php",
        data:datos,
        beforeSend:inicioEnvio,
        success:function(res){
            console.log(res)
        },
        timeout:5000,
        error:problemas
    });
return false;
}

function enviar_abono_correo(mov,abono,descripcion,forma_pago){
        var usuario_id=localStorage.getItem("id");
        var datos = {
            "mov": mov,
            "abono":abono,
            "descripcion":descripcion,
            "forma_pago":forma_pago,
        };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/enviar_correo_abono.php",
            data:datos,
            beforeSend:inicioEnvio,
            success:function(res){
                console.log(res)
            },
            timeout:5000,
            error:problemas
        });
    return false;
}


function enviar_reserva_correo(info,correo,reenviar){
    if(correo!=""){
        var usuario_id=localStorage.getItem("id");
        var datos = {
            "info": info,
            "usuario_id":usuario_id,
            "correo":correo,
        };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/enviar_correo_reserva.php",
            data:datos,
            beforeSend:inicioEnvio,
            success:function(res){
                respuesta_correo_reserva(res,reenviar)
            },
            timeout:5000,
            error:problemas
        });
    }else{
        swal("No hay un correo asociado para enviar la confirmación","No hay un correo asociado para enviar la confirmación",'error');
    }
    return false;
}
function respuesta_correo_reserva(info,reenviar){
    console.log(info);
    if(reenviar){
        swal("Correo de confirmación reenviado correctamente","Correo de confirmación reenviado correctamente",'success');
    }
}

function enviar_cancela_correo(info,correo,reenviar){
    if(correo!=""){
        var usuario_id=localStorage.getItem("id");
        var datos = {
            "info": info,
            "usuario_id":usuario_id,
            "correo":correo,
        };
        console.log(datos)
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/enviar_correo_cancela.php",
            data:datos,
            beforeSend:inicioEnvio,
            success:function(res){
                respuesta_correo_reserva(res,reenviar)
            },
            timeout:5000,
            error:problemas
        });
    }else{
        // swal("No hay un correo asociado para enviar la confirmación","No hay un correo asociado para enviar la confirmación",'error');
    }
    return false;
}
function asignarValorTarjeta(){

    if(!verificarFormulario('form-garantia',"name")){
        closeModal();
    }
    $("#nut").val($("#numero_tarjeta").val())
    $("#nt").val($("#cardholder").val())
    $("#nombre_tarjeta").val($("#tipo").val())
    $("#mes").val($("#expires-month").val())
    $("#year").val($("#expires-year").val())
    $("#ccv").val($("#tccv").val())
    $("#estadotarjeta").val($("input[name=estado]:checked").val())
    estado_credito = "";
    if ($('#c_abierto').is(':checked')) {
        estado_credito = "abierto";
    }
    if ($('#c_cerrado').is(':checked')) {
        estado_credito = "cerrado";
    }
    limite_credito = encodeURI(document.getElementById("limite_credito").value);
    $("#estadocredito").val(estado_credito)
    $("#limitecredito").val(limite_credito)
}

function guardarCheck(){
    hab_id = $("#habitacion_checkin :selected").data("habid")
    if(hab_id!=0){
        guardarNuevaReservacion(hab_id)
    }else{
        alert("Debe seleccionar al menos una habitación")
    }
}

function datosFormulario(id_form){
    var form = document.getElementById(id_form);
    var datosFormulario= {};

    for (var i = 0; i < form.elements.length; i++) {
        var elemento = form.elements[i];
        var id=elemento.id
        datosFormulario[id] = elemento.value
    }
    return datosFormulario;
}

function verificarFormulario(id_form,field) {
    var form = document.getElementById(id_form);
    var camposNoValidados = [];
    // Recorre todos los elementos del formulario
    for (var i = 0; i < form.elements.length; i++) {
        var elemento = form.elements[i];
        // Verifica si el elemento es un campo requerido y si está vacío
    if (elemento.required && elemento.value === "" && elemento.value === null ) {
    if(field=="id"){
        camposNoValidados.push(elemento.id);
    }else{
        camposNoValidados.push(elemento.name);
    }
    }
    }
    // Si hay campos no validados, muestra una alerta con sus identificadores
    if (camposNoValidados.length > 0) {
      //var mensaje="";
      var mensaje = "Los siguientes campos son requeridos pero están vacíos:\n";
      for (var j = 0; j < camposNoValidados.length; j++) {
        mensaje += "- " + camposNoValidados[j] + "\n";
      }
      alert(mensaje);
      //swal("Los siguientes campos son requeridos pero están vacíos",mensaje,'error');
      return true
    }else{
        return false
    }
}

function guardarUsoCasa(hab_id,estado){
    if (typeof fecha_valida !== 'undefined' && fecha_valida==false) {
        alert("Fecha de asignación inválida")
        return false
    }

    if(!verificarFormulario("form-reserva","id") ){
        // guardarReservacion(0,hab_id,id_cuenta,id_reservacion)
        var usuario_id=localStorage.getItem("id");
        var nombre = $("#nombre").val()
        var apellido = $("#apellido").val()
        var fecha_entrada = $("#fecha_entrada").val()
        var fecha_salida = $("#fecha_salida").val()
        $('#caja_herramientas').modal('hide');
        var datos = {
                "hab_id": hab_id,
                "estado": estado,
                "usuario_id": usuario_id,
                "nombre" : nombre,
                "apellido" : apellido,
                "fecha_entrada":fecha_entrada,
                "fecha_salida":fecha_salida
            };
        // console.log(datos)
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/hab_limpieza.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                // console.log(res)
                principal()
            },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

function obtener_adicionales(){
    //****************************************************************************************** */
    // funcion para los huespedes extras
    const nombresHuespedes = document.querySelectorAll(".nombreExtra");
    const valoresNombres = [];
    nombresHuespedes.forEach(function(input) {
        valoresNombres.push(input.value);
    });
    console.log(valoresNombres)
    const apellidosHuespedes = document.querySelectorAll(".apellidoExtra");
    const valoresApellidos = [];
    apellidosHuespedes.forEach(function(input){
        valoresApellidos.push(input.value);
    });
    console.log(valoresApellidos);
    const arregloHuespedes = [];
    for (let i = 0; i < valoresNombres.length; i++){
        const nuevoObjeto = {
            nombre: valoresNombres[i],
            apellido: valoresApellidos[i]
        };
        arregloHuespedes.push(nuevoObjeto)
    };
    return arregloHuespedes;
    console.log(arregloHuespedes);
}

function guardarNuevaReservacion(hab_id,id_cuenta=0,id_reservacion=0){
    const btn_reservacion = document.getElementById("btn_reservacion");

    if(btn_reservacion){
        btn_reservacion.setAttribute("disabled" , "true")
    }

    if (typeof fecha_valida !== 'undefined' && fecha_valida==false) {
        if(btn_reservacion){
            btn_reservacion.removeAttribute("disabled");
        }
        alert("Fecha de asignación inválida")
        return false
    }

    // Comprobar la forma de garantia si esta activo el input o desactivado y si viene null o string vacio
    var forma_garantia = document.getElementById("garantia_monto")
    if (forma_garantia.disabled) {
        console.log("El campo de texto esta desactivado")
    } else {
        console.log("El campo de texto esta activado")
        if(forma_garantia.value === "" || forma_garantia === null) {
            alert("Falta agregar el monto de la forma de garantia")
            return false
        }
    }

    if(!verificarFormulario("form-reserva","id") ){
        var usuario_id=localStorage.getItem("id");
        var nombre_huesped= document.getElementById("nombre").value;
        var nombre_huesped_sin_editar=""
        if(document.getElementById("leer_nombre_sin_editar")){
            nombre_huesped_sin_editar= document.getElementById("leer_nombre_sin_editar").value;
        }
        var apellido_huesped= document.getElementById("apellido").value;
        var apellido_huesped_sin_editar="";
        if(document.getElementById("leer_apellido_sin_editar")){
            apellido_huesped_sin_editar= document.getElementById("leer_apellido_sin_editar").value;
        }

        var empresa_huesped= document.getElementById("empresa").value;
        var telefono_huesped= document.getElementById("telefono").value;
        var pais_huesped= document.getElementById("pais").value;
        var estado_huesped= document.getElementById("estado").value;
        var ciudad_huesped= document.getElementById("ciudad").value;
        var direccion_huesped= document.getElementById("direccion").value;
        var comentarios_huesped= document.getElementById("observaciones").value;
        var tipo_tarjeta= document.getElementById("forma-garantia").value;
        if(tipo_tarjeta == "" || tipo_tarjeta == null || tipo_tarjeta == "Seleccione una opción") {
            if(btn_reservacion){
                btn_reservacion.removeAttribute("disabled");
            }
            alert("Falta agregar la forma de garantia");
            return
        }
        var correo = $("#correo").val()
        huesped = $("#tomahuespedantes").val()
        var voucher =document.getElementById('voucher').value
        titular_tarjeta=$("#nt").val()
        numero_tarjeta=$("#nut").val()
        vencimiento_mes=$("#mes").val()
        vencimiento_ano=$("#year").val()
        cvv=$("#ccv").val()
        nombre_tarjeta = $("#nombre_tarjeta").val()
        estado_tarjeta=$("#estadotarjeta").val()
        estado_credito = $("#estadocredito").val()
        limite_credito = $("#limitecredito").val()
        limite_credito = limite_credito == "" ? 0 : limite_credito
        if(numero_tarjeta=="**************"){
            numero_tarjeta=null
        }
        // console.log(estado_credito, nombre_tarjeta)
        // return
        //guardar asyncronicamente el "husped" para obtener su id; si ya existe retorna su id..
        let xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.open("GET","includes/guardar_huesped.php?nombre="+nombre_huesped+"&apellido="+apellido_huesped+"&direccion="+direccion_huesped+"&pais="+pais_huesped+"&empresa="+empresa_huesped+"&ciudad="+ciudad_huesped+"&estado="+estado_huesped+"&telefono="+telefono_huesped+"&comentarios="+comentarios_huesped+"&tipo_tarjeta="+tipo_tarjeta+"&usuario_id="+usuario_id+"&titular_tarjeta="+titular_tarjeta+"&numero_tarjeta="+numero_tarjeta+"&vencimiento_mes="+vencimiento_mes+"&vencimiento_ano="+vencimiento_ano+"&cvv="+cvv+"&nombre_tarjeta="+nombre_tarjeta+"&estado_tarjeta="+estado_tarjeta+"&correo="+correo+"&voucher="+voucher+"&estado_credito="+estado_credito+"&limite_credito="+limite_credito+"&nombre_huesped_sin_editar="+nombre_huesped_sin_editar+"&apellido_huesped_sin_editar="+apellido_huesped_sin_editar,true);
        xhttp.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                //Entrara la contidicion que valida la respuesta del formulario
                //console.log(e.target.responseText);
                //return
                const  response_msj =xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
                if(response_msj == "NO_DATA"){
                    swal("Debe llenar los campos requeridos para el húesped", "Verifique que los campos no estén vacíos", "error");
                    if(btn_reservacion){
                        btn_reservacion.removeAttribute("disabled");
                    }
                    return
                }else if(response_msj=="NO_VALIDO"){
                    swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
                    if(btn_reservacion){
                        btn_reservacion.removeAttribute("disabled");
                    }
                    return
                }else{
                    if(btn_reservacion){
                        btn_reservacion.setAttribute("disabled" , "true")
                    }
                    guardarReservacion(response_msj,hab_id,id_cuenta,id_reservacion)
                    //todo ocurre correctamente.
                }
            }else{
                swal("Error del servidor!", "Intentelo de nuevo o contacte con soporte tecnico", "error");
                if(btn_reservacion){
                    btn_reservacion.removeAttribute("disabled");
                }
            }
        })
        xhttp.send();
    }
    if(btn_reservacion){
        btn_reservacion.removeAttribute("disabled");
    }
}

// Guardar una reservacion
function guardar_reservacion(precio_hospedaje,total_adulto,total_junior,total_infantil,cantidad_hospedaje,hab_id,cantidad_maxima,tipo_hab,estado){
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
    var cantidad_ocupacion= extra_adulto + extra_junior + extra_infantil + extra_menor;
	var tarifa= Number(document.getElementById("tarifa").value);
	var nombre_reserva= encodeURI(document.getElementById("nombre_reserva").value);
	var acompanante= encodeURI(document.getElementById("acompanante").value);
	var forma_pago= document.getElementById("forma_pago").value;
	var limite_pago= document.getElementById("limite_pago").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var forzar_tarifa= Number(document.getElementById("forzar_tarifa").value);
	var descuento= Number(document.getElementById("descuento").value);
    var codigo_descuento= document.getElementById("codigo_descuento").value;
    //var codigo_descuento= Number(document.getElementById("codigo_descuento").value);
    var total_pago= Number(document.getElementById("total_pago").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil;
	//var total= total_hab + total_suplementos;
    //var total= total_hab; ANTERIOR
    var total= Number(document.getElementById("total").value);
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
        "codigo_descuento": codigo_descuento,
        "total": total,
        "total_pago": total_pago,
        "hab_id": hab_id,
        "tipo_hab": tipo_hab,
        "estado": estado,
        "usuario_id": usuario_id,
    };

    //  console.log(datos)
    //  return ;

	if(id_huesped >0 && fecha_entrada.length >0 && fecha_salida.length >0 && noches >0 && numero_hab >0 && tarifa >0 && nombre_reserva.length >0 && forma_pago >0 && limite_pago >0 && total_suplementos >=0 && total_pago >=0 && descuento >-0.01 && descuento <100){
        if(cantidad_ocupacion <= cantidad_maxima){
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
                    "codigo_descuento": codigo_descuento,
                    "total": total,
                    "total_pago": total_pago,
                    "hab_id": hab_id,
                    "tipo_hab": tipo_hab,
                    "estado": estado,
                    "usuario_id": usuario_id,
                };
            if(hab_id != 0){
                $.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/guardar_reservacion.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:principal,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
                });
                return false;
            }else{
                $.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/guardar_reservacion.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:ver_reservaciones,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
                });
            return false;
            }
        }else{
            alert("¡Cantidad máxima excedida de personas permitidas por el tipo de habitación!");
        }
    }else{
        alert("Campos incompletos o descuento no permitido");
    }
}

// Muestra las reservaciones de la bd
function ver_reservaciones(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra la paginacion de las reservaciones
function ver_reservaciones_paginacion(buton,posicion,caso=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $('#inicial').value
    final =$('#final').value
    $("#paginacion_reservaciones").load("includes/ver_reservaciones_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id+"&caso="+caso+"&inicial="+inicial+"&final="+final,
    function(res){
    });
}

// Barra de diferentes busquedas en ver llegadas
function buscar_llegadas_salidas(e,opcion){
    setTimeout(() => {
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        var inicial = $("#inicial").val()
        var final = $("#final").val()
        if(inicial==undefined){
            inicial="";
        }
        final = $("#final").val()
        if(final==undefined){
            final="";
        }
        funcion_php="";
        funcion_buscar="";
        if(opcion==1){
            funcion_php="ver_llegadas.php"
            funcion_buscar = "buscar_llegadas.php"
        }else{
            funcion_php ="ver_salidas.php"
            funcion_buscar = "buscar_salidas.php"
        }
        if(a_buscar.length >0){
            $('.pagination').hide();
        }else{
            //$('.pagination').show();
            // if( e.which === 8 ){ $("#area_trabajo_menu").load("includes/"+funcion_php+"?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+0); return false; }
        }
        $("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+opcion+"&final="+final);  
    }, "1000");
}

// Barra de diferentes busquedas en ver reservaciones
function buscar_reservacion(e){
    const div = document.getElementById("paginacion_reservaciones");

    div.innerHTML = "";

    setTimeout(() => {
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        if(a_buscar.length >0){
            $('.pagination').hide();
            console.log(a_buscar)
            $("#paginacion_reservaciones").load("includes/buscar_reservacion.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id,function(res){
            });
        }else{
            $('.pagination').show();
            // return false;
            // if( e.which === 8 ){ $("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id); return false; }
        }
    }, "1000");
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

// Busqueda combinada en ver reservaciones
function busqueda_reservacion_combinada(){
    div = document.getElementById("paginacion_reservaciones");

    div.innerHTML = "";

	var inicial=$("#inicial").val();
	var final=$("#final").val();
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var id=localStorage.getItem("id");
    if((inicial.length >0 && final.length >0) || a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#paginacion_reservaciones").load("includes/busqueda_reservacion_combinada.php?inicial="+inicial+"&final="+final+"&id="+id+"&a_buscar="+a_buscar);
}

// Muestra las reservaciones por dia de la bd
function ver_reservaciones_por_dia(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_reservaciones_por_dia.php?usuario_id="+usuario_id);
	closeNav();
}

// Muestra la paginacion de las reservaciones por dia
function ver_reservaciones_paginacion_por_dia(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_reservaciones").load("includes/ver_reservaciones_paginacion_por_dia.php?posicion="+posicion+"&usuario_id="+usuario_id);
}

// Barra de diferentes busquedas en ver reservaciones por dia
function buscar_reservacion_por_dia(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/buscar_reservacion_por_dia.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);
}

// Busqueda por fecha en ver reservaciones por dia
function busqueda_reservacion_por_dia(){
	var dia=$("#dia").val();
    var id=localStorage.getItem("id");
    if(dia.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/busqueda_reservacion_por_dia.php?dia="+dia+"&id="+id);
}

// Busqueda dentro de los reportes de entrada/salida.
function busqueda_reservacion_combinada_por_dia(){
	var dia=$("#dia").val();
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var id=localStorage.getItem("id");
    if(dia.length >0 || a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/busqueda_reservacion_combinada_por_dia.php?dia="+dia+"&id="+id+"&a_buscar="+a_buscar);
}

// Busqueda combinada en ver reservaciones por dia
function busqueda_reservacion_combinada_por_dia(){
	var dia=$("#dia").val();
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var id=localStorage.getItem("id");
    if(dia.length >0 || a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/busqueda_reservacion_combinada_por_dia.php?dia="+dia+"&id="+id+"&a_buscar="+a_buscar);
}

//Generar reporte de todas las reservaciones (rango de fechas)

function ver_reservaciones_reporte(){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    final = $("#final").val()
    a_buscar = $("#a_buscar").val()
    window.open("includes/reporte_reservaciones.php?inicial="+inicial+"&final="+final+"&usuario_id="+usuario_id+"&a_buscar="+a_buscar);
}

// Generar reporte en ver reservaciones por dia
function reporte_reservacion_por_dia(dia){
    var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_reservacion_por_dia.php?dia="+dia+"&usuario_id="+usuario_id);
}

// Editar una reservacion
function editar_reservacionNew(id,ruta_regreso){
    if(ruta_regreso==""){
        ruta_regreso="regresar_reservacion()";
    }
    $("#area_trabajo_menu").load("includes/editar_reservacionNew.php?id="+id+"&ruta_regreso="+ruta_regreso);
}

// Editar un checkin
function editar_checkin(id,hab_id,ruta_regreso){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/editar_checkin.php?id="+id+"&hab_id="+hab_id+"&ruta_regreso="+ruta_regreso+"&usuario_id="+usuario_id);
    closeModal();
	closeNav();
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
    var numero_hab= Number(document.getElementById("numero_hab").value);
    $(".div_adultos_editar").html('<div class="spinner-border text-primary"></div>');
    $(".div_adultos_editar").load("includes/cambiar_tarifa_editar.php?tarifa="+tarifa+"&noches="+noches+"&numero_hab="+numero_hab+"&id="+id);  
}

// Calculamos el total de una reservacion al editarla
function calcular_total_editar(precio_hospedaje,total_adulto,total_junior,total_infantil){
	var fecha_entrada= document.getElementById("fecha_entrada").value;
	var fecha_salida= document.getElementById("fecha_salida").value;
	var noches= calculo_noches(fecha_entrada,fecha_salida);
	var numero_hab= Number(document.getElementById("numero_hab").value);
	var tarifa= Number(document.getElementById("tarifa").value);
    var extra_adulto= Number(document.getElementById("extra_adulto").value);
	var extra_junior= Number(document.getElementById("extra_junior").value);
	var extra_infantil= Number(document.getElementById("extra_infantil").value);
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var descuento= Number(document.getElementById("descuento").value);
    //var total_pago= Number(document.getElementById("total_pago").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	//var total= total_hab + total_suplementos;
    var total= total_hab;
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	/*document.getElementById("noches").value= noches;
	document.getElementById("tarifa").value= tarifa;
	document.getElementById("numero_hab").value= numero_hab;*/
	document.getElementById("total_hab").value= total_hab;
	document.getElementById("total").value= calculo_descuento + total_suplementos;
}

// Editar una reservacion
function modificar_reservacion(id,precio_hospedaje,total_adulto,total_junior,total_infantil,cantidad_hospedaje,id_cuenta,cantidad_maxima,tipo_hab){
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
    var cantidad_ocupacion= extra_adulto + extra_junior + extra_infantil + extra_menor;
	var tarifa= Number(document.getElementById("tarifa").value);
	var nombre_reserva= encodeURI(document.getElementById("nombre_reserva").value);
	var acompanante= encodeURI(document.getElementById("acompanante").value);
	var forma_pago= document.getElementById("forma_pago").value;
	var limite_pago= document.getElementById("limite_pago").value;
	var suplementos= encodeURI(document.getElementById("suplementos").value);
	var total_suplementos= Number(document.getElementById("total_suplementos").value);
	var forzar_tarifa= Number(document.getElementById("forzar_tarifa").value);
	var descuento= Number(document.getElementById("descuento").value);
    var codigo_descuento= document.getElementById("codigo_descuento").value;
    //var codigo_descuento= Number(document.getElementById("codigo_descuento").value);
    var total_pago= Number(document.getElementById("total_pago").value);
	var total_hospedaje= precio_hospedaje * noches * numero_hab;
	var total_adulto= total_adulto * extra_adulto;
	var total_junior= total_junior * extra_junior;
	var total_infantil= total_infantil * extra_infantil;
	var total_hab= total_hospedaje + total_adulto + total_junior + total_infantil; 
	//var total= total_hab + total_suplementos;
    //var total= total_hab; ANTERIOR
    var total= Number(document.getElementById("total").value);
	var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	total= calculo_descuento;
	if(id >0 && id_huesped >0 && fecha_entrada.length >0 && fecha_salida.length >0 && noches >0 && numero_hab >0 && tarifa >0 && nombre_reserva.length >0 && forma_pago.length >0 && limite_pago >0 && total_suplementos >=0 && total_pago >=0 && descuento >-0.01 && descuento <100){
        if(cantidad_ocupacion <= cantidad_maxima){
            $("#boton_reservacion").html('<div class="spinner-border text-primary"></div>');
            var datos = {
                "id": id,
                "id_huesped": id_huesped,
                "id_cuenta": id_cuenta,
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
                "codigo_descuento": codigo_descuento,
                "total": total,
                "total_pago": total_pago,
                "tipo_hab": tipo_hab,
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
            alert("¡Cantidad máxima excedida de personas permitidas por el tipo de habitación!");
        }
    }else{
        alert("Campos incompletos o descuento no permitido");
    }
}

// Muestra las reservaciones de la bd
function ver_reporte_reservacion(id,ruta="regresar_reservacion()",titulo="RESERVACION",correo=""){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_reporte_reservacion.php?id="+id+"&usuario_id="+usuario_id+"&ruta="+ruta+"&titulo="+titulo+"&correo="+correo);
	closeNav();
}

// Generar reporte de reservacion
function reporte_reservacion(id,titulo){
    var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_reservacion.php?id="+id+"&usuario_id="+usuario_id+"&titulo="+titulo);
}

// Borrar una reservacion
function borrar_reservacion(id,preasignada=0){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
                "usuario_id": usuario_id,
                "preasignada":preasignada
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
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

//funcion para agregar la habitacion seleccionada a la reservacion.
function guardar_preasignar_reservacion(id,opcion=0){
    var usuario_id=localStorage.getItem("id");
    preasignada = $("#preasignada").val();
    // console.log(preasignada,id)
    // return
    if (id >0 && preasignada.length >0) {
        $('#caja_herramientas').modal('hide');
        $("#boton_cancelar_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "preasignada": preasignada,
                "usuario_id": usuario_id
            }
        // console.log(datos)
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/preasignar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                    console.log(res)
                    if(opcion==0){
                        ver_reservaciones();
                    }else{
                        ver_reportes_llegadas();
                    }
                },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Modal de preasignar reservacion
function preasignar_reservacion(id,opcion=0,tipo_hab,numero_hab){
    console.log(numero_hab)
	$("#mostrar_herramientas").load("includes/preasignar_modal_reservacion.php?id="+id+"&opcion="+opcion+"&tipo_hab="+tipo_hab+"&numero_hab="+numero_hab);
}

// Modal de cancelar una reservacion
function aceptar_garantizar_reservacion(id,preasignada=0,correo,garantizada=0,huesped_id){
	$("#mostrar_herramientas").load("includes/garantizar_modal_reservacion.php?id="+id+"&preasignada="+preasignada+"&correo="+correo+"&garantizada="+garantizada+"&huesped_id="+huesped_id);
}

function guardar_datos_tarjeta(huesped_id,forma_garantia){
    if(!verificarFormulario('garantia-tarjeta','name')){
    datos= {
        "numero_tarjeta" :$("#numero_tarjeta").val(),
        "nombre_tarjeta" :$("#cardholder").val(),
        "tipo_tarjeta" :$("#tipo").val(),
        "mes_tarjeta" :$("#expires-month").val(),
        "year_tarjeta" :$("#expires-year").val(),
        "huesped_id" : huesped_id,
        "forma_garantia":forma_garantia
    }
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"includes/guardar_datos_tarjeta.php",
        data:datos,
        beforeSend:loaderbar,
        success:function(res){
            console.log(res)
        },
        //success:problemas_sistema,
        timeout:5000,
        error:problemas_sistema
    });
}
}

function garantizar_reserva_selects(){
    estado =$("#estado").val()
    garantia =$("#forma-garantia option:selected").text()
    garantia = garantia.toLowerCase()
    if(estado=="garantizada" && garantia.includes('tarjeta')){
        $("#div-tarjeta").show()
    }else{
        $("#div-tarjeta").hide()
    }
}

function garantizar_reservacion(id,preasignada=0,correo,garantizada=0,huesped_id){
    var usuario_id=localStorage.getItem("id");
    var estado= encodeURI(document.getElementById("estado").value);
    var forma_garantia= encodeURI(document.getElementById("forma-garantia").value);
    var monto= encodeURI(document.getElementById("monto").value);
    numero_tarjeta=$("#numero_tarjeta").val()
    if(numero_tarjeta!=""){
        guardar_datos_tarjeta(huesped_id,forma_garantia)
    }
    // return
    if (id >0 && estado.length >0 && forma_garantia.length>0 && monto.length >0) {
        $('#caja_herramientas').modal('hide');
        $("#boton_cancelar_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "estado_interno": estado,
                "forma_garantia": forma_garantia,
                "usuario_id": usuario_id,
                "total_pago":monto,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/garantizar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                    ver_reservaciones()
                },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Modal de cancelar una reservacion
function aceptar_cancelar_reservacion(id,preasignada = 0 ,correo,garantizada=0){
	$("#mostrar_herramientas").load("includes/cancelar_modal_reservacion.php?id="+id+"&preasignada="+preasignada+"&correo="+correo+"&garantizada="+garantizada);
}

// Cancelar una reservacion
function cancelar_reservacion(id,preasignada=0,correo,garantizada=0){
    var usuario_id=localStorage.getItem("id");
    var nombre_cancela= encodeURI(document.getElementById("nombre_cancela").value);
    var motivo_cancela= encodeURI(document.getElementById("motivo_cancela").value);
    // console.log(motivo_cancela)
    // return
    if (id >0 && nombre_cancela.length >0 && motivo_cancela.length>0) {
        $('#caja_herramientas').modal('hide');
        $("#boton_cancelar_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "nombre_cancela": nombre_cancela,
                "motivo_cancela": motivo_cancela,
                "usuario_id": usuario_id,
                "preasignada":preasignada,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/cancelar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                    console.log(res)
                    if(correo!="" && garantizada!=1){
                        enviar_cancela_correo(id,correo,false)
                    }
                    ver_reservaciones()
                },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Modal de borrar una reservacion
function aceptar_borrar_reservacion(id,preasignada=0){
	$("#mostrar_herramientas").load("includes/borrar_modal_reservacion.php?id="+id+"&preasignada="+preasignada);
}

// Regresar a la pagina anterior de editar un reservacion
function regresar_reservacion(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id);
}

// Modal de asignar una reservacion a una habitacion en estado disponible
function select_asignar_checkin(id,numero_hab,hab_id="",movimiento){
    numero_hab=1;
    //si ya tiene una habitación preasignada, hará "checkin" automaticamente.
    if(hab_id!=""){
        var usuario_id=localStorage.getItem("id");
        $('#caja_herramientas').modal('hide');
        var datos = {
            "hab_id": hab_id,
            "id_reservacion": id,
            "habitaciones": 0,
            "usuario_id": usuario_id,
            "movimiento":movimiento
            };
        console.log(datos)
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/asignar_reservacion.php",
            data:datos,
            success:function(res){
                console.log(res)
                // return
                if(res=="OCUPADA"){
                    setTimeout(() => {
                        include="includes/asignar_modal_reservacion.php?id="+id+"&numero_hab="+numero_hab
                        $("#mostrar_herramientas").load(include);
                        $('#caja_herramientas').modal('show');
                    }, 500);
                }else{
                    seleccionar_vista()
                    setTimeout(() => {
                        mostrar_herramientas(hab_id,1,'')
                        $('#caja_herramientas').modal('show');
                    }, 2000);
                }
            },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    }else{
        $("#mostrar_herramientas").load("includes/asignar_modal_reservacion.php?id="+id+"&numero_hab="+numero_hab+"&mov="+movimiento);
    }
    //si no, tendrá que seleccionar una de las habitaciones disponibles.
}

// Modal de asignar una reservacion a una habitacion en estado disponible
function select_asignar_reservacion(id,numero_hab){
    console.log(id)
    return
	$("#mostrar_herramientas").load("includes/asignar_modal_reservacion.php?id="+id+"&numero_hab="+numero_hab);
}

function seleccionar_vista(){
    vista= localStorage.getItem('vista')
    if(vista==3 || vista==0){
        var usuario_id=localStorage.getItem("id");
        $('#area_trabajo').hide();
        $('#area_trabajo_menu').show();
        $('#pie').show();
        $("#area_trabajo_menu").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
        closeModal();
        closeNav();
    }else{
        var id=localStorage.getItem("id");
        var token=localStorage.getItem("tocken");
        localStorage.removeItem('estatus_hab')
        estatus_hab=""
        $('#area_trabajo').hide();
        $('#pie').show();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/area_trabajo.php?id="+id+"&token="+token+"&estatus_hab="+estatus_hab,function(){
        });
        closeModal();
        closeNav();
    }
}

// Asignar una reservacion a una habitacion en estado disponible
function asignar_reservacion(hab_id,id_reservacion,habitaciones,mov){
    //here
    if(habitaciones == 1){
        var usuario_id=localStorage.getItem("id");
        $('#caja_herramientas').modal('hide');
        var datos = {
            "hab_id": hab_id,
            "id_reservacion": id_reservacion,
            "habitaciones": habitaciones,
            "usuario_id": usuario_id,
            "movimiento":mov,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/asignar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                // console.log(res)
                // return
                seleccionar_vista()
                setTimeout(() => {
                    mostrar_herramientas(hab_id,1,'')
                    $('#caja_herramientas').modal('show');
                }, 2000);
            },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        var usuario_id=localStorage.getItem("id");
        habitaciones= habitaciones - 1;
        var datos = {
            "hab_id": hab_id,
            "id_reservacion": id_reservacion,
            "habitaciones": habitaciones,
            "usuario_id": usuario_id,
            };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/asignar_reservacion.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_multiple,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    return false;
    }
}

// Recibe los datos para realizar checkin multiple
function recibe_datos_multiple(datos){
    //alert(datos);
    var res = datos.split("/");
    //$('#caja_herramientas').modal('hide');
    select_asignar_reservacion_multiple(res[0], res[1]);
}

// Modal de asignar mas de una habitacion a una reservacion
function select_asignar_reservacion_multiple(id,numero_hab){
	$("#mostrar_herramientas").load("includes/asignar_modal_reservacion_multiple.php?id="+id+"&numero_hab="+numero_hab);
}

// Asignar mas de una habitacion a una reservacion
function asignar_reservacion_multiple(hab_id,id_reservacion,habitaciones){
    if(habitaciones == 1){
        var usuario_id=localStorage.getItem("id");
        $('#caja_herramientas').modal('hide');
        var datos = {
            "hab_id": hab_id,
            "id_reservacion": id_reservacion,
            "habitaciones": habitaciones,
            "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/asignar_reservacion_multiple.php",
                data:datos,
                beforeSend:loaderbar,
                success:principal,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        var usuario_id=localStorage.getItem("id");
        habitaciones= habitaciones - 1;
        var datos = {
            "hab_id": hab_id,
            "id_reservacion": id_reservacion,
            "habitaciones": habitaciones,
            "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/asignar_reservacion_multiple.php",
                data:datos,
                beforeSend:loaderbar,
                success:recibe_datos_multiple,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

//* Huesped *//
function agregar_vehiculo(id_reserva,id_huesped){
    let usuario_id=localStorage.getItem("id");
	$("#mostrar_herramientas").load("includes/agregar_datos_vehiculo.php?usuario_id="+usuario_id+"&id_huesped="+id_huesped+"&id_reserva="+id_reserva);
}

// Agregar un huesped
function agregar_huespedes(){
	$("#mostrar_herramientas").load("includes/agregar_huespedes.php");
}

// Modal para agregar un huesped en una reservacion
function agregar_huespedes_reservacion(){
    $("#mostrar_herramientas").load("includes/agregar_huespedes_reservacion.php");
}

function validar_guardar_huesped(reservacion){
    if(reservacion == 0){
        guardar_huesped()
    }else{
        swal("El huesped que intenta agregar ya tiene una reservacion!", "Excelente trabajo!", "warning");
    }
}

function guardar_datos_vehiculo(id_reserva,id_huesped) {
    let usuario_id=localStorage.getItem("id");
    let matricula = $("#matricula").val();
    let ingreso = $("#ingreso").val();
    // console.log(fecha_ingreso)
    if(matricula == "" || ingreso == ""){
            alert("Debe escribir al menos una matrícula y una fecha de ingreso");
    }else{
        datos = datosFormulario("form-vehiculo")
        datos['usuario_id'] = usuario_id
        datos['id_huesped'] = id_huesped
        datos['id_reserva'] = id_reserva
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_datos_vehiculo.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                if(res=="OK"){
                    swal("Datos agregados correctamente", "Los datos ingresados se han registrado con éxito!", "success");
                    $('#caja_herramientas').modal('hide');
                }else{
                    swal("Ha ocurrido un error con la transferencia de información", "Verifique su información e intentlo de nuevo", "error");
                }
                console.log(res)
            },
            timeout:5000,
            error:problemas_sistema
        });
    }
}
function cambiar_estado_vehiculo(id_huesped,estado){
    usuario_id=localStorage.getItem("id");
    $("#coche_estado").load("includes/cambiar_estado_vehiculo.php?usuario_id="+usuario_id+"&id_huesped="+id_huesped+"&estado="+estado); 
    console.log("Cambiando el estado del vehiculo");
}
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
    estado_credito = "";
    if ($('#c_abierto').is(':checked')) {
        estado_credito = "abierto";
    }
    if ($('#c_cerrado').is(':checked')) {
        estado_credito = "cerrado";
    }
    var limite_credito = encodeURI(document.getElementById("limite_credito").value);
    if (isNaN(limite_credito)) {
        console.log('Es un número');
        limite_credito=0;
    }else{
        if(limite_credito<=0){
            limite_credito=0;
        }
        
    }
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
    if(!verificarFormulario("form-huesped","id")){
        let xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.open("GET","includes/guardar_huesped.php?nombre="+nombre+"&apellido="+apellido+"&direccion="+direccion+"&ciudad="+ciudad+
        "&estado="+estado+"&codigo_postal="+codigo_postal+"&telefono="+telefono+"&correo="+correo+"&contrato="+contrato+"&cupon="+cupon+
        "&preferencias="+preferencias+"&comentarios="+comentarios+"&titular_tarjeta="+titular_tarjeta+"&tipo_tarjeta="+tipo_tarjeta+"&numero_tarjeta="+numero_tarjeta+
        "&vencimiento_mes="+vencimiento_mes+"&vencimiento_ano="+vencimiento_ano+"&cvv="+cvv+"&usuario_id="+usuario_id+
        "&estado_credito="+estado_credito+"&limite_credito="+limite_credito,
        true);
        xhttp.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                //Entrara la contidicion que valida la respuesta del formulario
                const  response =xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
                 console.log(response)
                // return
                if (response == 'NO_DATA') {
                    swal("Debe llenar los campos requeridos", "Verifique que los campos no estén vacíos", "error");
                    return
                }else if(response == 'NO_VALIDO'){
                    swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
                }else{
                    $('#caja_herramientas').modal('hide');
                    swal("Nuevo huesped agregado!", "Excelente trabajo!", "success");
                    ver_huespedes()
                }
            }else{
                swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
            }
        })
        xhttp.send();
    }
}

function mostrar_tarjeta(huesped_id){
    if ($('#check_tarjeta').is(':checked')) {
        let password = prompt("Escriba su contraseña para continuar")
        if (password == null || password == "") {
            $('#numero_tarjeta').val("**************")
            $('#check_tarjeta').prop('checked', false);
        } else {
            validar_pass(password,huesped_id)
        }
    }else{
        $('#numero_tarjeta').val("**************")
    }
}

function validar_pass(password,huesped_id){
    let usuario_id=localStorage.getItem("id");
    let datos={
        "usuario_id" : usuario_id,
        "password" : password,
        "huesped_id" : huesped_id,
    }
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"includes/evaluar_password.php",
        data:datos,
        beforeSend:loaderbar,
        success:function(res){
            if(res!=0){
                console.log("good")
                $('#numero_tarjeta').val(res)
                $('#numero_tarjeta').prop("disabled",false)
            }else{
                $('#check_tarjeta').prop('checked', false);
            }
        },
        timeout:5000,
        error:problemas_sistema
    });
}

// Guarda el modal luego de su uso
function guardar_modal(){
    $('#caja_herramientas').modal('hide');
}

// Muestra los huespedes de la bd
function ver_huespedes(){ 
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_huespedes.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra la paginacion de los huespedes
function ver_huespedes_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_huespedes").load("includes/ver_huespedes_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Barra de diferentes busquedas en ver huespedes
function buscar_huesped(e){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
        if( e.which === 8 ){ return false; }
    }
	$("#tabla_huesped").load("includes/buscar_huesped.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);
}

// Editar un huesped
function editar_huesped(id){
    $("#area_trabajo_menu").load("includes/editar_huesped.php?id="+id);
}

function buscar_historial_huesped(id){
    a_buscar = $("#a_buscar").val()
    inicial = $("#inicial_historial").val() === undefined ? 0 :  $("#inicial_historial").val()
    final =$("#final_historial").val() === undefined  ? 0 : $("#final_historial").val()
    $("#tabla_historial").load("includes/buscar_historial_huesped.php?id="+id+"&inicial="+inicial+"&final="+final+"&a_buscar="+a_buscar);
}


function buscar_historial_cuentas(){
    a_buscar = $("#a_buscar").val()
    inicial = $("#inicial_historial").val() === undefined ? 0 :  $("#inicial_historial").val()
    final =$("#final_historial").val() === undefined  ? 0 : $("#final_historial").val()
    $("#tabla_historial").load("includes/buscar_historial_cuentas.php?inicial="+inicial+"&final="+final+"&a_buscar="+a_buscar)+"&usuario_id="+usuario_id;
}

// ver Historia del huesped
function ver_historial_cuentas(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_historial_cuentas.php?usuario_id="+usuario_id+"&inicial="+0+"&final="+0);
    closeModal();
	closeNav();
}
// ver reporte de ama de llaves
function ver_reporte_ama_de_llaves(){
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $('#area_trabajo_menu').load("includes/reporte_ama_llaves.php");
    closeModal();
    closeNav();
}

// ver Historia del huesped
function ver_historial_huesped(id){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_historial_huesped.php?id="+id+"&inicial="+0+"&final="+0);
    closeModal();
	closeNav();
}

// ver Historia del huesped
function ver_historial_huesped(id){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_historial_huesped.php?id="+id+"&inicial="+0+"&final="+0);
    closeModal();
	closeNav();
}

// Editar un huesped
function modificar_huesped(id,hab_id,id_reservacion){
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

    if(numero_tarjeta=="**************"){
        numero_tarjeta=null
    }

	if(id >0){
		$("#boton_huesped").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "id_reservacion": id_reservacion,
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
        if(hab_id == -1){
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
            if(id_reservacion == 0){
                $.ajax({
                        async:true,
                        type: "POST",
                        dataType: "html",
                        contentType: "application/x-www-form-urlencoded",
                        url:"includes/aplicar_editar_huesped.php",
                        data:datos,
                        //beforeSend:loaderbar,
                        success:cambiar_adultos,
                        //success:problemas_sistema,
                        timeout:5000,
                        error:problemas_sistema
                    });
                return false;
            }else{
                $.ajax({
                        async:true,
                        type: "POST",
                        dataType: "html",
                        contentType: "application/x-www-form-urlencoded",
                        url:"includes/aplicar_editar_huesped.php",
                        data:datos,
                        //beforeSend:loaderbar,
                        success:cambiar_adultos_editar,
                        //success:problemas_sistema,
                        timeout:5000,
                        error:problemas_sistema
                    });
                return false;
            }
        }
    }else{
        alert("Campos incompletos");
    }
}

// Borrar un huesped
function borrar_huesped(id){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if(id >0){
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
                //success:problemas_sistema,
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
function habSeleccionada(event){
    if(event!=0){
        var tipo_hab = event.target.options[event.target.selectedIndex].dataset.habtipo;
        if(tipo_hab!=undefined){
            console.log(tipo_hab)
        }
    }
    // console.log($("#habitacion_check").val())
    // hab_id = $("#habitacion_check").val()
    include = "includes/consultar_tarifa_hab.php?tipo_hab="+tipo_hab;
    $("#tarifa").load(include);
}

// Agregar una uso casa
function uso_casa_asignar(hab_id,estado){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/agregar_uso_casa.php?hab_id="+hab_id); 
	$('#caja_herramientas').modal('hide');
}

// Agregar una reservacion en la habitacion
function disponible_asignar(hab_id,estado){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	//checkin
    //$("#area_trabajo_menu").load("includes/agregar_reservaciones.php?hab_id="+hab_id+"&estado="+estado);
    $("#area_trabajo_menu").load("includes/agregar_reservacionNew.php?hab_id="+hab_id);
	$('#caja_herramientas').modal('hide');
}

//* Reporte *//
// Aceptar realizara el cargo por noche de las habitaciones ocupadas
function mostrar_cargo_noche(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/mostrar_cargo_noche.php");
	closeNav();
}

// Cambiar el estado de cargo noche en una habitacion
function cambiar_cargo_noche(id,cargo){
    var cargo_noche= document.getElementById("cargo_noche").checked;
    // Convertir cargo noche valor
    /*if(cargo_noche){
        cargo_noche= 0;
    }else{
        cargo_noche= 1;
    }*/
    if(cargo == 0){
        cargo_noche= 1;
    }else{
        cargo_noche= 0;
    }
    //alert(cargo_noche);
	if(id >0){
        var datos = {
                "id": id,
                "cargo_noche": cargo_noche,
			};
		$.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/cambiar_cargo_noche.php",
                data:datos,
                //beforeSend:loaderbar,
                success:mostrar_cargo_noche,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
			});
            return false;
    }else{
        alert("Campos incompletos");
    }
}

// Modal de aceptar el cargo noche de las habitaciones seleccionadas
function aceptar_cargo_noche(){
	$("#mostrar_herramientas").load("includes/aceptar_modal_cargo_noche.php");
}

// Aceptar el cargo noche de las habitaciones seleccionadas
function cargo_noche(){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    var datos = {
            "usuario_id": usuario_id,
        };
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/cargo_noche.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                console.log(res)
                principal()
            },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    //window.open("includes/reporte_cargo_noche.php?usuario_id="+usuario_id);
    //guardar_reporte_cargo_noche();
    mostrar_cargo_noche_reporte();
    return false;
}

// Generar reporte de cargo noche y guardarlo
function guardar_reporte_cargo_noche(){
    var usuario_id=localStorage.getItem("id");
	var tam= tam_ventana();
	var alto= tam[1];
	var ancho= tam[0];
    $("#area_trabajo_menu").load("includes/barra_progreso.php");
	//window.open("includes/mostrar_cargo_noche_reporte.php?usuario_id="+usuario_id, "Diseño Web", "width="+ancho+", height="+alto);
    window.open("includes/reporte_cargo_noche.php?usuario_id="+usuario_id, "Diseño Web", "width="+ancho+", height="+alto);
    setTimeout(mostrar_cargo_noche_reporte, 5000);
}

// Mostrar el reporte de cargo noche
function mostrar_cargo_noche_reporte(){
	var tam= tam_ventana();
	var alto= tam[1];
	var ancho= tam[0];
    //var alto= 1000;
	//var ancho= 500;
    //$("#area_trabajo_menu").load("includes/barra_progreso.php");
	window.open("includes/mostrar_cargo_noche_reporte.php?ancho="+ancho+"&alto="+alto, "Diseño Web", "width="+ancho+", height="+alto);
    //window.open("includes/reporte_cargo_noche.php?usuario_id="+usuario_id);
}

// Muestra los reportes de los cargos por noche de la bd
function ver_cargo_noche(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_cargo_noche.php");
    closeModal();
	closeNav();
}

// Muestra los reportes guardados de los cargos por noche de la bd
function mostrar_reporte_cargo_noche(id){
	window.open("reportes/reservaciones/cargo_noche/reporte_cargo_noche_"+id+".pdf");
}

// Busqueda por fecha en ver reportes guardados de los cargos por noche de la bd
function busqueda_cargo_noche(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_cargo_noche").load("includes/busqueda_cargo_noche.php?inicial="+inicial+"&final="+final);
}

//* Forma pago *//
// Guardar una forma de pago
function guardar_forma_pago(){
    var usuario_id=localStorage.getItem("id");
	var descripcion= encodeURI(document.getElementById("descripcion").value);
    var garantia = encodeURI(document.getElementById('garantia').checked)
	if(descripcion.length >0){
			$("#boton_forma").html('<div class="spinner-border text-primary"></div>');
			var datos = {
                    "descripcion": descripcion,
                    "usuario_id": usuario_id,
                    "garantia":garantia,
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
                    //success:problemas_sistema,
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
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_formas_pago.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Editar una forma de pago
function editar_forma_pago(id){
    $("#mostrar_herramientas").load("includes/editar_forma_pago.php?id="+id);
}

// Editar una forma de pago
function modificar_forma_pago(id){
	var usuario_id=localStorage.getItem("id");
    var descripcion= encodeURI(document.getElementById("descripcion_nueva").value);
    var garantia= encodeURI(document.getElementById("garantia_nueva").checked);
    $('#caja_herramientas').modal('hide');
    if(id >0 && descripcion.length >0){
		$("#boton_forma").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "descripcion": descripcion,
                "garantia": garantia,
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
                //success:problemas_sistema,
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

//* Usuario *//
// Agregar un usuario
function agregar_usuarios(id){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_usuarios.php?id="+id); 
    $(".navbar-collapse").collapse('hide');
    closeModal();
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
                success:function(res){
                    console.log(res)
                    if(res.includes("Duplicate entry")){
                        alert("El nombre de usuario ya se encuentra ocupado")
                        //<input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_usuario()">
                        $("#boton_usuario").html('<input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_usuario()">');
                    }else{
                        ver_usuarios()
                    }
                },
                  //success:problemas_sistema,
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
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_usuarios.php?id="+id);
    $(".navbar-collapse").collapse('hide');
    closeModal();
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
    /*var tipo_ver= document.getElementById("tipo_ver").checked;
    var tipo_agregar= document.getElementById("tipo_agregar").checked;
    var tipo_editar= document.getElementById("tipo_editar").checked;
    var tipo_borrar= document.getElementById("tipo_borrar").checked;*/
    var tarifa_ver= document.getElementById("tarifa_ver").checked;
    var tarifa_agregar= document.getElementById("tarifa_agregar").checked;
    var tarifa_editar= document.getElementById("tarifa_editar").checked;
    var tarifa_borrar= document.getElementById("tarifa_borrar").checked;
    /*var hab_ver= document.getElementById("hab_ver").checked;
    var hab_agregar= document.getElementById("hab_agregar").checked;
    var hab_editar= document.getElementById("hab_editar").checked;
    var hab_borrar= document.getElementById("hab_borrar").checked;*/
    var reservacion_ver= document.getElementById("reservacion_ver").checked;
    var reservacion_agregar= document.getElementById("reservacion_agregar").checked;
    var reservacion_editar= document.getElementById("reservacion_editar").checked;
    var reservacion_borrar= document.getElementById("reservacion_borrar").checked;
    var reservacion_preasignar= document.getElementById("reservacion_preasignar").checked;
    var reporte_ver= document.getElementById("reporte_ver").checked;
    var reporte_agregar= document.getElementById("reporte_agregar").checked;
    var forma_pago_ver= document.getElementById("forma_pago_ver").checked;
    var forma_pago_agregar= document.getElementById("forma_pago_agregar").checked;
    var forma_pago_editar= document.getElementById("forma_pago_editar").checked;
    var forma_pago_borrar= document.getElementById("forma_pago_borrar").checked;
    var inventario_ver= document.getElementById("inventario_ver").checked;
    var inventario_agregar= document.getElementById("inventario_agregar").checked;
    var inventario_editar= document.getElementById("inventario_editar").checked;
    var inventario_borrar= document.getElementById("inventario_borrar").checked;
    var inventario_surtir= document.getElementById("inventario_surtir").checked;
    var categoria_ver= document.getElementById("categoria_ver").checked;
    var categoria_agregar= document.getElementById("categoria_agregar").checked;
    var categoria_editar= document.getElementById("categoria_editar").checked;
    var categoria_borrar= document.getElementById("categoria_borrar").checked;
    var restaurante_ver= document.getElementById("restaurante_ver").checked;
    var restaurante_agregar= document.getElementById("restaurante_agregar").checked;
    var restaurante_editar= document.getElementById("restaurante_editar").checked;
    var restaurante_borrar= document.getElementById("restaurante_borrar").checked;
    var cupon_ver= document.getElementById("cupon_ver").checked;
    var cupon_agregar= document.getElementById("cupon_agregar").checked;
    var cupon_editar= document.getElementById("cupon_editar").checked;
    var cupon_borrar= document.getElementById("cupon_borrar").checked;
    var logs_ver= document.getElementById("logs_ver").checked;
    var auditoria_ver= document.getElementById("auditoria_ver").checked;
    var auditoria_editar= document.getElementById("auditoria_editar").checked;
    var llegadas_salidas_ver= document.getElementById("llegadas_salidas_ver").checked;
    // console.log(reservacion_preasignar)
    // return
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
    /*if(tipo_ver){
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
    }*/
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
    /*if(hab_ver){
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
    }*/
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
    if(reporte_agregar){
        reporte_agregar = 1;
    }else{
        reporte_agregar = 0;
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
    if(inventario_editar ){
        inventario_editar = 1;
    }else{
        inventario_editar = 0;
    }
    if(inventario_borrar){
        inventario_borrar = 1;
    }else{
        inventario_borrar = 0;
    }
    if(inventario_surtir){
        inventario_surtir = 1;
    }else{
        inventario_surtir = 0;
    }
    // Convertir categoria permisos
    if(categoria_ver){
        categoria_ver = 1;
    }else{
        categoria_ver = 0;
    }
    if(categoria_agregar){
        categoria_agregar = 1;
    }else{
        categoria_agregar = 0;
    }
    if(categoria_editar ){
        categoria_editar = 1;
    }else{
        categoria_editar = 0;
    }
    if(categoria_borrar){
        categoria_borrar = 1;
    }else{
        categoria_borrar = 0;
    }
    // Convertir restaurante permisos
    if(restaurante_ver){
        restaurante_ver = 1;
    }else{
        restaurante_ver = 0;
    }
    if(restaurante_agregar){
        restaurante_agregar = 1;
    }else{
        restaurante_agregar = 0;
    }
    if(restaurante_editar ){
        restaurante_editar = 1;
    }else{
        restaurante_editar = 0;
    }
    if(restaurante_borrar){
        restaurante_borrar = 1;
    }else{
        restaurante_borrar = 0;
    }
    // Convertir cupon permisos
    if(cupon_ver){
        cupon_ver = 1;
    }else{
        cupon_ver = 0;
    }
    if(cupon_agregar){
        cupon_agregar = 1;
    }else{
        cupon_agregar = 0;
    }
    if(cupon_editar ){
        cupon_editar = 1;
    }else{
        cupon_editar = 0;
    }
    if(cupon_borrar){
        cupon_borrar = 1;
    }else{
        cupon_borrar = 0;
    }
    // Convertir logs permisos
    if(logs_ver){
        logs_ver = 1;
    }else{
        logs_ver = 0;
    }
	if(usuario.length >0 && nivel.length >0){
        //if(contrasena == recontrasena){
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
                    /*"tipo_ver": tipo_ver,
                    "tipo_agregar": tipo_agregar,
                    "tipo_editar": tipo_editar,
                    "tipo_borrar": tipo_borrar,*/
                    "tarifa_ver": tarifa_ver,
                    "tarifa_agregar": tarifa_agregar,
                    "tarifa_editar": tarifa_editar,
                    "tarifa_borrar": tarifa_borrar,
                    /*"hab_ver": hab_ver,
                    "hab_agregar": hab_agregar,
                    "hab_editar": hab_editar,
                    "hab_borrar": hab_borrar,*/
                    "reservacion_ver": reservacion_ver,
                    "reservacion_agregar": reservacion_agregar,
                    "reservacion_editar": reservacion_editar,
                    "reservacion_borrar": reservacion_borrar,
                    "reservacion_preasignar":reservacion_preasignar,
                    "reporte_ver": reporte_ver,
                    "reporte_agregar": reporte_agregar,
                    "forma_pago_ver": forma_pago_ver,
                    "forma_pago_agregar": forma_pago_agregar,
                    "forma_pago_editar": forma_pago_editar,
                    "forma_pago_borrar": forma_pago_borrar,
                    "inventario_ver": inventario_ver,
                    "inventario_agregar": inventario_agregar,
                    "inventario_editar": inventario_editar,
                    "inventario_borrar": inventario_borrar,
                    "inventario_surtir": inventario_surtir,
                    "categoria_ver": categoria_ver,
                    "categoria_agregar": categoria_agregar,
                    "categoria_editar": categoria_editar,
                    "categoria_borrar": categoria_borrar,
                    "restaurante_ver": restaurante_ver,
                    "restaurante_agregar": restaurante_agregar,
                    "restaurante_editar": restaurante_editar,
                    "restaurante_borrar": restaurante_borrar,
                    "cupon_ver": cupon_ver,
                    "cupon_agregar": cupon_agregar,
                    "cupon_editar": cupon_editar,
                    "cupon_borrar": cupon_borrar,
                    "logs_ver": logs_ver,
                    "auditoria_ver":auditoria_ver,
                    "auditoria_editar":auditoria_editar,
                    "llegadas_salidas_ver":llegadas_salidas_ver,
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
                success:function(res){
                    //console.log(res)
                    ver_usuarios()
                },
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
                //success:problemas_sistema,
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

//* Edo. Cuenta *//
// Muestra el estado de cuenta de una habitacion
function estado_cuenta_maestra(hab_id,estado,mov,id){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/estado_cuenta_maestra.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&id="+id+"&usuario_id="+usuario_id); 
	$('#caja_herramientas').modal('hide');
}

// Muestra el estado de cuenta de una habitacion
function estado_cuenta(hab_id,estado,mov=0){
    var id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/estado_cuenta.php?hab_id="+hab_id+"&estado="+estado+"&usuario_id="+id,function(res){
        if(res=="nada"){
            document.location.href='inicio.php';
        }
    });
	$('#caja_herramientas').modal('hide');
}

function validarNumero(event) {
    const charCode = event.charCode;
    // Check if the pressed key is a number (charCode 48 to 57 represent digits 0 to 9)
    if ((charCode < 48 || charCode > 57) && charCode !== 46) {
    event.preventDefault();
    }

    const inputText = event.target.value;
    if(charCode === 46 && inputText.indexOf(".") !== -1 ) {
        event.preventDefault();
    }
}

// Agregar un cargo al cargo por habitacion //
function agregar_cargo(hab_id,estado,faltante,mov=0,id_maestra=0){
	$("#mostrar_herramientas").load("includes/agregar_cargo.php?hab_id="+hab_id+"&estado="+estado+"&faltante="+faltante+"&mov="+mov+"&id_maestra="+id_maestra);
}

// Guardar un abono al cargo por habitacion
function guardar_cargo(hab_id,estado,faltante,mov=0,id_maestra=0){
    var usuario_id=localStorage.getItem("id");
    var descripcion= encodeURI(document.getElementById("descripcion").value);
    var cargo= document.getElementById("cargo").value;
    if(cargo.length > 10){
        alert("Cantidad debe de ser menor a 10 digitos")
        return
    }else if (descripcion.length >0 && cargo >0){
        $("#boton_abono").html('<div class="spinner-border text-primary"></div>');
        var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "faltante": faltante,
            "descripcion": descripcion,
            "cargo": cargo,
            "abono": 0,
            "usuario_id": usuario_id,
            "mov":mov,
            "id_maestra":id_maestra,
            };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_cargo.php",
            data:datos,
              //beforeSend:loaderbar,
            success:function(res){
                console.log(res)
                if(id_maestra==0){
                    recibe_datos_monto(res)
                }else{
                    recibe_datos_monto_maestra(res)
                }
            },
              //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Agregar un abono al cargo por habitacion //
function agregar_abono(hab_id,estado,faltante,mov=0,id_maestra=0){
	$("#mostrar_herramientas").load("includes/agregar_abono.php?hab_id="+hab_id+"&estado="+estado+"&faltante="+faltante+"&mov="+mov+"&id_maestra="+id_maestra);
}

// Guardar un abono al cargo por habitacion
function guardar_abono(hab_id,estado,faltante,mov=0,id_maestra=0){
    /*alert(hab_id);
    alert(estado);
    alert(faltante);*/
    var usuario_id=localStorage.getItem("id");
    var descripcion= "";
    if(document.getElementById("leer_tipo_abono").value=="value2"){
        descripcion="Abono restaurante";
    }
    else if(document.getElementById("leer_tipo_abono").value=="value3"){
        descripcion="Abono hospedaje";
    }
    var forma_pago= document.getElementById("forma_pago").value;
    var cargo= document.getElementById("cargo").value;
    var abono= document.getElementById("abono").value;
    var fp_txt = $("#forma_pago option:selected").text();
    // console.log(fp_txt)
    // return
    if(descripcion.length >0 && forma_pago >0 && abono >0){
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
                "mov":mov,
                "id_maestra":id_maestra,
            };
        //  console.log(datos)
        //  return
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/guardar_abono.php",
                data:datos,
                //beforeSend:loaderbar,
                success:function(res){
                // console.log(res)
                // return
                if(id_maestra==0){
                    var data = res.split("/");
                    recibe_datos_monto(res)
                    enviar_abono_correo(data[2],abono,descripcion,fp_txt);
                }else{
                    recibe_datos_monto_maestra(res)
                }
                },
              //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Recibe los datos para efectuar agregar un monto
function recibe_datos_monto_maestra(datos){
    //alert(datos);
    var res = datos.split("/");
    $('#caja_herramientas').modal('hide');
    estado_cuenta_maestra(res[0] , res[1], res[2], res[3]);
}

// Recibe los datos para efectuar agregar un monto
function recibe_datos_monto(datos){
    $('#caja_herramientas').modal('hide');
    var res = datos.split("/");
    estado_cuenta(res[0] , res[1]);
}

// Modal de herramientas de cargos en estado de cuenta
function herramientas_cargos(id,hab_id,estado,usuario,cargo,id_maestra=0,mov=0){
    $("#mostrar_herramientas").load("includes/modal_herramientas_cargos.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&usuario="+usuario+"&cargo="+cargo+"&id_maestra="+id_maestra+"&mov="+mov);
}

// Modal de editar cargo en estado de cuenta
function editar_herramientas_cargo(id,hab_id,estado,cargo,id_maestra=0,mov=0){
    $("#mostrar_herramientas").load("includes/modal_editar_herramientas_cargo.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&cargo="+cargo+"&id_maestra="+id_maestra+"&mov="+mov);
}

function confirmar_cambiar_cargos(){
    swal({
        title: "¿Estás de acuerdo con editar los cargos de las cuentas?",
        text: "¡Los cargos se aplicaran y pueden ser editados mientras corra la noche!",
        icon: "warning",
        buttons: {
            cancel: {
            text: "Cancelar",
            value: null,
            visible: true,
            className: "",
            closeModal: true,
            },
            confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "",
            closeModal: true
            }
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
        campos_cargos()
        }
        });
    }
    function campos_cargos(){
        var usuario_id=localStorage.getItem("id");
        var array_cargos=[];
        var cargos= document.getElementsByClassName('campos_cargos')
        var campos_habs = document.getElementsByClassName('campos_habs')
        for (var i = 0; i < cargos.length; i++) {
            if(cargos[i].value=="" && campos_habs[i].checked){
                array_cargos.push({
                    "reservaid":cargos[i].dataset.reservaid,
                    "valor":0,
                    })
            }
            if(cargos[i].value!="" && campos_habs[i].checked){
                array_cargos.push({
                    "reservaid":cargos[i].dataset.reservaid,
                    "valor": cargos[i].value,
                    })
            }
        }
        if(array_cargos.length!=0){
            var datos = {
                "datos_cargos": JSON.stringify(array_cargos),
                "usuario_id": usuario_id,
            };
            $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/aplicar_editar_herramientas_cargos.php",
                data:datos,
                //beforeSend:loaderbar,
                success:function(res){
                    console.log(res)
                    cargo_auditoria()
                    //ver_auditoria()
                },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        }
        return false;
    }

function cajasAuditoria() {
    cajas = document.getElementById('cajas').checked
    console.log(cajas)
    if(cajas) {
        // Iterate each checkbox
        $('.campos_habs').each(function() {
            this.checked = true;
        });
    } else {
        $('.campos_habs').each(function() {
            this.checked = false;
        });
    }

}
// Aceptar el cargo noche de las habitaciones seleccionadas
function cargo_auditoria(){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');

    var datos = {
            "usuario_id": usuario_id,
        };
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/cargo_auditoria.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                console.log(res)
                mostrar_cargo_noche_reporte();
                principal()
            },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    //window.open("includes/reporte_cargo_noche.php?usuario_id="+usuario_id);
    //guardar_reporte_cargo_noche();
    return false;
}

// Editar un cargo en estado de cuenta desde auditoria.
function modificar_herramientas_cargo_aud(id,hab_id,estado,id_maestra=0,mov=0,campo){
	var usuario_id=localStorage.getItem("id");
    var cargo= document.getElementById(campo).value;
    if(cargo!=""){
        $("#boton_cargo").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "estado": estado,
                "cargo": cargo,
                "usuario_id": usuario_id,
                "id_maestra": id_maestra,
                "mov":mov,
            };
        // console.log(datos)
        // return
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/aplicar_editar_herramientas_cargo.php",
                data:datos,
                //beforeSend:loaderbar,
                success:function(res){
                },
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
    }
    return false;
}

// Editar un cargo en estado de cuenta
function modificar_herramientas_cargo(id,hab_id,estado,id_maestra=0,mov=0){
	var usuario_id=localStorage.getItem("id");
    var cargo= document.getElementById("cargo").value;
    if(id >0){
		$("#boton_cargo").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "estado": estado,
                "cargo": cargo,
                "usuario_id": usuario_id,
                "id_maestra": id_maestra,
                "mov":mov,
            };
        // console.log(datos)
        // return
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/aplicar_editar_herramientas_cargo.php",
                data:datos,
              //beforeSend:loaderbar,
            success:function(res){
                if(id_maestra==0){
                    recibe_datos_monto(res)
                }else{
                    recibe_datos_monto_maestra(res)
                }
            },
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
function aceptar_borrar_herramientas_cargo(id,hab_id,estado,cargo,id_maestra,mov){
    $("#mostrar_herramientas").load("includes/modal_borrar_herramientas_cargo.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&cargo="+cargo+"&id_maestra="+id_maestra+"&mov="+mov);
}

// Borrar un cargo en estado de cuenta
function borrar_herramientas_cargo(id,hab_id,estado,id_maestra,mov){
	var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if(id >0){
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "estado": estado,
                "usuario_id": usuario_id,
                "id_maestra":id_maestra,
                "mov":mov
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_herramientas_cargo.php",
                data:datos,
              //beforeSend:loaderbar,
            success:function(res){
                if(id_maestra==0){
                    recibe_datos_monto(res)
                }else{
                    recibe_datos_monto_maestra(res)
                }
            },
              //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Modal de herramientas de abonos en estado de cuenta
function herramientas_abonos(id,hab_id,estado,usuario,abono,id_maestra=0,mov=0){
    $("#mostrar_herramientas").load("includes/modal_herramientas_abonos.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&usuario="+usuario+"&abono="+abono+"&mov="+mov+"&id_maestra="+id_maestra);
}

// Modal de editar abono en estado de cuenta
function editar_herramientas_abono(id,hab_id,estado,abono,id_maestra=0,mov=0){
    $("#mostrar_herramientas").load("includes/modal_editar_herramientas_abono.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&abono="+abono+"&mov="+mov+"&id_maestra="+id_maestra);
}

// Editar un abono en estado de cuenta
function modificar_herramientas_abono(id,hab_id,estado,id_maestra=0,mov=0){
	var usuario_id=localStorage.getItem("id");
    var abono= document.getElementById("abono").value;
    if(id >0){
		$("#boton_abono").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "estado": estado,
                "abono": abono,
                "usuario_id": usuario_id,
                "id_maestra":id_maestra,
                "mov":mov,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/aplicar_editar_herramientas_abono.php",
                data:datos,
              //beforeSend:loaderbar,
            success:function(res){
                if(id_maestra==0){
                    recibe_datos_monto(res)
                }else{
                    recibe_datos_monto_maestra(res)
                }
            },
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
function aceptar_borrar_herramientas_abono(id,hab_id,estado,abono,mov=0,id_maestra=0){
    $("#mostrar_herramientas").load("includes/modal_borrar_herramientas_abono.php?id="+id+"&hab_id="+hab_id+"&estado="+estado+"&abono="+abono+"&mov="+mov+"&id_maestra="+id_maestra);
}

// Borrar un abono en estado de cuenta
function borrar_herramientas_abono(id,hab_id,estado,mov=0,id_maestra=0){
	var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    if(id >0){
        var datos = {
                "id": id,
                "hab_id": hab_id,
                "estado": estado,
                "usuario_id": usuario_id,
                "mov":mov,
                "id_maestra":id_maestra,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_herramientas_abono.php",
                data:datos,
              //beforeSend:loaderbar,
            success:function(res){
                if(id_maestra==0){
                    recibe_datos_monto(res)
                }else{
                    recibe_datos_monto_maestra(res)
                }
            },
              //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

//* Edo. Cuenta - Cambiar hab *//
// Modal de cambiar de habitacion el monto en estado de cuenta
function cambiar_hab_herramientas_monto(monto,id,hab_id,estado,cargo){
    $("#mostrar_herramientas").load("includes/modal_cambiar_hab_herramientas_monto.php?monto="+monto+"&id="+id+"&hab_id="+hab_id+"&estado="+estado+"&cargo="+cargo);
}

// Funcion para cambiar de habitacion el monto en estado de cuenta
function cambiar_hab_monto(id_hab,mov,monto,id,hab_id,estado){
	var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
	var datos = {
            "id_hab": id_hab,
            "mov": mov,
            "monto": monto,
            "id": id,
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/cambiar_hab_monto.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_monto,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}
function cargos_seleccionados(){
    const cargos= document.getElementsByClassName('campos_cargos')
    let array_cargos=[]
    const abonos= document.getElementsByClassName('campos_abonos')
    let array_abonos=[]
    for (let i = 0; i < cargos.length; i++) {
        // console.log(cargos[i].dataset.cuentaid)
        if(cargos[i].checked)
            array_cargos.push({
                "cargo_id":cargos[i].dataset.cuentaid,
                })
    }
    for (let i = 0; i < abonos.length; i++) {
        if(abonos[i].checked)
            array_abonos.push({
                "abono_id":abonos[i].dataset.cuentaid,
                })
    }
    return [array_cargos,array_abonos]
    console.log(array_abonos,array_cargos)
}

// Modal para seleccionar las cuentas a unificar
function seleccionar_cuentas(hab_id,estado,mov){
    var usuario_id=localStorage.getItem("id");
    $("#mostrar_herramientas").load("includes/modal_seleccionar_cuentas.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&usuario_id="+usuario_id);
}

// Modal para unificar cuentas en una habitacion seleccionada
function unificar_cuentas(hab_id,estado,mov){
    $("#mostrar_herramientas").load("includes/modal_unificar_cuentas.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov);
}

// Funcion para cambiar de habitacion las cuentas en estado de cuenta a otra habitacion
function cambiar_hab_cuentas_seleccionadas(id_hab,nombre_hab,mov_hab,hab_id,estado,mov){
	var usuario_id=localStorage.getItem("id");
    var nombre_hab= encodeURI(nombre_hab);
    $('#caja_herramientas').modal('hide');
    const cuenta = cargos_seleccionados()
    console.log(cuenta)
    let cargos = cuenta[0]
    let abonos = cuenta[1]
    cargos = cargos.length == 0 ? 0 : cargos
    abonos = abonos.length == 0 ? 0 : abonos
    if(cargos==0 && abonos==0){
        alert("No ha seleccionado nada para unificar")
        return
    }
	var datos = {
            "id_hab": id_hab,
            "nombre_hab": nombre_hab,
            "mov_hab": mov_hab,
            "hab_id": hab_id,
            "estado": estado,
            "mov": mov,
            "usuario_id": usuario_id,
            "cargos":cargos,
            "abonos":abonos,
		};
    // console.log(datos)
    // return
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded", 
            url:"includes/cambiar_hab_cuentas_seleccionadas.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_monto,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

function confirmar_duplicar_reservacion(id_reserva,id_mov, ruta){
    swal({
        title: "¿Estás de acuerdo con duplicar la reservación?",
        icon: "warning",
        buttons: {
            cancel: {
            text: "Cancelar",
            value: null,
            visible: true,
            className: "",
            closeModal: true,
            },
            confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "",
            closeModal: true
            }
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            duplicar_reservacion(id_reserva,id_mov,ruta)
        }
        });
}

function confirmar_cancelar_preasignada(id_reserva,id_mov,ruta){
    swal({
        title: "¿Estás de acuerdo con cancelar la preasignación?",
        icon: "warning",
        buttons: {
            cancel: {
            text: "Cancelar",
            value: null,
            visible: true,
            className: "",
            closeModal: true,
            },
            confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "",
            closeModal: true
            }
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            cancelar_preasignada(id_reserva,id_mov,ruta)
        }
        });
}

function cancelar_preasignada(id_reserva,id_mov,ruta){
    var usuario_id=localStorage.getItem("id");
    let datos = {
        "id_reserva":id_reserva,
        "id_mov":id_mov,
        "usuario_id":usuario_id,
    }
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded", 
        url:"includes/cancelar_preasignada.php",
        data:datos,
        beforeSend:loaderbar,
        success:eval(ruta),
        //success:problemas_sistema,
        timeout:5000,
        error:problemas_sistema
    });
}

function duplicar_reservacion(id_reserva,id_mov,ruta){
    var usuario_id=localStorage.getItem("id");
    let datos = {
        "id_reserva":id_reserva,
        "id_mov":id_mov,
        "usuario_id":usuario_id,
    }
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded", 
        url:"includes/duplicar_reservacion.php",
        data:datos,
        beforeSend:loaderbar,
        success:eval(ruta),
        timeout:5000,
        error:problemas_sistema
    });
}

// Funcion para cambiar de habitacion las cuentas en estado de cuenta a otra habitacion
function cambiar_hab_cuentas(id_hab,nombre_hab,mov_hab,hab_id,estado,mov){
	var usuario_id=localStorage.getItem("id");
    var nombre_hab= encodeURI(nombre_hab);
    $('#caja_herramientas').modal('hide');

	var datos = {
            "id_hab": id_hab,
            "nombre_hab": nombre_hab,
            "mov_hab": mov_hab,
            "hab_id": hab_id,
            "estado": estado,
            "mov": mov,
            "usuario_id": usuario_id,
		};
    // console.log(datos)
    // return
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/cambiar_hab_cuentas.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_monto,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

//* Categoria *//
// Guardar un categoria del inventario
function guardar_categoria(){
	var usuario_id=localStorage.getItem("id");
    var nombre= encodeURI(document.getElementById("nombre").value);
    $('#caja_herramientas').modal('hide');
    if(nombre.length >0){
		var datos = {
			"nombre": nombre,
            "usuario_id": usuario_id,
		};
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_categoria.php",
            data:datos,
            //beforeSend:loaderbar,
            success:ver_categorias,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
            });
        return false;
	}else{
		alert("Sin informacion a guardar");
	}
}

// Muestra las categorias de la bd
function ver_categorias(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_categorias.php?usuario_id="+usuario_id);
	closeNav();
}

// Editar una categoria
function editar_categoria(id){
    $("#mostrar_herramientas").load("includes/editar_categoria.php?id="+id);
}

// Editar una categoria
function modificar_categoria(id){
	var usuario_id=localStorage.getItem("id");
    var nombre = encodeURI(document.getElementById("nombre_categoria").value);
    $('#caja_herramientas').modal('hide');
    if(id >0 && nombre.length >0){
		$("#boton_categoria").html('<div class="spinner-border text-primary"></div>');
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
                url:"includes/aplicar_editar_categoria.php",
                data:datos,
                //beforeSend:loaderbar,
                success:ver_categorias,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Borrar una categoria
function borrar_categoria(id){
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
                url:"includes/borrar_categoria.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_categorias,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
};

// Modal de borrar una categoria
function aceptar_borrar_categoria(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_categoria.php?id="+id);
};

//* Inventario y Sutir*//

// Agregar en el inventario
function agregar_inventario(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_inventario.php");
	closeNav();
};

// Guardar en el inventario
function guardar_inventario(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
	var categoria= document.getElementById("categoria").value;
    var precio= document.getElementById("precio").value;
    var precio_compra= document.getElementById("precio_compra").value;
    var stock= document.getElementById("stock").value;
    var inventario= document.getElementById("inventario").value;
    var bodega_inventario= document.getElementById("bodega_inventario").value;
    var bodega_stock= document.getElementById("bodega_stock").value;
    var clave= document.getElementById("clave").value;
	if(nombre.length >0 && categoria >0 && precio >0){
			$("#boton_inventario").html('<div class="spinner-border text-primary"></div>');
			var datos = {
                    "nombre": nombre,
                    "descripcion": descripcion,
                    "categoria": categoria,
                    "precio": precio,
                    "precio_compra": precio_compra,
                    "stock": stock,
                    "inventario": inventario,
                    "bodega_inventario": bodega_inventario,
                    "bodega_stock": bodega_stock,
                    "clave": clave,
                    "usuario_id": usuario_id,
				};
			$.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/guardar_inventario.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:ver_inventario,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
				});
				return false;
			}else{
				alert("Campos incompletos");
			}
}

// Muestra los datos del inventario de la bd
function ver_inventario(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_inventario.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

function switch_rack(){
    if(siguiente_vista==0){
        localStorage.setItem('vista',0)
        localStorage.setItem('txt_vista',"Rack Habitacional")
    }else{
        localStorage.setItem('vista',1)
        localStorage.setItem('txt_vista',"Rack Operaciones")
    }
    vista = localStorage.getItem('vista')
    if(vista==3 || vista==0){
        console.log("rack de habitaciones "+vista);
        var usuario_id=localStorage.getItem("id");
        $('#area_trabajo').hide();
        $('#area_trabajo_menu').show();
        $('#pie').show();
        $("#area_trabajo_menu").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
        closeModal();
        closeNav();
        siguiente_vista=1;
    }else{
        console.log("rack de operaciones "+vista);
        var id=localStorage.getItem("id");
        var token=localStorage.getItem("tocken");
        localStorage.removeItem('estatus_hab')
        estatus_hab=""
        $('#area_trabajo').hide();
        $('#pie').show();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/area_trabajo.php?id="+id+"&token="+token+"&estatus_hab="+estatus_hab);
        closeModal();
        closeNav();
        siguiente_vista=0;
    }
}

function ver_rack_habitacional(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
	closeNav();
}

// Muestra la paginacion del inventario
function ver_inventario_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_inventario").load("includes/ver_inventario_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Barra de diferentes busquedas en ver inventario
function buscar_inventario(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_inventario").load("includes/buscar_inventario.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);
}

// Editar el inventario
function editar_inventario(id){
    $("#area_trabajo_menu").load("includes/editar_inventario.php?id="+id);
}

// Editar el inventario
function modificar_inventario(id){
	var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
	var categoria= document.getElementById("categoria").value;
    var precio= document.getElementById("precio").value;
    var precio_compra= document.getElementById("precio_compra").value;
    var stock= document.getElementById("stock").value;
    var inventario= document.getElementById("inventario").value;
    var bodega_inventario= document.getElementById("bodega_inventario").value;
    var bodega_stock= document.getElementById("bodega_stock").value;
    var clave= document.getElementById("clave").value;
	if(id >0){
		$("#boton_inventario").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "nombre": nombre,
                "descripcion": descripcion,
                "categoria": categoria,
                "precio": precio,
                "precio_compra": precio_compra,
                "stock": stock,
                "inventario": inventario,
                "bodega_inventario": bodega_inventario,
                "bodega_stock": bodega_stock,
                "clave": clave,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/aplicar_editar_inventario.php",
                data:datos,
                //beforeSend:loaderbar,
                success:ver_inventario,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Borrar un inventario
function borrar_inventario(id){
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
                url:"includes/borrar_inventario.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_inventario,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar inventario
function aceptar_borrar_inventario(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_inventario.php?id="+id);
}

// Regresar a la pagina anterior de editar inventario
function regresar_editar_inventario(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_inventario.php?usuario_id="+usuario_id);
}

//* Surtir *//
// Muestra los productos para poder surtir inventario
function surtir_inventario(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_inventario_surtir.php");
    closeModal();
	closeNav();
}

// Muestra los datos de los reportes de surtir inventario de la bd
function ver_surtir(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_surtir.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra la paginacion de los reportes de surtir inventario
function ver_surtir_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_surtir_inventario").load("includes/ver_surtir_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);   
}

// Busqueda por fecha en ver reportes de surtir inventario
function busqueda_surtir(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_surtir_inventario").load("includes/busqueda_surtir.php?inicial="+inicial+"&final="+final);
}

// Barra de diferentes busquedas para poder surtir inventario
function buscar_surtir_inventario(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
	$("#tabla_surtir_inventario").load("includes/buscar_surtir_inventario.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);  
}

// Mostrar diferentes categorias en ver inventario surtir
function mostrar_surtir_categoria(){
    //var categoria = document.getElementById("categoria").value;
    var categoria=$("#categoria").val();
    if(categoria == 0){
        $("#area_trabajo_menu").load("includes/surtir_inventario.php");
    }else{
        $("#area_trabajo_menu").load("includes/surtir_inventario_categoria.php?categoria="+categoria);
    }
}

// Guardar producto a surtir en el inventario
function inventario_surtir_producto(producto){
    var cant= "cantidad"+producto;
    var cantidad_producto= document.getElementById(cant).value;
	if(cantidad_producto>0){
		var datos = {
				"producto": producto,
			    "cantidad_producto": cantidad_producto,
			};
		$.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/inventario_surtir.php",
                data:datos,
                beforeSend:loaderbar,
                success:cargar_surtir,
                //success:problemas_hab,
                timeout:5000,
                error:problemas_sistema
			});
		return false;
	}else{
		alert("Cantidad insuficiente");
	}
}

// Muestra los datos de surtir de la bd
function cargar_surtir(){
	$("#a_surtir").load("includes/mostrar_surtir.php");
}

// Modal de editar un producto de surtir inventario
function aceptar_editar_surtir_inventario(id){
	$("#mostrar_herramientas").load("includes/editar_modal_surtir_inventario.php?id="+id);
}

// Editar un producto de surtir inventario
function editar_surtir_inventario(id){
	var cantidad= document.getElementById("cantidad").value;
	if(cantidad >0){
        $('#caja_herramientas').modal('hide');
		$("#boton_surtir").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "cantidad": cantidad,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/editar_surtir_inventario.php",
                data:datos,
                //beforeSend:loaderbar,
                success:cargar_surtir,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }else{
        alert("¡La cantidad debe ser mayor a 0!");
    }
}

// Borrar un producto de surtir inventario
function borrar_surtir_inventario(id){
    $('#caja_herramientas').modal('hide');
    if (id >0) {
        var datos = {
                "id": id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/borrar_surtir_inventario.php",
                data:datos,
                beforeSend:loaderbar,
                success:cargar_surtir,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar un producto de surtir inventario
function aceptar_borrar_surtir_inventario(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_surtir_inventario.php?id="+id);
}

// Modal de aplicar surtir inventario
function aceptar_aplicar_surtir_inventario(id){
	$("#mostrar_herramientas").load("includes/aplicar_modal_surtir_inventario.php?id="+id);
}

function validarEmail(email){
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

function comprobarEmail(){
    email = $("#correo").val()
    if(!validarEmail(email) && email!=""){
        alert("Escribe una dirección de correo válida")
    }
}

// Aplicar surtir inventario
function aplicar_surtir_inventario(){
    var usuario_id=localStorage.getItem("id");
    $('#caja_herramientas').modal('hide');
    $("#area_trabajo_menu").load("includes/aplicar_surtir_inventario.php?usuario_id="+usuario_id);
    reporte_surtir_inventario(0);
    principal();
}

// Generar reporte de surtir inventario
function reporte_surtir_inventario(id){
	var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_surtir_inventario.php?id="+id+"&usuario_id="+usuario_id);
}

//* Restaurante *//
// Agregar en el restaurante
function agregar_restaurante(hab_id,estado,maestra=0,mov=0){
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_restaurante.php?hab_id="+hab_id+"&estado="+estado+"&maestra="+maestra+"&mov="+mov);
    closeModal();
	closeNav();
}

function vista_desarrollo(hab_id,estado){
    window.open("includes/mail.php?id="+hab_id);
    return
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	// $("#area_trabajo_menu").load("includes/vista_desarrollo.php?hab_id="+hab_id+"&estado="+estado);
	closeNav();
}

// Agregar en el restaurante en mesa
function agregar_restaurante_mesa(mesa_id,estado){
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_restaurante_mesa.php?mesa_id="+mesa_id+"&estado="+estado);
	closeNav();
}

// Mostrar categorias existentes en el inventario
function buscar_categoria_restaurente(categoria,hab_id,estado,mov,mesa,maestra=0){
	$("#caja_mostrar_busqueda").load("includes/mostrar_buscar_categoria_restaurente.php?categoria="+categoria+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&mesa="+mesa+"&maestra="+maestra);
}

function buscarCategoriaRestaurante(categoria,hab_id,estado,mov,mesa){
    $("#caja_mostrar_busqueda").load("includes/mostrar_buscar_categoria_restaurente.php?categoria="+categoria+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&mesa="+mesa);
}

// Mostrar productos de las categorias existentes en el inventario
function cargar_producto_restaurante(producto,categoria,hab_id,estado,mov,mesa,maestra=0){
	var usuario_id=localStorage.getItem("id");
    var datos = {
		"producto": producto,
        "categoria": categoria,
        "hab_id": hab_id,
		"estado": estado,
        "mov": mov,
        "mesa": mesa,
		"usuario_id": usuario_id,
        "id_maestra":maestra,
		};
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/agregar_producto_restaurante.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_restaurante,
            //success:problemas,
            timeout:5000,
            error:problemas_cargar_producto
            });
        return false;
}

// Recibe los datos para efectuar aregar producto de restaurante
function recibe_datos_restaurante(datos){
    //alert(datos);
    var res = datos.split("/");
    console.log(res[5]);
    agregar_restaurante_cat(res[0] , res[1] , res[2] , res[3], res[4], res[5]);
}

// Agregar en el restaurante
function agregar_restaurante_cat(categoria,hab_id,estado,mesa,mov,maestra){
    console.log(maestra)
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_restaurante_cat.php?hab_id="+hab_id+"&estado="+estado+"&categoria="+categoria+"&categoria="+categoria+"&mesa="+mesa+"&mov="+mov+"&id_maestra="+maestra);
	closeNav();
}

// Si existe un problema en el proceso
function problemas_cargar_producto(datos){
	alert("El producto ya fue agregado.  Inf: "+datos.toString());
}

// Buscar cualquier producto en el inventario
function buscar_producto_restaurante(hab_id,estado,mov,mesa,id_maestra=0){
	var a_buscar= encodeURI(document.getElementById("a_buscar").value);
	$("#caja_mostrar_busqueda").load("includes/buscar_producto_restaurante.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&a_buscar="+a_buscar+"&mesa="+mesa+"&id_maestra="+id_maestra);
}

// Modal de editar producto del pedido del restaurante
function editar_modal_producto_restaurante(producto,hab_id,estado,mov,mesa,cantidad,id_maestra){
    $("#mostrar_herramientas").load("includes/editar_modal_producto_restaurante.php?producto="+producto+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&mesa="+mesa+"&cantidad="+cantidad+"&id_maestra="+id_maestra);
}

// Editar producto del pedido del restaurante
function modificar_producto_restaurante(producto,hab_id,estado,mov,mesa,cantidad_antes,id_maestra=0){
	var usuario_id=localStorage.getItem("id");
    var categoria= 0;
    var cantidad= document.getElementById("cantidad").value;
	if(cantidad>0){
        var datos = {
            "producto": producto,
            "categoria": categoria,
            "hab_id": hab_id,
            "estado": estado,
            "mov": mov,
            "mesa": mesa,
            "cantidad": cantidad,
            "cantidad_antes": cantidad_antes,
            "usuario_id": usuario_id,
            "id_maestra":id_maestra
            };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/modificar_producto_restaurante.php",
            data:datos,
            beforeSend:loaderbar,
            success:recibe_datos_restaurante,
            //success:problemas,
            timeout:5000,
            error:problemas_cargar_producto
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Borrar un producto del pedido del restaurante
function eliminar_producto_restaurante(producto,hab_id,estado,mov,mesa,id_maestra=0){
    var usuario_id=localStorage.getItem("id");
    var categoria= 0;
    console.log(id_maestra);
    var datos = {
		"producto": producto,
        "categoria": categoria,
        "hab_id": hab_id,
		"estado": estado,
        "mov": mov,
        "mesa": mesa,
		"usuario_id": usuario_id,
        "id_maestra":id_maestra,
		};
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"includes/eliminar_producto_restaurante.php",
		data:datos,
		beforeSend:loaderbar,
		success:recibe_datos_restaurante,
		//success:problemas,
		timeout:5000,
		error:problemas_cargar_producto
		});
	return false;
}

// Guardar en el inventario
function guardar_inventario(){
    var usuario_id=localStorage.getItem("id");
	var nombre= encodeURI(document.getElementById("nombre").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
	var categoria= document.getElementById("categoria").value;
    var precio= document.getElementById("precio").value;
    var precio_compra= document.getElementById("precio_compra").value;
    var stock= document.getElementById("stock").value;
    var inventario= document.getElementById("inventario").value;
    var bodega_inventario= document.getElementById("bodega_inventario").value;
    var bodega_stock= document.getElementById("bodega_stock").value;
    var clave= document.getElementById("clave").value;
	if(nombre.length >0 && categoria >0 && precio >0){
			$("#boton_inventario").html('<div class="spinner-border text-primary"></div>');
			var datos = {
			    "nombre": nombre,
			    "descripcion": descripcion,
			    "categoria": categoria,
                "precio": precio,
                "precio_compra": precio_compra,
                "stock": stock,
                "inventario": inventario,
                "bodega_inventario": bodega_inventario,
                "bodega_stock": bodega_stock,
                "clave": clave,
                "usuario_id": usuario_id,
			};
			$.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/guardar_inventario.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:ver_inventario,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
				});
			return false;
			}else{
				alert("Campos incompletos");
			}
}

// Pedir restaurante cobro
function pedir_rest_cobro(total,hab_id,estado,mov,id_maestra=0){
    if(mov == 0){
        $("#mostrar_herramientas").load("includes/modal_pedir_rest_cobro.php?total="+total+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov); 
    }else{
        $("#mostrar_herramientas").load("includes/modal_elegir_rest_cobro.php?total="+total+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&id_maestra="+id_maestra); 
    }
}

// Pedir restaurante cobro directo
function pedir_rest_cobro_directo(total,hab_id,estado,mov){
    $("#mostrar_herramientas").load("includes/modal_pedir_rest_cobro.php?total="+total+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov); 
}

// Pedir restaurante el cobro se carga a la habitacion
function pedir_rest_cobro_hab(total,hab_id,estado,mov,id_maestra=0){
    $("#mostrar_herramientas").load("includes/modal_pedir_rest_cobro_hab.php?total="+total+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&id_maestra="+id_maestra); 
}

// Pedir restaurante cobro en mesa
function pedir_rest_cobro_mesa(total,hab_id,estado,mov){
	$("#mostrar_herramientas").load("includes/modal_pedir_rest_cobro_mesa.php?total="+total+"&hab_id="+hab_id+"&estado="+estado+"&mov="+mov); 
}

// Cambio en pedir restaurante
function cambio_rest_cobro(total){
	var efectivo=$("#efectivo").val();
	var cambio= efectivo-total;
	if(isNaN(cambio)){
		cambio= 0;
	}
	if(cambio<=0){
		cambio= 0;
	}
	document.getElementById("cambio").value =cambio;
}

// Descuento en pedir restaurante
function cambio_rest_descuento(total){
	var descuento= Number(document.getElementById("descuento").value);
    var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	document.getElementById("total").value= calculo_descuento;
}

// Aplicar el cobro en pedido restaurante
function aplicar_rest_cobro(total,hab_id,estado,mov,mesa){
    
    var mesa_id= hab_id;
    var total_inicial= total;
    var usuario_id=localStorage.getItem("id");
	var efectivo=parseFloat($("#efectivo").val());
    var cambio=parseFloat($("#cambio").val());
	var monto=parseFloat($("#monto").val());
    var forma_pago= document.getElementById("forma_pago").value;
    var folio= encodeURI(document.getElementById("folio").value);
	var descuento=parseFloat($("#descuento").val());
    var comentario= encodeURI(document.getElementById("comentario").value);
    var total_descuento=parseFloat($("#total").val());
	if(isNaN(efectivo)){
		efectivo= 0;
	}
	if(isNaN(monto)){
		monto= 0;
	}
	if(isNaN(descuento)){
		descuento= 0;
	}
    if(monto <= 0){
        forma_pago= 1;
    }
    var precio=$("#total").val();
    if(precio < total && precio >0){
        total = precio;
    }
    //alert(total);
    total= parseFloat(total);
    if(total > total_descuento){
        total_final= total_descuento;
    }else{
        total_final= total;
    }
	var total_pago= efectivo + monto;
    total_descuento= total_inicial - total_final;
    total_descuento= redondearDecimales(total_descuento,2);
    // Checar si el cobro es en mesa o no
    if(monto <= total_final){
        if(total_pago >= total_final){
            if(monto>0 && forma_pago>1 || efectivo> 0 && forma_pago==1){
                if(forma_pago==2 && folio.length >0 || forma_pago>2 || efectivo>=total_final){
                    $("#boton_pago").html('<div class="spinner-border text-primary"></div>');
                    if(mesa == 0){
                        var datos = {
                            "efectivo":efectivo,
                            "cambio": cambio,
                            "monto": monto,
                            "forma_pago": forma_pago,
                            "folio": folio,
                            "total_pago": total_pago,
                            "descuento": descuento,
                            "total_descuento": total_descuento,
                            "total_final": total_final,
                            "tota_pago": total_pago,
                            "cambio": cambio,
                            "total": total,
                            "comentario": comentario,
                            "hab_id": hab_id,
                            "mesa": mesa,
                            "estado": estado,
                            "mov": mov,
                            "usuario_id": usuario_id,
                            };
                        $.ajax({
                            async:true,
                            type: "POST",
                            dataType: "html",
                            contentType: "application/x-www-form-urlencoded",
                            url:"includes/aplicar_rest_cobro.php",
                            data:datos,
                            beforeSend:loaderbar,
                            success:principal,
                            //success:problemas_sistema,
                            timeout:5000,
                            error:problemas_sistema
                            });
                        return false;
                    }else{
                        var datos = {
                            "efectivo":efectivo,
                            "cambio": cambio,
                            "monto": monto,
                            "forma_pago": forma_pago,
                            "folio": folio,
                            "total_pago": total_pago,
                            "descuento": descuento,
                            "total_descuento": total_descuento,
                            "total_final": total_final,
                            "tota_pago": total_pago,
                            "cambio": cambio,
                            "total": total,
                            "comentario": comentario,
                            "mesa_id": mesa_id,
                            "mesa": mesa,
                            "estado": estado,
                            "mov": mov,
                            "usuario_id": usuario_id,
                            };
                        $.ajax({
                            async:true,
                            type: "POST",
                            dataType: "html",
                            contentType: "application/x-www-form-urlencoded",
                            url:"includes/cobrar_rest_cobro_mesa.php",
                            data:datos,
                            beforeSend:loaderbar,
                            success:mesas_restaurante,
                            //success:problemas,
                            timeout:5000,
                            error:problemas
                            });
                        return false;
                    }
                }else{
                        alert("¡Falta agregar el folio del pago de la tarjeta!");
                    }
            }else{
                alert("Agrega la forma de pago del moto agregado");
            }
        }else{
            alert("¡Aun falta dinero!");
        }
    }else{
        alert("La cantidad pagada con tarjeta u otro metodo es demasiada");
    }
}

// Datos del modal de confirmacion de cargar restaurante cobro
function modal_cargar_rest_cobro(total,mesa_id,estado,mov){
    $("#mostrar_herramientas").load("includes/modal_cargar_rest_cobro.php?total="+total+"&mesa_id="+mesa_id+"&estado="+estado+"&mov="+mov); 
}

// Filtra el nombre y apellido del huesped de la habitacion
function filtrar_huesped(){
    var hab= document.getElementById("hab").value;
    $(".div_huesped").load("includes/div_filtrar_huesped.php?hab="+hab);
}

// Aplicar el cobro en pedido restaurante enviado a una habitacion desde una mesa
function cargar_rest_cobro_mesa(total,mesa_id,estado,mov){
    var total_inicial= total;
    var usuario_id=localStorage.getItem("id");
    var hab= encodeURI(document.getElementById("hab").value);
    var nombre= encodeURI(document.getElementById("nombre").value);
    var apellido= encodeURI(document.getElementById("apellido").value);
    var credencial= encodeURI(document.getElementById("credencial").value);
    var descuento=parseFloat($("#descuento").val());
    var comentario= encodeURI(document.getElementById("comentario").value);
    var total_descuento=parseFloat($("#total").val());
    var revision_nombre= document.getElementById("nombre").value;
    var revision_apellido= document.getElementById("apellido").value;
    var revision_hab= 'Habitación errónea';
    if(isNaN(descuento)){
		descuento= 0;
	}
    var precio=$("#total").val();
    if(precio < total && precio >0){
        total = precio;
    }
    total= parseFloat(total);
    if(total > total_descuento){
        total_final= total_descuento;
    }else{
        total_final= total;
    }
    //alert(total);
    total= parseFloat(total);
    if(total > total_descuento){
        total_final= total_descuento;
    }else{
        total_final= total;
    }
    total_descuento= total_inicial - total_final;
    total_descuento= redondearDecimales(total_descuento,2);
    if(hab.length >0){
        if((revision_nombre != revision_hab) || (revision_apellido != revision_hab)){
            if(credencial.length >4){
                $("#boton_cargo").html('<div class="spinner-border text-primary"></div>');
                var datos = {
                    "hab": hab,
                    "credencial": credencial,
                    "descuento": descuento,
                    "total_descuento": total_descuento,
                    "total_final": total_final,
                    "comentario": comentario,
                    "total_inicial": total_inicial,
                    "mesa_id": mesa_id,
                    "estado": estado,
                    "mov": mov,
                    "usuario_id": usuario_id,
                        };
                        $.ajax({
                            async:true,
                            type: "POST",
                            dataType: "html",
                            contentType: "application/x-www-form-urlencoded",
                            url:"includes/cargar_rest_cobro_mesa.php",
                            data:datos,
                            beforeSend:loaderbar,
                            success:mesas_restaurante,
                            //success:problemas,
                            timeout:5000,
                            error:problemas
                            });
                        return false;
            }else{
                alert("¡Falta agregar el numero de credencial para votar!");
            }
        }else{
            alert("¡Habitación errónea, favor de ingresar otra!");
        }
    }else{
        alert("¡Falta agregar la habitacion!");
    }
}

//ver cuenta maestra
function ver_cuenta_maestra(){
    var usuario_id = localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_cuenta_maestra.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Aplicar el cobro en pedido restaurante enviado a una hab
function aplicar_rest_cobro_hab(total,hab_id,estado,mov,motivo="",id_maestra=0){
    var usuario_id=localStorage.getItem("id");
    const btnRest = document.getElementById("btn-restaurant");
    if(btnRest){
        btnRest.disabled = true ;
        btnRest.style.opacity = 0.7;
        btnRest.textContent = "Procesando...";
    }
    //alert("Boton presionado")
    $("#boton_pago").html('<div class="spinner-border text-primary"></div>');
    var datos = {
        "total": total,
        "hab_id": hab_id,
        "estado": estado,
        "mov": mov,
        "usuario_id": usuario_id,
        "motivo":motivo,
        "id_maestra":id_maestra,
    };
    // console.log(datos)
    // return
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"includes/aplicar_rest_cobro_hab.php",
        data:datos,
        beforeSend:loaderbar,
        success:function(res){
            console.log(res)
            if(id_maestra==0){
                principal()
            }else{
                estado_cuenta_maestra(0,1,mov,id_maestra)
            }
        },
        //success:problemas_sistema,
        error:problemas_sistema
    });
    return false;
}

// Aplicar el cobro en pedido restaurante
function aplicar_rest_cobro_mesa(total,hab_id,estado,mov){
    var usuario_id=localStorage.getItem("id");
    var comentario= encodeURI(document.getElementById("comentario").value);
    var datos = {
            "total": total,
            "comentario": comentario,
            "hab_id": hab_id,
            "estado": estado,
            "mov": mov,
            "usuario_id": usuario_id,
            };
            $.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/aplicar_rest_cobro_mesa.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:mesas_restaurante,
                    //success:problemas,
                    timeout:5000,
                    error:problemas
                });
                return false;
}

// Regresa al inicio
function principal(){
    $('#caja_herramientas').modal('hide');
	$('area_trabajo_menu').load("includes/blanco.php");
	$('#area_trabajo').show();
	$('#area_trabajo_menu').hide();
    recargar_pagina();
}

//* Mesas *//
// Mesas en el restaurante
function agregar_mesa(){
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_mesa.php");
	closeNav();
}

function guardar_mesa(){
    var usuario_id=localStorage.getItem("id");
    nombre=$("#nombre").val();
    comentario=$("#comentario").val();
    capacidad=$("#capacidad").val();
    if(nombre == ""){
        alert("Ingresa nombre de la mesa")
    }else if(capacidad == ""){
        alert("Ingresa una capacidad para la mesa")
    }else if(comentario == ""){
        alert("Ingresa un comentario para la habitacion")
    }else{
        var datos = {
            "nombre": nombre,
            "comentario": comentario,
            "capacidad": capacidad,
            "usuario_id": usuario_id,
            };
            console.log(datos)
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_mesa.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                mesas_restaurante()
                // console.log(res)
                // if(res=="OK"){
                //     mesas_restaurante()
                // }else{
                //     alert("Ha ocurrido un error intentelo de nuevo")
                // }
            },
            //success:problemas,
            timeout:5000,
            error:problemas
            });
        return false;
    }
}

// Mesas en el restaurante
function mesas_restaurante(){
    $('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/area_mesas.php");
	closeNav();
}

// Muestra o carga los productos por mesa
function mostrar_herramientas_mesas(mesa_id,estado,nombre){
	var id=localStorage.getItem("id");
	$("#mostrar_herramientas").load("includes/mostrar_herramientas_mesas.php?mesa_id="+mesa_id+"&id="+id+"&estado="+estado+"&nombre="+nombre+"&id="+id);
}

// Modal de asignar una mesa disponible
function mesa_disponible_asignar(mesa_id,estado){
	$("#mostrar_herramientas").load("includes/mesa_disponible_asignar.php?mesa_id="+mesa_id+"&estado="+estado);
}

// Asignar una mesa disponible
function disponible_asignar_mesa(mesa_id,estado){
	var usuario_id=localStorage.getItem("id");
	var personas= document.getElementById("personas").value;
	if(personas >0){
		$('#caja_herramientas').modal('hide');
		var datos = {
			"mesa_id": mesa_id,
			"estado": estado,
			"personas": personas,
			"usuario_id": usuario_id,
			};
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"includes/disponible_asignar.php",
			data:datos,
			beforeSend:loaderbar,
			success:mesas_restaurante,//
			//success:problemas,
			timeout:5000,
			error:problemas
			});
		return false;
	}else{
        alert("Campos incompletos");
    }
}

// Ver caja de restaurante
function ver_caja_rest(mesa_id,estado){
    /*$('#caja_herramientas').modal('hide');
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();*/
	$('#caja_herramientas').modal('hide');
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_caja_rest.php?mesa_id="+mesa_id+"&estado="+estado);
	//$("#mostrar_herramientas").load("includes/mesa_cobrar_rest.php?mesa_id="+mesa_id+"&estado="+estado);
}

// Herramientas para modificar un concepto del ticket de una mesa
function herramienta_comanda(mesa_id,comanda,cantidad,precio,producto){
	$("#caja_herramientas").modal();
	$("#mostrar_herramientas").load("includes/herramienta_comanda.php?mesa_id="+mesa_id+"&comanda="+comanda+"&cantidad="+cantidad+"&precio="+precio+"&producto="+producto);
}

// Modal de editar producto del concepto de una mesa
function editar_modal_producto_mesa(mesa_id,producto,cantidad,precio,id_producto){
    $("#mostrar_herramientas").load("includes/editar_modal_producto_mesa.php?mesa_id="+mesa_id+"&producto="+producto+"&cantidad="+cantidad+"&precio="+precio+"&id_producto="+id_producto);
}

// Editar producto del concepto de una mesa
function modificar_producto_mesa(mesa_id,producto,precio,id_producto,cantidad_antes){
	var estado= 1;
	var id=localStorage.getItem("id");
    var cantidad= document.getElementById("cantidad").value;
	var usuario= encodeURI(document.getElementById("usuario").value);
    var contrasena= document.getElementById("contrasena").value;
	if(cantidad>0 && usuario.length>0 && contrasena.length>0){
        var datos = {
            "id": id,
			"cantidad": cantidad,
			"usuario": usuario,
            "contrasena": contrasena,
            "mesa_id": mesa_id,
			"estado": estado,
            "producto": producto,
            "precio": precio,
			"id_producto": id_producto,
			"cantidad_antes": cantidad_antes,
            };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/modificar_producto_mesa.php",
            data:datos,
            //beforeSend:loaderbar,
            success:recibe_datos_editar_mesa,
            //success:problemas,
			timeout:5000,
			error:problemas
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Mensaje de usuario o contrasena mal al editar
function recibe_datos_editar_mesa(datos){
	var res= datos.split("/");
	var id= parseInt(res[2]);
	if(id >= 1){
		localStorage.setItem("id",id);
        $('#caja_herramientas').modal('hide');
		ver_caja_rest(res[0],res[1]);
	}else{
		alert("¡Creo que has escrito mal tu usuario o contraseña!");
		editar_modal_producto_mesa(res[0],res[3],res[4],res[5]);
		//$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-warning"><span class="glyphicon glyphicon-remove"></span> Creo que has escrito mal tu usuario o contraseña </strong>');
	}
}

// Modal de borrar producto del concepto de una mesa
function borrar_modal_producto_mesa(mesa_id,producto,id_producto){
	$("#mostrar_herramientas").load("includes/borrar_modal_producto_mesa.php?mesa_id="+mesa_id+"&producto="+producto+"&id_producto="+id_producto);
}

// Eliminar producto del concepto de una mesa
function eliminar_producto_mesa(mesa_id,producto,id_producto){
	var estado= 1;
	var id=localStorage.getItem("id");
	var usuario= encodeURI(document.getElementById("usuario").value);
    var contrasena= document.getElementById("contrasena").value;
	if(usuario.length>0 && contrasena.length>0){
        var datos = {
            "id": id,
			"usuario": usuario,
            "contrasena": contrasena,
            "mesa_id": mesa_id,
			"estado": estado,
            "producto": producto,
			"id_producto": id_producto,
            };
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/eliminar_producto_mesa.php",
            data:datos,
            //beforeSend:loaderbar,
            success:recibe_datos_borrar_mesa,
            //success:problemas,
			timeout:5000,
			error:problemas
            });
        return false;
    }else{
        alert("Campos incompletos");
    }
}

// Mensaje de usuario o contrasena mal al borrar
function recibe_datos_borrar_mesa(datos){
	var res= datos.split("/");
	var id= parseInt(res[2]);
	if(id >= 1){
		localStorage.setItem("id",id);
    	$('#caja_herramientas').modal('hide');
		ver_caja_rest(res[0],res[1]);
	}else{
		alert("¡Creo que has escrito mal tu usuario o contraseña!");
		borrar_modal_producto_mesa(res[0],res[3],res[4]);
		//$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-warning"><span class="glyphicon glyphicon-remove"></span> Creo que has escrito mal tu usuario o contraseña </strong>');
	}
}

// Modal de cambiar la cantidad de personas en la mesa
function mesa_cambiar_personas(mesa_id,estado){
	$("#mostrar_herramientas").load("includes/mesa_cambiar_personas.php?mesa_id="+mesa_id+"&estado="+estado);
}

// Cambiar la cantidad de personas en la mesa
function cambiar_personas(mesa_id,estado){
	var usuario_id=localStorage.getItem("id");
	var personas= document.getElementById("personas").value;
	if(personas > 0){
		$('#caja_herramientas').modal('hide');
		var datos = {
			"mesa_id": mesa_id,
			"estado": estado,
			"personas": personas,
			"usuario_id": usuario_id,
			};
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"includes/cambiar_personas.php",
			data:datos,
			beforeSend:loaderbar,
			success:mesas_restaurante,
			//success:problemas,
			timeout:5000,
			error:problemas
			});
		return false;
	}else{
        alert("Campos incompletos");
    }
}

// Modal de imprimir el ticket de la mesa
function mesa_imprimir_ticket(mesa_id,estado){
	$("#mostrar_herramientas").load("includes/mesa_imprimir_ticket.php?mesa_id="+mesa_id+"&estado="+estado);
}

// Imprimir el ticket de la mesa
function imprimir_ticket(mesa_id,estado){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
		"mesa_id": mesa_id,
		"estado": estado,
		"usuario_id": usuario_id,
		};
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"includes/imprimir_ticket.php",
		data:datos,
		beforeSend:loaderbar,
		success:mesas_restaurante,
		//success:problemas,
		timeout:5000,
		error:problemas
		});
	return false;
}

// Mostrar teclado en caja//
function mostrarteclado_rest(ident,total){
	$("#tecaldo").load("includes/teclado_rest.php?ident="+ident+"&total="+total);
	//alert("Mostrar teclado");
}

// Agregar texto en el teclado emergente en caja//*
function agregar_text_rest(ident,carac,total){
	var entrada= document.getElementById(teclado[ident]).value;
	var resultado;
    if(total == 0){
        var total=$("#total").val();
    }
	if(carac=='*'){
		resultado = entrada.slice(0, -1);
	}else{
		resultado = entrada.concat(carac);
	}
	document.getElementById(teclado[ident]).value =resultado;
	suma_cobro_rest_caja(total);
}

// Sumar cobro de dinero de restaurante en caja
function suma_cobro_rest_caja(precio){
    var total=$("#total").val();
    if(total < precio && total >0){
        precio = total;
    }
    //alert(total);
    //alert(precio);
	var efectivo=$("#efectivo").val();
	var cambio = efectivo-precio;
	if(isNaN(cambio)){
		cambio=0;
	}
	if(cambio<=0){
		cambio=0;
	}
	document.getElementById("cambio").value =cambio;
}

// Descuento en pedir restaurante en mesa
function cambio_rest_descuento_mesa(){
    var total=$("#total").val();
	var descuento= Number(document.getElementById("descuento").value);
    var calculo_descuento= descuento_total(total,descuento);
	calculo_descuento= redondearDecimales(calculo_descuento,2);
	document.getElementById("total").value= calculo_descuento;
}

//* Cupon *//
// Agregar un cupon
function agregar_cupones(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_cupones.php");
	closeNav();
}

// Guardar un cupon
function guardar_cupon(){
    var usuario_id=localStorage.getItem("id");
    var vigencia_inicio= document.getElementById("vigencia_inicio").value;
	var vigencia_fin= document.getElementById("vigencia_fin").value;
	var codigo= encodeURI(document.getElementById("codigo").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
    var cantidad= document.getElementById("cantidad").value;
    var porcentaje_tipo= document.getElementById("porcentaje_tipo").checked;
    var dinero_tipo= document.getElementById("dinero_tipo").checked;
    if(porcentaje_tipo){
        tipo=0;
    }
    if(dinero_tipo){
        tipo=1;
    }
	if(vigencia_inicio.length >0 && vigencia_fin.length >0 && codigo.length >0 && cantidad >0){
        if((cantidad >-0.01 && cantidad <100 && tipo == 0) || (cantidad >-0.01 && tipo == 1)){
			$("#boton_cupon").html('<div class="spinner-border text-primary"></div>');
			var datos = {
                    "vigencia_inicio": vigencia_inicio,
                    "vigencia_fin": vigencia_fin,
                    "codigo": codigo,
                    "descripcion": descripcion,
                    "cantidad": cantidad,
                    "tipo": tipo,
                    "usuario_id": usuario_id,
				};
			$.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/guardar_cupon.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:ver_cupones,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
				});
				return false;
            }else{
                alert("Cantidad de descuento no permitida");
            }
	}else{
        alert("Campos incompletos");
	}
}

// Muestra los cupones de la bd
function ver_cupones(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_cupones.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra la paginacion de los cupones
function ver_cupones_paginacion(buton,posicion){
    var usuario_id=localStorage.getItem("id");
    $("#paginacion_cupones").load("includes/ver_cupones_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id);
}

// Barra de diferentes busquedas en ver cupones
function buscar_cupon(){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_cupon").load("includes/buscar_cupon.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id);
}

// Busqueda por fecha en ver cupones
function busqueda_cupon(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    var id=localStorage.getItem("id");
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_cupon").load("includes/busqueda_cupon.php?inicial="+inicial+"&final="+final+"&id="+id);
}

// Editar un cupon
function editar_cupon(id){
    $("#area_trabajo_menu").load("includes/editar_cupon.php?id="+id);
}

// Editar un cupon
function modificar_cupon(id,hab_id,id_reservacion){
	var usuario_id=localStorage.getItem("id");
    var vigencia_inicio= document.getElementById("vigencia_inicio").value;
	var vigencia_fin= document.getElementById("vigencia_fin").value;
	var codigo= encodeURI(document.getElementById("codigo").value);
	var descripcion= encodeURI(document.getElementById("descripcion").value);
    var cantidad= document.getElementById("cantidad").value;
    var porcentaje_tipo= document.getElementById("porcentaje_tipo").checked;
    var dinero_tipo= document.getElementById("dinero_tipo").checked;
    if(porcentaje_tipo){
        tipo=0;
    }
    if(dinero_tipo){
        tipo=1;
    }
	if(vigencia_inicio.length >0 && vigencia_fin.length >0 && codigo.length >0 && cantidad >0){
        if((cantidad >-0.01 && cantidad <100 && tipo == 0) || (cantidad >-0.01 && tipo == 1)){
            $("#boton_cupon").html('<div class="spinner-border text-primary"></div>');
            var datos = {
                    "id": id,
                    "vigencia_inicio": vigencia_inicio,
                    "vigencia_fin": vigencia_fin,
                    "codigo": codigo,
                    "descripcion": descripcion,
                    "cantidad": cantidad,
                    "tipo": tipo,
                    "usuario_id": usuario_id,
                };
            $.ajax({
                    async:true,
                    type: "POST",
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url:"includes/aplicar_editar_cupon.php",
                    data:datos,
                    beforeSend:loaderbar,
                    success:ver_cupones,
                    //success:problemas_sistema,
                    timeout:5000,
                    error:problemas_sistema
                });
                return false;
            }else{
                alert("Cantidad de descuento no permitida");
            }
    }else{
        alert("Campos incompletos");
    }
}

// Borrar un cupon
function borrar_cupon(id){
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
                url:"includes/borrar_cupon.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_cupones,
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

// Modal de borrar un cupon
function aceptar_borrar_cupon(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_cupon.php?id="+id);
}

// Regresar a la pagina anterior de editar un cupon
function regresar_editar_cupon(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_cupones.php?usuario_id="+usuario_id);
}

//* Configuracion *//
// Cambiar la imagen de login del sistema
function cambiar_imagen(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/cambiar_imagen.php?usuario_id="+usuario_id);
	closeNav();
}

// Cambiar el archivo seleccionado en el servidor
function cambiar_archivo(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/cambiar_archivo.php?usuario_id="+usuario_id);
	closeNav();
}

// Cambiar los colores y nombre del sistema del sistema
function cambiar_fondo(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/cambiar_fondo.php?usuario_id="+usuario_id);
	closeNav();
}

// Conseguimos la previsualizacion donde se ve el cambio de los colores del estado del rack
function previsualizar_estado(){
    var estado= encodeURI(document.getElementById("estado").value);
	var rack= encodeURI($("#rack").val());
	var hover= encodeURI($("#hover").val());
	var letra= encodeURI($("#letra").val());
	var sub_sucia= encodeURI($("#sub_sucia").val());
    var sub_limpieza= encodeURI($("#sub_limpieza").val());
    rack= rack.substr(1);
    hover= hover.substr(1);
    letra= letra.substr(1);
    sub_sucia= sub_sucia.substr(1);
    sub_limpieza= sub_limpieza.substr(1);
    $(".div_previsualizar").html('<div class="spinner-border text-primary"></div>');
    $(".div_previsualizar").load("includes/cambiar_previsualizacion.php?estado="+estado+"&rack="+rack+"&hover="+hover+"&letra="+letra+"&sub_sucia="+sub_sucia+"&sub_limpieza="+sub_limpieza);  
    //alert("Cambiando color en "+estado);
}

//* Cortes *//
function saldo_huespedes(){
    usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_saldo_huespedes.php?usuario_id="+usuario_id);
    closeNav();
}

function corte_diario(){
    usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_corte_diario.php?usuario_id="+usuario_id);
    closeNav();
}

function hacer_corte(){
    usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_corte.php?usuario_id="+usuario_id);
    closeNav();
}

function factura_individual(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_individual.php");
    closeNav();
}
function factura_hab(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_global_form.php");
    closeNav();
}
function factura_global_form(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_global.php");
    closeNav();
}
function folio_casa_form(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/busqueda_folio_casa.php");
    closeNav();
}
function factura_cancelar(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_cancelar.php");
    //$("#area_trabajo_menu").load("includes/formulario_cancelar.php");
    closeNav();
}
function factura_cancelarbtn(folio){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_cancelar.php?folio="+folio);
    //$("#area_trabajo_menu").load("includes/formulario_cancelar.php");
    closeNav();
}
function factura_buscar_fecha(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_buscar_fecha.php");
    //$("#area_trabajo_menu").load("includes/ver_facturas_fecha.php");
    closeNav();
}
function factura_buscar_folio(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_buscar_folio.php");
    //$("#area_trabajo_menu").load("includes/ver_facturas_folio.php");
    closeNav();
}
function factura_buscar_folio_casa(){
    //usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/factura_buscar_folio_casa.php");
    //$("#area_trabajo_menu").load("includes/ver_facturas_folio.php");
    closeNav();
}

function manejo_facturas(){
    const btn = document.querySelector("#btn_generar_factura");
    const infoTotal = document.querySelector("#total_factura_global");
    const total = document.querySelector("#total_factura_global_number");
    const fechaInio = document.getElementById("fecha_inicio_factura").value;
    const fechaFin = document.getElementById("fecha_fin_factura").value;
    btn.style.display = "none"
    infoTotal.style.display = "none"

    if (!fechaInio) {
        swal({
            title: "Falta fecha de inicio",
            icon: "warning",
            confirmButtonText: "Aceptar",
            dangerMode: true,
        })
        return
    } else if (!fechaFin) {
        swal({
            title: "Falta fecha de final",
            icon: "warning",
            confirmButtonText: "Aceptar",
            dangerMode: true,
        })
        return
    } else if (fechaInio > fechaFin){
        swal({
            title: "Error en el rango de fechas",
            icon: "warning",
            confirmButtonText: "Aceptar",
            dangerMode: true,
        })
        return
    } else {
        const contenedor = document.getElementById("contenedor-facturas");
        datos = { fechaInio: fechaInio, fechaFin: fechaFin }
            contenedor.innerHTML = `
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
            `;
            $.ajax({
                async:true,
                type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/factura_global_consulta.php",
            data:datos,
            success: function(response){
                contenedor.innerHTML = response;
                const totalInput = document.getElementById("total_factura_input");
                const totalValue = totalInput.value; // Lee el valor del input
                total.textContent = totalValue; // Actualiza el elemento con el valor total
                btn.style.display = "block";
                infoTotal.style.display = "block";
            } ,
        });
    }
}
function manejo_facturas_folio_casa(){
    const btn = document.querySelector("#btn_generar_factura");
    const infoTotal = document.querySelector("#total_factura_global");
    //const total = document.querySelector("#total_factura_global_number");
    const folio_casa = document.getElementById("folio_casa").value;
    //const fechaFin = document.getElementById("fecha_fin_factura").value;
    btn.style.display = "none"
    infoTotal.style.display = "none"

    if (!folio_casa) {
        swal({
            title: "Falta fecha de inicio",
            icon: "warning",
            confirmButtonText: "Aceptar",
            dangerMode: true,
        })
        return
    }else {
        const contenedor = document.getElementById("contenedor-facturas");
        datos = { folio_casa: folio_casa }
            contenedor.innerHTML = `
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
            `;
            $.ajax({
                async:true,
                type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/buscar_folio_casa_facturar.php",
            data:datos,
            success: function(response){
                contenedor.innerHTML = response;
                const totalInput = document.getElementById("total_factura_input");
                //const totalValue = totalInput.value; // Lee el valor del input
                //total.textContent = totalValue; // Actualiza el elemento con el valor total
                btn.style.display = "block";
                infoTotal.style.display = "block";
            } ,
        });
    }
}
function generar_facturas_global(){
    var input_longitud=document.getElementById("leer_iteraciones");
    var tipo_de_factura=document.getElementById("tipo_factura").value;
    var index=input_longitud.value;
    var lista_id_tickets=[];
    var lista_totales=[];
    var lista_tipo=[];
    var lista_mov=[];
    var total=0;
    var bandera_facturacion=document.getElementById("leer_facturacion").value;
    
    for (let i = 0; i < index; i++) {
        var checkBox_status=document.getElementById("leer_check_"+i)
        var id_ticket=document.getElementById("leer_id_"+i);
        var leer_total=document.getElementById("leer_total_"+i);
        var leer_tipo=document.getElementById("leer_tipo_"+i);
        var mov=document.getElementById("leer_mov_"+i);
        if (checkBox_status.checked) {
            lista_id_tickets.push(id_ticket.value);
            total=total+parseInt(leer_total.value);
            lista_totales.push(parseInt(leer_total.value));
            lista_tipo.push(parseInt(leer_tipo.value));
            if(mov.value){
                lista_mov.push(parseInt(mov.value))
            }
            else{
                lista_mov.push("")
            }
            
        }
    }
    localStorage.setItem('lista_id_tickets', lista_id_tickets);
    localStorage.setItem('total', total);
    console.log("facturas generadas");
    if (total>0){
        /* $.ajax({
            async: true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-ww-form-urlencoded",
            url: "includes/factura_global_form.php",
            data: { lista_id_tickets: lista_id_tickets, total: total },
            success: function(response){
                //console.log(response)
                //alert("Alertas generadas con exito")
                /* swal({
                    title: "",
                    icon: "warning",
                    confirmButtonText: "Aceptar",
                    dangerMode: true,
                }) 
                console.log("Factura generada con exito")
            }
        }) */
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/factura_global_form.php?total="+total+"&listaId="+lista_id_tickets+"&tipo="+bandera_facturacion+"&lista_totales="+lista_totales+"&lista_tipo="+lista_tipo+"&mov="+lista_mov+"&tipo_factura="+tipo_de_factura);
        closeNav();
    }else{
        swal({
            title: "Por favor selecciona los datos que quieres facturar",
            icon: "warning",
            confirmButtonText: "Aceptar",
            dangerMode: true,
        })
    }
}

// Hacer un corte
function hacer_cortes(){
    usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/hacer_cortes.php?usuario_id="+usuario_id);
    closeNav();
}

// Hacer un corte
function hacer_cortes_dia(){
    usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/hacer_cortes_dia.php?usuario_id="+usuario_id);
    closeNav();
}

function mostrar_reporte_historial_cliente(id_huesped){
    var usuario_id=localStorage.getItem("id");
    a_buscar = $("#a_buscar").val()
    inicial = $("#inicial_historial").val() === undefined ? 0 :  $("#inicial_historial").val()
    final =$("#final_historial").val() === undefined  ? 0 : $("#final_historial").val()
    window.open("includes/guardar_historial_cuenta_cliente.php?usuario_id="+usuario_id+"&inicial="+inicial+"&final="+final+"&a_buscar="+a_buscar+"&id="+id_huesped);
}

function mostrar_reporte_historial(){
    var usuario_id=localStorage.getItem("id");
    a_buscar = $("#a_buscar").val()
    inicial = $("#inicial_historial").val() === undefined ? 0 :  $("#inicial_historial").val()
    final =$("#final_historial").val() === undefined  ? 0 : $("#final_historial").val()
    window.open("includes/guardar_historial_cuentas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&final="+final+"&a_buscar="+a_buscar);
}

function aceptar_guardar_corte_diario(){
    // $("#mostrar_herramientas").load("includes/guardar_modal_corte_nuevo.php");
    swal({
        title: "¿Realizar reporte?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            var usuario_id=localStorage.getItem("id");
            //var usuario_id= 4;
            $('#caja_herramientas').modal('hide');
            var datos = {
                "usuario_id": usuario_id,
            };
            window.open("includes/guardar_corte_diario.php?id_usuario="+usuario_id);
            return false;
        }
        });
}

function aceptar_guardar_corte_nuevo(){
    $("#mostrar_herramientas").load("includes/guardar_modal_corte_nuevo.php");
}

// Modal de guardar corte
function aceptar_guardar_corte(){
	$("#mostrar_herramientas").load("includes/guardar_modal_corte.php");
}

// Modal de guardar corte
function aceptar_guardar_corte_global(){
	$("#mostrar_herramientas").load("includes/guardar_modal_corte_global.php");
}

function aceptar_ver_saldo_huspedes(){
    window.open("includes/reporte_saldo_huespedes.php");
}

// Guardar un corte global
function guardar_corte_nuevo(){
    var usuario_id=localStorage.getItem("id");
    //var usuario_id= 4;
    $('#caja_herramientas').modal('hide');
    var datos = {
        "usuario_id": usuario_id,
    };
    window.open("includes/guardar_corte_nuevo.php?id_usuario="+usuario_id);
    // $.ajax({
    //         async:true,
    //         type: "POST",
    //         dataType: "html",
    //         contentType: "application/x-www-form-urlencoded",
    //         url:"includes/guardar_corte_global.php",
    //         data:datos,
    //         beforeSend:loaderbar,
    //         success:function(res){
    //         },
    //         //success:problemas_sistema,
    //         timeout:5000,
    //         error:problemas_sistema
    //     });
    //window.open("includes/reporte_corte.php?usuario_id="+usuario_id);
    //guardar_reporte_corte();
    // mostrar_corte_reporte();
    return false;
}

// Guardar un corte  diario...
function guardar_corte_global(){
    var usuario_id=localStorage.getItem("id");
    //var usuario_id= 4;
    $('#caja_herramientas').modal('hide');
    var datos = {
        "usuario_id": usuario_id,
    };
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_corte_global.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    //window.open("includes/reporte_corte.php?usuario_id="+usuario_id);
    //guardar_reporte_corte();
    mostrar_corte_reporte();
    return false;
}

// Guardar un corte global.
function guardar_corte(){
    var usuario_id=localStorage.getItem("id");
    //var usuario_id= 4;
    $('#caja_herramientas').modal('hide');
    var datos = {
            "usuario_id": usuario_id,
        };
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/guardar_corte.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                principal()
            },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    //window.open("includes/reporte_corte.php?usuario_id="+usuario_id);
    //guardar_reporte_corte();
    mostrar_corte_reporte();
    return false;
}

// Generar reporte de corte y guardarlo
function guardar_reporte_corte(){
    var usuario_id=localStorage.getItem("id");
	var tam= tam_ventana();
	var alto= tam[1];
	var ancho= tam[0];
    $("#area_trabajo_menu").load("includes/barra_progreso.php");
	window.open("includes/reporte_corte.php?usuario_id="+usuario_id, "Diseño Web", "width="+ancho+", height="+alto);
    setTimeout(mostrar_corte_reporte, 7000);
}

// Mostrar el reporte de corte
function mostrar_corte_reporte(){
	var tam= tam_ventana();
	var alto= tam[1];
	var ancho= tam[0];
	window.open("includes/mostrar_corte_reporte.php?ancho="+ancho+"&alto="+alto, "Diseño Web", "width="+ancho+", height="+alto);
    salirsession();
}

// Obtenemos el tamaño de la ventana
function tam_ventana() {
    var tam = [0, 0];
    if (typeof window.innerWidth != 'undefined')
    {
    tam = [window.innerWidth,window.innerHeight];
    }
    else if (typeof document.documentElement != 'undefined'
        && typeof document.documentElement.clientWidth !=
        'undefined' && document.documentElement.clientWidth != 0)
    {
        tam = [
            document.documentElement.clientWidth,
            document.documentElement.clientHeight
        ];
    }
    else   {
        tam = [
            document.getElementsByTagName('body')[0].clientWidth,
            document.getElementsByTagName('body')[0].clientHeight
        ];
    }
    return tam;
}

// Muestra las cortes de habitaciones de la bd
function ver_cortes(){
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_cortes.php?usuario_id="+usuario_id);
    closeModal();
	closeNav();
}

// Muestra los reportes guardados de los cortes de la bd
function mostrar_reporte_corte(id){
	window.open("reportes/corte/reporte_corte_"+id+".pdf");
}

// Barra de diferentes busquedas en ver llegadas
function buscar_canceladas(e,opcion){
    setTimeout(() => {
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        var inicial = $("#inicial").val()
        var final = $("#final").val()
        if(inicial==undefined){
            inicial="";
        }
        final = $("#final").val()
        if(final==undefined){
            final="";
        }
        funcion_php="ver_canceladas.php"
        funcion_buscar = "buscar_canceladas.php"
        if(a_buscar.length >0){
            $('.pagination').hide();
        }else{
            //$('.pagination').show();
            // if( e.which === 8 ){ $("#area_trabajo_menu").load("includes/"+funcion_php+"?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+0); return false; }
        }
        $("#tabla_reservacion").load("includes/buscar_canceladas.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+opcion+"&final="+final);  
    }, "1000");
}

function ver_reportes_canceladas(btn=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    if(inicial==undefined){
        inicial="";
    }
    final = $("#final").val()
    if(final==undefined){
        final="";
    }
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/ver_canceladas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+btn+"&final="+final);
        closeModal();
        closeNav();
    }else{
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        $("#tabla_reservacion").load("includes/buscar_canceladas.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+2+"&final="+final);  
    }
}

function ver_reportes_salidas(btn=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    if(inicial==undefined){
        inicial="";
    }
    final = $("#final").val()
    if(final==undefined){
        final="";
    }
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/ver_salidas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+btn+"&final="+final);
        closeModal();
        closeNav();
    }else{
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        $("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+2+"&final="+final);  
    }
}

function buscador_reportes_reservas(opcion){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#dia").val()
    if(inicial==undefined){
        inicial="";
    }
    inicial = encodeURIComponent(inicial)
    a_buscar = $("#a_buscar").val()
    if(a_buscar==undefined){
        a_buscar="";
    }
    a_buscar = encodeURIComponent(a_buscar)
	var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
    include = "includes/buscar_entradas_salidas.php?usuario_id="+usuario_id+"&opcion="+opcion+"&inicial="+inicial+"&a_buscar="+a_buscar
    $("#tabla_reservacion").load(include);
}

function imprimir_reportes(opcion){
    var usuario_id=localStorage.getItem("id");
    titulo=""
    ruta=""
    inicial = $("#dia").val()
    if(inicial==undefined){
        inicial="";
    }
    inicial = encodeURIComponent(inicial)
    a_buscar = $("#a_buscar").val()
    if(a_buscar==undefined){
        a_buscar="";
    }
    a_buscar = encodeURIComponent(a_buscar)
    switch (opcion ) {
        case 1:
            titulo="LLEGADAS PROBABLES"
            break;
        case 2:
            titulo="LLEGADAS EFECTIVAS"
            break;
        case 3:
            titulo="SALIDAS PROBABLES"
            break;
        case 4:
            titulo="SALIDAS EFECTIVAS"
            break;
        default:
            break;
    }
    include = "includes/reporte_reservacion_general.php?usuario_id="+usuario_id+"&titulo="+titulo+"&opcion="+opcion+"&inicial="+inicial+"&a_buscar="+a_buscar
    window.open(include);
}

function ver_reportes_reservaciones(opcion,btn=0){
    titulo=""
    ruta=""
    switch (opcion ) {
        case 1:
            titulo="LLEGADAS PROBABLES"
            break;
        case 2:
            titulo="LLEGADAS EFECTIVAS"
            break;
        case 3:
            titulo="SALIDAS PROBABLES"
            break;
        case 4:
            titulo="SALIDAS EFECTIVAS"
            break;
        default:
            break;
    }
    titulo = encodeURIComponent(titulo)
    var usuario_id=localStorage.getItem("id");
    inicial = $("#dia").val()
    if(inicial==undefined){
        inicial="";
    }
    a_buscar = $("#a_buscar").val()
    if(a_buscar==undefined){
        a_buscar="";
    }
    a_buscar = encodeURIComponent(a_buscar)
	var usuario_id=localStorage.getItem("id");
    if(btn==0){
        if(inicial!=""){
            $("#dia").val("")
            inicial=""
        }
        if(a_buscar!=""){
            $("#a_buscar").val("")
            a_buscar=""
        }
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        include = "includes/ver_reportes_reservaciones.php?usuario_id="+usuario_id+"&titulo="+titulo+"&opcion="+opcion+"&inicial="+inicial+"&a_buscar="+a_buscar
        $("#area_trabajo_menu").load(include);
    }else{
    a_buscar = $("#a_buscar").val()
    if(a_buscar==undefined){
        a_buscar="";
    }
    a_buscar = encodeURIComponent(a_buscar)
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
    include = "includes/buscar_entradas_salidas.php?usuario_id="+usuario_id+"&opcion="+opcion+"&inicial="+inicial+"&a_buscar="+a_buscar
    $("#tabla_reservacion").load(include);
    }
}

function ver_reporte_historial_cliente(){
    alert("Generando reporte, espere porfavor...")
}

//funcion para ver los reportes de llegada
function ver_reportes_llegadas(btn=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    if(inicial==undefined || inicial==""){
        inicial=0;
    }
    final = $("#final").val()
    if(final==undefined || inicial==""){
        final=0;
    }
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/ver_llegadas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+btn+"&final="+final);
        closeModal();
        closeNav();
    }else{
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        $("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+1+"&final="+final);  
    }
}

// Busqueda por fecha en ver cortes de la bd
function busqueda_corte(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    if(inicial.length >0 && final.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_corte").load("includes/busqueda_corte.php?inicial="+inicial+"&final="+final);
}

//* Logs *//
// Muestra los logs de la bd
function ver_logs(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_logs.php?usuario_id="+usuario_id)
    closeModal();
    closeNav();
}

// Muestra la paginacion de los logs
function ver_logs_paginacion(buton,id,inicial,final){//
    //alert(id);
    //alert(inicial);
    //alert(final);
    $("#paginacion_logs").load("includes/ver_logs_paginacion.php?id="+id+"&inicial="+inicial+"&final="+final);
}

// Busqueda por fecha en ver logs
function busqueda_logs(usuario_id){
    $("#boton_log").html('<div class="spinner-border text-primary"></div>');
    var inicial=$("#inicial").val();
    var final=$("#final").val();
    $("#area_trabajo_menu").load("includes/busqueda_logs.php?inicial="+inicial+"&final="+final+"&usuario_id="+usuario_id);
}

// Barra de busqueda de usuarios en logs
function buscar_logs_usuario(inicial,final,id){
	var usuario=$("#usuario").val();
    /*if(usuario >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }*/
	$("#tabla_logs").load("includes/buscar_logs_usuario.php?usuario="+usuario+"&inicial="+inicial+"&final="+final+"&id="+id);
}

// Barra de busqueda de actividad en logs
function buscar_logs_actividad(){
    var buscar=encodeURIComponent($("#buscar").val());
	$("#tabla_logs").load("includes/buscar_logs_actividad.php?buscar="+buscar);
}

// Boton de busqueda de usuarios y actividad en logs
function buscar_usuario_logs(){
	var usuario=$("#usuario").val();
	var buscar=encodeURIComponent($("#buscar").val());
	$("#tabla_logs").load("includes/buscar_usuario_logs.php?buscar="+buscar+"&usuario="+usuario);
}

// Generar reporte de logs
function reporte_logs(fecha_ini,fecha_fin){
	var usuario_id=localStorage.getItem("id");
    var usuario=$("#usuario").val();
	var buscar=encodeURIComponent($("#buscar").val());
	window.open("includes/reporte_logs.php?fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&usuario_id="+usuario_id+"&usuario="+usuario+"&buscar="+buscar);
}

// Regresar a la pagina anterior de ver logs
function regresar_logs(){
    var usuario_id=localStorage.getItem("id");
    $('#area_trabajo').hide();
	$('#area_trabajo_menu').show();
    $("#area_trabajo_menu").load("includes/ver_logs.php?usuario_id="+usuario_id)
}

//* Estados  Internos de Edo.Ocupado *//

//Edo. 0-Disponible//

// Modal de mandar una habitacion a un nuevo estado
function hab_estado_inicial(hab_id,estado,nuevo_estado){
	$("#mostrar_herramientas").load("includes/hab_modal_estado_inicial.php?hab_id="+hab_id+"&estado="+estado+"&nuevo_estado="+nuevo_estado);
}

// Modal para asignar una reservacion
function asignarHabitacion(id_reserva,hab_id,estado,ruta){
    $("#mostrar_herramientas").load("includes/hab_modal_asignar_reserva.php?hab_id="+hab_id+"&estado="+estado)
}

// Modal de mandar una habitacion a estado limpieza
function hab_estado_limpiar(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_estado_limpiar.php?hab_id="+hab_id+"&estado="+estado);
}
// Modal de mandar una habitacion a estado limpieza
function hab_estado_cambiar_hab(id_reserva, hab_id,estado,ruta){
	$("#mostrar_herramientas").load("includes/hab_modal_estado_cambiar_hab.php?hab_id="+hab_id+"&estado="+estado);
}

// Cambiar huesped de habitacion
function hab_cambio(hab_id,estado,nueva_hab_id){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
            "nueva_hab_id": nueva_hab_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_cambio.php",
            data:datos,
            beforeSend:loaderbar,
            success:function(res){
                principal()
            },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

// Mandar una habitacion a estado limpieza
function hab_limpieza(hab_id,estado,usuario){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario": usuario,
            "usuario_id": usuario_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_limpieza.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

// Mandar una habitacion a un nuevo estado
function hab_modal_inicial(hab_id,estado,usuario){
    $("#mostrar_herramientas").load("includes/hab_modal_inicial.php?hab_id="+hab_id+"&estado="+estado+"&usuario="+usuario);
}

// Mandar una habitacion a estado inicial
function hab_inicial(hab_id,estado,usuario){
	var usuario_id=localStorage.getItem("id");
    if(estado!=5){
        var motivo= encodeURI(document.getElementById("motivo").value);
        $('#caja_herramientas').modal('hide');
        var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario": usuario,
            "motivo": motivo,
            "usuario_id": usuario_id,
            };
    }else{
        $('#caja_herramientas').modal('hide');
        var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario": usuario,
            "usuario_id": usuario_id,
            };
    }
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_inicial.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

//Edo. 1-Ocupado//
// Modal de mandar a desocupar una habitacion ocupada
function hab_desocupar_hospedaje(hab_id,estado,ver=0){
	$("#mostrar_herramientas").load("includes/hab_modal_desocupar_hospedaje.php?hab_id="+hab_id+"&estado="+estado+"&ver="+ver);
}

// Mandar a desocupar una habitacion ocupada
function hab_desocupar(hab_id,estado, ver =0){
    var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
            "ver":ver,
		};
        // console.log(datos)
        // return
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_desocupar.php",
            data:datos,
            beforeSend:loaderbar,
        success:function(){
            if(ver==0){
                window.open("includes/imprimir_estado_cuenta2.php?id="+hab_id);
            }
            principal()
        },
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
        });
    return false;
}

// Modal de mandar a sucia una habitacion ocupada
function hab_sucia_hospedaje(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_sucia_hospedaje.php?hab_id="+hab_id+"&estado="+estado);
}


// Modal de mandar a sucia una habitacion ocupada
function hab_sucia_vacia(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_disponible_hospedaje.php?hab_id="+hab_id+"&estado="+estado); 
}

// !**************************************************************
// Mandar al estado interno sucia una habitacion disponible
function hab_disponible_sucia(hab_id,estado){
    console.log("from")
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_disponible_sucia.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}
//! ***************************************************************************
// Mandar al estado interno sucia una habitacion ocupada
function hab_ocupada_sucia(hab_id,estado){
    console.log("from")
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_ocupada_sucia.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

// Modal de terminar el estado interno de una habitacion ocupada
function hab_ocupada_terminar_interno(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_ocupada_terminar.php?hab_id="+hab_id+"&estado="+estado);
}

// Terminar el estado interno de una habitacion ocupada
function hab_ocupada_terminar(hab_id,estado){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario_id": usuario_id,
		};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_ocupada_terminar.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

//Edo. 2-Sucia//

// Modal de terminar el estado de una habitacion
function hab_terminar_estado(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_terminar_estado.php?hab_id="+hab_id+"&estado="+estado);
}

// Terminar el estado de una habitacion
function hab_terminar(hab_id,estado){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
		"hab_id": hab_id,
		"estado": estado,
        "usuario_id": usuario_id,
		};
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"includes/hab_terminar.php",
		data:datos,
		beforeSend:loaderbar,
		success:principal,
		//success:problemas_sistema,
        timeout:5000,
        error:problemas_sistema
	});
	return false;
}

//Edo. 3-Limpieza//
// Modal de cambiar persona que realiza estado de una habitacion
function hab_cambiar_persona_estado(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_cambiar_persona.php?hab_id="+hab_id+"&estado="+estado);
}

// Cambiar persona que realiza estado de una habitacion
function hab_cambiar_persona(hab_id,estado,usuario){
	var usuario_id=localStorage.getItem("id");
	$('#caja_herramientas').modal('hide');
	var datos = {
            "hab_id": hab_id,
            "estado": estado,
            "usuario": usuario,
            "usuario_id": usuario_id,
	};
	$.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/hab_cambiar_persona.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
		});
	return false;
}

//funcion para el acorderon
function mostrarAcorderon(){
    const acordeon = document.querySelector("#acordeon");
    const acordeonIcon = document.querySelector("#acordeonIcon");
    acordeon.classList.toggle("activeAcordeon");
    acordeonIcon.classList.toggle("active");
}

function mostrarAcordeonCompleto(cantidad=1){
    const input = document.querySelector("#extra_adulto").value
    const acorderon = document.querySelector("#acordeonchido")
    const cuerpoacordeon = document.querySelector("#acordeon");
    if(input > 1){
        acorderon.classList.add("accordionCustomMostrar")
        contenidoacordeon= ``
        cuerpoacordeon.innerHTML = ``;
        for ( let i = 1 ; i < input ; i++ ) {
            contenidoacordeon+= `
                <div class="accordionItemBodyContentCustom">
                    <label style="width: 100%; text-align: left;">Acompañante ${i}</label>
                    <div class="form-floating mb-1">
                        <input  type="text" class="form-control nombreExtra custom_input" id="acompañante ${i} nombre" minlength="5" maxlength="25" placeholder="Nombre" >
                        <label for="acompañante ${i} nombre">Nombre</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input  type="text" class="form-control apellidoExtra custom_input" id="acompañante ${i} apellido" minlength="5" maxlength="25" placeholder="Apellido">
                        <label for="acompañante ${i} apellido" class="form-label" >Apellido</label>
                    </div>
                </div>
            `
        }
        cuerpoacordeon.innerHTML += contenidoacordeon
    }else{
        acorderon.classList.remove("accordionCustomMostrar");
        cuerpoacordeon.innerHTML = ``;
    }
}

function guardarColoresHab() {
    let usuario_id = localStorage.getItem("id");
    const clasesEstados = [];
    let disponibleLimpia = document.getElementsByName("colorDisponibleLimpia");
    for (let i = 0; i < disponibleLimpia.length; i++){
        if (disponibleLimpia[i].checked){
            clasesEstados.push(disponibleLimpia[i].value)
        };
    };
    let limpiezaVacia = document.getElementsByName("LimpiezaVacia");
    for (let i = 0; i < limpiezaVacia.length; i++){
        if (limpiezaVacia[i].checked){
            clasesEstados.push(limpiezaVacia[i].value)
        };
    };
    let limpiezaOcupada = document.getElementsByName("LimpiezaOcupada");
    for (let i = 0; i < limpiezaOcupada.length; i++){
        if (limpiezaOcupada[i].checked){
            clasesEstados.push(limpiezaOcupada[i].value)
        };
    };
    let Ocupada = document.getElementsByName("Ocupada");
    for (let i = 0; i < Ocupada.length; i++){
        if (Ocupada[i].checked){
            clasesEstados.push(Ocupada[i].value)
        };
    };
    let OcupadaSucia = document.getElementsByName("OcupadaSucia");
    for (let i = 0; i < OcupadaSucia.length; i++){
        if (OcupadaSucia[i].checked){
            clasesEstados.push(OcupadaSucia[i].value)
        };
    };
    let usoCasa = document.getElementsByName("usoCasa");
    for (let i = 0; i < usoCasa.length; i++){
        if (usoCasa[i].checked){
            clasesEstados.push(usoCasa[i].value)
        };
    };
    let Bloqueado = document.getElementsByName("Bloqueado");
    for (let i = 0; i < Bloqueado.length; i++){
        if (Bloqueado[i].checked){
            clasesEstados.push(Bloqueado[i].value)
        };
    };
    let Mantenimiento = document.getElementsByName("Mantenimiento");
    for (let i = 0; i < Mantenimiento.length; i++){
        if (Mantenimiento[i].checked){
            clasesEstados.push(Mantenimiento[i].value)
        };
    };
    let ReservaPag = document.getElementsByName("ReservaPag");
    for (let i = 0; i < ReservaPag.length; i++){
        if (ReservaPag[i].checked){
            clasesEstados.push(ReservaPag[i].value)
        };
    };
    let ReservaPend = document.getElementsByName("ReservaPend");
    for (let i = 0; i < ReservaPend.length; i++){
        if (ReservaPend[i].checked){
            clasesEstados.push(ReservaPend[i].value)
        };
    };
    console.log(clasesEstados);
    let xhttp;
    xhttp = new XMLHttpRequest();
    let include = "includes/guardar_estados.php"
    xhttp.open("GET",include,true);
    xhttp.addEventListener('load',e =>{
        response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
        console.log(response);
    })
}

function handle_rest( id_check , operador ) {
    const total = document.getElementById("total_factura_global_number")
    const checkBox = document.getElementById(id_check)

    if( checkBox ){
        let totalValor = parseFloat(total.innerHTML.replace(/[$,]/g, ''));
        if(checkBox.checked){
            let resultado = totalValor + operador;
            let resultadoFormateado = "$" + resultado.toFixed(2);
            total.innerHTML = resultadoFormateado
        } else {
            let resultado = totalValor - operador;
            let resultadoFormateado = "$" + resultado.toFixed(2);
            total.innerHTML = resultadoFormateado
        }
    }
}

function asignar_habitaciones( id_reserva = 1 ){
    $('#area_trabajo').hide();
    $('#pie').hide();
    $('#area_trabajo_menu').show();
    $('#area_trabajo_menu').load("includes/asignar_reservaciones.php?id_reserva=" + id_reserva,function(res){
        if(res=="nada"){
            document.location.href= "inicio.php"
        }
    });
    $('#caja_herramientas').modal('hide');
}

function show_chat() {
    const chat = document.getElementById("chat");
    const chat_content = document.getElementById("chat_content");
    chat.style.display = (chat.style.display === "none") ? "block" : "none";
    const id = localStorage.getItem("id");
    const fabImgNotification = document.querySelector(".fab_img_notification");

    if (chat.style.display == "block") {
        cargarContenido();
        intervalId = setInterval(cargarContenido, 7000);
        fabImgNotification.style.display = "none";
    }else {
        /* chat_notification_global() */
        notifatonId = setInterval(chat_notification_global, 15000)
    }
}

function cargarContenido() {
    const chat = document.getElementById("chat");

    if( chat.style.display != "block"){
        return
    }

    const id = localStorage.getItem("id");

    const datos = {
        "id": id
    }

    $.ajax({
        async: true,
        url: "includes/chat.php",
        dataType: "html",
        type: "POST",
        data: datos,
        contentType: "application/x-www-form-urlencoded",
        success: function(response) {
            $("#chat_content").html(response);

        },
        error: function(error) {
            console.log("Error al cargar el contenido: ", error);
        }
    });
}
function send_message( mensage_type ) {
    const chat = document.getElementById("chat_content");
    const messageInput = document.getElementById("chat_message");
    const message = messageInput.value;
    const id = localStorage.getItem("id");

    if( !message ){
        return
    }else {
        const datos = {
            "mensaje" : message,
            "id_usuario": id,
            "message_type": mensage_type
        };
        const messageFormat = `
            <div class="chat_message_other chat_message_own chat_message_own_triangle">
                <img src="./assets/user_own.svg" style="border: 2px solid white" />
                <div class="chat_message_content_own">
                    <div class="chat_message_info chat_message_info_own">
                        <p class="chat_message_name">Tú</p>
                        <p class="chat_message_name">Justo ahora</p>
                    </div>
                    <p class="message">${message}</p>
                </div>
            </div>
        `;
        $.ajax({
            async: true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: "includes/chat_guardar_mensaje.php",
            data: datos,
            success: function (res) {
                //console.log(res)
                //chat.innerHTML += messageFormat;
                chat.insertAdjacentHTML('afterbegin', messageFormat);
                messageInput.value = "";
            }
        });
    };
};


function chat_notification_global() {
    const chat = document.getElementById("chat");
    /* console.log("wachando mensajes") */
    if( chat.style.display === "block"){
        return
    }
    const id = localStorage.getItem("id");
    const datos = {
        "id" : id
    }
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        url: "includes/chat_notificacion_global.php",
        data: datos,
        success: function (res){
            /* console.log("ID del mensaje:", res.mensaje_id);
            console.log("Mensaje:", res.mensaje);
            console.log("Hora de envío:", res.hora_envio); */
            /* console.log(res) */
            notificar(res.mensaje_id, res.usuario_id, res.mensaje, res.nombre)
        },
        error: function (error){
            console.log(error.responseText)
        }
    })
};




function notificar(nuevo_mensaje, usuario_id, nuevo_mensaje_1, nuevo_nombre) {
    const ultimo_mensaje = localStorage.getItem("ultimo_mensaje_global");
    const fabImgNotification = document.querySelector(".fab_img_notification");
    const local_user_id = localStorage.getItem("id");

    const notificacion = document.getElementById("notification")
    const nombre = document.getElementById("nombre_notificacion");
    const mensaje = document.getElementById("mensaje_notificacion");

    if(nuevo_mensaje == ultimo_mensaje  ){
        /* console.log("El mensaje es el mismo") */
    }else if ( usuario_id == local_user_id ) {
        /* console.log("El ultimo mensaje es el mio padrino") */
    }else if( nuevo_mensaje < ultimo_mensaje ){
        /* console.log("no se que show we alv") */
    } else {
        localStorage.setItem("ultimo_mensaje_global" , nuevo_mensaje)
        fabImgNotification.style.display = "block";
        let audioNotification = new Audio("./assets/sounds/new_message.mp3");

        if(audioNotification){
            audioNotification.currentTime = 0;
            audioNotification.play()
                .catch(error => {
                    console.error("Error al reporducr el sonido: ", error)
                });
        }
        notificacion.style.display = "block";
        notificacion.classList.add("show")
        nombre.innerText = nuevo_nombre
        mensaje.innerText = nuevo_mensaje_1
        setTimeout(() => {
            notificacion.style.display = "none";
        }, 4000);

    }
}


//chat_notification_global();

function handleSendMessage(event) {
    if( event.key === "Enter" ) {
        send_message();
    };
};


notifatonId = setInterval(chat_notification_global, 15000)

//Evaluamos el inicio de sesion
function inicio(){
	var x=$("#login");
	x.click(evaluar);
}

x=$(document);
x.ready(inicio);