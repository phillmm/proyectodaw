<?php include_once __DIR__ . '/../dash/dash_header.php'; ?>

<main class="principal">
    <div id="profile" class="profile">
        <section class="profile__section">
            <div class="profile__bloque-foto">
                <picture>
                    <source srcset="build/img/user.avif" type="image/avif">
                    <source srcset="build/img/user.webp" type="image/webp">
                    <img class="profile__foto" loading="lazy" src="build/img/user.png" alt="">
                </picture>
                <a href="#" class="profile__enlace">Cambiar foto</a>
            </div>
            <button id="btn-pass" class="boton-verde">Actualizar contraseña</button>
            <button class="boton-verde">Mis publicaciones</button>
            <button class="boton-verde">Mis ventas</button>
            <button class="boton-verde">Historial de compras</button>
            <button class="boton-amarillo">Eliminar cuenta</button>
        </section>
        <section class="profile__section">
            <h2 class="profile__titulo">Perfil de <?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?></h2>
            <form class="profile__formulario" method="POST">
                <input type="hidden" id="nom_ape" name="nom_ape" value="1">

                <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

                <div class="profile__formulario-campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $usuario->nombre; ?>">
                </div>
                
                <div class="profile__formulario-campo">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario->apellidos; ?>">
                </div>

                <div class="profile__formulario-campo">
                    <p class="label">Correo</p>
                    <p class="input disabled"><?php echo $usuario->email; ?></p>
                </div>

                <div class="profile__formulario-campo">
                    <p class="label">Estado cuenta</p>
                    <p class="input disabled"><?php echo ($usuario->confirmado) == '1' ? 'Activa' : 'Baja'; ?></p>
                </div>

                <input type="submit" class="boton-enviar" value="Guardar cambios">
            </form>
        </section>
    </div>
</main>

<?php include_once __DIR__ . '/../dash/dash_footer.php'; ?>