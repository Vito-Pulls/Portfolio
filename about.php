<?php
require_once 'config/rutas.php';
$seo_titulo = 'Sobre mí — Víctor Suárez';
$seo_descripcion = 'Conoce a Víctor Javier Suárez Acosta, desarrollador web junior fullstack especializado en PHP y JavaScript.';
$seo_url = 'http://localhost' . BASE_URL . '/about.php';
include 'includes/header.php';
?>

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
<!-- SKILLS -->
<section class="skills">
    <div class="contenedor">

        <div class="seccion-header">
            <span class="etiqueta">// tecnologías</span>
            <h2>Stack <span class="acento">&</span> Skills</h2>
        </div>

        <div class="skills__grid">

            <div class="skills__grupo">
                <h3 class="skills__grupo-titulo">Frontend</h3>
                <div class="skills__lista">
                    <div class="skill-bar" data-nivel="90">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">HTML5</span>
                            <span class="skill-bar__porcentaje">90%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="85">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">CSS3</span>
                            <span class="skill-bar__porcentaje">85%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="75">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">JavaScript</span>
                            <span class="skill-bar__porcentaje">75%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="skills__grupo">
                <h3 class="skills__grupo-titulo">Backend</h3>
                <div class="skills__lista">
                    <div class="skill-bar" data-nivel="80">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">PHP</span>
                            <span class="skill-bar__porcentaje">80%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="70">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">MySQL</span>
                            <span class="skill-bar__porcentaje">70%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="55">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">Laravel</span>
                            <span class="skill-bar__porcentaje">55%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="skills__grupo">
                <h3 class="skills__grupo-titulo">Herramientas</h3>
                <div class="skills__lista">
                    <div class="skill-bar" data-nivel="80">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">Git</span>
                            <span class="skill-bar__porcentaje">80%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="60">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">Docker</span>
                            <span class="skill-bar__porcentaje">60%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                    <div class="skill-bar" data-nivel="40">
                        <div class="skill-bar__info">
                            <span class="skill-bar__nombre">Despliegue</span>
                            <span class="skill-bar__porcentaje">40%</span>
                        </div>
                        <div class="skill-bar__pista">
                            <div class="skill-bar__relleno"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>