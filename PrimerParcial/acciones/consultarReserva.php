<?php
require_once "./clases/reserva.php";

$opcionListar = $_GET["listar"];
$fecha = $_GET["fecha"];
$tipoCliente = $_GET["tipoCliente"];
$numeroCliente = $_GET["numeroCliente"];

switch ($_GET["listar"]) {
    case 'a':
        $retorno = reserva::acumuladorImporteCancelado($fecha, $tipoCliente);
        echo "El total de las reservas canceladas en la fecha {$fecha} y por el tipo de cliente {$tipoCliente} es de {$retorno}";
        break;
    case 'b':
        $retorno = reserva::listadoReservasCanceladasNumeroCliente($numeroCliente);
        echo $retorno;
        break;
    case 'c':
        # code...
        break;
    case 'd':
        $retorno = reserva::listadoReservasCanceladasTipoCliente($tipoCliente);
        echo $retorno;
        break;
    case 'e':
        $retorno = reserva::listadoReservasCancelaciones($numeroCliente);
        echo $retorno;
        break;
    case 'value':
        # code...
        break;
}
