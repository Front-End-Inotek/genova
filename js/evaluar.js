    //             Validar formulario para inicio de sesión -->
    //Obtenemos el id del boton del formulario
    if(document.getElementById('btninicio')){
        //Definimos una variable que contendra el boton del formulario de sesion
        const btnLogin=document.getElementById('btninicio');
        //Con addEventListener escuchamos la accion click y ejecutamos las sentencia
        btnLogin.addEventListener('click',(e)=>{
            //Prevenir el comportamiento por default del navegador (recargarse)
            e.preventDefault();
            //Definimos una constante que contendra id de nuestro parrafo
            let msError=document.getElementById('error-text');
            //Elimina el contenido dentro del parrafo
            msError.innerHTML="";
            //Mostrara el parrafo que defini que esta oculto
            msError.style.display="Block";
            //Obtenemos del formulario los inputs de correo y contraseña sin espacios
            correo=formLogin.email.value.trim();
            password=formLogin.pass.value.trim();
            //Validamos que los inputs no esten vacios
            if(correo=="" && password==""){
                mostrarError('Por favor ingrese su usuario/contraseña', msError);
                inputError([formLogin.email,formLogin.pass]);
                return false;
            }else{
                inputErrorRemove([formLogin.email,formLogin.pass]);
            }
    
            if(correo=="" || correo==null){
                mostrarError('Por favor ingrese su correo',msError);
                inputError([formLogin.email]);
                formLogin.email.focus();
                return false;
            }
    
            if(password=="" || password==null){
                mostrarError('Por favor ingrese su contraseña',msError);
                inputError([formLogin.pass]);
                formLogin.pass.focus();
                return false;
            }
            //enviamos el fromulario
            enviarform();
            return true;
        });
    }
    //             Se envian los datos del formulario para evaluar -->
    function enviarform(){
        console.log("conectando");
        let msError=document.getElementById('error-text');
        //Declaramos una variable que contendra nuestro formulario
        var form = document.getElementById('formLogin');
        //Declaramos una constante que contendra XMLHttpRequest(); intercambia datos detras de escena
        const xhr = new XMLHttpRequest();
        //open recive informacion son 3 parametro
        xhr.open('POST', 'includes/evaluar.php', true);
        //FormData interpretara los datos del formulario
        var formData = new FormData(form);
        //Con el evento de escuchar al recargar entrara la condicion que nos da la respuesta del servidor
        xhr.addEventListener('load', e =>{
            //Si el servidor responde 4  y esta todo ok 200
            if (e.target.readyState == 4 && e.target.status == 200) {
                console.log(e.target.response);
                //Entrara la contidicion que valida la respuesta del formulario
                if (e.target.response == 'validado') {
                    mostrarValidado('Sesión iniciada con éxito', msError);
    
                    location.href = 'inicio.php';
                }else{
                    mostrarError('Correo y/o la contraseña no son validos', msError);
                }
            }
        })
        //Enviamos nuestro la respuesta de nuestro formulario
        xhr.send(formData);
    }
        function mostrarValidado(mensaje,msError){
            //agregamos la clase active
            msError.classList.add('active');
            msError.innerHTML=  '<div class="alert alert-success" role="alert"><a class="alert-link">'+mensaje+'</a></div>';
        }
        function mostrarError(mensaje,msError){
            //agregamos la clase active
            msError.classList.add('active');
            msError.innerHTML=  '<div class="alert alert-warning" role="alert"><a class="alert-link">'+mensaje+'</a></div>';
        }
        //a esta funcion le pasamos un array
        function inputError(datos){
            for (let i = 0; i < datos.length; i++) {
                 //a cada input le agregamos una clase error
                datos[i].classList.add('input-error');
        }
        }
        //a esta funcion le pasamos un array
        function inputErrorRemove(datos){
            for (let i = 0; i < datos.length; i++) {
                 //removemos la clase
                datos[i].classList.remove('input-error');
            }
    }