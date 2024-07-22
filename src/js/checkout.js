

(() => {
  'use strict'
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })

 
  //let amount;
  window.paypal
  paypal.Buttons({
      createOrder: function( data , actions ){
        console.log()

          return actions.order.create({
              purchase_units:[{
                  amount:{
                      value: grandTotal
                  }
              }]
          });
      },
      onApprove: function(data, actions) {
          return actions.order.capture().then(function(details){
              //alert("gracias "+details.payer.name.given_name+" tu transaccion fue compleatada con exito ");

              const data = {
                "id" :  details.purchase_units[0].payments.captures[0].id,
                "kids" : ninos,
                "nombre" : document.getElementById('firstName').value,
                "apellido" : document.getElementById('lastaname').value,
                "correo" : document.getElementById('email').value,
                "tarifa" : habType,
                "telefono" : document.getElementById('phone').value,
                "llegada" : document.getElementById('checkinDate').value,
                "salida" : document.getElementById('checkoutDate').value,
                "huespedes" : document.getElementById('guests').value,
                "cargo" : grandTotal,
              }
              
              let xhr = new XMLHttpRequest();
              xhr.open("POST", `guardar_reservacion.php`, true)
              xhr.setRequestHeader("Content-Type", "application/json");
              xhr.onload = function () {
                  if( xhr.status >= 200 && xhr.status < 300 ) {
                      console.log(xhr.responseText);
          
                  } else {
                      console.log("Hubo un error al crear la reserva")
                      xhr.close(data);
                  }      
              }
              let dataJSON = JSON.stringify(data)
              xhr.send(dataJSON);
              swal(
                "Muchas gracias",
                `${ details.payer.name.given_name } tu transacción fue completada con éxito`,
                `success`
              ).then((value) => {
                window.location.href = "../../index.php";
              });
          }).catch(function(error) {
            console.error("Error capturing order: ", error );
            swal(
              "Error",
              "There was an issue capturing your order. Please try again.",
              "error"
            )
          });   
      },
      onCancel: function(data) {
        swal(
          "Transacción cancelada",
          "Has cancelado la transacción",
          "info"
        )
      },
      onError: function(err) {
        console.error("Error with PayPal transaction:", err);
        swal("Error", "There was an issue with your PayPal transaction. Please try again.", "error");
      }
          
  }).render("#paypal-button-container")


  startPurchaseTimer()

  history.pushState(null, document.title, location.href);
  window.addEventListener('popstate', function () {
      history.pushState(null, document.title, location.href);
  });

})()

function startPurchaseTimer() {

  const tiempoLimite = 5 * 60 * 1000;
  let tiempoRestante = tiempoLimite;

  const intervalo = setInterval(function() {
    tiempoRestante -= 1000;
    if ( tiempoRestante <= 0) {
      clearInterval(intervalo);
      swal({
        title: "Tiempo agotado",
        text: "El tiempo para completar tu compra ha terminado.",
        icon: "error",
        button: "OK"
      }).then(() => {
        // Acciones adicionales al terminar el tiempo
        document.getElementById('paypal-button-container').style.display = 'none';
        window.location.href = "../../index.php";
      });
    } else {
      // Calcular minutos y segundos restantes
      const minutos = Math.floor(tiempoRestante / 60000);
      const segundos = Math.floor((tiempoRestante % 60000) / 1000); 

      // Formatear en texto con dos dígitos para los segundos
      const tiempoTexto = `${minutos}:${segundos < 10 ? '0' : ''}${segundos}`;
      
      actualizarContador(tiempoTexto);
    }
  }, 1000);

  function actualizarContador(tiempoSegundos) {
    const contador = document.getElementById("contador");
    if (contador) {
      contador.innerText = tiempoSegundos;
    }
  }
}

