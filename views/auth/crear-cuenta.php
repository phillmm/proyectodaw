<main class="crear">
    <div class="contenedor-sm">
        
        <form action="" class="crear__formulario" method="POST">
            <h1>Crea tu cuenta</h1>

            <div class="crear__formulario__alertas">
                <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
            </div>

            <div class="crear__formulario__campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </div>

            <div class="crear__formulario__campo">
                <label for="apellidos">Apellidos</label>
                <input type="apellidos" name="apellidos" id="apellidos">
            </div>

            <div class="crear__formulario__campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="crear__formulario__campo">
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" id="pass">
            </div>

            <div class="crear__formulario__campo">
                <label for="pass2">Confirmar contraseña</label>
                <input type="password" name="pass2" id="pass2">
            </div>

            <input class="boton-enviar--dark" type="submit" value="Crear cuenta">

            <div class="acciones">
                <a class="acciones__enlace" href="/login">Iniciar sesión</a>
                <a class="acciones__enlace" href="/olvide">Recuperar contraseña</a>
            </div>

        </form>

    </div>
</main>