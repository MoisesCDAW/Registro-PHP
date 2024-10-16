<?php
session_start();

function inicio (){
    if (isset($_POST["enviar"])) {
        $operacion = $_POST["enviar"];
    }

    switch ($operacion) {
        case 'registro':
            validarRegistro();
            break;
        case 'iniSesion':
            validarInicioSesion();
            break;
        case 'eliminarCuenta':
            eliminarCuenta();
            break;
        case 'cerrarSesion':
            cerrarSesion();
            break;
    }
}

inicio ();

function validarDato($dato){
    $dato = trim($dato);
    $dato = stripcslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}


function validarRegistro(){
    $nombre = $apellidos = $email = $fechaNac = $password = $passwordReplic = "";
    $json = "";
    $datos = [];
    $valido = true;
    $errores = [];

    // Seguridad de datos
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $nombre = validarDato($_POST["nombre"]);
        $apellidos = validarDato($_POST["apellidos"]);
        $email = validarDato($_POST["email"]);
        $password = validarDato($_POST["password"]);
        $passwordReplic = validarDato($_POST["passwordReplic"]);

        if (isset($_POST["fechaNac"])) {
            $fechaNac = $_POST["fechaNac"];
        }
    }

    // Validación de requisitos

    // Nombre
    if (!preg_match("/^[a-zA-Z]+$/", $nombre)) {
        $nombre = "";
        $valido = false;
        array_push($errores, "El nombre no es correcto");
    }

    // Apellidos
    if (!preg_match("/^[a-zA-Z-' ]+$/", $apellidos)) {
        $apellidos = "";
        $valido = false;
        array_push($errores, "Los apellidos no son correctos");
    }

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = "";
        $valido = false;
        array_push($errores, "El email no es correcto");
    }

    // Fecha de Nacimiento
    if ($fechaNac!="") {
        // ------------- PENDIENTE ----------------
    }

    // Contraseña
    if ($password==$passwordReplic) {
        $expresion = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/";
        if (!preg_match($expresion, $password)) {
            $password = "";
            $passwordReplic = "";
            $valido = false;
            array_push($errores, "La contraseña debe cumplir los requisitos");
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT); // Encriptación
        }
    }else {
        $password = "";
        $passwordReplic = "";
        $valido = false;
        array_push($errores, "Las contraseñas tienen que ser iguales");
    }

    // Guardado de datos o muestra de errores
    if ($valido) {
        $datos = ["nombre"=>$nombre, "apellidos"=>$apellidos, "email"=>$email, "fechaNac"=>$fechaNac, 
        "password"=>$password];    

        $json = json_encode($datos);
        file_put_contents("../usuarios/".$email .".json", json_encode($datos));

        $_SESSION["email"] = $email;
        header("location: operaciones.php");
        die();
    }else {
        $_SESSION["errores"] = $errores;
        header("location: index.php");
        die();
    }

}


function validarInicioSesion(){
    $email = $password = "";
    $json = "";
    $datos = [];
    $valido = true;
    $errores = [];

    // Seguridad de datos
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $email = validarDato($_POST["email"]);
        $password = validarDato($_POST["password"]);
    }

    if (file_get_contents("../usuarios/".$email.".json")===false) {
        array_push($errores, "No existe usuario con ese email");
    }else {
        $json = file_get_contents("../usuarios/".$email.".json");
        $datos = (array) json_decode($json);
        $passwordValido = password_verify($password, $datos["password"]);

        if ($datos["email"]==$email && $passwordValido) {
            $_SESSION["email"] = $email;
        }else {
            array_push($errores, "Contraseña incorrecta");
        }
    }

    if (count($errores)>0) {
        $_SESSION["errores"] = $errores;
        header("location: iniciosesion.php");
        die();
    }else {
        header("location: operaciones.php");
        die();
    }
}

function eliminarCuenta(){
    unlink("../usuarios/".$_SESSION["email"].".json");
    header("location: index.php");
    die();
}

function cerrarSesion(){
    unset($_SESSION["email"]);
    header("location: iniciosesion.php");
    die();
}

