const grafica = document.querySelector("#grafica");

const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"];

const datosVentas200 = {
    label: "Ocupacion de habitaciones",
    data: [50, 60, 60, 80, 90, 100, 95],
    borderColor: "rgba(56,116,255, 1)",
    borderWidth: 1,
    fill: false,
    tension: 0.1
}

new Chart(grafica, {
    type: "line",
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
        "rgba(163,221,203,1)",
        "rgba(232,233,161,1)",
        "rgba(230,181,102,1)",
        "rgba(229,112,126,1)",
        "rgba(229,12,106,1)",
    ],
    borderColor: [
        "rgba(163,221,203,1)",
        "rgba(232,233,161,1)",
        "rgba(230,181,102,1)",
        "rgba(229,112,126,1)",
        "rgba(229,12,106,1)",
    ],
    borderWidth: 1,
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
        "rgb(255, 99, 132)",
        "rgb(54, 162, 235)",
        "rgb(255, 205, 86)",
        "rgb(2, 205, 86)",
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
    backgroundColor: "rgba(54, 162, 235, 1)",
    borderColor: "rgba(54, 162, 235, 1)",
    borderWidth: 1,
};

const datosVentas2021 = {
    label: "Ventas restaurant",
    data: [1000, 1700, 5000, 5989, 6000, 7000, 9000],
    backgroundColor: "rgba(255, 159, 64, 1)",
    borderColor: "rgba(255, 159, 64, 1)",
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
    backgroundColor: "rgba(54, 162, 235, 0.5)",
    borderColor: "rgba(52, 162, 235, 1)",
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