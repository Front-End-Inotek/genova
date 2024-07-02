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


})()
