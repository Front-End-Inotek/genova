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
      createOrder: function(data,actions){
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
              alert("gracias "+details.payer.name.given_name+" tu transaccion fue compleatada con exito ");
          });
          
      }
          
  }).render("#paypal-button-container")


})()
