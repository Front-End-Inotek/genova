var teclado = ['user', 'pass','efectivo','monto','folio','descuento','comentario'];
var hab = [];
var hab_ultimo_mov = [];
var vista=0;
x=$(document);
x.ready(inicio);



//Evaluamos el inicio de sesion
function inicio(){
	var x=$("#login");
	x.click(evaluar);
}

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
            obtener_datos_hab_inicial ();
			$(".menu").load("includes/menu.php?id="+id+"&token="+token);

            if(vista==0){
                console.log("rack de habitaciones "+vista);
                var usuario_id=localStorage.getItem("id");
                $("#area_trabajo").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
                //closeNav();
            }else{
                console.log("rack de operaciones "+vista);
                var id=localStorage.getItem("id");
                var token=localStorage.getItem("tocken");
                $("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);
            }

			//$("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token);
            $("#pie").load("includes/pie.php?id="+id);
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
          //console.log(this.responseText);
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
                        $("#hab_"+hab_info[i]['id']).load("includes/mostrar_cambios_hab.php?hab_id="+hab_info[i]['id']);
                        /*const collection = document.getElementById("hab_"+hab_info[i]['id']);
                        collection.innerHTML = '<button id="submit">Submit</button>';*/

                        //console.log(hab_info[i]['id']+"-"+hab[hab_info[i]['id']]+"-"+hab_ultimo_mov[hab_info[i]['id']]);
                    }
                    else{
                        console.log("sin cambio en la habitacion con id "+hab_info[i]['id']);
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
    //console.log(vista);
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
        title: "Estas deacuerdo en cerrar la sesion?",
        text: "Podras iniciar sesion siempre que quieras y tus credenciales sean correctas!",
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
            swal("Tu sesion sigue activo!", "!", "success");
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
	alert("Ocurrio algun error en el proceso.  Inf: "+datos.toString());
}

// Muestra los subestados de las habitaciones
function mostrar_herramientas(hab_id,estado,nombre){ 
	var id=localStorage.getItem("id");
	$("#mostrar_herramientas").load("includes/mostrar_herramientas.php?hab_id="+hab_id+"&id="+id+"&estado="+estado+"&nombre="+nombre+"&id="+id);
   
}

