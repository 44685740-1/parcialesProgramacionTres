<?php
require_once "manejadorArchivos.php";

class cliente
{
    public $numeroCliente;
    public $nombre;
    public $apellido;
    public $tipoDocumento;
    public $numeroDocumento;
    public $mail;
    public $tipoCliente;
    public $pais;
    public $ciudad;
    public $telefono;

    public function __construct()
    {
    }

    public function constructorParametros($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono)
    {
        $this->numeroCliente = $numeroCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
        $this->mail = $mail;
        $this->tipoCliente = $tipoCliente;
        $this->pais = $pais;
        $this->ciudad = $ciudad;
        $this->telefono = $telefono;
    }

    public function ImprimirCliente()
    {
        return "Numero De Cliente {$this->numeroCliente}<br>Nombre {$this->nombre}<br>Apellido {$this->apellido}<br>Tipo Documento {$this->tipoDocumento}<br>Numero Documento {$this->numeroDocumento}<br>Mail {$this->mail}<br>Tipo Cliente {$this->tipoCliente}<br>Pais {$this->pais}<br>Ciudad {$this->ciudad}<br>Telefono {$this->telefono}";
    }

    public function verificarCliente($cliente)
    {
        $manejadorArchivos = new ManejadorArchivos("hoteles.json");
        $data = $manejadorArchivos->leer();
        $flagEncontrado = false;
        $respuesta = "CLIENTE INGRESADO";
        foreach ($data as $index => $value) {
            if ($value["nombre"] == $cliente->nombre && $value["tipoCliente"] == $cliente->tipoCliente) {
                $data[$index]["nombre"] = "pepe";
                $respuesta = "CLIENTE MODIFICADO";
                $flagEncontrado = true;
            }
        }
        $manejadorArchivos->guardar($data);
        if ($flagEncontrado == false) {
            $nuevoCliente = ['numeroCliente' => $cliente->numeroCliente, 'nombre' => $cliente->nombre, 'apellido' => $cliente->apellido, 'tipoDocumento' => $cliente->tipoDocumento, 'numeroDocumento' => $cliente->numeroDocumento, 'mail' => $cliente->mail, 'tipoCliente' => $cliente->tipoCliente, 'pais' => $cliente->pais, 'ciudad' => $cliente->ciudad, 'telefono' => $cliente->telefono];
            $data[] = $nuevoCliente;
            $manejadorArchivos->guardar($data);
        }

        return $respuesta;
    }
}
