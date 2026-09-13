<?php
declare(strict_types=1);

use Fyre\Http\RequestHandler;
use Fyre\Http\ResponseEmitter;
use Fyre\Router\RouteHandler;
use Psr\Http\Message\ServerRequestInterface;

// Load application
$app = require dirname(__DIR__).'/autoload.php';

// Handle request
$handler = $app->use(RequestHandler::class, [
    'fallbackHandler' => $app->use(RouteHandler::class),
]);
$response = $app->use(ServerRequestInterface::class) |> $handler->handle(...);

// Emit response using the current request after middleware
$request = $app->use(ServerRequestInterface::class);

$app->use(ResponseEmitter::class)->emit($response, $request);

// Dispatch shutdown event
$app->dispatchEvent('Engine.shutdown', [
    'request' => $request,
    'response' => $response,
]);
