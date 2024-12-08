<main class="login">
    <?php include_once __DIR__ . '/../templates/auth_cabecera.php'; ?>

        <form class="formulario" method="POST">
            <h3 class="formulario__titulo">BIENVENIDO/A</h3>

            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

            <div class="formulario__campo">
                <label for="email">Email</label>
                <input class="formulario__campo-input" type="text" name="email" id="email" value="">
            </div>

            <div class="formulario__campo">
                <label for="pass">Contraseña</label>
                <input class="formulario__campo-input" type="password" name="pass" id="pass">
            </div>

            <input class="boton-enviar" type="submit" value="Acceder">
                
            <div class="acciones">
                <a class="acciones__enlace" href="/crear-cuenta">Crear cuenta</a>
                <a class="acciones__enlace" href="/olvide">Recuperar contraseña</a>
            </div>
        </form>
    </div> <!-- Fin de contenido -->
</main>