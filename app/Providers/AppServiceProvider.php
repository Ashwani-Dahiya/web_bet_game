<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $active_nav = "";
        view()->share('active_nav', $active_nav);

        $notificationController = new NotificationController();

        $notification_count = $notificationController->get_notification_count();
        view()->share('notification_count', $notification_count);
    }
}

