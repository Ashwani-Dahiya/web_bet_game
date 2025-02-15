<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function notifications()
{
    $user_id = Auth::id(); // Auth::user()->id की जगह Auth::id() use करें

    // ✅ सिर्फ user की notifications को seen (1) करो, लेकिन user_id = 0 को मत छेड़ो
    NotificationModel::where('user_id', $user_id)
        ->where('seen_status', 0)
        ->update(['seen_status' => 1]);

    // ✅ अब सभी notifications को लाओ (user_id = $user_id + user_id = 0)
    $notifications = NotificationModel::where(function($query) use ($user_id) {
            $query->where('user_id', $user_id)
                  ->orWhere('user_id', 0);
        })
        ->orderBy('date', 'desc')
        ->get();

    return view("notification", compact('notifications'));
}

    public function get_notification_count()
    {
        if (!Auth::check()) {
            return 0; // अगर user login नहीं है तो 0 return करें
        }

        $user_id = Auth::id();

        $notifications = NotificationModel::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->orWhere('user_id', 0);
        })
            ->where('seen_status', 0) // यह सभी records पर लागू होगा
            ->get();

        return $notifications->count();
    }

}

