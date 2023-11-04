<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;


require_once "../clases/usuario.php";
require_once "../clases/usuarioController.php";



require __DIR__ . '/../vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

//$app->setBasePath('/app');
//$app->setBasePath('C:\xampp\htdocs\slim-php-deployment\app\index.php');
//comando de consola para abrilo en el puerto 8080
//php -S localhost:8080 -t app


// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
// $app->get('[/]', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'GET', 'msg' => "Bienvenido a SlimFramework 2023"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// $app->get('/test', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'GET', 'msg' => "Bienvenido a SlimFramework 2023"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// $app->post('[/]', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'POST', 'msg' => "Bienvenido a SlimFramework 2023"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// $app->post('/test', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'POST', 'msg' => "Bienvenido a SlimFramework 2023"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });



///////////////////////////////
$app->get('[/]', function (Request $request, Response $response) {
    $usuarioController = new UsuarioController(); // Instantiate your controller
    $usuarios = $usuarioController->listarUsuarios();

    return $response->getBody()->write(json_encode($usuarios));
});


$app->run();
