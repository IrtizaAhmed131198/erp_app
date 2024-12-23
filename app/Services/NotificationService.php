<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function sendNotification($userId, $type, $data, $referenceTable = null, $referenceId = null)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'data' => json_encode($data),
            'reference_table' => $referenceTable,
            'reference_id' => $referenceId,
        ]);
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }
}
