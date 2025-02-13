@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .report_sec {
            padding: 50px 200px;
        }

        .control-table {
            overflow: hidden;
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
                                    <td>{{ $sumWeeks1To6 }}</td>
                                    <td>{{ $sumWeeks7To12 }}</td>
                                    <td>{{ $sum1_12 }}</td>
                                    <td>{{ $query->in_stock_finish }}</td>
                                    <td>{{ $query->live_inventory_finish }}</td>
                                    <td>{{ $query->live_inventory_wip }}</td>
                                    <td>{{ $query->in_process_outside }}</td>
                                    <td>{{ $query->raw_mat }}</td>
                                    <td>{{ $query->in_stock_live }}</td>
                                    <td>{{ $query->wt_pc }}</td>
                                    <td>{{ $query->get_material->Package }}</td>
                                    <td>{{ $query }}</td>
                                    <td>{{ $query->safety }}</td>
                                    <td>{{ $query->min_ship }}</td>
                                    <td>{{ $query->order_notes }}</td>
                                    <td>{{ $query->part_notes }}</td>
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
