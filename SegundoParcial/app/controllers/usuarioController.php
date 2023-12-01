<?php

use Slim\Psr7\Response;

require_once "./models/reserva.php";
require_once "./controllers/clienteController.php";
require_once "./models/archivos.php";
require_once "./models/cliente.php";
require_once "./models/usuario.php";

class usuarioController
{

    public function InsertarUsuario($nombre, $mail, $clave, $rol)
    {
        $usuario = new Usuario();
        $usuario->nombre = $nombre;
        $usuario->mail = $mail;
        $usuario->clave = $clave;
        $usuario->rol = $rol;

        return $usuario->insertarUsuarioParametros();
    }

    public function AltaUsuarioRequest($request, $response)
    {
        $data = $request->getParsedBody();
        $nombre = $data["nombre"];
        $mail = $data["mail"];
        $clave = $data["clave"];
        $rol = $data["rol"];

        $usurio = new usuario();
        $usurio->constructorParametros($nombre, $mail, $clave, $rol);
        $usuarioController = new usuarioController();
        $respuesta = $usuarioController->InsertarUsuario($nombre, $mail, $clave, $rol);

        $respuestaJson = json_encode(['resultado' => $respuesta]);
        $payload = json_encode($respuestaJson);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    
}
