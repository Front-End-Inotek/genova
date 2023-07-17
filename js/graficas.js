var usuario_id=localStorage.getItem("id");

//Datos
var datos_ocupadas = [];
var datos_hospedaje =[];
var datos_pagos = [];
var datos_ventas=[];
var datos_ventas_rest=[];


//Graficas
var grafica_ocupadas;
var grafica_hospedaje;
var grafica_forma_pago;
var grafica_ventas;
var grafica_ventas_rest;

//Etiquetas
var etiquetas_hospedaje=[];
var etiquetas_forma_pago=[];

function mostrar_graficas(){
<<<<<<< HEAD

//const ocupacionActual = document.querySelector("#ocupacionActual");

/* const ocupacionEtiquetas = [
    "Ocupadas",
    "Sucia ocupadas",
    "Vacia sucias",
    "Mantenimiento",
    "Bloqueadas",
    "Reserva pagada",
    "Vacia limpieza",
    "Uso casa",
    "disponible"
];
 */
/* const datosOcupacionActual = {
    label: "Ocupacion actual de habitaciones",
    data: [
        10,
        2,
        5,
        2,
        1,
        2,
        4,
        1,
        16
    ]
    ,
    backgroundColor: [
        "rgba(254,63,64,1)",
        "rgb(194,1,1)",
        "rgb(0,159,92)",
        "rgb(255,193,7)",
        "rgba(101,101,102,1)",
        "rgb(77,3,174)",
        "rgb(71,134,255)",
        "rgb(5,209,202)",
        "rgb(155,154,154)"
    ],
    borderColor: [
        "rgba(254,63,64,1)",
        "rgb(194,1,1)",
        "rgb(0,159,92)",
        "rgb(255,193,7)",
        "rgba(101,101,102,1)",
        "rgb(77,3,174)",
        "rgb(71,134,255)",
        "rgb(5,209,202)",
        "rgb(155,154,154)"
    ],
    borderWidth: 2,
} */

/* new Chart(ocupacionActual, {
    type: "pie",
    data : {
        labels: ocupacionEtiquetas,
        datasets: [
            datosOcupacionActual
        ]
    },
    options: {
        legend: {
            position: "left"
        }
    }
}) */

=======
>>>>>>> 79e1a56e6f1e80e313c38e612ceca0fa839d8906
const $grafica = document.querySelector("#grafica");

const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre","Octubre","Noviembre","Diciembre"];

const datosVentas200 = {
    label: "Ocupacion de habitaciones",
    data: datos_ocupadas,
    backgroundColor: "rgba(84,183,245,0.5)",
    borderColor: 'rgba(56,116,255, 1)',
    borderWidth: 1,
    /* fill: false, */
    tension: 0.1
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
        }
    }
})

//Hospedaje
const graficaPastel = document.querySelector("#graficaPastel");
const datosOcupacion = {
    data: datos_hospedaje,
    backgroundColor: [
        "rgba(108,130,178,1)",
        "rgba(254,63,64,1)",
        "rgba(84,183,245,1)",
        "rgba(63,152,199,1)",
        "rgba(101,101,102,1)",
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
    }
})

//Formas Pago

const graficaDona = document.querySelector("#graficaDona");
const etiquetas_forma_pago = [];
const datosFormasDePago = {
    label: "Formas de pago",
    data: datos_pagos,
    backgroundColor: [
        "rgba(108,130,178,1)",
        "rgba(254,63,64,1)",
        "rgba(84,183,245,1)",
        "rgba(63,152,199,1)",
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
    label: "Ventas hospedaje",
    data: datos_ventas,
    backgroundColor: "#00D27A",
    borderColor: "#00D27A",
    borderWidth: 1,
};

const datosVentas2021 = {
    label: "Ventas restaurant",
    data: datos_ventas_rest,
    backgroundColor: "rgba(84,183,245,1)",
    borderColor: "rgba(84,183,245,1)",
    borderWidth: 1,
};

grafica_ventas=new Chart (ventas, {
    type: "bar",
    data: {
        labels : etiquetasVentas,
        datasets: [
            datosVentas2020,
            datosVentas2021
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

const etiquetasRestaurant = [ "Red Velvet" , "Coca cola" , "Sopa" , "Pizza" ];

const datosRestaurant = {
    label: "Productos mas vendidos",
    data: [ 400, 424 , 565 , 599 ],
    backgroundColor: "#00D27A",
    borderColor: "#00D27A",
    borderWidth: 1,
}

new Chart (restaurant, {
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
        }
    }
})
cargarInfoServidor();
}

function asignarInfo(info){
    console.log(info)
    
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

      //Abonos datos
      datos_ventas = info['datos_abonos'];
      grafica_ventas.data.datasets[0].data=datos_ventas
      //Ventas rest
      datos_ventas_rest = info['datos_cargos'];
      grafica_ventas.data.datasets[1].data=datos_ventas_rest
      grafica_ventas.update();
}

function cargarInfoServidor(){
    //Mientras se mantenga la vista de graficas, leera info del server.
    if(vista !=3){
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

    //timer_grafica = setTimeout('cargarInfoServidor()',3000);//5500
}

