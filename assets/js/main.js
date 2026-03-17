// Menú mobile
const botonMenu   = document.getElementById('botonMenu');
const enlacesNav  = document.getElementById('enlacesNav');

if (botonMenu && enlacesNav) {
  botonMenu.addEventListener('click', () => {
    enlacesNav.classList.toggle('abierto');
  });
}