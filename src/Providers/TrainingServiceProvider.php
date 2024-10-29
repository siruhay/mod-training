<?php

namespace Module\Training\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class TrainingServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views',
            'training'
        );

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            $classPolicy = str($modelClass)->before('\\Models\\') . '\\Policies\\' . str($modelClass)->after('\\Models\\') . 'Policy';

            return $classPolicy;
        });

        $this->commands($this->discoverCommands());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * The discoverCommands function
     *
     * @return array
     */
    protected function discoverCommands(): array
    {
        $commandPath = __DIR__ . '/../Commands';
        $commands = [];

        if (!$this->app->files->exists($commandPath)) {
            return $commands;
        }

        foreach($this->app->files->allFiles($commandPath) as $command) {
            $className = 'Module\\Training\\Commands\\' . str($command->getBasename())->before('.php')->toString();
            
            if (class_exists($className)) {
                array_push($commands, $className);
            }
        }

        return $commands;
    }
}