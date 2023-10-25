<?php
    require_once "./clases/cliente.php";

    if (isset($_GET["numeroCliente"]) && isset($_GET["tipoCliente"]) && isset($_GET["numeroDocumento"])) {
        $numeroCliente = $_GET["numeroCliente"];
        $tipoCliente = $_GET["tipoCliente"];
        $numeroDocumento = $_GET["numeroDocumento"];
    }

    $retorno = cliente::borrarCliente($numeroDocumento,$numeroCliente,$tipoCliente,"eliminado");

    if ($retorno == true) {
        echo "Se elimino el cliete";
    } else {
        echo "Cliente no encontrado";
    }

?>