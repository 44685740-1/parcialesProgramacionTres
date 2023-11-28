<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;


require __DIR__ . '/../vendor/autoload.php';

require_once "./models/cliente.php";
require_once "./controllers/clienteController.php";

require_once "./models/reserva.php";
require_once "./controllers/reservaController.php";

require_once "./models/ajuste.php";
require_once "./controllers/ajusteController.php";


// Instantiate App
$app = AppFactory::create();

//comando de consola para abrilo en el puerto 8080
//php -S localhost:8080 -t app


// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->group('/clientes', function (RouteCollectorProxy $group) {
    $group->post('/alta', \clienteController::class . ':altaCliente');
    $group->post('/consultar', \clienteController::class . ':consultarCliente');
    $group->put('/modificar', \clienteController::class . ':modificarClienteRequest');
});

$app->group('/reservas', function (RouteCollectorProxy $group) {
    $group->post('/alta', \reservaController::class . ':altaReserva');
    $group->post('/consultar/a', \reservaController::class . ':consultarReservaPuntoA');
    $group->post('/consultar/b', \reservaController::class . ':consultarReservaPuntoB');
    $group->post('/consultar/c', \reservaController::class . ':consultarReservaPuntoC');
    $group->post('/consultar/d', \reservaController::class . ':consultarReservaPuntoD');
    $group->post('/cancelar', \reservaController::class . ':cancelarReserva');
    $group->post('/ajuste', \reservaController::class . ':ajustarReserva');
});

$app->run();
