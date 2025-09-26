const progreso = document.getElementById('progreso')
const porcentaje = document.getElementById('porcentaje')
let cantidad = 0

let tiempo = setInterval(() => {
    cantidad += 1
    progreso.style.width= `${cantidad}%`

    if (cantidad == 100) {
        clearInterval(tiempo)
    }
    porcentaje.textContent = `${cantidad}%`
}, 70);
