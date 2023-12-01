// Inactividad del mouse
let inactivityTime = 0;
let timerInterval;

const startTimer = () => {
    setInterval(() => {
        inactivityTime += 1;
        console.log(inactivityTime);
        if (inactivityTime >= 30) {
            alert("Desconexión por inactividad");
            clearInterval(timerInterval);
        }
    }, 1000);

    return timerInterval;
}

const resetTimer = () => {
    console.log("Reseteo del invernadero");
    inactivityTime = 0;
}

document.addEventListener("mousemove", resetTimer);
document.addEventListener("mousedown", resetTimer);
document.addEventListener("keypress", resetTimer);
document.addEventListener("touchstart", resetTimer);
document.addEventListener("scroll", resetTimer);

startTimer();
