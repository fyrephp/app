<?php
declare(strict_types=1);

namespace App;

use Fyre\Core\Config;
use Fyre\Core\Engine;
use Fyre\Http\MiddlewareQueue;
use Override;

/**
 * Configures application bootstrap and middleware.
 */
class Application extends Engine
{
    /**
     * Loads application functions and bootstrap code.
     *
     * @param Config $config The Config.
     */
    public function boot(Config $config): void
    {
        $config
            ->load('functions')
            ->load('bootstrap');
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function middleware(MiddlewareQueue $queue): MiddlewareQueue
    {
        return $queue
            ->add('error')
            // Optional browser middleware; configure Session, Csrf, and Auth first.
            // ->add('session')
            // ->add('csrf')
            // ->add('auth')
            ->add('router')
            ->add('bindings');
    }
}
