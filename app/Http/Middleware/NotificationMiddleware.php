<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class NotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $notificationController = new NotificationController();
            $notification_count = $notificationController->get_notification_count();
            view()->share('notification_count', $notification_count);
        } else {
            view()->share('notification_count', 0);
        }

        return $next($request);
    }
}
