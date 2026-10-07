<?php
declare(strict_types=1);

use Fyre\Console\CommandRunner;

chdir(__DIR__);

// Load application
$app = require dirname(__DIR__).'/autoload.php';

// Boot application
$app->call([$app, 'boot']);

// Run command
$app
    ->use(CommandRunner::class)
    ->handle($argv ?? [])
    |> exit(...);
