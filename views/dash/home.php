<?php include_once __DIR__ . '/dash_header.php'; ?>

<main class="principal">
    <div class="principal__hero">
        <div class="slider">
            <div class="slider-container">
                <?php foreach($heroes as $hero): ?>
                    <div class="elemento-hero">
                        <img class="principal__hero-imagen" loading="lazy" src="/build/img/hero/<?php echo $hero->foto;?>" alt="Imagen de <?php echo $hero->titulo; ?>">
            
                        <div class="principal__hero-texto">
                            <h3><?php echo $hero->titulo; ?></h3>
                            <p><?php echo $hero->descripcion; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="buscados">
        <h2>Libros más buscados</h2>
        <div class="buscados__grid">
            <div class="buscados__bloque">
                <img src="/build/img/default.jpeg" alt="" class="buscados__img">
                <h4>Título del libro</h4>
                <p class="buscados__autor">Chanchito Feliz</p>
            </div>
            <div class="buscados__bloque">
                <img src="/build/img/default.jpeg" alt="" class="buscados__img">
                <h4>Título del libro</h4>
                <p class="buscados__autor">Chanchito Feliz</p>
            </div>
            <div class="buscados__bloque">
                <img src="/build/img/default.jpeg" alt="" class="buscados__img">
                <h4>Título del libro</h4>
                <p class="buscados__autor">Chanchito Feliz</p>
            </div>
            <div class="buscados__bloque">
                <img src="/build/img/default.jpeg" alt="" class="buscados__img">
                <h4>Título del libro</h4>
                <p class="buscados__autor">Chanchito Feliz</p>
            </div>
            <div class="buscados__bloque">
                <img src="/build/img/default.jpeg" alt="" class="buscados__img">
                <h4>Título del libro</h4>
                <p class="buscados__autor">Chanchito Feliz</p>
            </div>
        </div>
    </div>

    <div class="recomendaciones">
        <h2>Recomendaciones</h2>
        <div class="recomendaciones__grid">
            <div class="recomendaciones__bloque">
                <img src="/build/img/default.jpeg" alt="" class="recomendaciones__img">
                <h4>Título del libro</h4>
                <p class="recomendaciones__autor">Chanchito Feliz</p>
            </div>
            <div class="recomendaciones__bloque">
                <img src="/build/img/default.jpeg" alt="" class="recomendaciones__img">
                <h4>Título del libro</h4>
                <p class="recomendaciones__autor">Chanchito Feliz</p>
            </div>
            <div class="recomendaciones__bloque">
                <img src="/build/img/default.jpeg" alt="" class="recomendaciones__img">
                <h4>Título del libro</h4>
                <p class="recomendaciones__autor">Chanchito Feliz</p>
            </div>
            <div class="recomendaciones__bloque">
                <img src="/build/img/default.jpeg" alt="" class="recomendaciones__img">
                <h4>Título del libro</h4>
                <p class="recomendaciones__autor">Chanchito Feliz</p>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/dash_footer.php'; ?>