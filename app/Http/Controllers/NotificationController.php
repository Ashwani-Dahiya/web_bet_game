<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function notifications(){
        $user_id=Auth::user()->id;
        $notifications = NotificationModel::where('user_id',$user_id)->orWhere('user_id',0)->orderby('date','desc')->get();
        return view("notification",compact('notifications'));
    }
}
