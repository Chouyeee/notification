<?php

namespace Ichen\Notification;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/notification.php' => config_path('notification.php'),
            ]);
        }
    }
}
