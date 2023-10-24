<?php
    require_once "./clases/cliente.php";
    require_once "./clases/manejadorArchivos.php";
    require_once "archivos.php";

    if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["tipoDocumento"]) && isset($_POST["numeroDocumento"]) && isset($_POST["mail"]) && isset($_POST["tipoCliente"]) && isset($_POST["pais"]) && isset($_POST["ciudad"]) && isset($_POST["telefono"])) {
        $numeroCliente = mt_rand(100000, 999999);
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $tipoDocumento = $_POST["tipoDocumento"];
        $numeroDocumento = $_POST["numeroDocumento"];
        $mail = $_POST["mail"];
        $tipoCliente = $_POST["tipoCliente"];
        $pais = $_POST["pais"];
        $ciudad = $_POST["ciudad"];
        $telefono = $_POST["telefono"];      
    }

    $cliente = new cliente();
    $cliente->constructorParametros($numeroCliente,$nombre,$apellido,$tipoDocumento,$numeroDocumento,$mail,$tipoCliente,$pais,$ciudad,$telefono);

    $retorno = $cliente->verificarCliente($cliente);
    echo json_encode($retorno);

    if ($retorno == "CLIENTE INGRESADO") {
        $guardarImagenCliente = new guardarImagen();
        $guardarImagenCliente->guardarImagenCliente($cliente);
    }
?>