<?php include 'logica.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Operaciones</title>
</head>
<body>

    <div class="cuenta">
        <h2>Cuenta</h2>

        <div>
            <?php 
                $rutaFoto = "";

                $datos = read($_SESSION["email"]);

                foreach ($datos as $key => $value) {
                    if ($key!="contrasena" && $key!="rutaFoto" && $key !="id") {
                        echo ucwords($key)." : ".$value."<br>";
                    }
                    if ($key=="rutaFoto") {
                        $rutaFoto = $value;
                    }
                }

                echo "<img src='$rutaFoto' width='200px' height='200px''>";  
            ?>
        </div>

        <form action="logica.php" method="post">
            <button value="eliminarCuenta" name="enviar" onclick="return confirm('¿Estás seguro de borrar la cuenta?')">Eliminar Cuenta</button>
            <button value="cerrarSesion" name="enviar">Cerrar Sesión</button>
        </form>
    </div>

</body>
</html>