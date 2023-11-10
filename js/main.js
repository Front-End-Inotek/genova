function buscar_rfc(){
    //alert("Buscando");
    var inputRFC= document.getElementById("rfc").value;
    console.log("Entra consulta /");
    if(inputRFC.length>10){
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Entra respuesta //");
            var posicion=0;
            var respuesta=this.responseText;
            console.log(this.responseText);
            var datos = respuesta.split('/');
            document.getElementById("nombre").value = datos[0];
            document.getElementById("correo").value = datos[1];
            document.getElementById("notas").value = datos[2];
            document.getElementById("cp").value = datos[3];
            //document.getElementById("regimen").selectedIndex = posicion;
            document.getElementById("regimen").value =datos[4];
            //document.getElementById("cuerpo_app").innerHTML = this.responseText;
        }
        };
        xhttp.open("GET", "includes/consulta_rfc.php?inputRFC="+inputRFC, true);
        xhttp.send();
    }
}

function ocultar_animacion() {
    document.getElementById("animacion_formulario").style.display='none';
    //document.getElementById("animacion_timbrar").style.display='none';
    document.getElementById("dinamic").style.display='block';
    document.getElementById("timbrar").style.display='block';
}

function mostrar_animacion() {
    document.getElementById("animacion_formulario").style.display='block';
    //document.getElementById("animacion_timbrar").style.display='block';
    document.getElementById("timbrar").style.display='none';
    document.getElementById("dinamic").style.display='none';
}

function factura_global (){
    var checkfactura = document.getElementById("checkfacturaglobal");
    if(checkfactura.checked == true){
    console.log("Entra consulta global /");
    swal("Cambiaste a factura global!", "Se deben de añadir 3 campos complementarios", "warning");
    document.getElementById('input_periocidad').style.display='block';
    document.getElementById('input_mes').style.display='block';
    document.getElementById('input_año').style.display='block';
    }else{
    document.getElementById('input_periocidad').style.display='none';
    document.getElementById('input_mes').style.display='none';
    document.getElementById('input_año').style.display='none';
    }
}

