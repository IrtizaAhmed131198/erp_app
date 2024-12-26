<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\TargetCell;
use App\Models\TargetRow;
use Carbon\Carbon;

class NotificationService
{
    public function sendNotification($userId, $type, $data, $referenceTable = null, $referenceId = null, $field = null, $old = null, $new = null)
    {
//        $target_cell_check = TargetCell::where([
//            'table' => $referenceTable,
//            'ref_id' => $referenceId,
//            'field' => $field,
//            'old' => $old,
//        ])->where('created_at', '>=', Carbon::parse(Carbon::now()->subSeconds(10)))->get();
//
//        if (count($target_cell_check)) {
//            foreach ($target_cell_check as $target_cell_record) {
//                $del_noti = $target_cell_record->notification;
//                $target_cell_record->delete();
//                $del_noti->delete();
//            }
//        }

        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'data' => json_encode($data),
            'reference_table' => $referenceTable,
            'reference_id' => $referenceId,
        ]);

        if ($type == 'add_manual_entries' && !is_null($referenceTable) && !is_null($referenceId)) {
            TargetCell::firstOrCreate([
                'notification_id' => $notification->id,
            ], [
                'table' => $referenceTable,
                'ref_id' => $referenceId,
                'field' => $field,
                'old' => $old,
                'new' => $new
            ]);
        }

        if ($type == 'create_entries' && !is_null($referenceTable) && !is_null($referenceId)) {
            TargetRow::firstOrCreate([
                'notification_id' => $notification->id,
            ], [
                'table' => $referenceTable,
                'ref_id' => $referenceId,
            ]);
        }
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }
}
