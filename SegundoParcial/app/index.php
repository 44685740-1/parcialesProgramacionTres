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

require_once "./middlewares/Logger.php";
require_once "./middlewares/AuthJWT.php";

// Instantiate App
$app = AppFactory::create();

//comando de consola para abrilo en el puerto 8080
//php -S localhost:8080 -t app


// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->group('/clientes', function (RouteCollectorProxy $group) {
    $group->post('/alta', \clienteController::class . ':altaCliente')->add(\AuthJWT::class . ':registrarMovimientoExitoso')
    ->add(\AuthJWT::class . ':VerificarTokenRolGerente');
    $group->post('/consultar', \clienteController::class . ':consultarCliente')->add(\AuthJWT::class . ':VerificarTokenRolClienteOrRecepcionista');
    $group->put('/modificar', \clienteController::class . ':modificarClienteRequest');
    //$group->post('/eliminar', \clienteController::class . ':eliminarClienteRequest');
    $group->put('/eliminar/{tipoCliente}/{numeroCliente}/{estado}', \clienteController::class . ':eliminarClienteRequest')->add(\AuthJWT::class . ':registrarMovimientoExitoso')
    ->add(\AuthJWT::class . ':VerificarTokenRolGerente');

})->add(\AuthJWT::class . ':registroMovimientos')
->add(\AuthJWT::class . ':VerificarTokenValido');


$app->group('/reservas', function (RouteCollectorProxy $group) {
    $group->post('/alta', \reservaController::class . ':altaReserva');
    $group->post('/consultar/a', \reservaController::class . ':consultarReservaPuntoA');
    $group->post('/consultar/b', \reservaController::class . ':consultarReservaPuntoB');
    $group->post('/consultar/c', \reservaController::class . ':consultarReservaPuntoC');
    $group->post('/consultar/d', \reservaController::class . ':consultarReservaPuntoD');
    $group->post('/cancelar', \reservaController::class . ':cancelarReserva');
    $group->post('/ajuste', \reservaController::class . ':ajustarReserva');
    $group->post('/consultar/10/a', \reservaController::class . ':consultarReservaPuntoDiezA');
    $group->post('/consultar/10/b', \reservaController::class . ':consultarReservaPuntoDiezB');
    $group->post('/consultar/10/c', \reservaController::class . ':consultarReservaPuntoDiezC');
    $group->post('/consultar/10/d', \reservaController::class . ':consultarReservaPuntoDiezD');
    $group->post('/consultar/10/e', \reservaController::class . ':consultarReservaPuntoDiezE');
    $group->post('/consultar/10/f', \reservaController::class . ':consultarReservaPuntoDiezF');
})->add(\AuthJWT::class . ':registroMovimientos')
->add(\AuthJWT::class . ':VerificarTokenValido')
->add(\AuthJWT::class . ':VerificarTokenRolClienteOrRecepcionista')
->add(\AuthJWT::class . ':registrarMovimientoExitoso');

//loggin de Usuarios TOKEN
$app->post('/LoggingUsuario',[\Logger::class, 'LoggearUsuario']);

$app->run();
