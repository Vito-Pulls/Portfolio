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
                <a href="/about.php" class="btn btn--primario">Sobre mí</a>
                <a href="/contacto.php" class="btn btn--secundario">Contacto</a>
            </div>
        </div>

        <div class="hero__decoracion" aria-hidden="true">
            <div class="hero__cuadricula"></div>
            <div class="hero__orbe"></div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>