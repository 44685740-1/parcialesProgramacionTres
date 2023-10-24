<?php
    require_once "./clases/cliente.php";
    require_once "./clases/manejadorArchivos.php";
    require_once "./clases/reserva.php";
    require_once "archivos.php";
    
    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["fechaDeEntrada"]) && isset($_POST["fechaDeSalida"]) && isset($_POST["tipoHabitacion"]) && isset($_POST["importeTotalReserva"]) && isset($_POST["estado"])) {
        $id = mt_rand(100000, 999999);
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $fechaDeEntrada = $_POST["fechaDeEntrada"];
        $fechaDeSalida = $_POST["fechaDeSalida"];
        $tipoHabitacion = $_POST["tipoHabitacion"];
        $importeTotalReserva = $_POST["importeTotalReserva"];
        $estado = $_POST["estado"];
    }

    $retorno = cliente::verificarClienteIdTipo($numeroCliente,$tipoCliente);  
    if($retorno != "Tipo de cliente Incorrecto") {
        $reserva = new reserva();
        $reserva->constructorParametros($id,$fechaDeEntrada,$fechaDeSalida,$tipoHabitacion,$importeTotalReserva,$numeroCliente,$tipoCliente,$estado);
        $reserva->insertarReserva($reserva);
        echo "<br>SE GUARDO LA RESERVA<br>";
    } else {
        echo json_encode($retorno);
    }
?>