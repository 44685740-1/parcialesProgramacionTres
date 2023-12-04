<?php

use Slim\Psr7\Response;

require_once "./models/reserva.php";
require_once "./controllers/clienteController.php";
require_once "./models/archivos.php";
require_once "./models/cliente.php";

class reservaController
{

    public function InsertarReserva($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado)
    {
        $reserva = new reserva();
        $reserva->fechaDeEntrada = $fechaDeEntrada;
        $reserva->fechaDeSalida = $fechaDeSalida;
        $reserva->tipoHabitacion = $tipoHabitacion;
        $reserva->importeTotal = $importeTotal;
        $reserva->numeroCliente = $numeroCliente;
        $reserva->tipoCliente = $tipoCliente;
        $reserva->estado = $estado;

        return $reserva->insertarReservaParametros();
    }

    public function modificarReserva($id, $fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado)
    {
        $reserva = new reserva();
        $reserva->id = $id;
        $reserva->fechaDeEntrada = $fechaDeEntrada;
        $reserva->fechaDeSalida = $fechaDeSalida;
        $reserva->tipoHabitacion = $tipoHabitacion;
        $reserva->importeTotal = $importeTotal;
        $reserva->numeroCliente = $numeroCliente;
        $reserva->tipoCliente = $tipoCliente;
        $reserva->estado = $estado;

        return $reserva->modificarReservaParametros();
    }

    public function borrarReserva($id)
    {
        $reserva = new reserva();
        $reserva->id = $id;
        return $reserva->borrarReserva();
    }

    public function listarReservas()
    {
        return reserva::traerTodosLasReservas();
    }

    //ABM directamente con las request de SLIM

    public function altaReserva($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoCliente = $data['tipoCliente'];
        $numeroCliente = $data['numeroCliente'];
        $fechaDeEntrada = $data["fechaDeEntrada"];
        $fechaDeSalida = $data["fechaDeSalida"];
        $tipoHabitacion = $data["tipoHabitacion"];
        $importeTotal = $data['importeTotalReserva'];
        $estado = $data["estado"];

        $clienteBuscado = cliente::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);

