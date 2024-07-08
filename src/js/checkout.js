

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
              const { 
                id,

              } = details

              const data = {
                id, 
                "nombre" : document.getElementById('firstName').value,
                "apellido" : document.getElementById('lastaname').value,
                "correo" : document.getElementById('email').value,
                "tarifa" : habType,
                "telefono" : document.getElementById('phone').value,
                "llegada" : document.getElementById('checkinDate').value,
                "salida" : document.getElementById('checkoutDate').value,
                "huespedes" : document.getElementById('guests').value
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
              );
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
  // Show an initial alert that will disappear automatically
  swal({
      title: "Tiempo limitado para la compra",
      text: "Debes completar tu compra en 5 minutos.",
      icon: "warning",
      timer: 5000,
      button: false
  });

  // Set a timeout to redirect the user after 5 minutes
  setTimeout(function() {
      swal({
          title: "Tiempo agotado",
          text: "El tiempo para completar tu compra ha terminado.",
          icon: "error",
          button: "OK"
      }).then(() => {
          document.getElementById('paypal-button-container').style.display = 'none';
          document.getElementById('timeout-message').style.display = 'block';
          window.location.href = "../../index.php"; 
      });
  }, 300000);
}