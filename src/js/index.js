


const calender_container = document.querySelector("#calender");
const btnCalender = document.querySelector("#btnCalender");

btnCalender.addEventListener("click" , e => handleCalender());

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
yesterday.setDate(yesterday.getDate() - 1);
const formattedYesterday = yesterday.toISOString().split('T')[0];
calendarRange.setAttribute("min", formattedYesterday);


const initialDateHTML = document.querySelector("#initialDate")
const endDateHTML = document.querySelector("#endDate")

calendarRange.addEventListener("change", (e) => {
    const dates = e.target.value
    const datesArray = dates.split("/")
    const initialDate = datesArray[0];
    const endDate = datesArray[1];

    initialDateHTML.innerText = initialDate;
    endDateHTML.innerText = endDate;
    /* console.log(datesArray)
    console.log(e.target.value) */
})

const reservar = () => {
    console.log("Creando reserva...")

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "src/php/mail.php", true);

    xhr.onload = function () {
        if( xhr.status >= 200 && xhr.status < 300 ) {
            console.log(xhr.responseText);
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