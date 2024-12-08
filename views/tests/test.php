<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
</head>
<body style="margin: 20px;">
    <h1>Evaluación de:</h1>
    <h3>
        <ul>
            <li>Clase: <?php echo $clase ?></li>
            <li>Método: <?php echo $metodo ?></li>
        </ul>
    </h3>
    <h4>Resultado de la prueba:</h4>
    <p><?php echo $mensaje; ?></p>

    <p><strong>Alertas:</strong></p>
    <?php if (!empty($alertas)) : ?>
        <?php foreach ($alertas as $alerta) : ?>
            <?php echo implode('<br>', $alerta); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
