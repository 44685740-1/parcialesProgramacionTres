<?php
    require_once "./clases/reserva.php";

    if (isset($_POST["IdReserva"]) && isset($_POST["motivo"]) && isset($_POST["importe"])) {
        $numeroReserva = $_POST["IdReserva"];
        $motivo = $_POST["motivo"];
        $nuevoImporte = $_POST["importe"];
    }

    $retornoVerificarReserva = reserva::verificarReservaId($numeroReserva);
    if ($retornoVerificarReserva == true) {
        $retorno = reserva::cambiarImporteReserva($numeroReserva,$nuevoImporte);
        if ($retorno == true) {
            echo json_encode("SE MODIFICO EL IMPORTE DE LA RESERVA");
            reserva::insertarAjusteReserva($numeroReserva,$motivo,$nuevoImporte);
        } else {
            echo json_encode("NO SE PUDO MODIFICAR EL IMPORTE DE LA RESERVA");
        }
    } else {
        echo json_encode("NUMERO DE RESERVA INVALIDO");
    }


?>