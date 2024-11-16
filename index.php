<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
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

    <div class="info">
        <h2>Creación de usuarios</h2>
        <p>Es una aplicación creada para practicar el manejo de bases de datos con PHP y que contiene lo siguiente:
            <br>1. Validaciones para los datos ingresados por el usuario
            <br>2. Gestión de imágenes como foto de perfil
            <br>3. Conexión a base de datos
        </p>
    </div>

    <div class="index">
        <form action="logica.php" method="post" class="datos d_index">

            <div>
                <span>Email</span>
                <input type="text" name="email" placeholder="email">
            </div>

            <div>
                <span>Contraseña</span>
                <input type="password" name="password" placeholder="Contraseña">
            </div>
            
            <button name="enviar" value="iniSesion">ENVIAR</button>

            <div id="recordar">
                <input type="checkbox" name="recordar">
                <span>Recordar en este dispositivo</span>
            </div>
        </form>
    </div>

    <div class="cont-sec"class="cont-sec">
        <form action="registro.php" method="post">
            <p>¿No tienes cuenta?</p>
            <button name="enviar" value="registro">Click aquí</button>
        </form>

        <div class="errores">
            <?php 
                if (isset($_SESSION["errores"])) {
                    echo "<p style='font-size:18px;'>Errores detectados:</p>";
                    foreach ($_SESSION["errores"] as $key) {
                        echo $key."<br>";
                    }
                    unset($_SESSION["errores"]);
                } 
            ?>
        </div>
    </div>
</body>
</html>