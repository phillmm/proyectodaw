<header class="header">
    <div class="header__topbar">
        <a href="/dash/home">
            <picture>
                <source srcset="/build/img/logo.avif" type="image/avif">
                <source srcset="/build/img/logo.webp" type="image/webp">
                <img class="logo" loading="lazy" src="/build/img/logo.png" alt="">
            </picture>
        </a>
        <div class="header__busqueda">
            Aquí irá la barra de búsqueda
        </div>

        <div class="header__user">
            <p>
                Hola <a class="header__enlace" href="/perfil"><?php echo $nombre; ?></a>
            </p>
            <a href="/libros/catalogo">
                <button class="header__boton">
                    Catálogo
                </button>
            </a>
            <a href="/libros/crear">
                <button class="header__boton">
                    Publicar Libro
                </button>
            </a>
            <a href="/logout">
                <button class="header__boton">
                    Cerrar Sesión
                </button>
            </a>
        </div>
    </div>

    <?php $profile = isset($profile) ? $profile : false; ?>
    <?php if(!$profile): ?>
        <nav class="navegacion">
            <?php foreach($generos as $genero): ?>
                <a class="navegacion__enlace" href="/libros/catalogo?id=<?php echo $genero->id_genero; ?>" >
                    <?php echo $genero->nombre; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
</header>
