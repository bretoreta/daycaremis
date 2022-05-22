<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead($notification);

        return 'Success';
    }

    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return 'Success';
    }
}
