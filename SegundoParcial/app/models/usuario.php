<?php
include_once "./db/accesoDatos.php";

class usuario
{
    public $id;
    public $nombre;
    public $mail;
    public $clave;
    public $rol;

    public function __construct()
    {
    }

    public function constructorParametros($nombre, $mail, $clave, $rol)
    {
        $this->nombre = $nombre;
        $this->mail = $mail;
        $this->clave = $clave;
        $this->rol = $rol;
    }

    public function MostarDatos()
    {
        return "Nombre {$this->nombre}<br>Mail {$this->mail}<br>Clave {$this->clave}<br>Rol {$this->rol}";
    }

    public function InsertarUsuario()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `usuarios`(`nombre`, `mail`, `rol`, `clave`) 
        VALUES ('$this->nombre','$this->mail','$this->rol','$this->clave')");
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public function insertarUsuarioParametros()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `usuarios`(`nombre`, `mail`, `rol`, `clave`) 
        VALUES (:nombre, :mail,:rol,:clave)");

        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);

        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public static function traerUsuarioMailClaveRol($mail, $clave,$rol)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `usuarios` 
        WHERE mail = :mail AND clave = :clave AND rol = :rol ");

        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);

        $consulta->execute();
        $usuarioBuscado = $consulta->fetchObject("usuario");
        return $usuarioBuscado;
    }
}
