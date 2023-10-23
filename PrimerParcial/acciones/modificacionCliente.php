<?php
require_once "./clases/cliente.php";
require_once "./clases/manejadorArchivos.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true); // Decodificar la cadena JSON a un arreglo asociativo
    if (isset($data["numeroCliente"]) && isset($data["nombre"]) && isset($data["apellido"]) && isset($data["tipoDocumento"]) && isset($data["numeroDocumento"]) && isset($data["mail"]) && isset($data["tipoCliente"]) && isset($data["pais"]) && isset($data["ciudad"]) && isset($data["telefono"])) {
        $numeroCliente = $data["numeroCliente"];
        $nombre = $data["nombre"];
        $apellido = $data["apellido"];
        $tipoDocumento = $data["tipoDocumento"];
        $numeroDocumento = $data["numeroDocumento"];
        $mail = $data["mail"];
        $tipoCliente = $data["tipoCliente"];
        $pais = $data["pais"];
        $ciudad = $data["ciudad"];
        $telefono = $data["telefono"];
    }

    $cliente = new cliente();
    $cliente->constructorParametros($numeroCliente,$nombre,$apellido,$tipoDocumento,$numeroDocumento,$mail,$tipoCliente,$pais,$ciudad,$telefono);

    $retorno = cliente::modificarCliente($cliente);
    echo json_encode($retorno);
}
