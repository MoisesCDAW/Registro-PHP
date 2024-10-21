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
        if (isset($_SESSION["cuentaBorrada"])) {
            echo "<script>alert('Cuenta borrada correctamente')</script>";
            unset($_SESSION["cuentaBorrada"]);
        }

        if (isset($_COOKIE["email"])) { // Si existe la cookie es porque el usuario decidió recordar la sesión
            $_SESSION["email"] = $_COOKIE["email"];
            header("location: operaciones.php");
            die();
        }else{
            unset($_SESSION["nombre"]);
            unset($_SESSION["apellidos"]);
            unset($_SESSION["email"]);
            unset($_SESSION["fecha"]);
        }
    ?>

    <form action="logica.php" method="post">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="Contraseña"><br><br>
        <button name="enviar" value="iniSesion">ENVIAR</button><br><br>
        <input type="checkbox" name="recordar"> Recordar en este dispositivo
    </form>

    <form action="registro.php" method="post">
        <p>¿No tienes cuenta?</p>
        <button name="enviar" value="registro">Clic aquí</button>
    </form>

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