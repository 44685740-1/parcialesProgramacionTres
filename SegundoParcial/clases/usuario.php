<?php
include_once "../db/accesoDatos.php";
require_once "usuarioController.php";

class usuario
{
    public $id;
    public $nombre;
    public $salario;
    public $sector;

    public function __construct()
    {
        
    }

    public function constructorParametros($id, $nombre, $salario, $sector, $operacion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->salario = $salario;
        $this->sector = $sector;
    }

    public function MostrarDatos()
    {
        return "Id {$this->id}<br>Nombre {$this->nombre}<br>Salario {$this->salario}<br>Sector {$this->sector}";
    }


    public function InsertarUsusario()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `usuarios`(`nombre`, `salario`, `sector`) 
        VALUES ('$this->nombre','$this->salario','$this->sector')");
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public function insertarUsuarioParametros()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `usuarios`(`nombre`, `salario`, `sector`) 
        VALUES (:nombre,:salario,:sector,:operacion)");

        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':salario', $this->salario, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);

        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }


    public static function TraerTodosLosUsuarios()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("SELECT `id`, `nombre`, `salario`, `sector` FROM `usuarios`");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");
    }


    public static function TraerUnUsuario($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `usuarios` WHERE id = $id");
        $consulta->execute();
        $productoBuscado = $consulta->fetchObject("usuario");
        return $productoBuscado;
    }

    public function modificarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `usuarios` 
        SET `id`='$this->id',`nombre`='$this->nombre',`salario`='$this->salario',`sector`='$this->sector'
        WHERE id = '$this->id'");

        return $consulta->execute();
    }

    public function modificarUsuarioParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `usuarios` 
        SET `id`=':id',`nombre`=':nombre',`salario`=':salario',`sector`=':sector'
        WHERE id = ':id'");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':salario', $this->salario, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public function borrarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM `usuarios` 
        WHERE id = :id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

}
