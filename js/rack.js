
const mostrarCalentario = () => {
    //Fecha hoy
    const fechaHoy = document.getElementById("fecha_hoy");
    const obtenerNombreMesYAno = (fecha) => {
        const nombresMeses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiemnbre", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ]
        const ano = fecha.getFullYear();
        const numeroMes = fecha.getMonth();
        const nombreMes = nombresMeses[numeroMes];
        const resultado = `${nombreMes} <span class="text-secondary">${ano}</span>`;
        return resultado;
    }

    const fechaActual = new Date();
    const nombreMesYAno = obtenerNombreMesYAno(fechaActual);

    fechaHoy.innerHTML = nombreMesYAno;

    //Generar los proximos 30 dias
    const generadorDias = () => {
        const hoy = new Date();
        const diaEnMilisegundos = 24 * 60 * 60 * 1000;
    
        const siguientesDias = Array.from({ length: 30 }, (_, index) => {
        const siguienteDia = new Date(hoy.getTime() + index * diaEnMilisegundos);
    
        const options = { weekday: "long" };
        const nombreDia = new Intl.DateTimeFormat("es-ES", options).format(siguienteDia);
        const numeroDia = siguienteDia.getDate();
    
        return { nombreDia, numeroDia };
        });
    
        return siguientesDias;
    };
    const diasArray = generadorDias();
    const dias = document.getElementById("dias")

    diasArray.map(dia => {

        const divDia = document.createElement("div");
        divDia.classList.add("task_calendario");
        divDia.classList.add("dia_calendario");
        divDia.innerHTML = `<span>${dia.nombreDia} ${dia.numeroDia}</span>`;
        if(dia.nombreDia.toLocaleLowerCase() === "domingo") {
            divDia.style.backgroundColor = "rgba( 108, 139, 192, 0.2)"
        }

        dias.appendChild(divDia);
    })
}

const mostrarRackCalendario = () => {
    const habitaciones = document.getElementById("habitaciones");

    fetch("includes/prueba.php")
        .then(response => response.text())
        .then(data => {
            habitaciones.innerHTML = data;
        })
        .catch(error => {
            console.error("Error en la solicitud:", error)
        })

    console.log("Mostrando rack")
}


