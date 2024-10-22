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
        <input type="text" name="nombre" style="text-transform: capitalize;" value="<?php if (isset($_SESSION["nombre"])) {echo $_SESSION["nombre"];}?>" placeholder="Nombre">
        <input type="text" name="apellidos" style="text-transform: capitalize;" value="<?php if (isset($_SESSION["apellidos"])) {echo $_SESSION["apellidos"];}?>" placeholder="Apellidos">
        <input type="text" name="email" value="<?php if (isset($_SESSION["email"])) {echo $_SESSION["email"];}?>" placeholder="email">
        Mes/Día/Año: <input type="date" name="fechaNac" value="<?php if (isset($_SESSION["fecha"])) {echo $_SESSION["fecha"];}?>">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="password" name="passwordReplic" placeholder="Repite la contraseña">
        Recom.: 200 x 200 <input type="file" name="fotoPerfil"><br><br>
        <button name="enviar" value="registro">ENVIAR</button>
    </form>

    <form action="index.php" method="post">
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