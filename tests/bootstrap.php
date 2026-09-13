<?php
declare(strict_types=1);

use Fyre\Core\ErrorHandler;

require dirname(__DIR__).'/autoload.php';

app(ErrorHandler::class)->unregister();
