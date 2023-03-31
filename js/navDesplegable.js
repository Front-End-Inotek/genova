        /********************************************************/
        /* esta es la funcion para desplegar y ocultar el navbar*/
        /********************************************************/
        /*menu_btn.addEventListener("click", () => {
        sidebar.classList.toggle("active-nav");
        container.classList.toggle("active-cont");
        });*/

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

        function boton_menu() {
        let sidebar = document.querySelector("#sidebar");
        let container = document.querySelector(".my-container");
        sidebar.classList.toggle("active-nav");
        container.classList.toggle("active-cont");
        }

        /*************************************************************/
        /* aqui termina la funcion para desplegar y ocultar el navbar*/
        /*************************************************************/

        function sub_menu(){
        /*para despleglar los sub menus*/ 

        // Obtener todos los elementos del menú con clase "nav-link"
        var menuItems = document.querySelectorAll(".nav-link");

        // Iterar a través de cada elemento de menú y agregar un evento de clic
        menuItems.forEach(function(item) {
        var submenu = item.querySelector(".submenu");

        // Si el elemento de menú tiene un submenú, agregar evento de clic
        if (submenu) {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            // Si el submenú está oculto, lo mostramos
            if (submenu.style.display === "none") {
            submenu.style.display = "block";
            }
            // Si el submenú está visible, lo ocultamos
            else {
            submenu.style.display = "none";
            }
        });
        }
        });

        }


