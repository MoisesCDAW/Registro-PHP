<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <form action="logica.php" method="post" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="apellidos" placeholder="Apellidos">
        <input type="text" name="email" placeholder="email">
        <input type="date" name="fechaNac">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="password" name="passwordReplic" placeholder="Repite la contraseña">
        <input type="file" name="fotoPerfil">
        <button name="enviar" value="registro">ENVIAR</button>
    </form>

    <form action="iniciosesion.php" method="post">
        <p>¿Ya tienes cuenta?</p>
        <button name="enviar" value="iniSesion">Clic aquí</button>
    </form>

    <?php 
        if (isset($_SESSION["errores"])) {
            print_r($_SESSION["errores"]);
            unset($_SESSION["errores"]);
        } 
    ?>
</body>
</html>