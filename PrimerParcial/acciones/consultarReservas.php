<?php
    require_once "./clases/reserva.php";

    $opcionListar = $_GET["listar"];
    $tipoHabitacion = $_GET["tipoHabitacion"];
        

    switch ($opcionListar) {
        case 'a':
            if (isset($_GET["fecha"])) {
                $fecha = $_GET["fecha"];
                $retorno = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion,$fecha);
                echo $retorno;
            } else {
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fechaAyer = new DateTime();
                $fechaAyer->modify("-1 days"); 
                $fechaAyerString = $fechaAyer->format("d-m-Y");   
                $retorno = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion,$fechaAyerString);
                echo $retorno;
            }
            break;
        case 'b':
            if (isset($_GET["numeroDeCliente"])) {
                $numeroDeCliente = $_GET["numeroDeCliente"];
                $reservasFiltradas = reserva::listadoReservasCliente($numeroDeCliente);
                echo $reservasFiltradas;
            }
            break;
        case 'c':
            if (isset($_GET["fechaUno"]) && isset($_GET["fechaDos"])) {
                $fechaUno = $_GET["fechaUno"];
                $fechaDos = $_GET["fechaDos"];
                $retorno = reserva::listadoReservasFecha($fechaUno,$fechaDos);
                $arrayReservasFiltradas = json_decode($retorno,true);
                usort($arrayReservasFiltradas,'compareByDate');
                echo json_encode($arrayReservasFiltradas);
            }
            break;
        case 'd':
            if (isset($_GET["tipoHabitacion"])) {
                $tipoHabitacion = $_GET["tipoHabitacion"];
                $reservasFiltradas = reserva::listadoReservasTipoHabitacion($tipoHabitacion);
                echo $reservasFiltradas;
            }
            break;
    }

    function compareByDate($a, $b) {
        $dateA = strtotime($a["fechaDeEntrada"]);
        $dateB = strtotime($b["fechaDeEntrada"]);
    
        if ($dateA == $dateB) {
            return 0;
        }
    
        return ($dateA < $dateB) ? -1 : 1;
    }
?>