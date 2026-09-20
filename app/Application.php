<?php
declare(strict_types=1);

namespace App;

use Fyre\Core\Engine;
use Fyre\Http\MiddlewareQueue;
use Override;

/**
 * Configures application bootstrap and middleware.
 */
class Application extends Engine
{
    /**
     * Runs custom initialization after application bootstrap.
     */
    public function boot(): void {}

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
