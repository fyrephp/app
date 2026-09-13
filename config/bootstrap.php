<?php
declare(strict_types=1);

use Fyre\Core\ErrorHandler;
use Fyre\Utility\Path;

// Load environment variables
$envPath = Path::join(CONFIG, '.env');
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

    if ($env === false) {
        throw new RuntimeException('Could not parse environment file: '.$envPath);
    }

    foreach ($env as $key => $value) {
        if (getenv($key) !== false) {
            continue;
        }

        putenv($key.'='.$value);
    }
}

// Load application config
config()->load('app');

// Register error handler
app(ErrorHandler::class)->register();

// Set global defaults
config('App.defaultLocale', 'en') |> locale_set_default(...);
config('App.timezone', 'UTC') |> date_default_timezone_set(...);
config('App.charset', 'UTF-8') |> mb_internal_encoding(...);
