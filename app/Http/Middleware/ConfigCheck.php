<?php

namespace App\Http\Middleware;

use App\Models\UserConfig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!get_user_config('master_screen_region_1_column_configuration')) {
            UserConfig::create([
                'user_id' => auth()->id(),
                'key' => 'master_screen_region_1_column_configuration',
                'value' => json_encode([
                    [
                        'column' => 'department',
                        'order' => 1,
                        'visibility' => true
                    ],
                    [
                        'column' => 'work_center',
                        'order' => 2,
                        'visibility' => true
                    ],
                    [
                        'column' => 'planning_queue',
                        'order' => 3,
                        'visibility' => true
                    ],
                    [
                        'column' => 'status',
                        'order' => 4,
                        'visibility' => true
                    ],
                    // [
                    //     'column' => 'job_number',
                    //     'order' => 5,
                    //     'visibility' => true
                    // ],
                    // [
                    //     'column' => 'lot_number',
                    //     'order' => 6,
                    //     'visibility' => true
                    // ],
                    [
                        'column' => 'ids',
                        'order' => 5,
                        'visibility' => true
                    ]
                ]),
            ]);
        }

        if (!get_user_config('master_screen_region_2_column_configuration')) {
            UserConfig::create([
                'user_id' => auth()->id(),
                'key' => 'master_screen_region_2_column_configuration',
                'value' => json_encode([
                    [
                        'column' => 'part_number',
                        'order' => 1,
                        'visibility' => true
                    ],
                    [
                        'column' => 'customer',
                        'order' => 2,
                        'visibility' => true
                    ],
                    [
                        'column' => 'rev',
                        'order' => 3,
                        'visibility' => true
                    ],
                    [
                        'column' => 'process',
                        'order' => 4,
                        'visibility' => true
                    ],
                    [
                        'column' => 'reqd_1_6_weeks',
                        'order' => 5,
                        'visibility' => true
                    ],
                    [
                        'column' => 'reqd_7_12_weeks',
                        'order' => 6,
                        'visibility' => true
                    ],
                    [
                        'column' => 'scheduled_total',
                        'order' => 7,
                        'visibility' => true
                    ],
                    [
                        'column' => 'in_stock_finished',
                        'order' => 8,
                        'visibility' => true
                    ],
                    [
                        'column' => 'live_inventory_finished',
                        'order' => 9,
                        'visibility' => true
                    ],
                    [
                        'column' => 'live_inventory_wip',
                        'order' => 10,
                        'visibility' => true
                    ],
                    [
                        'column' => 'in_process_out_side',
                        'order' => 11,
                        'visibility' => true
                    ],
                    [
                        'column' => 'on_order_raw_matl',
                        'order' => 12,
                        'visibility' => true
                    ],
                    [
                        'column' => 'in_stock_live',
                        'order' => 13,
                        'visibility' => true
                    ],
                    [
                        'column' => 'wt_pc',
                        'order' => 14,
                        'visibility' => true
                    ],
                    [
                        'column' => 'material_sort',
                        'order' => 15,
                        'visibility' => true
                    ],
                    [
                        'column' => 'wt_reqd_1_12_weeks',
                        'order' => 16,
                        'visibility' => true
                    ],
                    [
                        'column' => 'safety',
                        'order' => 17,
                        'visibility' => true
                    ],
                    [
                        'column' => 'min_ship',
                        'order' => 18,
                        'visibility' => true
                    ],
                    [
                        'column' => 'order_notes',
                        'order' => 19,
                        'visibility' => true
                    ],
                    [
                        'column' => 'part_notes',
                        'order' => 20,
                        'visibility' => true
                    ]
                ]),
            ]);
        }

        return $next($request);
    }
}
