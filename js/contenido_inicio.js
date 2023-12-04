function mostrarTimbrado (){
    var theObject = new XMLHttpRequest();
        theObject.open('GET', 'includes/formulario_factura.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        }
        theObject.send();
}

function consultarTimbrado (){
    var theObject = new XMLHttpRequest();
        theObject.open('GET', 'includes/formulario_consultar.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        }
        theObject.send();
}

function cancelarTimbrado (){
    var theObject = new XMLHttpRequest();
        theObject.open('GET', 'includes/formulario_cancelar.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        }
        theObject.send();
}

function verfacturas_folio (){
    var theObject = new XMLHttpRequest();
        theObject.open('GET', 'includes/ver_facturas_folio.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        }
        theObject.send();
}

function verfacturas_fecha (){
    var theObject = new XMLHttpRequest();
        theObject.open('GET', 'includes/ver_facturas_fecha.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        theObject.onreadystatechange = function() {
            document.getElementById('contenedor-formulario').innerHTML = theObject.responseText;
        }
        theObject.send();
}


/*XMLHttp = false;
XMLHttp = new XMLHttpRequest();

//cargar fragmentos en la parte de inicio
if(XMLHttp)
{
    XMLHttp.open("GET","includes/formulario_factura.php",true);
    XMLHttp.onload= function cargarcontenido() {
    if(XMLHttp.readyState==4)
    {
        document.getElementById("contenedor-formulario").innerHTML = this.responseText;
    }
    }
    XMLHttp.send(null);
}*/