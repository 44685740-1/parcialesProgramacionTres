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

    public static function acumuladorImporteHabitacionFecha($tipoHabitacion, $fecha)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(importeTotal) AS totalImporte
        FROM reservas
        WHERE tipoHabitacion = :tipoHabitacion AND fechaDeEntrada = STR_TO_DATE(:fecha, '%Y-%m-%d');");

        $consulta->bindValue(':tipoHabitacion', $tipoHabitacion, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->execute();

        $importeTotal = $consulta->fetchColumn();
        return $importeTotal;
    }

    public static function acumuladorImporteCanceladaFechaTipoCliente($tipoCliente, $fecha, $estado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(importeTotal) AS totalImporte
        FROM reservas
        WHERE tipoCliente = :tipoCliente  AND estado = :estado AND fechaDeEntrada = STR_TO_DATE(:fecha, '%Y-%m-%d');");

        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();

        $importeTotal = $consulta->fetchColumn();
        return $importeTotal;
    }

    public static function listadoReservasNumeroCliente($numeroCliente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE numeroCliente = :numeroCliente ");

        $consulta->bindValue(':numeroCliente', $numeroCliente, PDO::PARAM_INT);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function listadoReservasNumeroClienteCanceladas($numeroCliente, $estado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE numeroCliente = :numeroCliente AND estado = :estado");

        $consulta->bindValue(':numeroCliente', $numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function listadoReservasCanceladasTipoCliente($tipoCliente, $estado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE tipoCliente = :tipoCliente AND estado = :estado");

        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function listadoReservasTipoHabitacion($tipoHabitacion)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE tipoHabitacion = :tipoHabitacion ");

        $consulta->bindValue(':tipoHabitacion', $tipoHabitacion, PDO::PARAM_STR);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function listadoReservasFecha($fechaUno, $fechaDos)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE fechaDeEntrada = :fechaUno || fechaDeEntrada = :fechaDos ");

        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function buscarReservaId($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE id = :id ");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $listaReservas = $consulta->fetchObject("reserva");
        return $listaReservas;
    }


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

        $clienteBuscado = clienteController::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);

        if ($clienteBuscado != null) {
            $reserva = new reserva();
            $reserva->constructorParametros($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado);

            $reservaController = new reservaController();
            $respuesta = $reservaController->InsertarReserva($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado);

            $guardarImagenReserva = new guardarImagen();
            $guardarImagenReserva->guardarImagenReserva($reserva);

            $respuestaJson = json_encode(['resultado' => $respuesta]);
            $payload = json_encode($respuestaJson);
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
            $importeTotal = reservaController::acumuladorImporteHabitacionFecha($tipoHabitacion, $fecha);

            $payload = json_encode(array("Importe Total De Reservas" => $importeTotal));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fechaAyer = new DateTime();
            $fechaAyer->modify("-1 days");
            $fechaAyerString = $fechaAyer->format("d-m-Y");

            $importeTotal = reservaController::acumuladorImporteHabitacionFecha($tipoHabitacion, $fechaAyerString);
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

        $listaReservas = reservaController::listadoReservasNumeroCliente($numeroCliente);

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

        $listaReservas = reservaController::listadoReservasTipoHabitacion($tipoHabitacion);

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

        $listaReservas = reservaController::listadoReservasFecha($fechaUno, $fechaDos);

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

        $reservaBuscada = reservaController::buscarReservaId($reservaId);
        $clienteBuscado = clienteController::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);
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

        $reservaBuscada = reservaController::buscarReservaId($numeroReserva);

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

        $importe = reservaController::acumuladorImporteCanceladaFechaTipoCliente($tipoCliente, $fecha, $estado);

        if ($importe != null) {
            $payload = json_encode(array("El importe Total Cancelado" => $importe));
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

        $listaReservas = reservaController::listadoReservasNumeroClienteCanceladas($numeroCliente, $estado);

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

        $listaReservas = reservaController::listadoReservasCanceladasTipoCliente($tipoCliente, $estado);

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

        $listaReservas = reservaController::listadoReservasNumeroCliente($numeroCliente);

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
