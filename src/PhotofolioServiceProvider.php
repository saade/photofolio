<?php

namespace SaadeMotion\Photofolio;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use SaadeMotion\Photofolio\Facades\Photofolio as PhotofolioFacade;
use SaadeMotion\Photofolio\Http\Middleware\PhotofolioAdminMiddleware;

class PhotofolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Photofolio', PhotofolioFacade::class);
        $this->app->singleton('photofolio', function () {
            return new Photofolio();
        });

        $this->registerHelpers();
        $this->registerConsoleCommands();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'photofolio');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $router->aliasMiddleware('photofolio.admin', PhotofolioAdminMiddleware::class);
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\AdminCommand::class);
    }
}
