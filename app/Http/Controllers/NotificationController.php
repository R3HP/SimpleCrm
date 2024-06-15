<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request){
        
        $user = Auth::user();

        $notifications = $user->unreadNotifications;

        return view('Notification.index', compact('notifications'));
    }

    public function update(DatabaseNotification $notification){
        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }

    public function destroy(){
        // $notification->markAsUnread()
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications .index');
    }


}
