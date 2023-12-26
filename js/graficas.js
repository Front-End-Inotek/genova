let usuario_id=localStorage.getItem("id");

//Datos
let datos_ocupadas = [];
let datos_hospedaje =[];
let datos_pagos = [];
let datos_ventas=[];
let datos_ventas_rest=[];
let ventas_rest=[];

let datos_abonos=[];
let datos_cargos=[];

//Graficas
let grafica_ocupadas;
let grafica_hospedaje;
let grafica_forma_pago;
let grafica_ventas;
let grafica_ventas_rest;
let grafica_ventas4;

//Etiquetas
let etiquetas_hospedaje=[];
let etiquetas_forma_pago=[];
let etiquetasRestaurant=[];

function mostrar_graficas(){
const $grafica = document.querySelector("#grafica");

const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre","Octubre","Noviembre","Diciembre"];

const datosVentas200 = {
    label: "Ocupacion de habitaciones",
    data: datos_ocupadas,
    backgroundColor: "#007bff7a",
    borderColor: "#007BFF",
    borderWidth: 1,
    /* fill: false, */
    /* tension: 1 */
}
grafica_ocupadas  = new Chart($grafica, {
    type: 'line',
    data: {
        labels: etiquetas,
        datasets: [
            datosVentas200,
        ]
    },
    options: {
        scales : {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
    }
})

//Hospedaje
const graficaPastel = document.querySelector("#graficaPastel");
const datosOcupacion = {
    data: datos_hospedaje,
    backgroundColor: [
        "#6C82B2",
        "#FE3F40",
        "#54B7F5",
        "#3F98C7",
        "#656566",
        "#02B0C0",
        "#B3E4FF",
        "#AEF8AB",
        "#FDE996",
        "#FE9F6C",
        "#0E41B0",
        "#B4B7FA",
        "#F9FAF5",
        "#D0EDA4",
        "#F7F172",
        "#A01D1E",
        "#6C82F2",
        "#FE3FF0",
        "#54B7F5",
        "#1F98A7",
        "#6565F6",
        "#02B4F1",
    ],
    /* borderColor: [
        "rgba(108,130,178,1)",
        "rgba(254,63,64,1)",
        "rgba(84,183,245,1)",
        "rgba(63,152,199,1)",
        "rgba(101,101,102,1)",
    ], */
    /* borderWidth: 1, */
};

grafica_hospedaje= new Chart(graficaPastel,{
    type: "pie",
    data: {
        labels: etiquetas_hospedaje,
        datasets: [
            datosOcupacion
        ]
    },
    options: {
        legend: {
            display: false
        }
    }
})

//Formas Pago

const graficaDona = document.querySelector("#graficaDona");
const etiquetas_forma_pago = [];
const datosFormasDePago = {
    label: "Formas de pago",
    data: datos_pagos,
    backgroundColor: [
        "#3F98C7",
        "#B4B7FA",
        "#02B0C0",
        "#B3E4FF",
        "#AEF8AB",
        "#A01D1E",
        "#6C82B2",
        "#656566",
        "#FDE996",
        "#FE9F6C",
        "#0E41B0",
        "#54B7F5",
        "#F9FAF5",
        "#D0EDA4",
        "#F7F172",
        "#F3B9BB",
        "#FAF5F5",
        "#EDA324",
        "#FE3F40",
        "#F77772",
    ],
    hoverOffset: 4
}
grafica_forma_pago =  new Chart(graficaDona, {
    type: "doughnut",
    data: {
        labels : etiquetas_forma_pago,
        datasets: [
            datosFormasDePago
        ]
    }
})
//Ventas
const ventas = document.querySelector("#ventas");
const etiquetasVentas = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];

const datosVentas2020 = {
    label: "Cargos",
    data: datos_cargos,
    backgroundColor: "#007BFF",
    borderColor: "#007BFF",
    borderWidth: 1,
};

const datosVentas2021 = {
    label: "Abonos",
    data: datos_abonos,
    backgroundColor: "#17A2B8",
    borderColor: "#17A2B8",
    borderWidth: 1,
};

grafica_ventas=new Chart (ventas, {
    type: "bar",
    data: {
        labels : etiquetasVentas,
        datasets: [
            datosVentas2021,
            datosVentas2020,
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
})

const restaurant = document.querySelector("#restaurant");

const datosRestaurant = {
    label: "Unidades vendidas",
    data: ventas_rest,
    backgroundColor: "#007BFF",
    borderColor: "#007BFF",
    borderWidth: 1,
}

grafica_ventas4 = new Chart (restaurant, {
    type: "bar",
    data: {
        labels: etiquetasRestaurant,
        datasets: [
            datosRestaurant
        ]
    },
    options: {
        scales : {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        }
    }
})
cargarInfoServidor();
}

function asignarInfo(info){
    /* console.log(info) */
    //Ocupacion
    datos_ocupadas = info['datos_ocupadas']
    grafica_ocupadas.data.datasets[0].data = datos_ocupadas;
    grafica_ocupadas.update();
    //Hospedaje
    datos_hospedaje = info['datos_hospedaje'];
    grafica_hospedaje.data.datasets[0].data = datos_hospedaje;
    grafica_hospedaje.data.labels = info['etiquetas_hospedaje']
    grafica_hospedaje.update();
    //Formas de pago
    datos_pagos = info['datos_pagos'];
    grafica_forma_pago.data.datasets[0].data=datos_pagos
    grafica_forma_pago.data.labels = info['etiquetas_forma_pago']
    grafica_forma_pago.update();
    // //Ventas
    // datos_ventas = info['datos_ventas'];
    // grafica_ventas.data.datasets[0].data=datos_ventas
    // //Ventas rest
    // datos_ventas_rest = info['datos_ventas_rest'];
    // grafica_ventas.data.datasets[1].data=datos_ventas_rest
    // grafica_ventas.update();
      //Abonos/cargos datos
    datos_abonos = info['datos_abonos'];
    grafica_ventas.data.datasets[0].data=datos_abonos
    datos_cargos = info['datos_cargos'];
    grafica_ventas.data.datasets[1].data=datos_cargos
    grafica_ventas.update();
    //Datos rest 4
    ventas4 = info['venta_rest'];
    grafica_ventas4.data.labels = info['etiquetas_rest']
    grafica_ventas4.data.datasets[0].data=ventas4
    grafica_ventas4.update();
}

function cargarInfoServidor(){
    //Mientras se mantenga la vista de graficas, leera info del server.
    if(localStorage.getItem('vista') !=3){
        clearTimeout(timer_grafica)
        return
    }
    // console.log("**** Cargando info del servidor *****")
    include="includes/cargar_datos_visit.php?usuario="+usuario_id
    $.ajax({
        async:true,
        type: "GET",
        dataType: "HTML",
        contentType: "application/json",
        url:include,
        // beforeSend:loaderbar,
        //una vez eliminado el token de la bd, se redirecciona.
        success:function(res){
            res = JSON.parse(res)
            asignarInfo(res)
        },
        //success:problemas_sistema,
        timeout:5000,
        error:function(err){
            console.log(err)
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    });
    // timer_grafica = setTimeout('cargarInfoServidor()',3000);//5500
}

