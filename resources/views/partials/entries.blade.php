@foreach ($entries as $index => $data)
    <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
    <tr>
        <td class="vertical-text highlighted">
        </td>
        @if(Auth::user()->role == 1)
            <td class="toggleable toggle-department">
                <select name="department" id="department"
                        data-id="{{ $data->id }}"
                        onchange="sendAjaxRequest('department', this.value)">
                    <option value="" disabled>Select</option>
                    @foreach($department as $dept)
                        <option value="{{ $dept->name }}" {{ $data->department == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="toggleable toggle-work-center">
                <select name="work-center" id="work-center"
                        data-id=""
                        onchange="">
                    <option value="" disabled>Select</option>
                    @foreach($work_selector as $val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endforeach
                </select>
            </td>
            {{-- <td class="toggleable toggle-work-center">
                <select name="work-center" id="work-center"
                        data-id="{{ $data->work_center_one->id }}"
                        onchange="sendAjaxRequest2('com', this.value)">
                    <option value="" disabled>Select</option>
                    <option value="COM 1"
                        {{ $data->work_center_one->com == 'COM 1' ? 'selected' : '' }}>COM 1
                    </option>
                    <option value="COM 2"
                        {{ $data->work_center_one->com == 'COM 2' ? 'selected' : '' }}>COM 2
                    </option>
                    <option value="COM 3"
                        {{ $data->work_center_one->com == 'COM 3' ? 'selected' : '' }}>COM 3
                    </option>
                </select>
            </td> --}}
        @else
            <td class="toggleable toggle-department">{{ $data->get_department->name }}</td>
            <td class="toggleable toggle-work-center">{{ $data->work_center_one->com ?? 'N/A'}}</td>
        @endif

        @if(Auth::user()->status_column == 1)
            <td class="toggleable toggle-planning">
                <input type="text" name="planning" id="planning" value="{{ $data->planning ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('planning', this.value)">
            </td>
            <td class="toggleable toggle-department">
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
            <td class="toggleable toggle-department">
                <input type="text" name="job" id="job" value="{{ $data->job ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('job', this.value)">
            </td>
            <td class="toggleable toggle-department">
                <input type="text" name="lot" id="lot" value="{{ $data->lot ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('lot', this.value)">
            </td>
        @else
            <td class="toggleable-1 toggle-department">{{ $data->planning }}</td>
            <td class="toggleable-1 toggle-department">{{ $data->status }}</td>
            <td class="toggleable-1 toggle-department">{{ $data->job }}</td>
            <td class="toggleable-1 toggle-department">{{ $data->lot }}</td>
        @endif

        <td class="toggleable">ID# {{ $data->id }}</td>
        <td class="toggleable">{{ $data->part->Part_Number }}</td>
        @if(Auth::user()->role == 1)
            <td class="toggleable">
                <select name="customer" id="customer"
                        data-id="{{ $data->id }}"
                        onchange="sendAjaxRequest('customer', this.value)">
                    <option value="" disabled>Select</option>
                    @foreach ($customers as $item)
                        <option value="{{ $item->id }}"
                            {{ $data->customer == $item->id ? 'selected' : '' }}>
                            {{ $item->CustomerName }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="toggleable">
                <input type="text" name="rev" id="rev" value="{{ $data->rev ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('rev', this.value)">
            </td>
            <td class="toggleable">
                <input type="text" name="process" id="process" value="{{ $data->process ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('process', this.value)">
            </td>
        @else
            <td class="toggleable">{{ $data->get_customer->CustomerName }}</td>
            <td class="toggleable">{{ $data->rev }}</td>
            <td class="toggleable">{{ $data->process }}</td>
        @endif
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

            $sum1_12 = $sumWeeks1To6 + $sumWeeks7To12;
        @endphp

        <td class="toggleable-1">{{ $sumWeeks1To6 }}</td>
        <td class="toggleable-1">{{ $sumWeeks7To12 }}</td>
        <td class="toggleable-1 schedule_total">{{ $sumWeeks1To6 + $sumWeeks7To12 }}</td>
        <td class="toggleable-1 in_stock_finish">
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
                <input type="number" name="live_inventory_finish" id="live_inventory_finish"
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
            <td class="toggleable-1">
                <input type="number" name="in_process_outside" id="in_process_outside"
                    value="{{ $data->out_source_one->in_process_outside ?? '' }}" data-id="{{ $data->out_source_one->id }}"
                    onkeyup="sendAjaxRequest3('in_process_outside', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}"
                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value)">
            </td>
        @else
            <td class="toggleable-1">{{ $data->out_source_one->in_process_outside }}</td>
            <td class="toggleable-1">{{ $data->raw_mat }}</td>
        @endif
        @if(Auth::user()->role == 1)
            <td class="toggleable-1">
                <input type="number" step="any" name="in_stock_live" id="in_stock_live"
                    value="{{ $data->in_stock_live }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('in_stock_live', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="number" step="any" name="wt_pc" id="wt_pc"
                    value="{{ $data->wt_pc }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('wt_pc', this.value)">
            </td>
            <td class="toggleable-1">
                <select name="material" id="material"
                        data-id="{{ $data->id }}"
                        onchange="sendAjaxRequest('material', this.value)">
                    <option value="" disabled>Select</option>
                    @foreach ($materials as $item)
                        <option value="{{ $item->id }}"
                            {{ $data->material == $item->id ? 'selected' : '' }}>
                            {{ $item->Package }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>
            <td class="toggleable-1">
                <input type="number" step="any" name="safety" id="safety"
                    value="{{ $data->safety }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('safety', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="number" step="any" name="min_ship" id="min_ship"
                    value="{{ $data->min_ship }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('min_ship', this.value)">
            </td>
            <td class="toggleable-1">
                <textarea name="part_notes" id="order_notes"
                    value="{{ $data->order_notes }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('order_notes', this.value)">{{ $data->order_notes }}</textarea>
            </td>
            <td class="toggleable-1">
                <textarea name="part_notes" id="part_notes"
                    value="{{ $data->part_notes }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('part_notes', this.value)">{{ $data->part_notes }}</textarea>
            </td>
        @else
            <td class="toggleable-1">{{ $data->in_stock_live }}</td>
            <td class="toggleable-1">{{ $data->wt_pc }}</td>
            <td class="toggleable-1">{{ $data->get_material->Package }}</td>
            <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>
            <td class="toggleable-1">{{ $data->safety }}</td>
            <td class="toggleable-1">{{ $data->min_ship }}</td>
            <td class="toggleable-1">{{ $data->order_notes }}</td>
            <td class="toggleable-1">{{ $data->part_notes }}</td>
        @endif

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
        @if(Auth::user()->role == 1)
            <td class="toggleable-1">
                <input type="text" step="any" name="future_raw" id="future_raw"
                    value="{{ $data->future_raw }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('future_raw', this.value)">
            </td>
            <td class="toggleable-1">
                <input type="number" step="any" name="price" id="price"
                    value="{{ $data->price }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('price', this.value)">
            </td>
            <td class="toggleable-1">
                <textarea name="notes" id="notes"
                    value="{{ $data->notes }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('notes', this.value)">{{ $data->notes }}</textarea>
            </td>
        @else
            <td class="toggleable-2">{{ $data->future_raw }}</td>
            <td class="toggleable-2">${{ $data->price }}</td>
            <td class="toggleable-2">{{ $data->notes }}</td>
        @endif
    </tr>
@endforeach
