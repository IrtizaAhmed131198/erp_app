<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function createNotification($userId, $type, $data)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'data' => json_encode($data),
        ]);
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        $notification->update(['is_read' => true]);
    }

    public function getUnreadNotifications($userId)
    {
        return Notification::where('user_id', $userId)->where('is_read', false)->get();
    }
}
