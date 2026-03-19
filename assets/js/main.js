document.addEventListener('DOMContentLoaded', () => {

  // Menú mobile
  const botonMenu = document.getElementById('botonMenu');
  const enlacesNav = document.getElementById('enlacesNav');

  if (botonMenu && enlacesNav) {
    botonMenu.addEventListener('click', () => {
      enlacesNav.classList.toggle('abierto');
    });
  }
  // Efecto typing hero
  const frases = [
    'php artisan make:magic',
    'git commit -m "en mi pc funciona"',
    'console.log("hola mundo")',
    'SELECT * FROM proyectos WHERE terminado = 1',
    'npm run build && rezo()',
  ];

  const elementoTexto = document.getElementById('textoAnimado');

  if (elementoTexto) {
    let indiceFrase = 0;
    let indiceLetra = 0;
    let escribiendo = true;
    let pausaFinal = false;
    let timeoutId;

    function escribir() {
      const fraseActual = frases[indiceFrase];

      if (pausaFinal) {
        pausaFinal = false;
        escribiendo = false;
      }

      if (escribiendo) {
        elementoTexto.textContent = fraseActual.slice(0, indiceLetra + 1);
        indiceLetra++;

        if (indiceLetra === fraseActual.length) {
          pausaFinal = true;
          timeoutId = setTimeout(escribir, 1800);
          return;
        }
        timeoutId = setTimeout(escribir, 70);
      } else {
        elementoTexto.textContent = fraseActual.slice(0, indiceLetra - 1);
        indiceLetra--;

        if (indiceLetra === 0) {
          escribiendo = true;
          indiceFrase = (indiceFrase + 1) % frases.length;
        }
        timeoutId = setTimeout(escribir, 35);
      }
    }
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        clearTimeout(timeoutId);
      } else {
        clearTimeout(timeoutId);
        escribir();
      }
    });
    escribir();
  }
  // Animación de entrada de cards al hacer scroll
  const cards = document.querySelectorAll('.project-card');

  if (cards.length > 0) {
    const observador = new IntersectionObserver((entradas) => {
      entradas.forEach((entrada, i) => {
        if (entrada.isIntersecting) {
          setTimeout(() => {
            entrada.target.classList.add('visible');
          }, i * 120);
          observador.unobserve(entrada.target);
        }
      });
    }, { threshold: 0.1 });

    cards.forEach(card => observador.observe(card));
  }
});