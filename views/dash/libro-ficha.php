<?php include_once __DIR__ . '/dash_header.php'; ?>

<main class="principal">
    <div class="ficha">
        <div class="ficha__contenido">
            <h2 class="ficha__titulo"><?php echo $libro->nombre; ?></h2>
            <h4 class="ficha__autor"><?php echo $libro->autor; ?> | <span class="ficha__genero"><?php echo $libro->genero; ?></span></h4>
            <h2 class="ficha__precio">$<?php echo $libro->precio; ?> €</h2>
            <p class="ficha__descripcion"><?php echo $libro->descripcion; ?></p>
        </div>

        <div class="ficha__img">
            <img src="/build/img/default.jpeg" alt="Imagen del libro">

            <a href="" class="boton-comprar">Añadir al Carrito</a>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/dash_footer.php'; ?>