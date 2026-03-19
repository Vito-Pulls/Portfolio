<?php include 'includes/header.php'; ?>

<section class="about-hero">
    <div class="contenedor about-hero__contenido">

        <div class="about-hero__texto">
            <span class="etiqueta">// sobre mí</span>
            <h1><span class="acento">Víctor </span>Javier<br>Suárez <span class="acento">Acosta</span></h1>
            <p class="about-hero__rol">Desarrollador Web Junior — Fullstack</p>
        </div>

        <div class="about-hero__imagen">
            <div class="about-hero__foto-wrapper">
                <div class="about-hero__foto-placeholder">
                    <span>VS</span>
                </div>
                <div class="about-hero__foto-marco"></div>
            </div>
        </div>

    </div>
</section>

<!-- BIO -->
<section class="bio">
    <div class="contenedor bio__contenido">

        <div class="bio__bloque">
            <span class="etiqueta">// quién soy</span>
            <h2>Un poco sobre<span class="acento"> mí</span></h2>
            <div class="bio__parrafos">
                <p>
                    Soy desarrollador web con base en España, enfocado en construir
                    aplicaciones funcionales y bien estructuradas. Me muevo cómodo
                    tanto en el frontend como en el backend, con especial interés
                    en PHP y JavaScript vanilla.
                </p>
                <p>
                    Actualmente en formación continua, buscando proyectos donde
                    pueda aportar desde el primer día y seguir creciendo como profesional.
                    Me gusta el código limpio, los commits con sentido y las interfaces
                    que no necesitan manual de instrucciones.
                </p>
                <p>
                    Cuando no estoy programando, estoy aprendiendo algo nuevo
                    o rompiendo algo para entender cómo funciona.
                </p>
            </div>
        </div>

        <div class="bio__datos">
            <div class="bio__dato">
                <span class="bio__dato-clave etiqueta">ubicación</span>
                <span class="bio__dato-valor">España</span>
            </div>
            <div class="bio__dato">
                <span class="bio__dato-clave etiqueta">foco actual</span>
                <span class="bio__dato-valor">Fullstack PHP + JS</span>
            </div>
            <div class="bio__dato">
                <span class="bio__dato-clave etiqueta">idiomas</span>
                <span class="bio__dato-valor">Español · Inglés</span>
            </div>
            <a href="<?= BASE_URL ?>/contacto.php" class="btn btn--primario">Contactar</a>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>