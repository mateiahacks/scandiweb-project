<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ ."/../config/DoctrineConfig.php";

// Dotenv setup
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

// Doctrine setup
$is_dev_mode = $_ENV['ENV_TYPE'] == "development";
$doctrine_config = new DoctrineConfig($is_dev_mode);
$entity_manager = $doctrine_config->getEntityManager();

// Checking for generating schemas through doctrine
if (!isset($_SERVER['REQUEST_METHOD'])) {
    return;
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    global $entity_manager;
    $r->post('/graphql', [App\Controller\GraphQL::class, App\Controller\GraphQL::handle($entity_manager)]);
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "Error 404";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "Error 405";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        echo $handler($vars);
        break;
}