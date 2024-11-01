<?php include 'logica.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones</title>
</head>
<body>

    <?php 
        $rutaFoto = "";

        $datos = read($_SESSION["email"]);

        foreach ($datos as $key => $value) {
            if ($key!="contrasena" && $key!="rutaFoto" && $key !="id") {
                echo $key." : ".$value."<br>";
            }
            if ($key=="rutaFoto") {
                $rutaFoto = $value;
            }
        }

        echo "<img src='$rutaFoto' width='200px' height='200px''>";  
    ?>

    <br>

    <form action="logica.php" method="post">
        <button value="eliminarCuenta" name="enviar" onclick="return confirm('¿Estás seguro de borrar la cuenta?')">Eliminar Cuenta</button>
        <button value="cerrarSesion" name="enviar">Cerrar Sesión</button>
    </form>
</body>
</html>