<?php
// In your helpers.php or as a separate component
use App\Models\WorkCenterSelec;

if (!function_exists('emoji_for_type')) {
    function emoji_for_type()
    {
        $emojis = ['🔍', '📌', '🏷️', '💬', '😂', '🎁', '📅', '📋️'];
        return $emojis[array_rand($emojis)];
    }
}

function get_user_config($key)
{
    if (!auth()->check()) {
        return false;
    }

    if (
        !$record = \App\Models\UserConfig::where([
            'user_id' => auth()->id(),
            'key' => $key,
        ])->first()
    ) {
        return false;
    }

    return $record;
}

function get_column_label($column)
{
    $column_label_map = [];

    //master screen - region 1
    $column_label_map['department'] = 'Department';
    $column_label_map['work_center'] = 'Work Center';
    $column_label_map['planning_queue'] = 'Planning Queue';
    $column_label_map['status'] = 'Status';
    $column_label_map['job_number'] = 'Job #';
    $column_label_map['lot_number'] = 'Lot #';
    $column_label_map['id'] = 'ID';
    $column_label_map['part_number'] = 'Part No.';
    $column_label_map['customer'] = 'Customer';
    $column_label_map['rev'] = 'Rev';
    $column_label_map['process'] = 'Process';

    $column_label_map['reqd_1_6_weeks'] = 'REQ 1-6 WEEKS';
    $column_label_map['reqd_7_12_weeks'] = 'REQ 7-12 WEEKS';
    $column_label_map['scheduled_total'] = 'SCHED`L TOTAL';
    $column_label_map['in_stock_finished'] = 'IN STOCK FINISHED';
    $column_label_map['live_inventory_finished'] = 'LIVE INVENTORY F';
    $column_label_map['live_inventory_wip'] = 'LIVE INVENTORY WIP';
    $column_label_map['in_process_out_side'] = 'IN PROCESS OUT SIDE';
    $column_label_map['on_order_raw_matl'] = 'ON ORDER RAW MAT`L';
    $column_label_map['in_stock_live'] = 'IN STOCK LIVE';
    $column_label_map['wt_pc'] = 'WT/PC';
    $column_label_map['material_sort'] = 'MATERIAL (SORT)';
    $column_label_map['wt_reqd_1_12_weeks'] = 'Wt Req`d 1-12 Weeks';
    $column_label_map['safety'] = 'SAFETY';
    $column_label_map['min_ship'] = 'Min Ship';
    $column_label_map['order_notes'] = 'Order Notes';
    $column_label_map['part_notes'] = 'Part Notes';

    return $column_label_map[$column] ?? '';
}

function master_data_editable_column_map($column)
{
    $arr = [
        'department' => 'department',
        'com' => 'work_center',
        'planning' => 'planning_queue',
        'status' => 'status',
        'job' => 'job_number',
        'lot' => 'lot_number',
        'customer' => 'customer',
        'rev' => 'rev',
        'process' => 'process',
        'in_stock_finish' => 'in_stock_finished',
        'live_inventory_finish' => 'live_inventory_finished',
        'live_inventory_wip' => 'live_inventory_wip',
        'in_process_outside' => 'in_process_out_side',
        'raw_mat' => 'on_order_raw_matl',
        'in_stock_live' => 'in_stock_live',
        'wt_pc' => 'wt_pc',
        'material' => 'material_sort',
        'safety' => 'safety',
        'min_ship' => 'min_ship',
        'order_notes' => 'order_notes',
        'part_notes' => 'part_notes',
        'future_raw' => 'future_raw',
        'price' => 'price',
        'notes' => 'notes',
    ];

    return $arr[$column] ?? '';
}
