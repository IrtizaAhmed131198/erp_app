<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\TargetCell;
use App\Models\TargetRow;
use App\Models\Reports;
use Carbon\Carbon;

class NotificationService
{
    public function sendNotification($userId, $type, $data, $referenceTable = null, $referenceId = null, $field = null, $old = null, $new = null, $post_type = null, $info = null, $report = 0, $referenceId2 = null)
    {
        // dd($userId, $type, $data, $referenceTable, $referenceId, $field, $old, $new, $post_type);
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'post_type' => $post_type,
            'info' => $info,
            'data' => json_encode($data),
            'reference_table' => $referenceTable,
            'reference_id' => $referenceId,
        ]);

        // dd($notification);

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

        if ($report == 1 && $field != 'active') {
            if($field == 'com'){
                $field = 'work_center';
                $referenceId = $referenceId2;
            }
            // Check if there's an existing report for the same user, entry and today
            $existingReport = Reports::where('user_id', $userId)
                ->where('entry_id', $referenceId)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($existingReport) {
                // Update the existing record
                $existingReport->{$field} = $new;
                $existingReport->save();
            } else {
                // Create a new record
                $reports = new Reports();
                $reports->user_id = $userId;
                $reports->entry_id = $referenceId;
                $reports->{$field} = $new;
                $reports->save();
            }
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
