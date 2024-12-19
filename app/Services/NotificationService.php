<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function sendNotification($userId, $type, $data)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'data' => json_encode($data),
        ]);
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        $notification->update(['is_read' => true]);
    }
}
