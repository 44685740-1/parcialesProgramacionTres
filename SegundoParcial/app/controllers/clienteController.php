<?php

use Slim\Psr7\Response;

require_once "./models/cliente.php";
require_once "./models/archivos.php";

class clienteController{
    public function InsertarCliente($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono)
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

        return $cliente->insertarClienteParametros();
    }

    public function modificarCliente($id,$numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono)
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

    public static function buscarClienteNombreTipoCliente($nombre,$tipoCliente){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes` 
        WHERE nombre = :nombre AND tipoCliente = :tipoCliente");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->execute();
    
        $usuarioBuscado = $consulta->fetchObject("cliente");
        return $usuarioBuscado;
    }
    
    public static function buscarClienteNumeroTipoCliente($numeroCliente,$tipoCliente){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes` 
        WHERE numeroCliente = :numeroCliente AND tipoCliente = :tipoCliente");
        $consulta->bindValue(':numeroCliente', $numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->execute();
    
        $usuarioBuscado = $consulta->fetchObject("cliente");
        return $usuarioBuscado;
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

        $clienteBuscado = clienteController::buscarClienteNombreTipoCliente($nombre,$tipoCliente);
        
        if ($clienteBuscado != null) {
            $clienteController = new clienteController();
            $resultado = $clienteController->modificarCliente($clienteBuscado->id,$numeroCliente,$nombre,$apellido,$tipoDocumento,$numeroDocumento,$mail,$tipoCliente,$pais,$ciudad,$telefono);
            $payload = json_encode(array("Resultado Modificar" => $resultado));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $cliente = new cliente();
            $cliente->constructorParametros($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono);
    
            $clienteController = new clienteController();
            $respuesta = $clienteController->InsertarCliente($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono);

            $guardarImagenCliente = new guardarImagen();
            $guardarImagenCliente->guardarImagenCliente($cliente);
            //retorno el id del usuario Ingresado
            $respuestaJson = json_encode(['resultado' => $respuesta]);
            $payload = json_encode($respuestaJson);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function consultarCliente($request, $response){
        $data = $request->getParsedBody();
        $tipoCliente = $data["tipoCliente"];
        $numeroCliente = $data["numeroCliente"];

        $clienteBuscado = clienteController::buscarClienteNumeroTipoCliente($numeroCliente,$tipoCliente);

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
}
?>