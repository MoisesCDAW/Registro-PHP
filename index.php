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
        <input type="text" name="nombre" value="<?php if (isset($_SESSION["nombre"])) {echo $_SESSION["nombre"];}?>" placeholder="Nombre">
        <input type="text" name="apellidos" value="<?php if (isset($_SESSION["apellidos"])) {echo $_SESSION["apellidos"];}?>" placeholder="Apellidos">
        <input type="text" name="email" value="<?php if (isset($_SESSION["email"])) {echo $_SESSION["email"];}?>" placeholder="email">
        <input type="date" name="fechaNac" value="<?php if (isset($_SESSION["fecha"])) {echo $_SESSION["fecha"];}?>">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="password" name="passwordReplic" placeholder="Repite la contraseña">
        <input type="file" name="fotoPerfil">
        <button name="enviar" value="registro">ENVIAR</button>
    </form>

    <?php     
        unset($_SESSION["email"]);
        unset($_SESSION["nombre"]);
        unset($_SESSION["apellidos"]);
        unset($_SESSION["email"]);
        unset($_SESSION["fecha"]);
    ?>

    <form action="iniciosesion.php" method="post">
        <p>¿Ya tienes cuenta?</p>
        <button name="enviar" value="iniSesion">Clic aquí</button>
    </form>

    <br>
    <?php
        if (isset($_SESSION["errores"])) {
            echo "<p style='font-size:18px;'>Errores detectados:</p>";
            foreach ($_SESSION["errores"] as $key) {
                echo $key."<br>";
            }
            

            unset($_SESSION["errores"]);
        } 
    ?>
</body>
</html>