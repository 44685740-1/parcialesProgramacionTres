<?php
include_once "./db/accesoDatos.php";

class cliente
{
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
    public $modalidadPago;
    public $estado;

    public function __construct()
    {
    }

    public function constructorParametros($numeroCliente, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $mail, $tipoCliente, $pais, $ciudad, $telefono, $modalidadPago, $estado)
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
        $this->modalidadPago = $modalidadPago;
        $this->estado = $estado;
    }

    public function MostarDatos()
    {
        return "Numero De Cliente {$this->numeroCliente}<br>Nombre {$this->nombre}<br>Apellido {$this->apellido}<br>Tipo Documento {$this->tipoDocumento}<br>Numero Documento {$this->numeroDocumento}<br>Mail {$this->mail}<br>Tipo Cliente {$this->tipoCliente}<br>Pais {$this->pais}<br>Ciudad {$this->ciudad}<br>Telefono {$this->telefono}<br>Modalidad De Pago {$this->modalidadPago}<br>Estado {$this->estado}";
    }

    public function InsertarCliente()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso("INSERT INTO `clientes`(`numeroCliente`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `mail`, `tipoCliente`, `pais`, `ciudad`, `telefono`, `modalidadPago`, `estado`) 
        VALUES ('$this->numeroCliente','$this->nombre','$this->apellido','$this->tipoDocumento','$this->numeroDocumento','$this->mail','$this->tipoCliente','$this->pais','$this->ciudad','$this->telefono','$this->modalidadPago','$this->estado')");
        $consulta = $objetoAccsesoDatos->RetornarConsulta();
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public function insertarClienteParametros()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `clientes`(`numeroCliente`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `mail`, `tipoCliente`, `pais`, `ciudad`, `telefono`, `modalidadPago`, `estado`) 
        VALUES (:numeroCliente,:nombre,:apellido,:tipoDocumento,:numeroDocumento,:mail,:tipoCliente,:pais,:ciudad,:telefono,:modalidadPago,:estado)");
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
        $consulta->bindValue(':modalidadPago', $this->modalidadPago, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);

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
        SET `numeroCliente`='$this->numeroCliente',`nombre`='$this->nombre',`apellido`='$this->apellido',`tipoDocumento`='$this->tipoDocumento',`numeroDocumento`='$this->numeroDocumento',`mail`='$this->mail', `tipoCliente`='$this->tipoCliente',`pais`='$this->pais',`ciudad`='$this->ciudad',`telefono`='$this->telefono',`modalidadPago`='$this->modalidadPago',`estado`='$this->estado'
        WHERE id = '$this->id'");
        $consulta = $objetoAccesoDato->RetornarConsulta();
        return $consulta->execute();
    }

    public function modificarClienteParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `clientes` 
        SET `numeroCliente`= :numeroCliente,`nombre`= :nombre,`apellido`= :apellido,`tipoDocumento`= :tipoDocumento,`numeroDocumento`= :numeroDocumento,`mail`= :mail, `tipoCliente`= :tipoCliente,`pais`= :pais,`ciudad`= :ciudad,`telefono`= :telefono,`modalidadPago`= :modalidadPago,`estado`= :estado
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
        $consulta->bindValue(':modalidadPago', $this->modalidadPago, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
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

    public static function moverCarpetaCliente($numeroCliente, $tipoCliente)
    {
        $carpeta_archivos_origen = './imagenesDeCliente/2023/';
        $carpeta_archivos_Destino = './imagenesBackupClientes/2023';
        $nombre_archivo = $numeroCliente . $tipoCliente . ".png";

        if (rename($carpeta_archivos_origen . $nombre_archivo,  $carpeta_archivos_Destino .  $nombre_archivo)) {
            return 'La imagen se movió exitosamente.';
        } else {
            return 'No se pudo mover la imagen.';
        }
    }

    public static function buscarClienteModalidadPago($modalidadPago)
    {
        
    }

    public static function buscarClienteNombreTipoCliente($nombre, $tipoCliente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes` 
        WHERE nombre = :nombre AND tipoCliente = :tipoCliente");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->execute();

        $usuarioBuscado = $consulta->fetchObject("cliente");
        return $usuarioBuscado;
    }

    public static function buscarClienteNumeroTipoCliente($numeroCliente, $tipoCliente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes` 
        WHERE numeroCliente = :numeroCliente AND tipoCliente = :tipoCliente");
        $consulta->bindValue(':numeroCliente', $numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->execute();

        $usuarioBuscado = $consulta->fetchObject("cliente");
        return $usuarioBuscado;
    }

    public static function modificarEstadoCliente($id, $estado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `clientes` SET `estado`= :estado 
        WHERE id = :id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        return $consulta->execute();
    }
}
