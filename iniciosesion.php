<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesion</title>
</head>
<body>

    <?php
        unset($_SESSION["email"]);
        unset($_SESSION["nombre"]);
        unset($_SESSION["apellidos"]);
        unset($_SESSION["email"]);
        unset($_SESSION["fecha"]);
    ?>

    <form action="logica.php" method="post">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="Contraseña">
        <button name="enviar" value="iniSesion">ENVIAR</button><br><br>
        <input type="checkbox" name="recordar"> Recordar en este dispositivo
    </form>

    <form action="index.php" method="post">
        <p>¿No tienes cuenta?</p>
        <button name="enviar" value="registro">Clic aquí</button>
    </form>

    <?php 
        if (isset($_SESSION["errores"])) {
            print_r($_SESSION["errores"]);
            unset($_SESSION["errores"]);
        } 
    ?>
</body>
</html>