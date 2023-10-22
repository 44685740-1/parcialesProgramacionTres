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
                default:
                    echo json_encode(['error' => 'Parámetro "accion" no permitido']);
                    break;
            }
            break;
        case 'POST':
            switch ($_GET['accion']){
                case 'clienteAlta':
                    include './acciones/clienteAlta.php';
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
                    include './acciones/modificarCliente.php';
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