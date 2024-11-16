<?php session_start();?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Registro</title>
</head>
<body>
    <div class="contenedor">
        <form action="logica.php" method="post" enctype="multipart/form-data" class="datos">

            <div>
                <span>Nombre</span>
                <input type="text" name="nombre" style="text-transform: capitalize;" value="<?php if (isset($_SESSION["nombre"])) {echo $_SESSION["nombre"];}?>">
            </div>
            
            <div>
                <span>Apellidos</span>
                <input type="text" name="apellidos" style="text-transform: capitalize;" value="<?php if (isset($_SESSION["apellidos"])) {echo $_SESSION["apellidos"];}?>">
            </div>
            
            <div>
                <span>Email</span>
                <input type="text" name="email" value="<?php if (isset($_SESSION["email"])) {echo $_SESSION["email"];}?>">
            </div>
            
            <div>
                <span>Nacimiento</span>
                <input type="date" name="fechaNac" value="<?php if (isset($_SESSION["fecha"])) {echo $_SESSION["fecha"];}?>">
            </div>
            
            <div>
                <span>Contraseña</span>
                <input type="password" name="password" >
            </div>
            
            <div>
                <span>Repítela</span>
                <input type="password" name="passwordReplic">
            </div>

            <div>
                <span>Foto de Perfil. Recom.: 200 x 200 </span>
                <input type="file" name="fotoPerfil" id="img">
            </div>

            <button name="enviar" value="registro">ENVIAR</button>
        </form>
    </div>

    <div class="cont-sec">
        <form action="index.php" method="post">
            <p>¿Ya tienes cuenta?</p>
            <button name="enviar" value="iniSesion">Click aquí</button>
        </form>

        <div class="errores">
            <?php
                if (isset($_SESSION["errores"])) {
                    echo "<p style='font-size:18px;'>Errores detectados:</p>";
                    $contador = 1;
                    foreach ($_SESSION["errores"] as $key) {
                        echo $contador . ". ".$key."<br>";
                        $contador++;
                    }
                    unset($_SESSION["errores"]);
                } 
            ?>
        </div>
    </div>

</body>
</html>