<?php
include_once "./db/accesoDatos.php";

class reserva
{

    public $id;
    public $fechaDeEntrada;
    public $fechaDeSalida;
    public $tipoHabitacion;
    public $importeTotal;
    public $numeroCliente;
    public $tipoCliente;
    public $estado;

    public function __construct()
    {
        
    }

    public function constructorParametros($fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente, $estado)
    {
        //$this->id = $id;
        $this->fechaDeEntrada = $fechaDeEntrada;
        $this->fechaDeSalida = $fechaDeSalida;
        $this->tipoHabitacion = $tipoHabitacion;
        $this->importeTotal = $importeTotal;
        $this->numeroCliente = $numeroCliente;
        $this->tipoCliente = $tipoCliente;
        $this->estado = $estado;
    }

    public function MostarDatos()
    {
        return "Id {$this->id}<br>Fecha de Entrada {$this->fechaDeEntrada}<br>Fecha de Salida {$this->fechaDeSalida}<br>Tipo De Habitacion {$this->tipoHabitacion}<br>Importe Total {$this->importeTotal}<br>Numero De Cliente {$this->numeroCliente}<br>Tipo Cliente {$this->tipoCliente}<br>Estado {$this->estado}";
    }

    public function InsertarReserva()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso("INSERT INTO `reservas`(`fechaDeEntrada`, `fechaDeSalida`, `tipoHabitacion`, `importeTotal`, `numeroCliente`, `tipoCliente`, `estado`) 
        VALUES ((STR_TO_DATE('$this->fechaDeEntrada', '%Y-%m-%d')),(STR_TO_DATE('$this->fechaDeSalida', '%Y-%m-%d')),'$this->tipoHabitacion', '$this->importeTotal' ,'$this->numeroCliente','$this->tipoCliente','$this->estado')");
        $consulta = $objetoAccsesoDatos->RetornarConsulta();
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }


    public function insertarReservaParametros()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `reservas`(`fechaDeEntrada`, `fechaDeSalida`, `tipoHabitacion`, `importeTotal`, `numeroCliente`, `tipoCliente`, `estado`) 
        VALUES ((STR_TO_DATE(:fechaDeEntrada, '%Y-%m-%d')),(STR_TO_DATE(:fechaDeSalida, '%Y-%m-%d')),:tipoHabitacion, :importeTotalReserva ,:numeroCliente ,:tipoCliente, :estado)");
        $consulta->bindValue(':fechaDeEntrada', $this->fechaDeEntrada, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDeSalida', $this->fechaDeSalida, PDO::PARAM_STR);
        $consulta->bindValue(':tipoHabitacion', $this->tipoHabitacion, PDO::PARAM_STR);
        $consulta->bindValue(':importeTotalReserva', $this->importeTotal, PDO::PARAM_INT);
        $consulta->bindValue(':numeroCliente', $this->numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':tipoCliente', $this->tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
    }

    public static function traerTodosLasReservas()
    {
        $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccsesoDatos->RetornarConsulta("SELECT * FROM `reservas` ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
    }

    public static function TraerUnaReserva($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE id = $id");
        $consulta->execute();
        $clienteBuscado = $consulta->fetchObject("reserva");
        return $clienteBuscado;
    }

    public function modificarReserva()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `reservas` 
        SET `fechaDeEntrada`= STR_TO_DATE('$this->fechaDeEntrada', '%Y-%m-%d'),`fechaDeSalida`= STR_TO_DATE('$this->fechaDeSalida', '%Y-%m-%d'),`tipoHabitacion`='$this->tipoHabitacion',`importeTotal`= '$this->importeTotal',`numeroCliente`= '$this->numeroCliente',`tipoCliente`='$this->tipoCliente',`estado`='$this->estado'  
        WHERE id = '$this->id'");
        return $consulta->execute();
    }

    public function modificarReservaParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `reservas` 
        SET `fechaDeEntrada`= STR_TO_DATE(:fechaDeEntrada, '%Y-%m-%d'),`fechaDeSalida`= STR_TO_DATE(:fechaDeSalida, '%Y-%m-%d'),`tipoHabitacion`= :tipoHabitacion,`importeTotal`= :importeTotalReserva ,`numeroCliente`= :numeroCliente ,`tipoCliente`= :tipoCliente,`estado`= :estado  
        WHERE id = :id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaDeEntrada', $this->fechaDeEntrada, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDeSalida', $this->fechaDeSalida, PDO::PARAM_STR);
        $consulta->bindValue(':tipoHabitacion', $this->tipoHabitacion, PDO::PARAM_STR);
        $consulta->bindValue(':importeTotalReserva', $this->importeTotal, PDO::PARAM_INT);
        $consulta->bindValue(':numeroCliente', $this->numeroCliente, PDO::PARAM_INT);
        $consulta->bindValue(':tipoCliente', $this->tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        
        return $consulta->execute();
    }

    public function borrarReserva()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM `reservas` 
        WHERE id = :id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

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
        WHERE fechaDeEntrada = :fechaUno || fechaDeEntrada = :fechaDos");

        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();

        $listaReservas = $consulta->fetchAll(PDO::FETCH_CLASS, "reserva");
        return $listaReservas;
    }

    public static function listadoReservasFechaCanceladas($estado,$fechaUno, $fechaDos)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `reservas` 
        WHERE  estado = :estado AND (fechaDeEntrada = :fechaUno || fechaDeEntrada = :fechaDos)");

        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
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
}
