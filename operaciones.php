<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones</title>
</head>
<body>
    <form action="logica.php" method="post">
        <button value="eliminarCuenta" name="enviar">Eliminar Cuenta</button>
        <button value="cerrarSesion" name="enviar">Cerrar Sesión</button>
    </form>

    <?php 
        if (isset($_SESSION["email"])) {
            $datos = file_get_contents("../usuarios/".$_SESSION["email"].".json");
            $datos = json_decode($datos);
            foreach ($datos as $key => $value) {
                if ($key!="password") {
                    echo $key." : ".$value."<br>";
                }
            }
        }
    ?>
</body>
</html>