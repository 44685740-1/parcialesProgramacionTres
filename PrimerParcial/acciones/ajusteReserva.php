<?php
    require_once "./clases/reserva.php";

    if (isset($_POST["IdReserva"]) && isset($_POST["motivo"])) {
        $numeroReserva = $_POST["IdReserva"];
        $motivo = $_POST["motivo"];
    }

    $retornoVerificarReserva = reserva::verificarReservaId($numeroReserva);
    if ($retornoVerificarReserva == true) {
        echo "Encontrada";
    } else {
        echo "No esta";
    }


?>