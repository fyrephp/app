<?php
declare(strict_types=1);

$router->get('/', static fn(): string => view('welcome', [
    'title' => 'FyrePHP',
]), as: 'home');

// $router->discoverRoutes(['App\Controllers']);
