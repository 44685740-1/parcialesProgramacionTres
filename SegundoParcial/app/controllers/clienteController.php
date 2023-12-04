<?php

use Slim\Psr7\Response;

require_once "./models/cliente.php";
require_once "./models/archivos.php";

class clienteController
{
    public function InsertarCliente($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado)
    {
        $cliente = new cliente();
        $cliente->numeroCliente = $numeroCliente;
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->tipoDocumento = $tipoDocumento;
        $cliente->numeroDocumento = $numeroDocumento;
        $cliente->mail = $mail;
        $cliente->tipoCliente = $tipoCliente;
        $cliente->pais = $pais;
        $cliente->ciudad = $ciudad;
        $cliente->telefono = $telefono;
        $cliente->modalidadPago = $modalidadPago;
        $cliente->estado = $estado;

        return $cliente->insertarClienteParametros();
    }

    public function modificarCliente($id, $numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado)
    {
        $cliente = new cliente();
        $cliente->id = $id;
        $cliente->numeroCliente = $numeroCliente;
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->tipoDocumento = $tipoDocumento;
        $cliente->numeroDocumento = $numeroDocumento;
        $cliente->mail = $mail;
        $cliente->tipoCliente = $tipoCliente;
        $cliente->pais = $pais;
        $cliente->ciudad = $ciudad;
        $cliente->telefono = $telefono;
        $cliente->modalidadPago = $modalidadPago;
        $cliente->estado = $estado;

        return $cliente->modificarClienteParametros();
    }

    public function borrarCliente($id)
    {
        $cliente = new cliente();
        $cliente->id = $id;
        return $cliente->borrarCliente();
    }

    public function listarUsuarios()
    {
        return cliente::traerTodosLosClientes();
    }

    


    //ABM con los request de SLIM directamente
    public function altaCliente($request, $response)
    {
        $data = $request->getParsedBody();
        $numeroCliente = mt_rand(100000, 999999);
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $tipoDocumento = $data["tipoDocumento"];
        $numeroDocumento = $data["numeroDocumento"];
        $mail = $data["mail"];
        $tipoCliente = $data['tipoCliente'];
        $pais = $data["pais"];
        $ciudad = $data["ciudad"];
        $telefono = $data["telefono"];
        $modalidadPago = $data["modalidadPago"];
        $estado = $data["estado"];

        $clienteBuscado = cliente::buscarClienteNombreTipoCliente($nombre, $tipoCliente);

        if ($clienteBuscado != null) {
            $clienteController = new clienteController();
            $resultado = $clienteController->modificarCliente($clienteBuscado->id, $numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado);
            $payload = json_encode(array("Resultado_Modificar" => $resultado));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $cliente = new cliente();
            $cliente->constructorParametros($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado);

            $clienteController = new clienteController();
            $respuesta = $clienteController->InsertarCliente($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado);

            $guardarImagenCliente = new guardarImagen();
            $retornoGuardarImagen = $guardarImagenCliente->guardarImagenCliente($cliente);
            
            $payload = json_encode(array("ultimo_id_ingresado" => $respuesta,"Respuesta_imagen_guardada" => $retornoGuardarImagen));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarCliente($request, $response)
    {
        $data = $request->getParsedBody();
        $tipoCliente = $data["tipoCliente"];
        $numeroCliente = $data["numeroCliente"];

        $clienteBuscado = cliente::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);

        if ($clienteBuscado != null) {
            $payload = json_encode(array("Pais" => "$clienteBuscado->pais", "Ciudad" => "$clienteBuscado->ciudad", "Telefono" => "$clienteBuscado->telefono"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "Tipo Cliente Incorrecto"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function modificarClienteRequest($request, $response)
    {
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $numeroCliente = $data["numeroCliente"];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $tipoDocumento = $data["tipoDocumento"];
        $numeroDocumento = $data["numeroDocumento"];
        $mail = $data["mail"];
        $tipoCliente = $data['tipoCliente'];
        $pais = $data["pais"];
        $ciudad = $data["ciudad"];
        $telefono = $data["telefono"];
        $modalidadPago = $data["modalidadPago"];
        $estado = $data["estado"];

        $clienteBuscado = cliente::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);

        if ($clienteBuscado != null) {
            $clienteController = new clienteController();
            $resultado = $clienteController->modificarCliente($clienteBuscado->id, $numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado);
            $payload = json_encode(array("Resultado_Modificar" => $resultado));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "Tipo Cliente Incorrecto o Numero de Cliente Incorrecto"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function eliminarClienteRequest($request, $response,$args)
    {
        // $data = $request->getParsedBody();
        // $tipoCliente = $data["tipoCliente"];
        // $numeroCliente = $data["numeroCliente"];
        // $estado = $data["estado"];

        $data = $request->getQueryParams();
        $tipoCliente = $args["tipoCliente"];
        $numeroCliente = $args["numeroCliente"];
        $estado = $args["estado"];

        $clienteBuscado = cliente::buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente);

        if ($clienteBuscado != null) {
            $respuesta = cliente::modificarEstadoCliente($clienteBuscado->id, $estado);
            $resultado = cliente::moverCarpetaCliente($numeroCliente,$tipoCliente);
            
            $payload = json_encode(array("Resultado_Modificar_Estado_Cliente" => $respuesta,"Reseultado_Imagen_Movida" => $respuesta));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(array("Respuesta" => "Tipo Cliente o Numero de cliente Incorrecto"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}
