
        /* para cambiar entre racks*/
        function switch_rack(){

            var checkfactura = document.getElementById("flexSwitchCheckDefault");
            if(checkfactura.checked == true){

                console.log("rack de operaciones");
                alert('si');

            }else{

                console.log("rack de habitaciones");
                alert('si');

            }
        }

         /*********************************************/
        /* funcion para desplegar y ocultar el navbar*
        /*********************************************/

        function boton_menu() {
        let sidebar = document.querySelector("#sidebar");
        let container = document.querySelector(".my-container");
        sidebar.classList.toggle("active-nav");
        container.classList.toggle("active-cont");
        }

        /*********************************************/
        /*funcion para desplegar y ocultar submenus**/
        /*********************************************/

        function sub_menu() {
          // Obtener todos los elementos del menú con clase "nav-link"
          var menuItems = document.querySelectorAll(".nav-link");
        
          // Iterar a través de cada elemento de menú y agregar un evento de clic
          menuItems.forEach(function(item) {
            var submenu = item.querySelector(".submenu");
        
            // Si el elemento de menú tiene un submenú y el evento de clic aún no se ha agregado, agregar evento de clic
            if (submenu && !item.classList.contains("has-click-event")) {
              item.addEventListener("click", function(event) {
                event.preventDefault();
                // Si el submenú está oculto, lo mostramos
                if (submenu.style.display === "none" || submenu.style.display === "") {
                  submenu.style.display = "block";
                }
                // Si el submenú está visible, lo ocultamos
                else {
                  submenu.style.display = "none";
                }
              });
              // Agregar clase al elemento del menú para indicar que se ha agregado el evento de clic
              item.classList.add("has-click-event");
            }
          });
        }

