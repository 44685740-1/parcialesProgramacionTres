<?php
    require_once "./clases/cliente.php";
    require_once "./clases/manejadorArchivos.php";
    require_once "./clases/reserva.php";
    require_once "archivos.php";
    
    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["fechaDeEntrada"]) && isset($_POST["fechaDeSalida"]) && isset($_POST["tipoHabitacion"]) && isset($_POST["importeTotalReserva"])) {
        $id = mt_rand(100000, 999999);
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $fechaDeEntrada = $_POST["fechaDeEntrada"];
        $fechaDeSalida = $_POST["fechaDeSalida"];
        $tipoHabitacion = $_POST["tipoHabitacion"];
        $importeTotalReserva = $_POST["importeTotalReserva"];
    }

    $retorno = cliente::verificarClienteIdTipo($numeroCliente,$tipoCliente);  
    if($retorno != "Tipo de cliente Incorrecto") {
        $reserva = new reserva();
        $reserva->constructorParametros($id,$fechaDeEntrada,$fechaDeSalida,$tipoHabitacion,$importeTotalReserva,$numeroCliente,$tipoCliente);
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $nuevaReserva = ['id' => $reserva->id,'fechaDeEntrada' => $reserva->fechaDeEntrada, 'fehcaDeSalida' => $reserva->fechaDeSalida, 'tipoHabitacion' => $reserva->tipoHabitacion, 'importeTotalReserva' => $reserva->importeTotal, 'numeroCliente' => $reserva->numeroCliente, 'tipoCliente' => $reserva->tipoCliente];
        $data[] = $nuevaReserva;
        $manejadorArchivos->guardar($data);
        $guardarImagen = new guardarImagen();
        $guardarImagen->guardarImagenReserva($reserva);
    } else {
        echo $retorno;
    }
?>