<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesion</title>
</head>
<body>
    <form action="logica.php" method="post">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="Contraseña">
        <button name="enviar" value="iniSesion">ENVIAR</button>
    </form>

    <form action="index.php" method="post">
        <p>¿No tienes cuenta?</p>
        <button name="enviar" value="registro">Clic aquí</button>
    </form>
</body>
</html>