//Generar los proximos 30 dias
const generadorDias = () => {
    const hoy = new Date();
    const diaEnMilisegundos = 24 * 60 * 60 * 1000;
  
    const siguientesDias = Array.from({ length: 30 }, (_, index) => {
      const siguienteDia = new Date(hoy.getTime() + index * diaEnMilisegundos);
  
      const options = { weekday: "long" };
      const nombreDia = new Intl.DateTimeFormat("es-ES", options).format(siguienteDia);
      const numeroDia = siguienteDia.getDate();
  
      return { nombreDia, numeroDia };
    });
  
    return siguientesDias;
};
    
  const dias = generadorDias();
  console.log(dias);