<?php

function validarBotonesEnviar (){
    if (isset($_POST["enviar"])) {
        $operacion = $_POST["enviar"];
    }
}

validarDatos();