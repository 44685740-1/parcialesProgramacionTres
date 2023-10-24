<?php
    require_once "./clases/cliente.php";
    require_once "./clases/reserva.php";

    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["IdReserva"]) && isset($_POST["estado"])) {
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $idReserva = $_POST["IdReserva"];
        $nuevoEstado = $_POST["estado"];
    }

    $retornoVerificarCliente = cliente::verificarclienteId($numeroCliente);
    $retornoVerificarReserva = reserva::verificarReservaId($idReserva);
    if ($retornoVerificarCliente == true && $retornoVerificarReserva == true) {
        $retorno = reserva::cambiarEstadoReserva($idReserva,$nuevoEstado);
        if ($retorno == true) {
            echo json_encode("ESTADO DE RESERVA MODIFICADO");
        } else {
            echo json_encode("HUBO UN PROBLEMA Y NO SE PUDO MODIFICAR");
        }
    } else {
        echo json_encode("RESERVA O CLIENTE INVALIDO");
    }
?>