//cerrar el modal cuando se navega a otra 'vista'
function closeModal(){
    $('#caja_herramientas').modal('hide');
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


// Agregar una politica de reservacion
function agregar_politicas_reservacion(){
	$("#mostrar_herramientas").load("includes/agregar_politicas_reservacion.php");
    //$("#mostrar_herramientas").load("includes/borrar_modal_tipo.php?id="+id);
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

    console.log(nombre,monto)
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
    xhttp.open("GET","includes/guardar_politica_reservacion.php?nombre="+nombre+"&codigo="+codigo+"&descripcion="+descripcion+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
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
    xhttp.send();
}

function guardar_planes_alimentos() {
	var nombre= encodeURI(document.getElementById("nombre").value);
	var costo= encodeURI(document.getElementById("codigo").value);

    console.log(nombre,costo)

    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }

    if(costo === null || costo === ''){
        swal("Campo costo vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }

    guardar_planAlimentos()
}
function guardar_planAlimentos(){
    let usuario_id=localStorage.getItem("id");
	let nombre= encodeURI(document.getElementById("nombre").value);
	let costo= encodeURI(document.getElementById("codigo").value);


    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_plan_alimentos.php?nombre="+nombre+"&costo="+costo+"&usuario_id="+usuario_id,true);
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
    xhttp.send();
}

function guardar_tipo() {
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
    xhttp.send();
}


// Guardar un tipo de habitacion
function guardar_habitacion(){
    //debugger
   // $('#caja_herramientas').modal('hide');
    let usuario_id=localStorage.getItem("id");
	let nombre= encodeURI(document.getElementById("nombre").value);
	let codigo= encodeURI(document.getElementById("codigo").value);

    let datos = {
        "nombre": nombre,
        "codigo": codigo,
        "usuario_id": usuario_id,
    };

    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_tipo.php?nombre="+nombre+"&codigo="+codigo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
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

// Editar una politica de reservacion
function editar_politica_reservacion(id){
    include = "includes/editar_politica_reservacion.php?id="+id
    $("#mostrar_herramientas").load(include);
}

// Editar un plan de alimentos
function editar_plan_alimentos(id,nombre,costo){
    nombre = encodeURIComponent(nombre)
    include = "includes/editar_plan_alimentos.php?id="+id+"&nombre="+nombre+"&costo="+costo
  
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

    include = "includes/aplicar_editar_politica_reservacion.php?nombre="+nombre+"&codigo="+codigo+"&id="+id+"&usuario_id="+usuario_id+"&descripcion="+descripcion;
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


function modificar_plan_alimentos(id){
    // Editar un tipo de plan de alimentación
	let usuario_id = localStorage.getItem("id");
    let id_plan = id;
    let nombre = encodeURI(document.getElementById("nombre").value);
	let costo = encodeURI(document.getElementById("codigo").value);

    include = "includes/aplicar_editar_plan_alimentacion.php?nombre="+nombre+"&costo="+costo+"&id_tipo="+id_plan+"&usuario_id="+usuario_id;
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
                swal("Actualizo el plan de alimentación!", "Excelente trabajo!", "success");
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

// Editar un tipo de habitacion
function modificar_tipo(id){
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
    xhttp.open("GET","includes/aplicar_editar_tipo.php?nombre="+nombre+"&codigo="+codigo+"&id_tipo="+id_tipo+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            console.log(e.target.response);
            if (e.target.response == 'NO') {
                $('#caja_herramientas').modal('hide');
                ver_tipos()
                swal("Actualizo tipo de habitacion!", "Excelente trabajo!", "success");
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
        title: "Antes de continuar por favor verifique datos de la habitacion a eliminar",
        text: "Antes de continuar por favor verifique datos de la habitacion a eliminar ",
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
	let precio_junior= document.getElementById("precio_junior").value;
	let precio_infantil= document.getElementById("precio_infantil").value;
    let tipo= document.getElementById("tipo").value;
    let leyenda= encodeURI(document.getElementById("leyenda").value);

    if(nombre === null || nombre === ''){
        swal("Campo nombre vacio!", "Verifique los datos correctamente por favor!", "warning");
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

    if(precio_junior === null || precio_junior === ''){
        swal("Campo precio_junior vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }
    if(precio_infantil === null || precio_infantil === ''){
        swal("Campo precio_infantil vacio!", "Verifique los datos correctamente por favor!", "warning");
        return false;
    }

    if(tipo === null || tipo === ''){
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
	let precio_junior= document.getElementById("precio_junior").value;
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
        "precio_junior": precio_junior,
        "precio_infantil": precio_infantil,
        "tipo": tipo,
        "leyenda": leyenda,
    };

    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_tarifa.php?nombre="+nombre+"&precio_hospedaje="+precio_hospedaje+"&cantidad_hospedaje="+cantidad_hospedaje+"&cantidad_maxima="+cantidad_maxima+"&precio_adulto="+precio_adulto+"&precio_junior="+precio_junior+"&precio_infantil="+precio_infantil+"&tipo="+tipo+"&leyenda="+leyenda+"&usuario_id="+usuario_id,true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            response = xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
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
    xhttp.send();
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
	var precio_junior= document.getElementById("precio_junior").value;
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
        "precio_junior": precio_junior,
        "precio_infantil": precio_infantil,
        "tipo": tipo,
        "leyenda": leyenda
    };

    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/aplicar_editar_tarifa.php?id="+id+"&nombre="+nombre+"&precio_hospedaje="+precio_hospedaje+"&cantidad_hospedaje="+cantidad_hospedaje+"&cantidad_maxima="+cantidad_maxima+"&precio_adulto="+precio_adulto+"&precio_junior="+precio_junior+"&precio_infantil="+precio_infantil+"&tipo="+tipo+"&leyenda="+leyenda+"&usuario_id="+usuario_id,true);
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
                swal("Nuevo tipo de habitacion agregado!", "Excelente trabajo!", "success");
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
        <td>Precio</td>
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
        title: "Antes de continuar por favor verifique datos de la tarifa a eliminar",
        text: "Antes de continuar por favor verifique datos de la tarifa a eliminar ",
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
function agregar_reservaciones(hab_id=0){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_reservacionNew.php?hab_id="+hab_id); 
    closeModal();
	closeNav();
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
        document.getElementById('numero_hab').disabled=false;
    }

 }

// Calculamos la cantidad de noches de una reservacion
function calcular_noches(hab_id=0){

 
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
    document.getElementById("noches").value = noches

    if(fecha_entrada_value!="" && fecha_salida_value!=""){
      
      
    if( fecha_entrada_value >= fecha_salida_value ){
      
       fecha_salida.value=""
      
        
    }else{
        fechas = (getDatesInRange(auxSelectedDate,dateSalida))
        ultima_fecha = fechas[fechas.length-1]
     
    

        // $(".div_adultos").load("includes/consultar_reservacion_disponible.php?fechas="+JSON.stringify(fechas)+"&hab_id="+hab_id);
        include = "includes/consultar_reservacion_disponible.php?fecha_entrada="+fecha_entrada.value+"&fecha_salida="+fecha_salida.value+"&hab_id="+hab_id;
        console.log(include);
        if(hab_id!=0){
            $(".div_adultos").load(include);    
        }
        
        $("#preasignada").load(include);    
     
    }
  

  
    }
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
function cambiar_adultosNew(event=null,hab_id){
    //si hay un select entonces se lee el evento del select para extraer el hab_id, desde reservaciones.
    //se verifica que el evento no sea nulo para obtener el id del tipo de la habitación desde el tipo de tarifa selccionada.
    
    if(event!=0){
        var tipo_hab = event.target.options[event.target.selectedIndex].dataset.tipo;
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
   
    if(!isNaN(noches) && forzar_tarifa==""){
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
               $("#aux_total").val(res.precio_hab)
               $("#tarifa_menores").val(res.precio_infantil)
               $("#tarifa_adultos").val(res.precio_adulto)
               //al seleccionar una nueva tarifa los extras se "reinician"
               $("#extra_adulto").val("")
               $("#extra_infantil").val("")
               $("#pax-extra").val("")
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
            numero_hab = numero_hab == 0 ? 1 : numero_hab
            tarifa = noches * forzar_tarifa * numero_hab
            $("#total").val(tarifa)
            $("#aux_total").val(tarifa)
            $("#tipo-habitacion").removeAttr("disabled");
            $("#tarifa_menores").val("")
            $("#tarifa_adultos").val("")
            $("#tarifa").removeAttr('required');
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

function nuevo_calculo_total(event=null){
    var numero_hab= Number(document.getElementById("numero_hab").value);
    var noches= Number(document.getElementById("noches").value);
    var tarifa= Number(document.getElementById("tarifa").value);
    
    //extra los campos de las tarifas consultadas de la db.

    var extra_adulto= Number(document.getElementById("extra_adulto").value);

	var extra_infantil= Number(document.getElementById("extra_infantil").value);

    var tarifa_infantil = Number(document.getElementById("tarifa_menores").value);
    
    var tarifa_adulto = Number(document.getElementById("tarifa_adultos").value);

	var pax_extra= Number(document.getElementById("pax-extra").value);

    var costo_plan=Number(document.getElementById('costoplan').value); 
    //si  se elige un plan de alimentación desde el select.
    if(event!=null){
        var costoplan = event.target.options[event.target.selectedIndex].dataset.costoplan;
        if(costoplan!=undefined){
           
            costo_plan=Number(costoplan)
            $('#costoplan').val(costo_plan)
        
        }
    }
    //se guarda el total generado por las fechas seleccionadas (no se altera), para despues sumarlo al total (alterable)
    var aux_total=Number(document.getElementById('aux_total').value)
	
	var total_infantil= tarifa_infantil * extra_infantil;
    var total_adulto = tarifa_adulto * extra_adulto;
    var adicionales =  total_infantil  + total_adulto + pax_extra + costo_plan;  
    var total = aux_total + adicionales;

    console.log(total_adulto)
    fadulto = 0;
    finfantil =0;

    //si el total del adulto o del infante son 0, no se seleccionó una tarifa de la db, se realiza otro calculo.
    if(total_adulto==0){
        console.log(total,extra_adulto)
        fadulto = $("#forzar-tarifa").val() * extra_adulto
    }
    if(total_infantil==0){
        finfantil = $("#forzar-tarifa").val() * extra_infantil
    }
    aux_total = total + fadulto + finfantil
    if(aux_total==0){
        total= total
    }else{
        total = aux_total
    }

    document.getElementById("total").value= total;
   

   
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
        console.log(garantia)
        if(garantia!=undefined && garantia == 1){
            $("#div_voucher").show();
        }else{
            $("#div_voucher").hide();
        }
    }
    if(garantia_id==1 || garantia_id==0){
        $("#btngarantia").attr("disabled",true)
    }else{
        $("#btngarantia").removeAttr("disabled");
    }

    console.log(garantia_id)
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
    $("#mostrar_herramientas").load('includes/modal_mostrar_garantia.php?huesped='+id_huesped+"&estadotarjeta="+estado_tarjeta,function(){
        if(estado_tarjeta!=""){
            $(":checkbox[value="+estado_tarjeta+"]").prop("checked","true");
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

function aceptar_asignar_huespedNew(id,nombre,apellido,empresa,telefono,pais,estado,ciudad,direccion,estado_tarjeta,tipo_tarjeta,titular_tarjeta,numero_tarjeta,vencimiento_mes,vencimiento_ano,ccv,correo,voucher){
    console.log(id,nombre,apellido,empresa,telefono,pais,estado,ciudad,direccion,estado_tarjeta,tipo_tarjeta,titular_tarjeta,numero_tarjeta,vencimiento_mes,vencimiento_ano,ccv)
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
    $("#mes").val(vencimiento_mes)
    $("#year").val(vencimiento_ano)
    $("#ccv").val(ccv)

    $("#correo").val(correo)

    if(tipo_tarjeta=="Efectivo" || tipo_tarjeta==1){
        $("#forma-garantia option[value=1]").prop("selected", true);
        $("#btngarantia").attr("disabled",true)
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
        $("#div_voucher").show();
        $('#voucher').val(voucher)
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
        canal_reserva = (document.getElementById("canal-reserva").value);
        tipo_reservacion = (document.getElementById("tipo-reservacion").value);
        titulo="RESERVACION"
       
        var persona_reserva= (document.getElementById("persona-reserva").value);
        

    }else{
        estado=2;
        persona_reserva="checkin"
        titulo="CHECK-IN"
    }

    var forzar_tarifa = $("#forzar-tarifa").val()


    var extra_adulto= Number(document.getElementById("extra_adulto").value);
    var extra_infantil= Number(document.getElementById("extra_infantil").value);

    var pax_extra= Number(document.getElementById("extra_infantil").value);
    
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

    var precio_hospedaje = document.getElementById('aux_total').value
    var total_hospedaje = document.getElementById('total').value

    sobrevender = sobrevender ? 1 : 0 ;

    console.log(sobrevender)

    //verifica si hay una tarifa (forzada o no)
    var tarifa_existe = 0;
    if($("#forzar-tarifa").val()==""){
        tarifa_existe = tarifa;
    }else{
        tarifa_existe=forzar_tarifa;
        $("#tarifa").removeAttr('required');
    }

    ruta="includes/guardar_reservacionNew.php";

    if(id_cuenta!=0){
        ruta="includes/aplicar_editar_reservacionNew.php";
    }
    var voucher =document.getElementById('voucher').value
    var estado_tarjeta=document.getElementById('estadotarjeta').value


    // if(forzar_tarifa!=""){
    //     numero_hab = numero_hab == 0 ? 1 : numero_hab
    //     tarifa = noches * forzar_tarifa * numero_hab
    //     $("#total").val(tarifa)
    //     $("#aux_total").val(tarifa)
    //     $("#tipo-habitacion").removeAttr("disabled");
    //     $("#tarifa_menores").val("")
    //     $("#tarifa_adultos").val("")
    //     $("#tarifa").removeAttr('required');
    // }

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
        "total_hab": total,
        "forzar_tarifa":forzar_tarifa,
        "descuento": 0,
        "codigo_descuento": 0,
        "total": total_hospedaje,
        "total_pago": 0,
        "hab_id": Number(hab_id),
        "tipo_hab": tarifa,
        "estado": estado,
        "usuario_id": usuario_id,
        "plan_alimentos" : plan_alimentos,
        "canal_reserva" : canal_reserva,
        "tipo_reservacion":tipo_reservacion,
        "sobrevender":sobrevender,
        "preasignada" : Number(preasignada),
        "voucher":voucher,
        "estado_tarjeta":estado_tarjeta,
      };
        console.log(datos)
        //console.log(response_msj,fecha_entrada.length,fecha_salida.length,tarifa,persona_reserva.length,forma_pago,total_hab)
        // return ;
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
                // console.log(res)
                // return
                //recibo el id de la reservacion creada.
                //Aquí en teoría ya se guardo/hizo la reservación y es momento de mandar el correo con el pdf de confirmación
                ver_reporte_reservacion(res,"ver_reservaciones()",titulo)
            },
        
            timeout:5000,
            error:problemas_sistema
          });
      return false;
    
    }else{
        alert("Campos incompletos o descuento no permitido");
    }
}

function asignarValorTarjeta(){
    $("#nut").val($("#cardnumber").val())
    $("#nt").val($("#cardholder").val())
    $("#nombre_tarjeta").val($("#tipo").val())
    $("#mes").val($("#expires-month").val())
    $("#year").val($("#expires-year").val())
    $("#ccv").val($("#tccv").val())
    $("#estadotarjeta").val($("input[name=estado]:checked").val())
}

function guardarNuevaReservacion(hab_id,id_cuenta=0,id_reservacion=0){


    var usuario_id=localStorage.getItem("id");
    var nombre_huesped= document.getElementById("nombre").value;
    var apellido_huesped= document.getElementById("apellido").value;
    var empresa_huesped= document.getElementById("empresa").value;
    var telefono_huesped= document.getElementById("telefono").value;
    var pais_huesped= document.getElementById("pais").value;
    var estado_huesped= document.getElementById("estado").value;
    var ciudad_huesped= document.getElementById("ciudad").value;
    var direccion_huesped= document.getElementById("direccion").value;

    var comentarios_huesped= document.getElementById("observaciones").value;

    var tipo_tarjeta= document.getElementById("forma-garantia").value;

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

    // console.log(nombre_tarjeta)
    // return



    //guardar asyncronicamente el "husped" para obtener su id; si ya existe retorna su id..
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_huesped.php?nombre="+nombre_huesped+"&apellido="+apellido_huesped+"&direccion="+direccion_huesped+"&pais="+pais_huesped+"&empresa="+empresa_huesped+
    "&ciudad="+ciudad_huesped+"&estado="+estado_huesped+"&telefono="+telefono_huesped+"&comentarios="+comentarios_huesped+"&tipo_tarjeta="+tipo_tarjeta+"&usuario_id="+usuario_id+
    "&titular_tarjeta="+titular_tarjeta+"&numero_tarjeta="+numero_tarjeta+
    "&vencimiento_mes="+vencimiento_mes+"&vencimiento_ano="+vencimiento_ano+"&cvv="+cvv+"&nombre_tarjeta="+nombre_tarjeta
    +"&estado_tarjeta="+estado_tarjeta+"&correo="+correo+"&voucher="+voucher
    ,true);

    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            // console.log(e.target.responseText);
            // console.log(xhttp.responseText)
            const  response_msj =xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
           
           
            if(response_msj == "NO_DATA"){
                swal("Debe llenar los campos requeridos para el húesped", "Verifique que los campos no estén vacíos", "error");
                return
            }else if(response_msj=="NO_VALIDO"){
                swal("Los datos no se agregaron!", "Error de trasnferencia de datos!", "error");
                return
            }else{
                guardarReservacion(response_msj,hab_id,id_cuenta,id_reservacion)
                //todo ocurre correctamente.
                
            }
        
        }else{
            swal("Error del servidor!", "Intentelo de nuevo o contacte con soporte tecnico", "error");
        }
    })
    xhttp.send();

    
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
    inicial = 0;
    a_buscar=0;
     //se ocupa 'mantener' los filtros que están seleccionados para mandarselos a la paginación y que no se 'pierda' dicho filtro (?)
    // if(caso!=0){
    //     inicial = $('#inicial').value
    //     a_buscar = $('#a_buscar').value
    // }
    $("#paginacion_reservaciones").load("includes/ver_reservaciones_paginacion.php?posicion="+posicion+"&usuario_id="+usuario_id+"&caso="+caso);   
}

// Barra de diferentes busquedas en ver llegadas
function buscar_llegadas_salidas(e,opcion){
   
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    var inicial = $("#inicial").val()
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
        if( e.which === 8 ){ $("#area_trabajo_menu").load("includes/"+funcion_php+"?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+0); return false; }
    }
 
	$("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+opcion);  
}

// Barra de diferentes busquedas en ver reservaciones
function buscar_reservacion(e){
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var usuario_id=localStorage.getItem("id");
    if(a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
        if( e.which === 8 ){ $("#area_trabajo_menu").load("includes/ver_reservaciones.php?usuario_id="+usuario_id); return false; }
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

// Busqueda combinada en ver reservaciones
function busqueda_reservacion_combinada(){
	var inicial=$("#inicial").val();
	var final=$("#final").val();
    console.log(final)
    var a_buscar=encodeURIComponent($("#a_buscar").val());
    var id=localStorage.getItem("id");
    if((inicial.length >0 && final.length >0) || a_buscar.length >0){
        $('.pagination').hide();
    }else{
        $('.pagination').show();
    }
	$("#tabla_reservacion").load("includes/busqueda_reservacion_combinada.php?inicial="+inicial+"&final="+final+"&id="+id+"&a_buscar="+a_buscar);
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

// Generar reporte en ver reservaciones por dia
function reporte_reservacion_por_dia(dia){
    var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_reservacion_por_dia.php?dia="+dia+"&usuario_id="+usuario_id);
}
// Editar una reservacion
function editar_reservacionNew(id){
    $("#area_trabajo_menu").load("includes/editar_reservacionNew.php?id="+id);
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
function ver_reporte_reservacion(id,ruta="regresar_reservacion()",titulo="RESERVACION"){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/ver_reporte_reservacion.php?id="+id+"&usuario_id="+usuario_id+"&ruta="+ruta+"&titulo="+titulo);
	closeNav();
}

// Generar reporte de reservacion
function reporte_reservacion(id){
    var usuario_id=localStorage.getItem("id");
    window.open("includes/reporte_reservacion.php?id="+id+"&usuario_id="+usuario_id);
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
                //success:problemas_sistema,
                timeout:5000,
                error:problemas_sistema
            });
        return false;
    }
}

//funcion para agregar la habitacion seleccionada a la reservacion.
function guardar_preasignar_reservacion(id,opcion="")
{
    var usuario_id=localStorage.getItem("id");
    preasignada = $("#preasignada").val();
    console.log(preasignada,id)
   


    if (id >0 && preasignada.length >0) {
        $('#caja_herramientas').modal('hide');
        $("#boton_cancelar_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "preasignada": preasignada,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/preasignar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:function(res){
                    if(opcion==""){
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
function preasignar_reservacion(id,opcion=""){
	$("#mostrar_herramientas").load("includes/preasignar_modal_reservacion.php?id="+id+"&opcion="+opcion);
}

// Modal de cancelar una reservacion
function aceptar_cancelar_reservacion(id){
	$("#mostrar_herramientas").load("includes/cancelar_modal_reservacion.php?id="+id);
}

// Cancelar una reservacion
function cancelar_reservacion(id){
    var usuario_id=localStorage.getItem("id");
    var nombre_cancela= encodeURI(document.getElementById("nombre_cancela").value);

    if (id >0 && nombre_cancela.length >0) {
        $('#caja_herramientas').modal('hide');
        $("#boton_cancelar_reservacion").html('<div class="spinner-border text-primary"></div>');
        var datos = {
                "id": id,
                "nombre_cancela": nombre_cancela,
                "usuario_id": usuario_id,
            };
        $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"includes/cancelar_reservacion.php",
                data:datos,
                beforeSend:loaderbar,
                success:ver_reservaciones,
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
function aceptar_borrar_reservacion(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_reservacion.php?id="+id);
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
    console.log(hab_id, id,movimiento )
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
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"includes/asignar_reservacion.php",
            data:datos,
            beforeSend:loaderbar,
            success:principal,
            //success:problemas_sistema,
            timeout:5000,
            error:problemas_sistema
          });
    }else{
        $("#mostrar_herramientas").load("includes/asignar_modal_reservacion.php?id="+id+"&numero_hab="+numero_hab);
    }

    //si no, tendrá que seleccionar una de las habitaciones disponibles.

	
}

// Modal de asignar una reservacion a una habitacion en estado disponible
function select_asignar_reservacion(id,numero_hab){
	$("#mostrar_herramientas").load("includes/asignar_modal_reservacion.php?id="+id+"&numero_hab="+numero_hab);
}

// Asignar una reservacion a una habitacion en estado disponible
function asignar_reservacion(hab_id,id_reservacion,habitaciones){
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
              url:"includes/asignar_reservacion.php",
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

    // console.log(datos)
    // return;

    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/guardar_huesped.php?nombre="+nombre+"&apellido="+apellido+"&direccion="+direccion+"&ciudad="+ciudad+
    "&estado="+estado+"&codigo_postal="+codigo_postal+"&telefono="+telefono+"&correo="+correo+"&contrato="+contrato+"&cupon="+cupon+
    "&preferencias="+preferencias+"&comentarios="+comentarios+"&titular_tarjeta="+titular_tarjeta+"&tipo_tarjeta="+tipo_tarjeta+"&numero_tarjeta="+numero_tarjeta+
    "&vencimiento_mes="+vencimiento_mes+"&vencimiento_ano="+vencimiento_ano+"&cvv="+cvv+"&usuario_id="+usuario_id,true);

    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            // console.log(e.target.responseText);
            // console.log(xhttp.responseText)
            const  response =xhttp.responseText.replace(/(\r\n|\n|\r)/gm, "");
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
            success:principal,
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
    var garantia = encodeURI(document.getElementById('garantia').value)
	

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
                  success:ver_usuarios,
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
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/estado_cuenta_maestra.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov+"&id="+id); 
	$('#caja_herramientas').modal('hide');
}

// Muestra el estado de cuenta de una habitacion
function estado_cuenta(hab_id,estado,mov=0){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/estado_cuenta.php?hab_id="+hab_id+"&estado="+estado); 
	$('#caja_herramientas').modal('hide');
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
    var descripcion= encodeURI(document.getElementById("descripcion").value);
    var forma_pago= document.getElementById("forma_pago").value;
    var cargo= document.getElementById("cargo").value;
    var abono= document.getElementById("abono").value;
    
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
         
        $.ajax({
              async:true,
              type: "POST",
              dataType: "html",
              contentType: "application/x-www-form-urlencoded",
              url:"includes/guardar_abono.php",
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

// Recibe los datos para efectuar agregar un monto
function recibe_datos_monto_maestra(datos){
    //alert(datos);
    var res = datos.split("/");
    $('#caja_herramientas').modal('hide');
    
    estado_cuenta_maestra(res[0] , res[1], res[2], res[3]);
}

// Recibe los datos para efectuar agregar un monto
function recibe_datos_monto(datos){
    //alert(datos);
    var res = datos.split("/");
    $('#caja_herramientas').modal('hide');
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

// Modal para unificar cuentas en una habitacion seleccionada 
function unificar_cuentas(hab_id,estado,mov){
    $("#mostrar_herramientas").load("includes/modal_unificar_cuentas.php?hab_id="+hab_id+"&estado="+estado+"&mov="+mov);
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
}

// Modal de borrar una categoria
function aceptar_borrar_categoria(id){
	$("#mostrar_herramientas").load("includes/borrar_modal_categoria.php?id="+id);
}

//* Inventario y Sutir*//

// Agregar en el inventario
function agregar_inventario(){
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/agregar_inventario.php"); 
	closeNav();
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
    console.log(vista);
    if(vista==0){
        console.log("rack de habitaciones "+vista);
        var usuario_id=localStorage.getItem("id");
        $("#area_trabajo").load("includes/rack_habitacional.php?usuario_id="+usuario_id);
        vista=1;
    }else{
        console.log("rack de operaciones "+vista);
        var id=localStorage.getItem("id");
        var token=localStorage.getItem("tocken");
        localStorage.removeItem('estatus_hab')
        estatus_hab=""

        $("#area_trabajo").load("includes/area_trabajo.php?id="+id+"&token="+token+"&estatus_hab="+estatus_hab);
        vista=0;
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
    window.open("includes/mail.php");
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

    var datos = {
        "total": total,
        "hab_id": hab_id,
        "estado": estado,
        "mov": mov,
        "usuario_id": usuario_id,
        "motivo":motivo,
        "id_maestra":id_maestra,
    };
    //console.log(datos)
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
        timeout:5000,
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

// Hacer un corte
function hacer_cortes(){
    var usuario_id=localStorage.getItem("id");
	$('#area_trabajo').hide();
    $('#pie').hide();
	$('#area_trabajo_menu').show();
	$("#area_trabajo_menu").load("includes/hacer_cortes.php?usuario_id="+usuario_id);
	closeNav();
}

// Modal de guardar corte
function aceptar_guardar_corte(){
	$("#mostrar_herramientas").load("includes/guardar_modal_corte.php");
}

// Guardar un corte
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



//funcion para ver los reportes de salida

function ver_reportes_salidas(btn=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    if(inicial==undefined){
        inicial="";
        //ver_reportes_salidas
    }
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/ver_salidas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+btn);
        closeModal();
        closeNav();
    }else{
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        var inicial = $("#inicial").val()
        $("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+2);  
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
    inicial = encodeURIComponent(inicial)
	var usuario_id=localStorage.getItem("id");
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        include = "includes/ver_reportes_reservaciones.php?usuario_id="+usuario_id+"&titulo="+titulo+"&opcion="+opcion+"&inicial="+inicial
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


//funcion para ver los reportes de llegada
function ver_reportes_llegadas(btn=0){
    var usuario_id=localStorage.getItem("id");
    inicial = $("#inicial").val()
    if(inicial==undefined){
        inicial="";
    }
    if(btn==0){
        $('#area_trabajo').hide();
        $('#pie').hide();
        $('#area_trabajo_menu').show();
        $("#area_trabajo_menu").load("includes/ver_llegadas.php?usuario_id="+usuario_id+"&inicial="+inicial+"&btn="+btn);
        closeModal();
        closeNav();
    }else{
        
        var a_buscar=encodeURIComponent($("#a_buscar").val());
        var usuario_id=localStorage.getItem("id");
        var inicial = $("#inicial").val()
        $("#tabla_reservacion").load("includes/buscar_entradas_salidas_recep.php?a_buscar="+a_buscar+"&usuario_id="+usuario_id+"&inicial="+inicial+"&opcion="+1);  
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

// Modal de mandar una habitacion a estado limpieza
function hab_estado_limpiar(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_estado_limpiar.php?hab_id="+hab_id+"&estado="+estado);
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
function hab_desocupar_hospedaje(hab_id,estado){
	$("#mostrar_herramientas").load("includes/hab_modal_desocupar_hospedaje.php?hab_id="+hab_id+"&estado="+estado);
}

// Mandar a desocupar una habitacion ocupada
function hab_desocupar(hab_id,estado){
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
          url:"includes/hab_desocupar.php",
          data:datos,
          beforeSend:loaderbar,
          success:principal,
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

// Mandar al estado interno sucia una habitacion ocupada
function hab_ocupada_sucia(hab_id,estado){
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


