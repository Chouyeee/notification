<?php

namespace Ichen\Notification;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mapApiRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/notification.php' => config_path('notification.php'),
                __DIR__.'/config/nexmo.php' => config_path('nexmo.php'),
            ]);
        }
    }

    protected function mapApiRoutes()
    {
        \Route::prefix('api')
            ->middleware('api')
            ->namespace(__NAMESPACE__.'\\Http\\Controllers')
            ->group(__DIR__.'/Http/routes/api.php');
    }
}