        if ($clienteBuscado != null) {
            $reserva = new reserva();
            $reserva->constructorParametros($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado);

            $reservaController = new reservaController();
            $respuesta = $reservaController->InsertarReserva($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado);

            $guardarImagenReserva = new guardarImagen();
            $respuestaGuardarImagen =  $guardarImagenReserva->guardarImagenReserva($reserva);

            $payload = json_encode(array("Respuesta_Reserva_Ingresada" => $respuesta, "respuesta_guardar_imagen_reserva" => $respuestaGuardarImagen));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respueta" => "El cliente no Existe"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoA($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoHabitacion = $data['tipoHabitacion'];

        if (isset($data["fecha"])) {
            $fecha = $data['fecha'];
            $importeTotal = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion, $fecha);

            $payload = json_encode(array("Importe Total De Reservas" => $importeTotal));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fechaAyer = new DateTime();
            $fechaAyer->modify("-1 days");
            $fechaAyerString = $fechaAyer->format("d-m-Y");

            $importeTotal = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion, $fechaAyerString);
            if ($importeTotal === null) {
                $importeTotal = 0;
            }
            $payload = json_encode(array("Importe Total De Reservas" => $importeTotal));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoB($request, $response)
    {
        $data = $request->getParsedBody();
        $numeroCliente = $data["numeroCliente"];

        $listaReservas = reserva::listadoReservasNumeroCliente($numeroCliente);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas con ese Numero de Cliente"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoD($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoHabitacion = $data["tipoHabitacion"];

        $listaReservas = reserva::listadoReservasTipoHabitacion($tipoHabitacion);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas con ese Tipo De Habitacion"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoC($request, $response)
    {
        $data = $request->getParsedBody();
        $fechaUno = $data["fechaUno"];
        $fechaDos = $data["fechaDos"];

        $listaReservas = reserva::listadoReservasFecha($fechaUno, $fechaDos);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas En este Rango de Fechas"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function cancelarReserva($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoCliente = $data["tipoCliente"];
        $numeroCliente = $data["numeroCliente"];
        $reservaId = $data["reservaId"];

        $reservaBuscada = reserva::buscarReservaId($reservaId);
        $clienteBuscado = cliente::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);
        if ($reservaBuscada != null && $clienteBuscado != null) {
            $reservaController = new reservaController();
            $respuesta = $reservaController->modificarReserva($reservaBuscada->id, $reservaBuscada->fechaDeEntrada, $reservaBuscada->fechaDeSalida, $reservaBuscada->tipoHabitacion, $reservaBuscada->importeTotal, $reservaBuscada->numeroCliente, $reservaBuscada->tipoCliente, "cancelada");

            $payload = json_encode(array("Resultado Modificar" => $respuesta));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No se encontro el cliente o la Reserva"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function ajustarReserva($request, $response)
    {
        $data = $request->getParsedBody();
        $numeroReserva = $data["numeroReserva"];
        $motivo = $data["motivo"];
        $nuevoImporte = $data["nuevoImporte"];

        $reservaBuscada = reserva::buscarReservaId($numeroReserva);

        if ($reservaBuscada != null) {
            $reservaController = new reservaController();
            $respuestaModificar = $reservaController->modificarReserva($reservaBuscada->id, $reservaBuscada->fechaDeEntrada, $reservaBuscada->fechaDeSalida, $reservaBuscada->tipoHabitacion, $nuevoImporte, $reservaBuscada->numeroCliente, $reservaBuscada->tipoCliente, "cancelada");

            $ajusteController = new ajusteController();
            $respuestaInsertarAjuste = $ajusteController->InsertarAjuste($numeroReserva, $motivo, $nuevoImporte);
            $payload = json_encode(array("Resultado Modificar" => $respuestaModificar, "Resultado Insertar Ajuste" => $respuestaInsertarAjuste));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No se encontro el Numero De Reserva"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezA($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoCliente = $data["tipoCliente"];
        $estado = $data["estado"];
        $fecha = $data["fecha"];

        $importe = reserva::acumuladorImporteCanceladaFechaTipoCliente($tipoCliente, $fecha, $estado);

        if ($importe != null) {
            $payload = json_encode(array("importe_cancelado" => $importe));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $importe = 0;
            $payload = json_encode(array("El importe Total Cancelado" => $importe));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezB($request, $response)
    {
        $data = $request->getParsedBody();
        $numeroCliente = $data["numeroCliente"];
        $estado = $data["estado"];

        $listaReservas = reserva::listadoReservasNumeroClienteCanceladas($numeroCliente, $estado);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas Canceladas con ese Numero de Cliente"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezD($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoCliente = $data["tipoCliente"];
        $estado = $data["estado"];

        $listaReservas = reserva::listadoReservasCanceladasTipoCliente($tipoCliente, $estado);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas Canceladas con ese Tipo de Cliente"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezE($request, $response)
    {
        $data = $request->getParsedBody();
        $numeroCliente = $data["numeroCliente"];

        $listaReservas = reserva::listadoReservasNumeroCliente($numeroCliente);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas Canceladas con ese Numero de Cliente"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezC($request, $response)
    {
        $data = $request->getParsedBody();
        $fechaUno = $data["fechaUno"];
        $fechaDos = $data["fechaDos"];
        $estado = $data["estado"];

        $listaReservas = reserva::listadoReservasFechaCanceladas($estado,$fechaUno,$fechaDos);

        if ($listaReservas != null) {
            $payload = json_encode($listaReservas);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "No hay Reservas Canceladas En ese Rango de Fechas"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarReservaPuntoDiezF($request, $response)
    {
        $data = $request->getParsedBody();
        $modalidadPago = $data["modalidadPago"];

        $reservas = cliente::buscarClienteModalidadPago($modalidadPago);

        $payload = json_encode($reservas);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
