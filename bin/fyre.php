<?php
declare(strict_types=1);

use Fyre\Console\CommandRunner;

chdir(__DIR__);

// Load application
$app = require dirname(__DIR__).'/autoload.php';

// Run command
$app
    ->use(CommandRunner::class)
    ->handle($argv ?? [])
    |> exit(...);
