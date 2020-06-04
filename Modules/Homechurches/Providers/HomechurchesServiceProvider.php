<?php

namespace Modules\Homechurches\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Observers\FileObserver;
use Modules\Core\Observers\SlugObserver;
use Modules\Homechurches\Repositories\EloquentHomechurch;

class HomechurchesServiceProvider extends ServiceProvider
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
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        AliasLoader::getInstance()->alias(
            'Homechurches',
            'Modules\Homechurches\Facades\Facade'
        );

        /*Homechurch::observe(new SlugObserver());
        Homechurch::observe(new FileObserver());*/

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind(
			"Modules\Homechurches\Repositories\HomechurchInterface",
            "Modules\Homechurches\Repositories\EloquentHomechurch"
        );
        // $app->bind('', function (Application $app) {
        //     $repository = new EloquentHomechurch(new Homechurch);
        //     return $repository;
        // });

        $app->view->composer('homechurches::public.*', function ($view) {
            $view->page = \MyApp::getPageLinkedToModule('homechurches');
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('homechurches.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'homechurches'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/homechurches');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/homechurches';
        }, \Config::get('view.paths')), [$sourcePath]), 'homechurches');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/homechurches');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'homechurches');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'homechurches');
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
}
