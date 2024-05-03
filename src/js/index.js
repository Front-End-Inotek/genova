


const calender_container = document.querySelector("#calender");
const btnCalender = document.querySelector("#btnCalender");

const btn_inicialFecha = document.querySelector("#handleInicio");
const btn_finalFecha = document.querySelector("#handleFinal");

btnCalender.addEventListener("click" , e => handleCalender());
btn_inicialFecha.addEventListener("click" , e => handleCalender());
btn_finalFecha.addEventListener("click" , e => handleCalender());

const handleCalender = () => {
    if ( calender_container.style.display === "flex" ) {
        calender_container.style.display = "none";
    } else {
        calender_container.style.display = "flex";
    }
}
//Slider buttons
const btnLeft = document.querySelector(".btn-left");
const btnRight = document.querySelector(".btn-right");

//Slider container
const slider = document.querySelector("#slider");

//Images
const sliderSection = document.querySelectorAll(".slider-section");

btnLeft.addEventListener( "click", e => moveToLeft() );
btnRight.addEventListener( "click", e => moveToRight() );

setInterval(() => {
    moveToRight();
}, 5000);

let operation = 0;
let counter = 0;
let widthImg = 100 / sliderSection.length;

const moveToRight = () => {
    if ( counter >= sliderSection.length - 1 ) {
        counter = 0;
        operation = 0;
        slider.style.transform = `translate(-${operation}%)`
        return
    } 
    counter++;
    operation = operation + widthImg
    slider.style.transform = `translate(-${operation}%)`
    slider.style.transition = "all ease-in-out .6s"
}
const moveToLeft = () => {
    counter--;
    if ( counter < 0 ) {
        counter = sliderSection.length - 1;
        operation = widthImg * ( sliderSection.length - 1 )
        slider.style.transform = `translate(-${operation}%)`
        return;
    }
    operation = operation - widthImg
    slider.style.transform = `translate(-${operation}%)`
    slider.style.transition = "all ease-in-out .6s"
}

const calendarRange = document.querySelector("calendar-range");

// Calcular la fecha de ayer
const yesterday = new Date();
yesterday.setDate(yesterday.getDate());
const formattedYesterday = yesterday.toISOString().split('T')[0];
calendarRange.setAttribute("min", formattedYesterday);
let arrive;
let leave;

const initialDateHTML = document.querySelector("#initialDate")
const endDateHTML = document.querySelector("#endDate")

calendarRange.addEventListener("change", (e) => {
    const dates = e.target.value
    const datesArray = dates.split("/")
    const initialDate = datesArray[0];
    const endDate = datesArray[1];
    arrive = initialDate;
    leave = endDate;

    initialDateHTML.innerText = initialDate;
    endDateHTML.innerText = endDate;
    /* console.log(datesArray)
    console.log(e.target.value) */
})

const reservar = () => {

    const email = document.getElementById("email").value
    const name = document.getElementById("name").value
    const phone = document.getElementById("tel").value
    const guestsSelect = document.querySelector('select[name="persons"]');
    const guests = guestsSelect.value;

    
    if (guests !== "") {
        console.log("Número de huéspedes seleccionado:", guests);
    } else {
        console.log("Ningún número de huéspedes seleccionado.");
    }
    if (!email) {
        swal("Sin correo electrónico!", "Agrega un email valido valido!", "warning");
        return
    }
    if ( !email.includes("@") || email.includes(" ") || !email.includes(".")) {
        swal("Email no valido", "Agrega un email valido valido!", "warning");
        return
    }
    if (!name) {
        swal("Sin nombre!", "Agrega un nombre valido!", "warning");
        return
    }
    if (!phone) {
        swal("Sin numero de telefono!", "Agrega un numero de telefono valido!", "warning");
        return
    }
    if (!guests) {
        swal("Sin cantidad de huespedes!", "Agrega un numero de huespedes valido!", "warning");
        return
    }
    if (!arrive) {
        swal("Sin fecha inicial de la reserva!", "Agrega una fecha inicial!", "warning");
        return
    }
    if (!leave) {
        swal("Sin fecha de salida en la reserva!", "Agrega una fecha salida!", "warning");
        return
    }

    console.log("Creando reserva...")

    const quersyString = `name=${encodeURIComponent(name)}&phone=${encodeURIComponent(phone)}&guests=${encodeURIComponent(guests)}&initial=${arrive}&end=${leave}&email=${encodeURIComponent(email)}`

    let xhr = new XMLHttpRequest();

    xhr.open("GET", `src/php/mail.php?${quersyString}`, true);

    xhr.onload = function () {
        if( xhr.status >= 200 && xhr.status < 300 ) {
            console.log(xhr.responseText);
            swal("Reservación solicitada con exito!", "Hemos recibido tu solicitud!", "success");
        } else {
            console.log("Hubo un error al crear la reserva")
        }
    };

    xhr.onerror = function () {
        console.error("Error de red al intentar crear la reserva.");
    };

    xhr.send();
}

const btnReserva = document.querySelector("#btn_crear_reserva");


btnReserva.addEventListener('click' , e => reservar())