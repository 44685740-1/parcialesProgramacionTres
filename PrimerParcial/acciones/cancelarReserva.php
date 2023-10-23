<?php
    require_once "./clases/cliente.php";
    require_once "./clases/reserva.php";

    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["IdReserva"])) {
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $idReserva = $_POST["IdReserva"];
    }

    $retornoVerificarCliente = cliente::verificarclienteId($numeroCliente);
    $retornoVerificarReserva = reserva::verificarReservaId($idReserva);
    if ($retornoVerificarCliente == true && $retornoVerificarReserva == true) {
        echo json_encode("AMBOS ENCONTRADOS<br>");
        reserva::eliminarReservaId($idReserva);
    } else {
        echo json_encode("RESERVA O CLIENTE INVALIDO");
    }
?>