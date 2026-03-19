<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero">
    <div class="contenedor hero__contenido">

        <div class="hero__texto">
            <span class="etiqueta">// desarrollador web junior</span>

            <h1 class="hero__titulo">
                Hola, soy<br>
                <span class="acento">Víctor Suárez</span>
            </h1>

            <p class="hero__subtitulo">
                Desarrollo interfaces y sistemas que funcionan.<br>
                Fullstack con foco en <span class="acento">PHP</span>, <span class="acento">JavaScript</span> y <span
                    class="acento">HTML/CSS</span>.
            </p>

            <div class="hero__terminal">
                <span class="hero__terminal-prompt">$&nbsp;</span>
                <span id="textoAnimado" class="hero__terminal-texto"></span>
                <span class="hero__terminal-cursor">▋</span>
            </div>

            <div class="hero__acciones">
                <a href="<?= BASE_URL ?>/about.php" class="btn btn--primario">Sobre mí</a>
                <a href="<?= BASE_URL ?>/contact.php" class="btn btn--secundario">Contacto</a>
            </div>
        </div>

        <div class="hero__decoracion" aria-hidden="true">
            <div class="hero__cuadricula"></div>
            <div class="hero__orbe"></div>
        </div>

    </div>
</section>
<!-- PROYECTOS -->
<section class="proyectos" id="proyectos">
    <div class="contenedor">

        <div class="seccion-header">
            <span class="etiqueta">// mis trabajos</span>
            <h2>Proyectos<span class="acento">.</span></h2>
            <p>Una selección de cosas que he construido.</p>
        </div>

        <div class="proyectos__grid">

            <article class="project-card project-card--destacado">
                <div class="project-card__header">
                    <span class="project-card__tipo etiqueta">fullstack</span>
                    <div class="project-card__enlaces">
                        <a href="#" aria-label="Ver código" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path
                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Ver demo" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                <polyline points="15 3 21 3 21 9" />
                                <line x1="10" y1="14" x2="21" y2="3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <h3 class="project-card__titulo">Nombre del Proyecto</h3>
                <p class="project-card__descripcion">
                    Descripción breve del proyecto. Qué problema resuelve, qué tecnologías usa y cuál fue tu rol.
                </p>
                <div class="project-card__stack">
                    <span>PHP</span>
                    <span>MySQL</span>
                    <span>JavaScript</span>
                </div>
            </article>

            <article class="project-card">
                <div class="project-card__header">
                    <span class="project-card__tipo etiqueta">frontend</span>
                    <div class="project-card__enlaces">
                        <a href="#" aria-label="Ver código" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path
                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Ver demo" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                <polyline points="15 3 21 3 21 9" />
                                <line x1="10" y1="14" x2="21" y2="3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <h3 class="project-card__titulo">Otro Proyecto</h3>
                <p class="project-card__descripcion">
                    Descripción breve del proyecto. Qué problema resuelve, qué tecnologías usa y cuál fue tu rol.
                </p>
                <div class="project-card__stack">
                    <span>HTML</span>
                    <span>CSS</span>
                    <span>JavaScript</span>
                </div>
            </article>

            <article class="project-card">
                <div class="project-card__header">
                    <span class="project-card__tipo etiqueta">backend</span>
                    <div class="project-card__enlaces">
                        <a href="#" aria-label="Ver código" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path
                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Ver demo" class="project-card__icono">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                <polyline points="15 3 21 3 21 9" />
                                <line x1="10" y1="14" x2="21" y2="3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <h3 class="project-card__titulo">Tercer Proyecto</h3>
                <p class="project-card__descripcion">
                    Descripción breve del proyecto. Qué problema resuelve, qué tecnologías usa y cuál fue tu rol.
                </p>
                <div class="project-card__stack">
                    <span>PHP</span>
                    <span>MySQL</span>
                </div>
            </article>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>