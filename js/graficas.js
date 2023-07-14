var datos_ocupadas = [];
var usuario_id=localStorage.getItem("id");
var grafica_ocupadas;
function mostrar_graficas(){


const ocupacionActual = document.querySelector("#ocupacionActual");

const ocupacionEtiquetas = [
    "Ocupada",
    "Sucia ocupada",
    "Vacia sucia",
    "Mantenimiento",
    "Bloqueada",
    "Reserva pagada",
    "Vacia limpieza",
    "Uso casa",
    "disponible"
];

const datosOcupacionActual = {
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
        "rgb(208,26,59)",
        "rgb(189,2,2)",
        "rgb(0,159,92)",
        "rgb(255,193,7)",
        "rgb(11,11,11)",
        "rgb(77,3,174)",
        "rgb(71,134,255)",
        "rgb(5,209,202)",
        "rgb(155,154,154)"
    ],
    /* borderColor: [
        "rgb(208,26,59)",
        "rgb(189,2,2)",
        "rgb(0,159,92)",
        "rgb(255,193,7)",
        "rgb(11,11,11)",
        "rgb(77,3,174)",
        "rgb(71,134,255)",
        "rgb(5,209,202)",
        "rgb(155,154,154)"
    ], */
    /* borderWidth: 1, */
}

new Chart(ocupacionActual, {
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
})

const $grafica = document.querySelector("#grafica");

const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Octubre","Noviembre","Diciembre"];

const datosVentas200 = {
    label: "Ocupacion de habitaciones",
    data: datos_ocupadas,
    /* backgroundColor: 'rgba(56,116,255, 0.7)', */
    borderColor: 'rgba(44,123,229, 1)',
    borderWidth: 1,
    fill: false,
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

const graficaPastel = document.querySelector("#graficaPastel");
const etiquetasGraficaPastel = ["Suite", "Doble", "Sencillo", "Suite", "Triple"];

const datosOcupacion = {
    data: [ 10 , 15, 50 , 10, 43],
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

new Chart(graficaPastel,{
    type: "pie",
    data: {
        labels: etiquetasGraficaPastel,
        datasets: [
            datosOcupacion
        ]
    }
})

const graficaDona = document.querySelector("#graficaDona");
const etiquetasDona = ["Efectivo", "Transferencia" , "Tarjeta" , "Cupon"];

const datosFormasDePago = {
    label: "Formas de pago",
    data: [ 15, 12, 43, 25],
    backgroundColor: [
        "rgba(108,130,178,1)",
        "rgba(254,63,64,1)",
        "rgba(84,183,245,1)",
        "rgba(63,152,199,1)",
    ],
    hoverOffset: 4
}
new Chart(graficaDona, {
    type: "doughnut",
    data: {
        labels : etiquetasDona,
        datasets: [
            datosFormasDePago
        ]
    }
})

const ventas = document.querySelector("#ventas");
const etiquetasVentas = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];

const datosVentas2020 = {
    label: "Ventas hospedaje",
    data: [5000, 1500, 8000, 5102, 4000, 1599, 10000],
    backgroundColor: "rgba(254,63,64,1)",
    borderColor: "rgba(254,63,64,1)",
    borderWidth: 1,
};

const datosVentas2021 = {
    label: "Ventas restaurant",
    data: [1000, 1700, 5000, 5989, 6000, 7000, 9000],
    backgroundColor: "rgba(101,101,102,1)",
    borderColor: "rgba(101,101,102,1)",
    borderWidth: 1,
};

new Chart (ventas, {
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
    data: [ 400, 424 , 565 , 324 ],
    backgroundColor: 'rgba(44,123,229, 1)',
    borderColor: 'rgba(44,123,229, 1)',
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

    // return
    datos_ocupadas = info['datos_ocupadas']

    grafica_ocupadas.data.datasets[0].data = datos_ocupadas;

    grafica_ocupadas.update();
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

    timer_grafica = setTimeout('cargarInfoServidor()',3000);//5500
}

