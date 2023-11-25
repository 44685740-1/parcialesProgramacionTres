<?php
include_once "./db/accesoDatos.php";

class cliente{
    public $id;
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
        //$this->id = $id;
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

    public function MostarDatos()
    {
        return "Numero De Cliente {$this->numeroCliente}<br>Nombre {$this->nombre}<br>Apellido {$this->apellido}<br>Tipo Documento {$this->tipoDocumento}<br>Numero Documento {$this->numeroDocumento}<br>Mail {$this->mail}<br>Tipo Cliente {$this->tipoCliente}<br>Pais {$this->pais}<br>Ciudad {$this->ciudad}<br>Telefono {$this->telefono}";
    }

    public function InsertarCliente()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso("INSERT INTO `clientes`(`numeroCliente`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `mail`, `tipoCliente`, `pais`, `ciudad`, `telefono`) 
        VALUES ('$this->numeroCliente','$this->nombre','$this->apellido','$this->tipoDocumento','$this->numeroDocumento','$this->mail','$this->tipoCliente','$this->pais','$this->ciudad','$this->telefono')");
        $consulta = $objetoAccsesoDatos->RetornarConsulta();
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public function insertarClienteParametros()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `clientes`(`numeroCliente`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `mail`, `tipoCliente`, `pais`, `ciudad`, `telefono`) 
        VALUES (:numeroCliente,:nombre,:apellido,:tipoDocumento,:numeroDocumento,:mail,:tipoCliente,:pais,:ciudad,:telefono)");
        $consulta->bindValue(':numeroCliente', $this->numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':tipoDocumento', $this->tipoDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':numeroDocumento', $this->numeroDocumento, PDO::PARAM_INT);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':tipoCliente', $this->tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);
        $consulta->bindValue(':ciudad', $this->ciudad, PDO::PARAM_STR);
        $consulta->bindValue(':telefono', $this->telefono, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public static function traerTodosLosClientes()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("SELECT * FROM `clientes`");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "cliente");
    }

    public static function TraerUnUsuario($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes`
        WHERE id = $id");
        $consulta->execute();
        $clienteBuscado = $consulta->fetchObject("cliente");
        return $clienteBuscado;
    }

    public function modificarCliente()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso("UPDATE `clientes` 
        SET `numeroCliente`='$this->numeroCliente',`nombre`='$this->nombre',`apellido`='$this->apellido',`tipoDocumento`='$this->tipoDocumento',`numeroDocumento`='$this->numeroDocumento',`mail`='$this->mail', `tipoCliente`='$this->tipoCliente',`pais`='$this->pais',`ciudad`='$this->ciudad',`telefono`='$this->telefono' 
        WHERE id = '$this->id'");
        $consulta = $objetoAccesoDato->RetornarConsulta();
        return $consulta->execute();
    }

    public function modificarClienteParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `clientes` 
        SET `numeroCliente`= :numeroCliente,`nombre`= :nombre,`apellido`= :apellido,`tipoDocumento`= :tipoDocumento,`numeroDocumento`= :numeroDocumento,`mail`= :mail, `tipoCliente`= :tipoCliente,`pais`= :pais,`ciudad`= :ciudad,`telefono`= :telefono 
        WHERE id = :id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':numeroCliente', $this->numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':tipoDocumento', $this->tipoDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':numeroDocumento', $this->numeroDocumento, PDO::PARAM_INT);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':tipoCliente', $this->tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);
        $consulta->bindValue(':ciudad', $this->ciudad, PDO::PARAM_STR);
        $consulta->bindValue(':telefono', $this->telefono, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public function borrarCliente()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM `clientes` 
        WHERE id = :id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
}
?>