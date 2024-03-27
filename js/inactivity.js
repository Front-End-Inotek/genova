// Inactividad del mouse
let inactivityTime = 0;
let timerInterval;

const startTimer = () => {
    setInterval(() => {
        inactivityTime += 1;
        //console.log(inactivityTime);
        if (inactivityTime >= 600) {
            clearInterval(timerInterval);
            salirsession()
        }
    }, 1000);

    return timerInterval;
}

const resetTimer = () => {
    //console.log("Reseteo del invernadero");
    inactivityTime = 0;
}
// Salir de la session
function salirsession(){
	let usuario_id = localStorage.getItem("id");
    localStorage.removeItem('id');
    localStorage.removeItem('tocken');
    localStorage.removeItem('vista');
    localStorage.removeItem('txt_vista');
    //remover el token de la db?
    include="includes/remover_token.php?usuario="+usuario_id
    $.ajax({
        async:true,
        type: "GET",
        dataType: "HTML",
        contentType: "application/json",
        url:include,
        beforeSend:loaderbar,
        //una vez eliminado el token de la bd, se redirecciona.
        success:function(res){
            document.location.href='index.php';
        },
        //success:problemas_sistema,
        timeout:5000,
        error:function(err){
            console.error(err)
            swal("Error del servidor!", "Intenelo de nuevo o contacte con soporte tecnico", "error");
        }
    });
}

document.addEventListener("mousemove", resetTimer);
document.addEventListener("mousedown", resetTimer);
document.addEventListener("keypress", resetTimer);
document.addEventListener("touchstart", resetTimer);
document.addEventListener("scroll", resetTimer);

startTimer();
