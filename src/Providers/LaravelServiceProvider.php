<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) 2014-2021 Sean Tymon <tymon148@gmail.com>
 * (c) 2021 PHP Open Source Saver
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace bisual\JWTAuth\Providers;

use Laravel\Octane\Events\RequestReceived;
use Laravel\Octane\Events\TaskReceived;
use Laravel\Octane\Events\TickReceived;
use bisual\JWTAuth\Facades\JWTAuth;
use bisual\JWTAuth\Facades\JWTFactory;
use bisual\JWTAuth\Facades\JWTProvider;
use bisual\JWTAuth\Http\Parser\Cookies;
use bisual\JWTAuth\Http\Parser\RouteParams;

class LaravelServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => $this->app->configPath('jwt.php')], 'config');
        $this->mergeConfigFrom($path, 'jwt');

        $this->aliasMiddleware();

        $this->extendAuthGuard();

        $this->app['tymon.jwt.parser']->addParser([
            new RouteParams(),
            new Cookies($this->app->make('config')->get('jwt.decrypt_cookies')),
        ]);

        if (isset($_SERVER['LARAVEL_OCTANE'])) {
            $clear = function () {
                JWTAuth::clearResolvedInstances();
                JWTFactory::clearResolvedInstances();
                JWTProvider::clearResolvedInstances();
            };

            $this->app['events']->listen(RequestReceived::class, $clear);
            $this->app['events']->listen(TaskReceived::class, $clear);
            $this->app['events']->listen(TickReceived::class, $clear);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function registerStorageProvider()
    {
        $this->app->singleton('tymon.jwt.provider.storage', function ($app) {
            $instance = $this->getConfigInstance($app, 'providers.storage');

            if (method_exists($instance, 'setLaravelVersion')) {
                $instance->setLaravelVersion($this->app->version());
            }

            return $instance;
        });
    }

    /**
     * Alias the middleware.
     *
     * @return void
     */
    protected function aliasMiddleware()
    {
        $router = $this->app['router'];

        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

        foreach ($this->middlewareAliases as $alias => $middleware) {
            $router->$method($alias, $middleware);
        }
    }
}
