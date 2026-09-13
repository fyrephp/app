<?php
declare(strict_types=1);

use Fyre\Auth\Authenticators\SessionAuthenticator;
use Fyre\Cache\Handlers\File\FileCacher;
use Fyre\DB\Handlers\Mysql\MysqlConnection;
use Fyre\Http\ClientResponse;
use Fyre\Http\Session\Handlers\FileSessionHandler;
use Fyre\Log\Handlers\FileLogger;
use Fyre\Mail\Handlers\SmtpMailer;
use Fyre\Queue\Handlers\RedisQueue;
use Fyre\Utility\Path;

return [
    'App' => [
        'baseUri' => env('BASE_URI', ''),
        'charset' => 'UTF-8',
        'debug' => filter_var(env('APP_DEBUG', '0'), FILTER_VALIDATE_BOOLEAN),
        'defaultLayout' => null,
        'defaultLocale' => 'en',
        'supportedLocales' => ['en'],
        'timezone' => 'UTC',
    ],
    'Auth' => [
        'authenticators' => [
            [
                'className' => SessionAuthenticator::class,
            ],
        ],
    ],
    'Cache' => [
        'default' => [
            'className' => FileCacher::class,
            'path' => Path::join(TMP, 'cache'),
        ],
        '_routes' => [
            'className' => FileCacher::class,
            'path' => Path::join(TMP, 'cache', 'routes'),
        ],
        '_schema' => [
            'className' => FileCacher::class,
            'path' => Path::join(TMP, 'cache', 'schema'),
        ],
        '_events' => [
            'className' => FileCacher::class,
            'path' => Path::join(TMP, 'cache', 'events'),
        ],
    ],
    'Csrf' => [
        'cookie' => [
            'secure' => filter_var(env('CSRF_COOKIE_SECURE', '1'), FILTER_VALIDATE_BOOLEAN),
        ],
        'salt' => env('CSRF_SALT'),
    ],
    'Database' => [
        'default' => [
            'className' => MysqlConnection::class,
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_NAME', ''),
            'port' => (int) env('DB_PORT', '3306'),
            'collation' => 'utf8mb4_unicode_ci',
            'charset' => 'utf8mb4',
            'log' => false,
        ],
    ],
    'Error' => [
        'level' => E_ALL,
        'log' => true,
        'renderer' => static function(Throwable $exception): ClientResponse|string {
            $contentType = request()->negotiate('content', ['text/html', 'application/json']);

            return match ($contentType) {
                'application/json' => json([
                    'message' => config('App.debug') ?
                        $exception->getMessage() :
                        'Something Went Wrong',
                ])->withStatus(500),
                default => view('error', [
                    'exception' => $exception,
                ])
            };
        },
    ],
    'Log' => [
        'default' => [
            'className' => FileLogger::class,
            'path' => LOG,
            'levels' => ['emergency', 'alert', 'critical', 'error', 'warning'],
        ],
        'queries' => [
            'className' => FileLogger::class,
            'path' => LOG,
            'file' => 'queries',
            'levels' => ['debug'],
            'scopes' => ['queries'],
        ],
    ],
    'Mail' => [
        'default' => [
            'className' => SmtpMailer::class,
            'host' => env('SMTP_HOST', ''),
            'username' => env('SMTP_USERNAME', ''),
            'password' => env('SMTP_PASSWORD', ''),
            'port' => (int) env('SMTP_PORT', '587'),
            'auth' => filter_var(env('SMTP_AUTH', '1'), FILTER_VALIDATE_BOOLEAN),
            'tls' => filter_var(env('SMTP_TLS', '1'), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
    'Queue' => [
        'default' => [
            'className' => RedisQueue::class,
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', ''),
            'port' => (int) env('REDIS_PORT', '6379'),
        ],
    ],
    'Session' => [
        'cookie' => [
            'secure' => filter_var(env('SESSION_COOKIE_SECURE', '1'), FILTER_VALIDATE_BOOLEAN),
        ],
        'handler' => [
            'className' => FileSessionHandler::class,
        ],
        'path' => Path::join(TMP, 'sessions'),
    ],
];
