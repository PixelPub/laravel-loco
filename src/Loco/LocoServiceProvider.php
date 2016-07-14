<?php namespace Pixelpub\Loco;

use Illuminate\Support\ServiceProvider;

/**
 * A Laravel 5's package template.
 *
 * @author: Rémi Collin 
 */
class LocoServiceProvider extends ServiceProvider {

    /**
     * This will be used to register config & view in 
     * your package namespace.
     */
    protected $packageName = 'loco';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish loco config.
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path($this->packageName.'.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/config.php', $this->packageName);

        $this->app->bind(LocoContract::class, function () {
            return new Loco(config('loco'));
        });
    }

}
