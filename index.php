<?php

require 'vendor/autoload.php';

session_start();

use App\View;
use App\Redirect;
use App\Controller\HomeController;
use App\Controller\SignupController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    // Home page
    $r->addRoute('GET', '/', [HomeController::class, 'home']);

    // Apartments
    $r->addRoute('GET', '/post', [HomeController::class, 'add']);
    $r->addRoute('POST', '/post', [HomeController::class, 'post']);

    // Login
    $r->addRoute('GET', '/signup', [SignupController::class, 'signUp']);
    $r->addRoute('POST', '/signup', [SignupController::class, 'signUpUser']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break; if ($response instanceof Redirect) {
            header("Location: ". $response->getPath());
            exit;
        }
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";

        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        $response = (new $controller)->$method($routeInfo[2]);

        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('app/View'));

        if ($response instanceof View) {
            echo $twig->render($response->getPath() . ".html", $response->getVariables());
        }
        if ($response instanceof Redirect) {
            header("Location: ". $response->getPath());
            exit;
        }

        break;
}
