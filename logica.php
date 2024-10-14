<?php

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

function validarRegistro(){
    echo "<script>open('operaciones.php', '_self')</script>";
}

function validarInicioSesion(){
    echo "<script>open('operaciones.php', '_self')</script>";
}

function eliminarCuenta(){
    echo "<script>alert('Cuenta eliminada')</script>";
    echo "<script>open('index.php', '_self')</script>";
}

function cerrarSesion(){
    echo "<script>open('iniciosesion.php', '_self')</script>";
}

