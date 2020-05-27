<?php

namespace Modules\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\View;
use Modules\App\Http\ViewComposers\AssetsComposer;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('app::layout', AssetsComposer::class);
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->registerInBackendState();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
       
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/app');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/app';
        }, \Config::get('view.paths')), [$sourcePath]), 'app');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/app');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'app');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'app');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register inBackend state to the IoC container.
     *
     * @return void
     */
    private function registerInBackendState()
    {
        if ($this->app->runningInConsole()) {
            return $this->app['inBackend'] = false;
        }
        // $index = in_array($this->app['request']->segment(1), setting('supported_locales'))
        //     ? 2
        //     : 1;

        // $this->app['inBackend'] = $this->app['request']->segment($index) === 'admin';

        $this->app['inBackend'] = $this->app['request']->segment(1) === 'admin';
    }

    /**
     * Blacklist admin routes on frontend for ziggy package.
     *
     * @return void
     */
    private function blacklistAdminRoutesOnFrontend()
    {
        if (! $this->app['inBackend'] && $this->app->configurationIsCached()) {
            $this->app['config']->set('ziggy.blacklist', ['admin.*']);
        }
    }
}
