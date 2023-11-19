<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;


require_once "./models/usuario.php";
require_once "./controllers/usuarioController.php";

require_once "./models/mesa.php";
require_once "./controllers/mesaController.php";

require_once "./models/producto.php";
require_once "./controllers/productoController.php";

require_once "./models/pedido.php";
require_once "./controllers/pedidosController.php";

require_once "./middlewares/Logger.php";
require_once "./middlewares/AuthJWT.php";

require __DIR__ . '/../vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

//comando de consola para abrilo en el puerto 8080
//php -S localhost:8080 -t app


// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();


//usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->post('/crear', \usuarioController::class . ':CrearUsuario');
    $group->get('/traerTodos', \usuarioController::class . ':traerUsuarios');
    $group->get('/traerUno/{id}', \usuarioController::class . ':traerUnUsuario');
    $group->post('/modificar/{id}', \usuarioController::class . ':modificarUnUsuario');
    $group->delete('/eliminar/{id}', \usuarioController::class . ':eliminarUnUsuario');
})->add(\Logger::class . ':verificarParametrosVaciosUsuario')
->add(\AuthJWT::class . ':VerificarTokenValido'); 

//login Usuario TOKEN
$app->post('/LoggingUsuario',[\Logger::class, 'LoggearUsuario']);

//mesas
$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->post('/crear', \mesaController::class . ':CrearMesa');
    $group->get('/traerTodas', \mesaController::class . ':traerMesas');
    $group->get('/traerUna/{id}', \mesaController::class . ':traerUnaMesa');
    $group->post('/modificar/{id}', \mesaController::class . ':modificarUnaMesa');
    $group->delete('/eliminar/{id}', \mesaController::class . ':eliminarUnaMesa');
})->add(\Logger::class . ':verificarParametrosVaciosMesa')
->add(\AuthJWT::class . ':VerificarTokenValido'); 

//productos
$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->post('/crear', \productoController::class . ':CrearProducto');
    $group->get('/traerTodos', \productoController::class . ':traerProductos');
    $group->get('/traerUno/{id}', \productoController::class . ':traerUnProducto');
    $group->post('/modificar/{id}', \productoController::class . ':modificarUnProducto');
    $group->delete('/eliminar/{id}', \productoController::class . ':eliminarUnProducto');
})->add(\Logger::class . ':verificarParametrosVaciosProducto')
->add(\AuthJWT::class . ':VerificarTokenValido'); 


//pedidos 
$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->post('/crear', \pedidosController::class . ':CrearPedido');
    $group->get('/traerTodos', \pedidosController::class . ':traerPedidos');
    $group->get('/traerUno/{id}', \pedidosController::class . ':traerUnPedido');
    $group->post('/modificar/{id}', \pedidosController::class . ':modificarUnPedido');
    $group->delete('/eliminar/{id}', \pedidosController::class . ':eliminarUnPedido');
})->add(\Logger::class . ':verificarParametrosVaciosPedido') 
->add(\AuthJWT::class . ':VerificarTokenValido');

//CSV
$app->group('/CSV', function (RouteCollectorProxy $group) {
    $group->post("/cargarUsuarios", \usuarioController::class . ':CargarUsuariosCSV');
    $group->post("/descargarUsuarios", \usuarioController::class . ':DescargaUsuariosCSV');
})->add(\AuthJWT::class . ':VerificarTokenValido');

$app->run();
