<?php

namespace Quetab\QuetabPanel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Auth;

class QuetabPanelServiceProvider extends ServiceProvider
{

    public function register(){
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'quetab');
    }

    /**
     * Bootstrap Quetab Panel application.
     */
    public function boot(): void
    {

        $configPath = $this->getConfigPath();
        $langPath = $this->getLangPath();
        $viewsPath = $this->getViewsPath();
        $version = '1.0.0';
        $package = 'quetab';

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path('quetab.php'),
            ], 'config');
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Load and publish views
        $this->loadViewsFrom($viewsPath, $package);
        $this->publishes([
            $viewsPath => $this->app->resourcePath('views/vendor/quetab'),
        ]);

        // Load and publish translations
        $this->loadTranslationsFrom($langPath, 'quetab');
        $this->publishes([
            $langPath => $this->app->langPath("vendor/$package"),
        ]);

        // Add to about
        //AboutCommand::add('Quetab Panel', fn () => ['Version' => $version]);
    }

    /**
     * Get the config path.
     *
     * @return string
     */
    private function getConfigPath(){
        return __DIR__ . '/config/quetab.php';
    }

    /**
     * Get the lang path.
     *
     * @return string
     */
    private function getLangPath(){
        return __DIR__ . '/lang';
    }   


    /**
     * 
     * Get the views path.
     * 
     * @return string
     */
    private function getViewsPath(){
        return __DIR__ . '/resources/views';
    }

}