@foreach ($entries as $index => $data)
    <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
    <tr>
        <td class="vertical-text highlighted">
        </td>
        <td class="toggleable toggle-department">{{ $data->department }}</td>
        <td class="toggleable toggle-work-center">{{ $data->work_center_one->com ?? 'N/A'}}</td>
        @if(Auth::user()->status_column == 1)
            <td class="toggleable toggle-planning">
                <input type="text" name="planning" id="planning" value="{{ $data->planning ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('planning', this.value)">
            </td>
            <td class="toggleable">
                <select name="status" id="status"
                        data-id="{{ $data->id }}"
                        onchange="sendAjaxRequest('status', this.value)">
                    <option value="" disabled selected>Select</option>
                    <option value="Running" {{ $data->status == 'Running' ? 'selected' : '' }}>Running</option>
                    <option value="Pending Order" {{ $data->status == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                    <option value="Pause" {{ $data->status == 'Pause' ? 'selected' : '' }}>Pause</option>
                    <option value="Closed" {{ $data->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </td>
            <td class="toggleable">
                <input type="text" name="job" id="job" value="{{ $data->job ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('job', this.value)">
            </td>
            <td class="toggleable">
                <input type="text" name="lot" id="lot" value="{{ $data->lot ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('lot', this.value)">
            </td>
        @else
            <td class="toggleable-1">{{ $data->planning }}</td>
            <td class="toggleable-1">{{ $data->status }}</td>
            <td class="toggleable-1">{{ $data->job }}</td>
            <td class="toggleable-1">{{ $data->lot }}</td>
        @endif
        <td class="toggleable">ID# {{ $data->id }}</td>
        <td class="toggleable">{{ $data->part_number }}</td>
        <td class="toggleable">{{ $data->customer }}</td>
        <td class="toggleable">{{ $data->rev }}</td>
        <td class="toggleable">{{ $data->process }}</td>
        <td  class="vertical-text highlighted">
        </td>

        @php
            $weeksArr = $data->weeks_months;
            if ($weeksArr) {
                $sumWeeks1To6 = array_sum([$weeksArr['week_1'], $weeksArr['week_2'], $weeksArr['week_3'], $weeksArr['week_4'], $weeksArr['week_5'], $weeksArr['week_6']]);
                $sumWeeks7To12 = array_sum([$weeksArr['week_7'], $weeksArr['week_8'], $weeksArr['week_9'], $weeksArr['week_10'], $weeksArr['week_11'], $weeksArr['week_12']]);
            } else {
                $sumWeeks1To6 = $sumWeeks7To12 = 0;
            }

            $in_stock_finish = $data->in_stock_finish ?? 0;
            $wt_pc = $data->wt_pc ?? 0;

            if($sumWeeks1To6 != 0 && $sumWeeks7To12 != 0){
                $WT_RQ = max((($sumWeeks1To6 + $sumWeeks7To12) - $in_stock_finish) * $wt_pc, 0);
            }else{
                $WT_RQ = 0;
            }
        @endphp

        <td class="toggleable-1">{{ $sumWeeks1To6 }}</td>
        <td class="toggleable-1">{{ $sumWeeks7To12 }}</td>
        <td class="toggleable-1">{{ $sumWeeks1To6 + $sumWeeks7To12 }}</td>
        <td class="toggleable-1">
            @if(Auth::user()->stock_finished_column == 1)
                <input type="number" step="any" name="in_stock_finish" id="in_stock_finish"
                    value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('in_stock_finish', this.value)">
            @else
                {{ $data->in_stock_finish ?? '' }}
            @endif
        </td>
        @php
        $live_inventory_finish = \DB::table('inventory')->where('Part_No', $data->part_number)->whereIn('status', ['new', 'returned'])->where('location', '!=', 'WIP')->sum('container_qty');
        $live_inventory_wip = \DB::table('inventory')->where('Part_No', $data->part_number)->whereIn('status', ['new', 'returned'])->where('location', '=', 'WIP')->sum('container_qty');
        $in_stock_live = \DB::table('inventory')->where('Part_No', $data->part_number)->sum('weight');
        @endphp
        @if(Auth::user()->role == 1)
            <td class="toggleable-1">
                <input type="number" step="any" name="live_inventory_finish" id="live_inventory_finish"
                    value="{{ $data->live_inventory_finish }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('live_inventory_finish', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="number" step="any" name="live_inventory_wip" id="live_inventory_wip"
                    value="{{ $data->live_inventory_wip }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('live_inventory_wip', this.value)">
            </td>
        @else
            <td class="toggleable-1">{{ $data->live_inventory_finish }}</td>
            <td class="toggleable-1">{{ $data->live_inventory_wip }}</td>
        @endif

        @if(Auth::user()->stock_finished_column == 1)
            {{-- <td class="toggleable-1">
                <input type="number" step="any" name="live_inventory_wip" id="live_inventory_wip"
                    value="{{ $data->live_inventory_wip ?? '' }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('live_inventory_wip', this.value)">
            </td> --}}
            <td class="toggleable-1">
                <input type="number" step="any" name="in_process_outside" id="in_process_outside"
                    value="{{ $data->in_process_outside ?? '' }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('in_process_outside', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value)">
            </td>
        @else
            <td class="toggleable-1">{{ $data->in_process_outside }}</td>
            <td class="toggleable-1">{{ $data->raw_mat }}</td>
        @endif
        @if(Auth::user()->role == 1)
            <td class="toggleable-1">
                <input type="number" step="any" name="in_stock_live" id="in_stock_live"
                    value="{{ $data->in_stock_live }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('in_stock_live', this.value)">
            </td>
        @else
            <td class="toggleable-1">{{ $data->in_stock_live }}</td>
        @endif
        <td class="toggleable-1">{{ $data->wt_pc }}</td>
        <td class="toggleable-1">{{ $data->material }}</td>
        <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sumWeeks1To6) }}</td>
        <td class="toggleable-1">{{ $data->safety }}</td>
        <td class="toggleable-1">{{ $data->min_ship }}</td>
        <td class="toggleable-1">{{ $data->order_notes }}</td>
        <td class="toggleable-1">{{ $data->part_notes }}</td>
        <td  class="vertical-text highlighted">
        </td>
        <td class="toggleable-2">{{ $data->weeks_months->past_due ?? '' }}</td>
        @for ($week = 1; $week <= 16; $week++)
            @php $weekKey = 'week_' . $week; @endphp
            <td class="toggleable-2 shipment_date" data-week-change='week_{{ $week }}'>
                {{ $data->weeks_months->$weekKey ?? '' }}
            </td>
        @endfor
        @for ($month = 5; $month <= 12; $month++)
            @php $monthKey = 'month_' . $month; @endphp
            <td class="toggleable-2 shipment_date" data-week-change='month_{{ $month }}'>
                {{ $data->weeks_months->$monthKey ?? '' }}
            </td>
        @endfor
        <td class="toggleable-2">{{ $data->future_raw }}</td>
        <td class="toggleable-2">${{ $data->price }}</td>
        <td class="toggleable-2">{{ $data->notes }}</td>
    </tr>
@endforeach
