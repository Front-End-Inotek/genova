


const calender_container = document.querySelector("#calender");
const btnCalender = document.querySelector("#btnCalender");

const btn_inicialFecha = document.querySelector("#handleInicio");
const btn_finalFecha = document.querySelector("#handleFinal");

const btn_submit = document.getElementById("btn_submit");

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
}, 10000);

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
    slider.style.transition = "all ease-in-out .2s"
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
    slider.style.transition = "all ease-in-out .2s"
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
    const dates = e.target.value;
    const datesArray = dates.split("/");
    const initialDate = datesArray[0];
    const endDate = datesArray[1];
    arrive = initialDate;
    leave = endDate;

    
    initialDateHTML.innerText = initialDate;
    endDateHTML.innerText = endDate;
    calender_container.style.display = "none";

    console.log(datesArray);
    console.log(e.target.value);
});



const reservar = () => {

    const email = document.getElementById("email").value.trim();
    const name = document.getElementById("name").value.trim();
    const lastname = document.getElementById("lastname").value.trim();
    const phone = document.getElementById("tel").value.trim();
    const guestsSelect = document.querySelector('select[name="persons"]');
    const guests = parseInt(guestsSelect.value.trim())
    const kidsSelect = document.querySelector('select[name="kids"]');
    const kids = parseInt(kidsSelect.value.trim())

    console.log(guests + kids)
    const hab_id = document.querySelector('input[name="hab"]:checked').value;

    if (guests !== "") {
        console.log("Número de huéspedes seleccionado:", guests);
    } else {
        console.log("Ningún número de huéspedes seleccionado.");
    }
    if(guests + kids > 4){
        console.log(guests + kids)
        swal("Solo 4 huespedes por habitacion! (Contando adultos y niños)")
        return
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
    if (!lastname) {
        swal("Sin apellido!", "Agrega un apellido valido!", "warning");
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
    const nameSurnameRegex  = /^[a-zA-Z\s'-]+$/;
    
    if (!nameSurnameRegex .test(name)) {
        swal("El nombre no es válido. Por favor, ingrese un nombre real.")
        return;
    }
    if (!nameSurnameRegex.test(lastname)) {
        swal("El apellido no es válido. Por favor, ingrese un apellido real.");
        return;
    }
    //console.log("Creando reserva...");

    const data = {
        "name": name,
        "lastname" : lastname,
        "phone": phone,
        "guests": guests,
        "initial": arrive,
        "end": leave,
        "email": email,
        "hab_id": hab_id,
        "kids" : kids
    };

    //console.log(data)
    
    // Crear un formulario oculto
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "src/includes/agregar_reservacion.php";
    
    // Agregar los datos al formulario
    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }
    }
    
    // Agregar el formulario al cuerpo del documento y enviarlo
    document.body.appendChild(form);
    form.submit();

}

const btnReserva = document.querySelector("#btn_crear_reserva");

const consultar_reserva = (  ) => {

    const loader = document.getElementById("loader")

    loader.style = "display: flex;"

    const email = document.getElementById("email").value.trim();
    const name = document.getElementById("name").value.trim();
    const phone = document.getElementById("tel").value.trim();
    const guestsSelect = document.querySelector('select[name="persons"]');
    const guests = guestsSelect.value.trim();;
    const contenedor = document.getElementById("contenedor_hab");
    contenedor.innerHTML = "";
    
    if (guests !== "") {
        console.log("Número de huéspedes seleccionado:", guests);
    } else {
        console.log("Ningún número de huéspedes seleccionado.");
    }
    if (!email) {
        swal("Sin correo electrónico!", "Agrega un email valido valido!", "warning");
        loader.style = "display: none;"
        return
    }
    if ( !email.includes("@") || email.includes(" ") || !email.includes(".")) {
        swal("Email no valido", "Agrega un email valido valido!", "warning");
        loader.style = "display: none;"
        return
    }
    if (!name) {
        swal("Sin nombre!", "Agrega un nombre valido!", "warning");
        loader.style = "display: none;"
        return
    }
    if (!phone) {
        swal("Sin numero de telefono!", "Agrega un numero de telefono valido!", "warning");
        loader.style = "display: none;"
        return
    }
    if (!guests) {
        swal("Sin cantidad de huespedes!", "Agrega un numero de huespedes valido!", "warning");
        loader.style = "display: none;"
        return
    }
    if (!arrive) {
        swal("Sin fecha inicial de la reserva!", "Agrega una fecha inicial!", "warning");
        loader.style = "display: none;"
        return
    }
    if (!leave) {
        swal("Sin fecha de salida en la reserva!", "Agrega una fecha salida!", "warning");
        loader.style = "display: none;"
        return
    }
    const nameSurnameRegex  = /^[a-zA-Z\s'-]+$/;
    if (!nameSurnameRegex .test(name)) {
        swal("El nombre no es válido. Por favor, ingrese un nombre real.");
        loader.style = "display: none;"
        return;
    }


    //console.log("consultando")
    const quersyString = `name=${encodeURIComponent(name)}&phone=${encodeURIComponent(phone)}&guests=${encodeURIComponent(guests)}&initial=${arrive}&end=${leave}&email=${encodeURIComponent(email)}`
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `src/includes/consultar_disponibilidad.php?${quersyString}`, true)
    xhr.onload = function () {
        if( xhr.status >= 200 && xhr.status < 300 ) {
            //console.log(xhr.responseText);
            loader.style = "display: none;"
            contenedor.innerHTML = xhr.responseText
            btn_submit.style = "display:block;";
            btn_submit.setAttribute("disabled", true);

        } else {
            console.log("Hubo un error al crear la reserva")
            xhr.close();
        }
    };

    xhr.onerror = function () {
        console.error("Error de red al intentar crear la reserva.");
    };

    xhr.send();

}

//Submit button
btnReserva.addEventListener('click' , e => consultar_reserva())
btn_submit.addEventListener('click', e=> reservar())

function selectCard(radio) {
    // Obtén el contenedor .card_hab más cercano al radio seleccionado
    const cardHab = radio.closest('.card_hab');
    
    // Remueve la clase 'selected' de todos los .card_hab
    document.querySelectorAll('.card_hab').forEach(function(card) {
        card.classList.remove('selected');
    });
    
    // Si el radio está seleccionado, agrega la clase 'selected' al contenedor .card_hab
    if (radio.checked) {
        cardHab.classList.add('selected');
    }

    btn_submit.removeAttribute("disabled");
}