function timbrar_factura(){
    console.log("Entra validaciones /");
    var rfc = document.getElementById("rfc");
    var nombre = document.getElementById("nombre");
    var cp = document.getElementById("cp");
    var regimen = document.getElementById("regimen");
    var cfdi = document.getElementById("cfdi");
    var correo = document.getElementById("correo");
    var metodopago = document.getElementById("metodopago");
    var forma_pago = document.getElementById("forma_pago");

    var checkfactura = document.getElementById("checkfacturaglobal");
    var input_año = document.getElementById('año');

    if(checkfactura.checked == true){
    if(input_año.value === null || input_año.value === ''){
        swal("Campo AÑO vacio!", "Verifique los datos correctamente por favor!", "error");
        return false;
    }
    }

        if(rfc.value === null || rfc.value === ''){
            swal("Campo RFC vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(nombre.value === null || nombre.value === ''){
            swal("Campo NOMBRE vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(cp.value === null || cp.value === ''){
            swal("Campo CODIGO POSTAL vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(regimen.value === null || regimen.value === ''){
            swal("Campo REGIMEN FISCAL vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(cfdi.value === null || cfdi.value === ''){
            swal("Campo USO DE CFDI FISCAL vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(correo.value === null || correo.value === ''){
            swal("Campo CORREO ELECTRONICO vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(metodopago.value === null || metodopago.value === ''){
            swal("Campo METODO DE PAGO vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        if(forma_pago.value === null || forma_pago.value === ''){
            swal("Campo FORMA DE PAGO vacio!", "Verifique los datos correctamente por favor!", "error");
            return false;
        }

        mandartimbre ();
}

function mandartimbre (){
    mostrar_animacion();

    //Declaramos una variable que contendra nuestro formulario
    form = document.getElementById('formfactura');
    //Declaramos una constante que contendra XMLHttpRequest(); intercambia datos detras de escena
    const xhr = new XMLHttpRequest();

    let contador = document.getElementById("filas").value;
    parseInt(contador);

    var tabla = document.createElement("div");
    var total = document.createElement("div");

    for (let i = 1; i <= contador; i++) {
        var
        cantidad = parseFloat(document.getElementById("cantidad["+i+"]").value),
        descripcion = document.getElementById("producto["+i+"]").value,
        precio = parseFloat(document.getElementById("importeuni["+i+"]").value),
        importe = parseFloat(document.getElementById("importe["+i+"]").value);

        if (cantidad > 0 && importe > 0) {
            tabla.innerHTML += `
            <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
                <tr>
                <td>Cantidad</td>
                <td>Descripcion</td>
                <td>Precio</td>
                <td>Importe</td>
                </tr>
                <tr>
                <td>${cantidad}</td>
                <td>${descripcion}</td>
                <td>${precio}</td>
                <td>${importe}</td>
                </tr>
            </table> <br>`;
        }
    }
        var
        rimporte = parseFloat(document.getElementById("rimporte").value),
        riva = parseFloat(document.getElementById("riva").value),
        rish = parseFloat(document.getElementById("rish").value),
        rtotal = parseFloat(document.getElementById("rtotal").value);

        total.innerHTML = `
        <table cellpadding="2" cellspacing="0" width="100%" border="1"; >
        <tr>
        <td>Importe</td>
        <td>I.V.A.</td>
        <td>I.S.H.</td>
        <td>Total</td>
        </tr>
        <tr>
        <td>${rimporte}</td>
        <td>${riva}</td>
        <td>${rish}</td>
        <td>${rtotal}</td>
        </tr>
        </table> <br>`;
        tabla.appendChild(total);

    swal({
        title: "FACTURACIÓN CFDI - VERSIÓN 4.0",
        text: "Antes de continuar por favor verifique que los siguientes datos sean correctos",
        content: tabla,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
    //open recive informacion son 3 parametro}
    xhr.open('POST', 'includes/timbrar_factura.php', true);
    //FormData interpretara los datos del formulario
    var formData = new FormData(form);
    //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
    xhr.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            console.log("Respuesta del servidor para timbrar //");
            //Entrara la contidicion que valida la respuesta del formulario
            if (e.target.response == 'NO') {
                ocultar_animacion();
                console.log("Respuesta del timbrado ///");
                swal("Tu factura se genero correctamente!", "Pronto podras descargar su factura!", "success")
                .then((value) => {
                    console.log("Entra llamado para generar pdf /");
                    generarPdf();
                    console.log("Abre mostrar pdf y mostrar xml /");
                    window.open('includes/mostrar_pdf.php');
                    setTimeout(() => {
                        window.open('includes/mostrar_xml.php');
                        console.log("Entra llamado para enviar correo /");
                        enviarcorreo();
                    }, 2000)
            });
            }else{
                ocultar_animacion();
                console.log(e.target.response);
                var respuesta=e.target.response;
                var datos = respuesta;
                swal("Tu factura no se genero!", datos, "error");
            }
        }else{
            ocultar_animacion();
            console.log(e.target.response);
            var respuesta=e.target.response;
            var datos = respuesta;
            swal("Error del servidor!", datos, "error");
        }
    })
    //Enviamos nuestro la respuesta de nuestro formulario
    xhr.send(formData);
            } else {
                ocultar_animacion();
        swal("Tu factura cancelo correctamente!", "Por favor verifique los datos y que los recuadros no tengan espacios!", "success")
        }
    });
}

function generarPdf(){
    console.log("Segunda entrada generar pdf //");
    //document.getElementById("timbrar").style.display='none';
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/xml_a_pdf.php",true);
    xhttp.addEventListener('load', e =>{
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            console.log("Entrar respuesta del servidor generar pdf ///");
            //Entrara la contidicion que valida la respuesta del formulario
            if (e.target.response == 'Gpfd') {
                swal("Tu factura no se genero!", "Error al intentar generar el arvhivo PDF!", "error");
                document.getElementById("timbrar").style.display='block';
            }else{
                //console.log(e.target.response );
                //swal("Envio exitoso!", "Pronto llegara un correo con tu factura!", "success");
                document.getElementById("timbrar").style.display='block';
            }
        }else{
            swal("Tu factura no se genero!", "Error del servidor", "error");
        }
    })
    //Enviamos nuestro la respuesta de nuestro formulario
    xhttp.send();
}

let contador = 0;
function enviarcorreo(){
    console.log("Entra enviar correo //");
    var rfc = encodeURI(document.getElementById("rfc").value);
    var nombre = encodeURI(document.getElementById("nombre").value);
    var cp = encodeURI(document.getElementById("cp").value);
    var regimen = encodeURI(document.getElementById("regimen").value);
    var cfdi = encodeURI(document.getElementById("cfdi").value);
    var correo = encodeURI(document.getElementById("correo").value);
    var metodopago = encodeURI(document.getElementById("metodopago").value);
    var forma_pago = encodeURI(document.getElementById("forma_pago").value);
    var notas = encodeURI(document.getElementById("notas").value);

    var datos = {
        "rfc":rfc,
        "nombre":nombre,
        "cp":cp,
        "regimen":regimen,
        "cfdi":cfdi,
        "correo":correo,
        "metodopago":metodopago,
        "forma_pago":forma_pago,
        "notas":notas
    }

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("GET","includes/enviar_correo.php?nombre="+nombre+"&cfdi="+cfdi+"&cp="+cp+"&regimen="+regimen+"&correo="+correo+"&metodopago="+metodopago+"&forma_pago="+forma_pago+"&notas="+notas,true);
    xhttp.addEventListener('load', e =>{
        console.log(e)
        //Si el servidor responde 4  y esta todo ok 200
        if (e.target.readyState == 4 && e.target.status == 200) {
            //Entrara la contidicion que valida la respuesta del formulario
            if (e.target.response == 'Messagehasbeensent') {
                console.log(e.target.response);
                console.log("Correo enviado ///");
                swal("Tu factura se envio correctamente!", "Pronto recibirás un correo con los archivos correspondientes de tu factura!", "success");
            }else if(contador < 3){
                console.log(e.target.response);
                swal({
                    title: "Tu factura no envió!",
                    text: "Puede consultar las facturas en las seccion de \"Buscar Factura\" en la barra de menu o presione \"OK\" para intentar enviar el correo otra vez ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        contador ++;
                        enviarcorreo();
                    } else {
                    swal("Puede consultar las facturas en las seccion de \"Buscar Factura\" en la barra de menu");
                    }
                });
            }else{
                swal("Error del servidor!", "Puede consultar las facturas en las seccion de Buscar Factura en la barra de menu", "error");
            }
        }else{
            swal("Error del servidor!", "Puede consultar las facturas en las seccion de Buscar Factura en la barra de menu", "error");
        }
    })
    //Enviamos nuestro la respuesta de nuestro formulario
    xhttp.send();
}
    function agregar_filas() {
        var fila = encodeURI(document.getElementById("filas").value);
        //console.log(fila);
        var datos = { "fila":fila }

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.open("GET","includes/formulario_factura.php?fila="+fila,true);
        xhttp.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                //Entrara la contidicion que valida la respuesta del formulario
                //console.log(fila);
                document.getElementById('formfactura').innerHTML = xhttp.responseText;
                document.getElementById("producto[2]").value = 'RESTAURANTE';
                document.getElementById("clave[2]").value = '90101500';
                document.getElementById("checisah[2]").checked = false;
            }else{
                swal("Error del servidor!", "No se pueden agregar mas filas", "error");
            }
        })
        //Enviamos nuestro la respuesta de nuestro formulario
        xhttp.send();
    }

    function cal() {
        console.log("Entra operaciones matematicas //");
        //alert("prueba");
        //try {
            let contador = document.getElementById("filas").value;
            parseInt(contador);
            //console.log(contador);
        let importes_total = 0;
        parseInt(importes_total);
        let iva_total = 0;
        parseInt(iva_total);
        let ish_total = 0;
        parseInt(ish_total);

        for (let i = 1; i <= contador; i++) {
            var
            cantidad1 = parseFloat(document.getElementById("cantidad["+i+"]").value) || 0,
            importe1 = parseFloat(document.getElementById("importeuni["+i+"]").value) || 0,
            ishcheck1 = document.getElementById("checisah["+i+"]").checked ,
            iva1=0,
            ish1=0,
            importes1=0;
            //console.log(cantidad1);
            //console.log(importe1);
            if (cantidad1 > 0 && importe1  > 0) {
    
            if(ishcheck1){
                importes1 =  ((cantidad1*importe1)/1.19);
                importes1=importes1.toFixed(2);
                iva1= importes1*0.16;
                iva1= iva1.toFixed(2);
                ish1= importes1*0.03;
                ish1= ish1.toFixed(2);
            }else{
                importes1 =(cantidad1*importe1)/1.16;
                importes1=importes1.toFixed(2);
                iva1= importes1*0.16;
                iva1= iva1.toFixed(2);
                ish1=0;
            }
            document.getElementById("iva["+i+"]").value=iva1;
            document.getElementById("ish["+i+"]").value=ish1;
            document.getElementById("importe["+i+"]").value=importes1;
            //console.log('importes '+importes1);

            importes_total += parseFloat(importes1);
            iva_total += parseFloat(iva1);
            ish_total += parseFloat(ish1);
            //console.log('total '+importes_total);
        }
    }
            let importetotal = parseFloat(importes_total);
            document.getElementById("rimporte").value = importetotal.toFixed(2);
        
            let ivatotal = parseFloat(iva_total);
            document.getElementById("riva").value = ivatotal.toFixed(2);
        
            let ishtotal = parseFloat(ish_total)
            document.getElementById("rish").value = ishtotal.toFixed(2);
        
            let totales = importetotal+ivatotal+ishtotal;
            document.getElementById("rtotal").value = totales.toFixed(2);
        
    }

    function validar_c_cancelacion(){
        var motivo = document.getElementById("motivo");
        const uuid = document.querySelector("#uuid");

            if(motivo.value === null || motivo.value === ''){
                swal("Campo Motivo vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }
            if(uuid.value === null || uuid.value === ""){
                swal("Campo UUID vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }

            swal({
                title: "Tu factura sera cancelada!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        cancelar_factura ();
                    } else {
                    swal("Verifica los archivos antes de cancelar!");
                }
            });
    }
    function cancelar_factura (){
        const folio = document.querySelector("#folio").value;
        const uuid = document.querySelector("#uuid").value;
        document.getElementById("animacion_cancelar").style.display='block';
        document.getElementById("cancelar").style.display='none';

        //Declaramos una variable que contendra nuestro formulario
        var form = document.getElementById('formcancelar');
        //Declaramos una constante que contendra XMLHttpRequest(); intercambia datos detras de escena
        const xhr = new XMLHttpRequest();
        //open recive informacion son 3 parametro
        xhr.open('POST', 'includes/cancelar_factura.php?uuid='+uuid+'&folio='+folio, true);
        //FormData interpretara los datos del formulario
        var formData = new FormData(form);
        //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
        xhr.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                console.log(e.target.response);
                //Entrara la contidicion que valida la respuesta del formulario
                if (e.target.response == 'OK') {
                    swal("Tu factura se cancelo!", " ", "success");
                    document.getElementById("animacion_cancelar").style.display='none';
                    document.getElementById("cancelar").style.display='block';
                }else{
                    console.log(e.target.response);
                    var respuesta=e.target.response;
                    var datos = respuesta;
                    swal("No se pudo realizar la cancelacion", datos , "error");
                    document.getElementById("animacion_cancelar").style.display='none';
                    document.getElementById("cancelar").style.display='block';
                }
            }else{
                swal("No se pudo realizar la cancelacion", "Revise que el formato de la factura sea con extension XML", "error");
                document.getElementById("animacion_cancelar").style.display='none';
                document.getElementById("cancelar").style.display='block';
            }
        })
        //Enviamos nuestro la respuesta de nuestro formulario
        xhr.send(formData);
    }

    function validar_c_consulta(){
        var archivo_xml = document.getElementById("archivo_xml");

            if(archivo_xml.value === null || archivo_xml.value === ''){
                swal("Campo archivo XML vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }

            consultar_factura();
    }

    function consultar_factura(){
        //debugger;
        document.getElementById("animacion_consultar").style.display='block';
        document.getElementById("consultar").style.display='none';
        //Declaramos una variable que contendra nuestro formulario
        var form = document.getElementById('formconsulta');
        //Declaramos una constante que contendra XMLHttpRequest(); intercambia datos detras de escena
        const xhr = new XMLHttpRequest();
        //open recive informacion son 3 parametro
        xhr.open('POST', 'includes/consultar_factura.php', true);
        //FormData interpretara los datos del formulario
        var formData = new FormData(form);
        //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
        xhr.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                console.log(e.target.response);
                //Entrara la contidicion que valida la respuesta del formulario
                if (e.target.response != 'Desconocido: talvez el servicio del sat esta sin servicio o saturado, intentalo mas tarde') {
                    console.log(e.target.response);
                    //swal("Tu consulta fue realizada con exito!", " ", "success");
                    var respuesta=e.target.response;
                    var datos = respuesta.split('/');
                    document.getElementById("tabla_contenido").innerHTML ='<tr><td> '+datos[0]+' </td><td> '+datos[1]+' </td><td> '+datos[2]+' </td>';
                    document.getElementById("animacion_consultar").style.display='none';
                    document.getElementById("consultar").style.display='block';
                }
            }else{
                swal("No se pudo realizar la consulta", "Por favor revisar que el archivo tenga terminacion .xml" , "error");
                console.log(e.target.response);
            }
        })
        //Enviamos nuestro la respuesta de nuestro formulario
        xhr.send(formData);
    }

    function buscar_factura_folio(){
        var inicial = document.getElementById("inicial");
        var final = document.getElementById("final");
            if(inicial.value === null || inicial.value === ''){
                swal("Campo folio inicial vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }
            if(final.value === null || final.value === ''){
                swal("Campo folio final vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }

            buscar_por_folio();
    }

    function buscar_por_folio(){
        var inicial = encodeURI(document.getElementById("inicial").value);
        var final = encodeURI(document.getElementById("final").value);

        var datos = {
            "inicial": inicial,
            "final": final
        }
        //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
        var theObject = new XMLHttpRequest();
        theObject.open("GET",  "includes/buscar_facturas_folio.php?inicial="+ inicial + "&final="+final ,true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-facturas').innerHTML = theObject.responseText;
        }
        theObject.send();
    }

    function buscar_factura_fecha(){
        var inicial = document.getElementById("inicial");
        var final = document.getElementById("final");
            if(inicial.value === null || inicial.value === ''){
                swal("Campo fecha inicial vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }
            if(final.value === null || final.value === ''){
                swal("Campo fecha final vacio!", "Verifique los datos correctamente por favor!", "error");
                return false;
            }

            buscar_por_fecha();
    }

    function buscar_por_fecha(){
        var inicial = encodeURI(document.getElementById("inicial").value);
        var final = encodeURI(document.getElementById("final").value);

        var datos = {
            "inicial": inicial,
            "final": final
        }
        //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
        var theObject = new XMLHttpRequest();
        theObject.open("GET",  "includes/buscar_facturas_fecha.php?inicial="+ inicial + "&final="+final ,true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        /* theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        } */
        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-facturas').innerHTML = theObject.responseText;
        }
        theObject.send();
    }
    function reporte_facturacio(modo,inicio,fin){
        window.open("includes/facturas_a_excel.php?modo="+modo+"&inicio="+inicio+"&fin="+fin, "Diseño Web", "width=300, height=200")
    }


    function reenviar_factura(folio , nombre) {
        let email="";
        swal({
            text: 'Ingresa el correo en donde deseas reenviar la factura.',
            content: "input",
            button: {
              text: "Reenviar",
              closeModal: false,
            },
          })
          .then((name) => {
            if (!name) {
                throw null;
            }
            email = name
            //return Promise.resolve()
          })
         .then(() => {
            console.log(folio)
            console.log(email)
            console.log(nombre)
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.open("GET","includes/reenviar_correo.php?nombre="+nombre+"&correo="+email+"&folio="+folio,true);
            xhttp.addEventListener('load', e =>{
                console.log(e)
                //Si el servidor responde 4  y esta todo ok 200
                if (e.target.readyState == 4 && e.target.status == 200) {
                    //Entrara la contidicion que valida la respuesta del formulario
                    if (e.target.response == 'Messagehasbeensent') {
                        console.log(e.target.response);
                        console.log("Correo enviado ///");
                        swal("Tu factura se envio correctamente!", "Pronto recibirás un correo con los archivos correspondientes de tu factura!", "success");
                    }else if(contador < 3){
                        console.log(e.target.response);
                        swal({
                            title: "Tu factura no envió!",
                            text: "Puede consultar las facturas en las seccion de \"Buscar Factura\" en la barra de menu o presione \"OK\" para intentar enviar el correo otra vez ",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                    }else{
                        swal("Error del servidor!", "Puede consultar las facturas en las seccion de Buscar Factura en la barra de menu", "error");
                    }
                }else{
                    swal("Error del servidor!", "Puede consultar las facturas en las seccion de Buscar Factura en la barra de menu", "error");
                }
            })
            //Enviamos nuestro la respuesta de nuestro formulario
            xhttp.send();
         })
          .catch(err => {
            if (err) {
              swal("Error", "Error al envio de factura", "error");
              console.log(err)
            } else {
              swal.stopLoading();
              swal.close();
            }
          });

    
    }