<?php
declare(strict_types=1);

use Fyre\Cache\CacheManager;
use Fyre\Core\ErrorHandler;
use Fyre\DB\ConnectionManager;
use Fyre\TestSuite\ConnectionHelper;
use Fyre\TestSuite\Queue\Handlers\TestQueue;

$app = require dirname(__DIR__).'/autoload.php';

config()->set('Queue.default.className', TestQueue::class);

$app->use(ConnectionManager::class) |> ConnectionHelper::addTestAliases(...);

$app->use(CacheManager::class)->disable();

$app->use(ErrorHandler::class)->unregister();
$app->use(ErrorHandler::class)->disableCli();

$app->call([$app, 'boot']);
