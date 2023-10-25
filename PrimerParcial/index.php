<?php
if(isset($_GET['accion'])){
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            switch ($_GET['accion']){
                case 'sesion':
                    include 'sesiones.php';
                    break;
                case 'cookies':
                    include 'cookies.php';
                    break;
                case 'json':
                    include 'json.php';
                    break;
                case 'consultarReservas':
                    include_once "./acciones/consultarReservas.php";
                    break;
                case 'consultarReserva':
                    include_once "./acciones/consultarReserva.php";
                    break;
                default:
                    echo json_encode(['error' => 'Parámetro "accion" no permitido']);
                    break;
            }
            break;
        case 'POST':
            switch ($_GET['accion']){
                case 'clienteAlta':
                    include_once './acciones/clienteAlta.php';
                    break;
                case 'consultarCliente':
                    include_once "./acciones/consultarCliente.php";
                    break;
                case 'reservaHabitacional':
                    include_once "./acciones/reservaHabitacional.php";
                    break;
                case 'cancelarReserva':
                    include_once "./acciones/cancelarReserva.php";
                    break;
                case 'ajusteReserva':
                    include_once "./acciones/ajusteReserva.php";
                    break;
                default:
                    echo json_encode(['error' => 'Parámetro "accion" no permitido']);
                    break;
            }
            break;
        default:
            echo json_encode(['error' => 'Parámetro "accion" no permitido']);
            break;
        case 'PUT':
            switch ($_GET['accion']){
                case 'modificarCliente':
                    include './acciones/modificacionCliente.php';
                    break;
                default:
                    echo json_encode(['error' => 'Parámetro "accion" no permitido']);
                    break;
            }
            break;
        case 'DELETE':
            switch ($_GET['accion']) {
                case 'borrarCliente':
                    include_once "./acciones/borrarCliente.php";
                    break;
                default:
                    echo json_encode(['error' => 'Parámetro "accion" no permitido']);
                    break;
            }
            break;
    }
} else {
    echo json_encode(['error' => 'Falta el parametro accion']);
}

?>