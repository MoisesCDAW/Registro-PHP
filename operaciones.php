<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones</title>
</head>
<body>

    <?php 
        if (isset($_SESSION["email"])) {
            $email = $_SESSION["email"];
            $rutaFoto = "";

            if (file_exists("../../usuarios/".$email.".json")) {
                $datos = file_get_contents("../../usuarios/".$email.".json");
                $datos = json_decode($datos);
                if ($datos != null && $datos!=false) {
                    foreach ($datos as $key => $value) {
                        if ($key!="password" && $key!="rutaFoto") {
                            echo $key." : ".$value."<br>";
                        }
                        if ($key=="rutaFoto") {
                            $rutaFoto = $value;
                        }
                    }
        
                    echo "<img src='$rutaFoto' width='200px' height='200px''>";
                }
            }
            
        }
    ?>

    <br>

    <form action="logica.php" method="post">
        <button value="eliminarCuenta" name="enviar">Eliminar Cuenta</button>
        <button value="cerrarSesion" name="enviar">Cerrar Sesión</button>
    </form>
</body>
</html>