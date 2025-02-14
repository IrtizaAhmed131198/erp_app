@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .report_sec {
            padding: 50px 200px;
        }

        .control-table {
            overflow: auto;
        }

        .report_sec #example_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .report_sec #example2_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .report_sec #example3_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .control-table #example_wrapper {
            white-space: nowrap;
            overflow: auto;
        }

        .control-table #example2_wrapper {
            white-space: nowrap;
            overflow: auto;
        }

        .control-table #example3_wrapper {
            white-space: nowrap;
            overflow: auto;
        }
    </style>
@endsection

@section('content')
    @php
        $weeksArr = $query->weeks_months;

        if ($weeksArr) {
            $sumWeeks1To6 = array_sum([
                $weeksArr['week_1'],
                $weeksArr['week_2'],
                $weeksArr['week_3'],
                $weeksArr['week_4'],
                $weeksArr['week_5'],
                $weeksArr['week_6'],
            ]);

            $sumWeeks7To12 = array_sum([
                $weeksArr['week_7'],
                $weeksArr['week_8'],
                $weeksArr['week_9'],
                $weeksArr['week_10'],
                $weeksArr['week_11'],
                $weeksArr['week_12'],
            ]);
        } else {
            $sumWeeks1To6 = $sumWeeks7To12 = 0;
        }

        $in_stock_finish = $query->in_stock_finish ?? 0;
        $wt_pc = $query->wt_pc ?? 0;

        if ($sumWeeks1To6 != 0 && $sumWeeks7To12 != 0) {
            $WT_RQ = max(($sumWeeks1To6 + $sumWeeks7To12 - $in_stock_finish) * $wt_pc, 0);
        } else {
            $WT_RQ = 0;
        }

        $sum1_12 = $sumWeeks1To6 + $sumWeeks7To12;

        $live_inventory_finish = \DB::table('inventory')
            ->where('Part_No', $query->part_number)
            ->whereIn('status', ['new', 'returned'])
            ->where('location', '!=', 'WIP')
            ->sum('container_qty');
        $live_inventory_wip = \DB::table('inventory')
            ->where('Part_No', $query->part_number)
            ->whereIn('status', ['new', 'returned'])
            ->where('location', '=', 'WIP')
            ->sum('container_qty');
        $in_stock_live = \DB::table('inventory')->where('Part_No', $query->part_number)->sum('weight');
        $sumWeeks1To6 =
            (float) $sumWeeks1To6 + (float) (isset($query->weeks_months->past_due) ? $query->weeks_months->past_due : 0);
        // dd($sumWeeks1To6);

        $datesArray = [];

        // Calculate the start date of the current week (Monday)
        $today = date('Y-m-d');
        $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
        $mondayOfWeek =
            $dayOfWeek == 0
                ? date('Y-m-d', strtotime('-6 days', strtotime($today))) // If Sunday, go back 6 days
                : date('Y-m-d', strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today))); // Else, go back to Monday

        // Calculate the start date of week 16
        $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

        // Calculate the end date of week 16
        $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

        // Calculate the start date of month 5 (the day after week 16 ends)
        $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));

        //column configuration
        $region_1_column_configuration_record = get_user_config('master_screen_region_1_column_configuration');
        $region_1_column_configuration = json_decode($region_1_column_configuration_record->value);
        usort($region_1_column_configuration, function ($a, $b) {
            return $a->order < $b->order ? -1 : 1;
        });

        $region_2_column_configuration_record = get_user_config('master_screen_region_2_column_configuration');
        $region_2_column_configuration = json_decode($region_2_column_configuration_record->value);
        usort($region_2_column_configuration, function ($a, $b) {
            return $a->order < $b->order ? -1 : 1;
        });
    @endphp

    <section class="report_sec">
        <div class="row align-items-center mb-2">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="parent-pagination">
                    <div class="pagination">
                        <a href="{{ route('index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0d6efd"
                                class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z" />
                            </svg>
                            <span class="pagination-heading">
                                Return To Master query
                            </span>
                        </a>
                    </div>
                    {{-- <div class="title">
                        <h1 class="heading-1">
                            {{ App\Models\User::find($userId)->name ?? 'User' }} Report
                        </h1>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-query-show">
                            <thead>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>WORK CENTER</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>LOT</th>
                                    <th>ID</th>
                                    <th>PART NO.</th>
                                    <th>CUSTOMER</th>
                                    <th>REV</th>
                                    <th>PROCESS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $query->get_department->name }}</td>
                                    <td>{{ $query->work_center_one->com_name }}</td>
                                    <td>{{ $query->planning }}</td>
                                    <td>{{ $query->status }}</td>
                                    <td>{{ $query->job }}</td>
                                    <td>{{ $query->lot }}</td>
                                    <td>{{ $query->ids }}</td>
                                    <td>{{ $query->part_number }}</td>
                                    <td>{{ $query->get_customer->CustomerName }}</td>
                                    <td>{{ $query->revision }}</td>
                                    <td>{{ $query->process }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-query-show">
                            <thead>
                                <tr>
                                    <th>REQ 1-6 WEEKS</th>
                                    <th>REQ 7-12 WEEKS</th>
                                    <th>SCHED`L TOTAL </th>
                                    <th>IN STOCK FINISHED</th>
                                    <th>LIVE INVENTORY F</th>
                                    <th>LIVE INVENTORY WIP</th>
                                    <th>IN PROCESS OUT SIDE</th>
                                    <th>ON ORDER RAW MAT`L</th>
                                    <th>IN STOCK LIVE</th>
                                    <th>WT/PC</th>
                                    <th>MATERIAL (SORT)</th>
                                    <th>WT REQ`D 1-12 WEEKS</th>
                                    <th>SAFETY</th>
                                    <th>MIN SHIP</th>
                                    <th>ORDER NOTES</th>
                                    <th>PART NOTES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($sumWeeks1To6) }}</td>
                                    <td>{{ number_format($sumWeeks7To12) }}</td>
                                    <td>{{ number_format($sum1_12) }}</td>
                                    <td>{{ number_format($query->in_stock_finish) }}</td>
                                    <td>{{ $query->live_inventory_finish }}</td>
                                    <td>{{ $query->live_inventory_wip }}</td>
                                    <td>{{ $query->in_process_outside }}</td>
                                    <td>{{ $query->raw_mat }}</td>
                                    <td>{{ $query->in_stock_live }}</td>
                                    <td>{{ $query->wt_pc }}</td>
                                    <td>{{ $query->get_material->Package }}</td>
                                    <td>{{ $sum1_12 - $query->in_stock_finish > 0 ? number_format(($sum1_12 - $query->in_stock_finish) * $query->wt_pc, 2) : 0 }}</td>
                                    <td>{{ number_format($query->safety) }}</td>
                                    <td>{{ $query->min_ship }}</td>
                                    <td>{{ $query->order_notes }}</td>
                                    <td>{{ $query->part_notes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-query-show">
                            <thead>
                                <tr>
                                    <th>PAST DUE</th>
                                    @for ($week = 1; $week <= 16; $week++)
                                        <th id="head_week_{{ $week }}">
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th id="head_month_{{ $month }}">
                                            @if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $month5StartDate))
                                                {{ date("j-M", strtotime($month5StartDate)) }}
                                            @else
                                                {{ $month5StartDate }}
                                            @endif
                                        </th>
                                        @php
                                            $month5StartDate = date(
                                                'j-M',
                                                strtotime('+31 days', strtotime($month5StartDate)),
                                            );
                                        @endphp
                                    @endfor
                                    <th>PRICE</th>
                                    <th>NOTES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format((float) (isset($query->weeks_months->past_due) ? $query->weeks_months->past_due : 0)) }}</td>
                                    @for ($week = 1; $week <= 16; $week++)
                                        @php
                                            $weekKey = 'week_' . $week;
                                            $weekValue = $query->weeks_months->$weekKey ?? '';
                                            $formattedWeekValue = is_numeric($weekValue) ? number_format($weekValue) : $weekValue;
                                        @endphp
                                        <td>
                                            {{ $formattedWeekValue }}
                                        </td>
                                    @endfor

                                    @for ($month = 5; $month <= 12; $month++)
                                        @php
                                            $monthKey = 'month_' . $month;
                                            $monthValue = $query->weeks_months->$monthKey ?? '';
                                            $formattedMonthValue = is_numeric($monthValue) ? number_format($monthValue) : $monthValue;
                                        @endphp
                                        <td>
                                            {{ $formattedMonthValue }}
                                        </td>
                                    @endfor

                                    <td>{{ number_format($query->price) }}</td>
                                    <td>{{ $query->notes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endsection
