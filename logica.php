<?php
session_start();


/**
 * Comprueba que botón ha pulsado el usuario
 */
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


/**
 * Usada para sanear los datos ingresados por el usuario
 */
function validarDato($dato){
    $dato = trim($dato);
    $dato = stripcslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}


/**
 * Capitaliza el string que se le pasa como parámetro
 */
function toCapitalize($string){
    $letras = ['Á'=>'á', 'É'=>'é', 'Í'=>'í', 'Ó'=>'ó', 'Ú'=>'ú'];
    $string = mb_strtolower(strtr($string, $letras));
    $primera = mb_substr($string, 0, 1);
    $primera = mb_strtoupper($primera);

    return $primera.mb_substr($string, 1);
}


/**
 * Valida la foto subida por el usuario. Guarda un por defecto si lo anterior no se cumple
 */
function validarFoto($email){
    $rutaFinal = "img/" . $email . "." . strtolower(pathinfo($_FILES["fotoPerfil"]["name"],PATHINFO_EXTENSION));
    $tipoFoto = "";
    $valido = 1;
    $rutaFotoPorDefecto = "img/porDefecto.png";

    if ($_FILES["fotoPerfil"]["name"]!="") {

        if (getimagesize($_FILES["fotoPerfil"]["tmp_name"])==false) { // Si no se puede saber el tamaño de la imagen, no es imagen
            $valido = 0;
        }
    
        if (file_exists($rutaFinal)) {
            $valido = 0;
        }
    
        if ($_FILES["fotoPerfil"]["size"] > 10000000) { // max: 10 Megabytes
            $valido = 0;
        }
    
        $tipoFoto = $_FILES["fotoPerfil"]["type"];
        if($tipoFoto != "image/png" && $tipoFoto != "image/jpg" && $tipoFoto != "image/jpeg") {
            $valido = 0;
        }
    
        if ($valido) {
            if(!move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], $rutaFinal)){
                return $valido=0;
            }else{
                return $rutaFinal;
            }
        }else {
            return $valido;
        }
    }else{
        return $rutaFotoPorDefecto;
    }
    
}


/**
 * Valida los datos de registro que ingresa el usuario:
 * 1. Sanea los datos ingresados
 * 2. Comprueba que el nombre, apellidos, email, fechaNac y contraseña
 * 3. Tiene como complemento a las funciones validarDato() y validarFoto()
 */
function validarRegistro(){
    $nombre = $apellidos = $email = $fechaNac = $password = $passwordReplic = "";
    $datos = [];
    $valido = true;
    $errores = [];
    $yearMinimo = 1920;

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
    if (!preg_match("/^[a-zA-ZñáéíóúÑÁÉÍÓÚ]{2,14}( [a-zA-Z][a-zA-ZñáéíóúÑÁÉÍÓÚ]{2,14})?$/", $nombre)) {
        $nombre = "";
        $valido = false;
        array_push($errores, "NOMBRE: Solo letras, Max: 30 caracteres y no puede estar vacío.");
        unset($_SESSION["nombre"]);
    }else {
        $aux = explode(" ", $nombre);
        for ($i=0; $i < count($aux); $i++) { 
            $aux[$i] = toCapitalize($aux[$i]);
        }
        $nombre = implode(" ", $aux);
        $_SESSION["nombre"] = $nombre;
    }

    // Apellidos
    if (!preg_match("/^[a-zA-ZñáéíóúÑÁÉÍÓÚ]{2,14}( [a-zA-Z][a-zA-ZñáéíóúÑÁÉÍÓÚ]{3,14})?$/", $apellidos)) {
        $apellidos = "";
        $valido = false;
        array_push($errores, "APELLIDOS: Solo letras, Max: 30 caracteres y no pueden estar vacíos. Primera letra sin acento");
        unset($_SESSION["apellidos"]);
    }else {
        $aux = explode(" ", $apellidos);
        for ($i=0; $i < count($aux); $i++) { 
            $aux[$i] = toCapitalize($aux[$i]);
        }
        $apellidos = implode(" ", $aux);

        $_SESSION["apellidos"] = $apellidos;
    }

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = "";
        $valido = false;
        array_push($errores, "EMAIL: Debe tener un formato válido: nombre@dominio.extensión, no estar vacío, sin acentos ni caracteres");
        unset($_SESSION["email"]);
    }else {
        $_SESSION["email"] = $email;
    }

    // Fecha de Nacimiento
    if ($fechaNac!="") {
        $actual = date_create();
        $fechaUsuario = date_create($fechaNac);

        if ($fechaUsuario>$actual || date_format($fechaUsuario, "Y")<$yearMinimo) {
            $fechaNac = "";
            $valido = false;
            array_push($errores, "FECHA: Debe tener un max de 105 años y min la actual");
        }else{
            $_SESSION["fecha"] = $fechaNac;
        }

    }else{
        $fechaNac = "";
        $valido = false;
        array_push($errores, "FECHA: No puede estar vacía");
    }

    // Contraseña
    if ($password==$passwordReplic) {
        $expresion = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?])([A-Za-z\d$@$!%*?]|[^ ]){8,15}$/";
        if (!preg_match($expresion, $password)) {
            $password = "";
            $passwordReplic = "";
            $valido = false;
            array_push($errores, "CONTRASEÑA: Debe incluir entre 8 y 15 caracteres, al menos 1 mayús, 1 minús, 1 num, 1 caracter especial ($@$!%*?) y sin espacios");
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT); // Encriptación
        }
    }else {
        $password = "";
        $passwordReplic = "";
        $valido = false;
        array_push($errores, "CONTRASEÑA: Tienen que ser iguales");
    }


    // Guardado de datos o muestra de errores
    if (file_get_contents("../../usuarios/".$email.".json")!==false) {
        array_push($errores, "ERROR: Ese email ya está en uso");
        $_SESSION["errores"] = $errores;
        header("location: registro.php");
        die();
    }else{
        if ($valido) {

             // Imagen
            $rutaFoto = validarFoto($email);
            if ($rutaFoto===0) {
                array_push($errores, "FOTO: Inválida, solo png, jpg o jpeg y < 10 MB");
            }else {
                $_SESSION["rutaFoto"] = $rutaFoto; // Para poder borrar la foto desde logica.php
            }

            $datos = ["nombre"=>$nombre, "apellidos"=>$apellidos, "email"=>$email, "fechaNac"=>$fechaNac, 
            "password"=>$password, "rutaFoto"=>$rutaFoto];    
    
            if (file_exists("../../usuarios/")==false) {
                mkdir("../../usuarios/", 0777, true);
            }

            file_put_contents("../../usuarios/".$email .".json", json_encode($datos));
            
    
            $_SESSION["email"] = $email;
            header("location: index.php");
            die();
        }else {
            $_SESSION["errores"] = $errores;
            header("location: registro.php");
            die();
        }
    }

}


