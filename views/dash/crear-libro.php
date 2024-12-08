<?php include_once __DIR__ . '/dash_header.php'; ?>

<main class="principal">
    <h2 class="titulo-seccion centrar-texto">Publicar Libro</h2>

    <p class="centrar-texto">Publicar libro para venta</p>

    <form class="formulario formulario--dash" method="POST" action="/libros/crear">

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <div class="formulario__campo">
            <label for="nombre">Nombre del Libro:</label>
            <input class="formulario__campo-input" type="text" id="nombre" name="nombre" value="<?php echo $nombre_libro; ?>">
        </div>

        <div class="formulario__campo">
            <label for="autor">Autor:</label>
            <input class="formulario__campo-input" type="text" id="autor" name="autor" value="<?php echo $autor; ?>">
        </div>

        <div class="formulario__campo">
            <label for="editorial">Editorial:</label>
            <input class="formulario__campo-input" type="text" id="editorial" name="editorial" value="<?php echo $editorial; ?>">
        </div>

        <div class="formulario__campo">
            <label for="isbn">ISBN:</label>
            <input class="formulario__campo-input" type="text" id="isbn" name="isbn" value="<?php echo $isbn; ?>">
        </div>

        <div class="formulario__campo">
            <label for="descripcion">Descripción:</label>
            <textarea class="formulario__campo-text" id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </div>

        <div class="formulario__campo">
            <label for="precio">Precio:</label>
            <input class="formulario__campo-input" type="number" id="precio" name="precio" value="<?php echo $precio; ?>">
        </div>

        <div class="formulario__campo">
            <label for="id_genero">Género:</label>
            <select class="formulario__campo-input" id="id_genero" name="id_genero">
                <?php foreach ($generos as $genero): ?>
                    <option value="<?php echo $genero->id_genero; ?>" <?php echo $id_genero == $genero->id_genero ? 'selected' : ''; ?> ><?php echo $genero->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="boton-enviar--dark" type="submit">Crear Libro</button>
    </form>
</main>

<?php include_once __DIR__ . '/dash_footer.php'; ?>