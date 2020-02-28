<?php

namespace Trisk\Glip;

use Illuminate\Support\ServiceProvider;
use Trisk\Glip\ValueObjects\PlatformConfig;
use Trisk\Glip\ValueObjects\UserCredentials;

/**
 * Class GlipApiServiceProvider
 *
 * @package Trisk\Glip
 */
class GlipApiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Methods to register.
     * @var array
     */
    protected $methods = [
        'Chat',
        'Post',
    ];

    /**
     * Default contracts namespace.
     * @var string
     */
    protected $contractsNamespace = 'Trisk\Glip\Contracts';

    /**
     * Default methods namespace.
     * @var string
     */
    protected $methodsNamespace = 'Trisk\Glip\Methods';

    /**
     * Default prefix of facade accessors.
     * @var string
     */
    protected $shortcutPrefix = 'glip.';

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('Trisk\Glip\Contracts\GlipApi', function () {
            $api = new GlipApi(new PlatformConfig(
                config('services.glip.client_id', ''),
                config('services.glip.client_secret', ''),
                config('services.glip.app_name', ''),
                config('services.glip.app_version', '')
            ));

            return $api->setUserCredentials(new UserCredentials(config('services.glip.username', ''), config('services.glip.password', '')));
        });

        $this->app->alias('Trisk\Glip\Contracts\GlipApi', 'glip.api');

        foreach ($this->methods as $method) {
            $this->registerGlipMethod($method);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['glip.api'];
    }

    /**
     * @param $name
     */
    public function registerGlipMethod($name)
    {
        $contract = str_finish($this->contractsNamespace, '\\')."Glip{$name}";
        $shortcut = $this->shortcutPrefix.snake_case($name);
        $class = str_finish($this->methodsNamespace, '\\').$name;

        $this->registerGlipSingletons($contract, $class, $shortcut);
    }

    /**
     * @param $contract
     * @param $class
     * @param $shortcut
     */
    public function registerGlipSingletons($contract, $class, $shortcut = null)
    {
        $this->app->singleton($contract, function () use ($class) {
            return new $class($this->app['glip.api'], $this->app['cache.store']);
        });

        if ($shortcut) {
            $this->app->alias($contract, $shortcut);
        }
    }
}