/**
 * Valida que el inicio de sesión:
 * 1. Que el email sea correcta comprobando que exista un archivo.json con ese email
 * 2. Que la contraseña sea igual a la del archivo .json de su respectivo usuario
 * 3. Tiene como complemento a la función validarDato()
 */
function validarInicioSesion(){
    $email = $password = "";
    $json = "";
    $datos = [];
    $errores = [];

    // Seguridad de datos
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $email = validarDato($_POST["email"]);
        $password = validarDato($_POST["password"]);
    }

    // Comprobación que los datos existen
    if (file_get_contents("../../usuarios/".$email.".json")===false) {
        array_push($errores, "No existe usuario con ese email");
    }else {
        $json = file_get_contents("../../usuarios/".$email.".json");
        $datos = (array) json_decode($json);
        $passwordValido = password_verify($password, $datos["password"]);

        if ($datos["email"]==$email && $passwordValido) {
            $_SESSION["email"] = $email;
        }else {
            array_push($errores, "Contraseña incorrecta");
        }
    }

    // Redirección a operaciones.php o muestra de errores
    if (count($errores)>0) {
        $_SESSION["errores"] = $errores;
        header("location: index.php");
        die();
    }else {

        // Recordar usuario
        if (isset($_POST["recordar"])) {
            setcookie("email", $email, time()+(60*60*24*30));
        }

        header("location: operaciones.php");
        die();
    }
}


/**
 * Elima la cuenta del usuario borrando la foto y su archivo .json
 */
function eliminarCuenta(){
    if ($_SESSION["rutaFoto"]!="img/porDefecto.png") {
        unlink($_SESSION["rutaFoto"]);
    }
    unlink("../../usuarios/".$_SESSION["email"].".json");
    unset($_SESSION["nombre"]);
    unset($_SESSION["apellidos"]);
    unset($_SESSION["email"]);
    unset($_SESSION["fecha"]);
    $_SESSION["cuentaBorrada"] = true;
    setcookie("email", "");
    header("location: index.php");
    die();
}


/**
 * Cierra la sesión del usuario y elimina los datos que se autocompletan en el formulario de registro
 */
function cerrarSesion(){
    setcookie("email", "");
    unset($_SESSION["nombre"]);
    unset($_SESSION["apellidos"]);
    unset($_SESSION["email"]);
    unset($_SESSION["fecha"]);
    header("location: index.php");
    die();
}

