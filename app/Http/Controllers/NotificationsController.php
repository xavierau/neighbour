<?php

namespace App\Http\Controllers;

use App\Events\Notification as Note;
use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationsController extends Controller
{
    public function getNotifications(Request $request)
    {
        $notifications = $request->user()->myNotifications();
        return response()->json(compact('notifications'));
    }

    public function acknowledge(Request $request)
    {
        $request->user()->has_notification = false;
        $request->user()->save();
    }
}
