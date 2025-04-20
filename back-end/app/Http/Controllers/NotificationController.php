<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetch(Request $request)
    {
        return [
            'unread' => $request->user()->unreadNotifications->count(),
            'notifications' => $request->user()
                ->notifications()
                ->take(5)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'data' => $notification->data,
                        'created_at' => $notification->created_at->diffForHumans(),
                        'read_at' => $notification->read_at
                    ];
                })
        ];
    }

    public function markAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}