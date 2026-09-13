<?php
declare(strict_types=1);

use App\Application;
use Fyre\Core\Loader;
use Fyre\Utility\Path;

// Load Composer
$composer = require __DIR__.'/vendor/autoload.php';

// Register autoloader
$loader = (new Loader())
    ->addClassMap($composer->getClassMap())
    ->addNamespaces($composer->getPrefixesPsr4())
    ->register();

// Constants
define('ROOT', __DIR__);
define('APP', Path::join(ROOT, 'app'));
define('CONFIG', Path::join(ROOT, 'config'));
define('LANG', Path::join(ROOT, 'lang'));
define('LOG', Path::join(ROOT, 'log'));
define('TEMPLATES', Path::join(ROOT, 'templates'));
define('TMP', Path::join(ROOT, 'tmp'));

// Boot application
$app = new Application($loader);

Application::setInstance($app);

$app->call([$app, 'boot']);

return $app;
