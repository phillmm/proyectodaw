<?php
/*
    Script PHP que toma el array de alertas que entra el controlador, lo itera y muestra su contenido por pantalla
    de manera individual.
*/
    foreach($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>
            <div class="alerta <?php echo $key;?>">
                <?php echo $mensaje; ?>
            </div>
<?php
        endforeach;
    endforeach;
?>