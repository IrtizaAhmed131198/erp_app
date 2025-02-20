@foreach ($entries as $index => $data)
    <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
    <tr id="entry_number_{{ $data->id }}">
        <td style="display: none"><button type="button" class="btn btn-danger delete-entry"
                data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button></td>
        @if (Auth::user()->View_1 == 1)
            <td class="vertical-text highlighted">
            </td>
            @foreach ($region_1_column_configuration as $region_1_column_configuration_item)
                @if ($region_1_column_configuration_item->visibility)
                    @if ($region_1_column_configuration_item->column == 'department')
                        @php
                            $data_target = 'entries_' . $data->id . '_department';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable toggle-department" id="{{ $data_target }}">
                                <select name="department" id="department" data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('department', this.value, event)" {!! isset($singleton) && $singleton == true && $index != 0 ? 'hidden' : '' !!}>
                                    <option value="" disabled>Select</option>
                                    @foreach ($department as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ $data->department == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @else
                            <td class="toggleable toggle-department" id="{{ $data_target }}">
                                {{ $data->get_department->name }}</td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'work_center')
                        @php
                            $data_target = 'entries_' . $data->id . '_work_centre_1';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable toggle-work-center" id="{{ $data_target }}">
                                <select name="work-center" id="work-center" data-id="{{ $data->work_center_one->id }}"
                                    onchange="sendAjaxRequest2('com', this.value, event)">
                                    <option value="" disabled>Select</option>
                                    @foreach ($work_selector as $val)
                                        <option value="{{ $val->id }}"
                                            {{ $data->work_center_one->com == $val->id ? 'selected' : '' }}>
                                            {{ $val->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @else
                            <td class="toggleable toggle-work-center" id="{{ $data_target }}">
                                {{ $data->work_center_one->com ?? 'N/A' }}</td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'planning_queue')
                        @php
                            $data_target = 'entries_' . $data->id . '_planning_queue';
                        @endphp
                        @if (Auth::user()->status_column == 1)
                            <td class="toggleable toggle-planning" id="{{ $data_target }}">
                                <input type="text" name="planning" id="planning"
                                    value="{{ number_format((float) $data->planning ?? 0) }}"
                                    data-id="{{ $data->id }}" oninput="formatNumberWithCommas(this)"
                                    onkeyup="sendAjaxRequest('planning', this.value, event)">
                            </td>
                        @else
                            <td class="toggleable toggle-department" id="{{ $data_target }}">{{ $data->planning }}
                            </td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'status')
                        @php
                            $data_target = 'entries_' . $data->id . '_status';
                        @endphp
                        @if (Auth::user()->status_column == 1)
                            <td class="toggleable toggle-department" id="{{ $data_target }}">
                                <select name="status" id="status" data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('status', this.value, event)">
                                    {{-- <option value="" disabled selected>Select</option> --}}
                                    <option value="Running" {{ $data->status == 'Running' ? 'selected' : '' }}
                                        style="background-color: #ff000087;">Running
                                    </option>
                                    <option value="Pending Order"
                                        {{ $data->status == 'Pending Order' ? 'selected' : '' }}
                                        style="background-color: #ffff009c;">Pending Order</option>
                                    <option value="Pause" {{ $data->status == 'Pause' ? 'selected' : '' }}
                                        style="background-color: #00800094;">Pause
                                    </option>
                                    <option value="Closed" {{ $data->status == 'Closed' ? 'selected' : '' }}
                                        style="background-color: #719ff4">Closed
                                    </option>
                                    <option value="Neutral" {{ $data->status == 'Neutral' ? 'selected' : '' }}
                                        style="background-color: #bfef72">Neutral
                                    </option>
                                </select>
                            </td>
                        @else
                            <td class="toggleable toggle-department" id="{{ $data_target }}">{{ $data->status }}</td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'job_number')
                        @php
                            $data_target = 'entries_' . $data->id . '_job_number';
                        @endphp
                        @if (Auth::user()->status_column == 1)
                            <td class="toggleable toggle-department targetshow" id="{{ $data_target }}">
                                <input type="text" name="job" id="job" class="data-w"
                                    value="{{ $data->job ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('job', this.value, event)"
                                    onmouseover="showTextAbove(this)">
                            </td>
                        @else
                            <td class="toggleable toggle-department" id="{{ $data_target }}">{{ $data->job }}</td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'lot_number')
                        @php
                            $data_target = 'entries_' . $data->id . '_lot_number';
                        @endphp
                        @if (Auth::user()->status_column == 1)
                            <td class="toggleable toggle-department targetshow" id="{{ $data_target }}">
                                <input type="text" name="lot" id="lot" class="data-w"
                                    value="{{ $data->lot ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('lot', this.value, event)"
                                    onmouseover="showTextAbove(this)">
                            </td>
                        @else
                            <td class="toggleable toggle-department" id="{{ $data_target }}">{{ $data->lot }}</td>
                        @endif
                    @elseif($region_1_column_configuration_item->column == 'ids')
                        @php
                            $data_target = 'entries_' . $data->id . '_ids';
                        @endphp
                        <td class="toggleable" id="{{ $data_target }}">{{ $data->ids ?? '' }}</td>
                    @endif
                @endif
            @endforeach
        @endif

        @if (Auth::user()->View_2 == 1)
            <td class="vertical-text highlighted">
            </td>

            @php
                $weeksArr = $data->weeks_months;

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

                $in_stock_finish = $data->in_stock_finish ?? 0;
                $wt_pc = $data->wt_pc ?? 0;

                if ($sumWeeks1To6 != 0 && $sumWeeks7To12 != 0) {
                    $WT_RQ = max(($sumWeeks1To6 + $sumWeeks7To12 - $in_stock_finish) * $wt_pc, 0);
                } else {
                    $WT_RQ = 0;
                }

                $sum1_12 = $sumWeeks1To6 + $sumWeeks7To12;

                $live_inventory_finish = \DB::table('inventory')
                    ->where('Part_No', $data->part_number)
                    ->whereIn('status', ['new', 'returned'])
                    ->where('location', '!=', 'WIP')
                    ->sum('container_qty');
                $live_inventory_wip = \DB::table('inventory')
                    ->where('Part_No', $data->part_number)
                    ->whereIn('status', ['new', 'returned'])
                    ->where('location', '=', 'WIP')
                    ->sum('container_qty');
                $in_stock_live = \DB::table('inventory')->where('Part_No', $data->part_number)->sum('weight');
                $sumWeeks1To6 =
                    (float) $sumWeeks1To6 +
                    (float) (isset($data->weeks_months->past_due) ? $data->weeks_months->past_due : 0);
                // dd($sumWeeks1To6);
            @endphp

            @foreach ($region_2_column_configuration as $region_2_column_configuration_item)
                @if ($region_2_column_configuration_item->visibility)
                    @if($region_2_column_configuration_item->column == 'part_number')
                        @php
                            $data_target = 'entries_' . $data->id . '_part_number';
                        @endphp
                        <td class="toggleable custom-toggleable" id="{{ $data_target }}">
                            <div class="custom-dropdown">
                                <button class="custom-dropdown-toggle part-st" type="button">
                                    {{ $data->part->Part_Number ?? '' }}
                                </button>
                                @if ($data->part && $data->part->id)
                                    <ul class="custom-dropdown-menu">
                                        <li>
                                            <a href="{{ route('calender', ['part_number' => $data->part->id]) }}"
                                                class="custom-dropdown-item" data-part="{{ $data->part_number }}"
                                                data-url="{{ route('calender') }}">
                                                Shipment & Production
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('data_center_edit', ['id' => $data->id, 'part_number' => $data->part->id]) }}"
                                                class="custom-dropdown-item" data-part="{{ $data->part_number }}"
                                                data-url="{{ route('data_center_edit', ['id' => $data->id]) }}">
                                                Part Number Input
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </td>
                    @elseif($region_2_column_configuration_item->column == 'customer')
                        @php
                            $data_target = 'entries_' . $data->id . '_customer';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable" id="{{ $data_target }}">
                                <select name="customer" id="customer" class="simple-select"
                                    data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('customer', this.value, event)">
                                    <option value="" disabled>Select</option>
                                    @foreach ($customers as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $data->customer == $item->id ? 'selected' : '' }}>
                                            {{ $item->CustomerName }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @else
                            <td class="toggleable" id="{{ $data_target }}">{{ $data->get_customer->CustomerName }}
                            </td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'rev')
                        @php
                            $data_target = 'entries_' . $data->id . '_rev';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable targetshow" id="{{ $data_target }}">
                                <input type="text" name="rev" id="rev" class="data-w"
                                    value="{{ $data->revision ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('revision', this.value, event)"
                                    onmouseover="showTextAbove(this)" readonly>
                            </td>
                        @else
                            <td class="toggleable" id="{{ $data_target }}">{{ $data->revision }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'process')
                        @php
                            $data_target = 'entries_' . $data->id . '_process';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable targetshow" id="{{ $data_target }}">
                                <input type="text" name="process" id="process" class="data-w"
                                    value="{{ $data->process ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('process', this.value, event)"
                                    onmouseover="showTextAbove(this)" readonly>
                            </td>
                        @else
                            <td class="toggleable" id="{{ $data_target }}">{{ $data->process }}</td>
                        @endif
                    @elseif ($region_2_column_configuration_item->column == 'reqd_1_6_weeks')
                        @php
                            $data_target = 'entries_' . $data->id . '_reqd_1_6_weeks';
                        @endphp
                        <td class="toggleable-1" id="{{ $data_target }}">{{ number_format($sumWeeks1To6) }}
                        </td>
                    @elseif($region_2_column_configuration_item->column == 'reqd_7_12_weeks')
                        @php
                            $data_target = 'entries_' . $data->id . '_reqd_7_12_weeks';
                        @endphp
                        <td class="toggleable-1" id="{{ $data_target }}">{{ number_format($sumWeeks7To12) }}</td>
                    @elseif($region_2_column_configuration_item->column == 'scheduled_total')
                        @php
                            $data_target = 'entries_' . $data->id . '_scheduled_total';
                        @endphp
                        <td class="toggleable-1 schedule_total" id="{{ $data_target }}">
                            {{ number_format((float) $sumWeeks1To6 + (float) $sumWeeks7To12) }}</td>
                    @elseif($region_2_column_configuration_item->column == 'in_stock_finished')
                        @php
                            $data_target = 'entries_' . $data->id . '_in_stock_finished';
                        @endphp
                        <td class="toggleable-1 in_stock_finish" id="{{ $data_target }}">
                            {{-- @if (Auth::user()->stock_finished_column == 1)
                            <input type="number" step="any" name="in_stock_finish" id="in_stock_finish"
                                   value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}"
                                   onkeyup="sendAjaxRequest('in_stock_finish', this.value, event)" class="simple-text">
                        @else --}}
                            {{ number_format($data->in_stock_finish ?? 0) }}
                            {{-- @endif --}}
                        </td>
                    @elseif($region_2_column_configuration_item->column == 'live_inventory_finished')
                        @php
                            $data_target = 'entries_' . $data->id . '_live_inventory_finished';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{-- <input type="text" name="live_inventory_finish" id="live_inventory_finish"
                                    value="{{ number_format($data->live_inventory_finish) }}"
                                    data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('live_inventory_finish', this.value, event)"
                                    oninput="formatAndPreventNegative(this)"> --}}
                                {{ number_format($data->live_inventory_finish) }}
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ number_format($data->live_inventory_finish) }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'live_inventory_wip')
                        @php
                            $data_target = 'entries_' . $data->id . '_live_inventory_wip';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{-- <input type="text" step="any" name="live_inventory_wip"
                                    id="live_inventory_wip" value="{{ number_format($data->live_inventory_wip) }}"
                                    data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('live_inventory_wip', this.value, event)"
                                    oninput="formatAndPreventNegative(this)"> --}}
                                {{ number_format($data->live_inventory_wip) }}
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ number_format($data->live_inventory_wip) }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'in_process_out_side')
                        @php
                            $out_source_id = $data->out_source_one->id ?? 0;
                            $data_target = 'entries_' . $data->id . '_in_process_outside';
                        @endphp
                        @if (Auth::user()->stock_finished_column == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <input type="text" name="in_process_outside" id="in_process_outside"
                                    value="{{ $data->in_process_outside ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('in_process_outside', this.value, event)">
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ $data->out_source_one->in_process_outside }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'on_order_raw_matl')
                        @php
                            $data_target = 'entries_' . $data->id . '_on_order_raw_matl';
                        @endphp
                        @if (Auth::user()->stock_finished_column == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <input type="text" name="raw_mat" id="raw_mat"
                                    value="{{ $data->raw_mat ?? '' }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('raw_mat', this.value, event)">
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">{{ $data->raw_mat }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'in_stock_live')
                        @php
                            $data_target = 'entries_' . $data->id . '_in_stock_live';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{-- <input type="text" step="any" name="in_stock_live" id="in_stock_live"
                                    value="{{ number_format($data->in_stock_live) }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('in_stock_live', this.value, event)"
                                    oninput="formatAndPreventNegative(this)"> --}}
                                {{ number_format($data->in_stock_live) }}
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ number_format($data->in_stock_live) }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'wt_pc')
                        @php
                            $data_target = 'entries_' . $data->id . '_wt_pc';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <input type="text" step="any" name="wt_pc" id="wt_pc"
                                    value="{{ number_format($data->wt_pc, 3, '.', ',') }}"
                                    data-id="{{ $data->id }}" oninput="formatAndPreventNegative(this)"
                                    onkeyup="sendAjaxRequest('wt_pc', this.value, event)" readonly>
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ number_format($data->wt_pc, 3, '.', ',') }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'material_sort')
                        @php
                            $data_target = 'entries_' . $data->id . '_material';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <select name="material" id="material" class="simple-select" data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('material', this.value, event)">
                                    <option value="" disabled>Select</option>
                                    @foreach ($materials as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $data->material == $item->id ? 'selected' : '' }}>
                                            {{ $item->Package }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- {{ $data->get_material->Package }} --}}
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">{{ $data->get_material->Package }}
                            </td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'wt_reqd_1_12_weeks')
                        @php
                            $data_target = 'entries_' . $data->id . '_wt_reqd_1_12_weeks';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ $sum1_12 - $data->in_stock_finish > 0 ? number_format(($sum1_12 - $data->in_stock_finish) * $data->wt_pc, 2) : 0 }}
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">
                                {{ $sum1_12 - $data->in_stock_finish > 0 ? number_format(($sum1_12 - $data->in_stock_finish) * $data->wt_pc, 2) : 0 }}
                            </td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'safety')
                        @php
                            $data_target = 'entries_' . $data->id . '_safety';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <input type="text" step="any" name="safety" id="safety"
                                    value="{{ number_format($data->safety ?? 0) }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('safety', this.value, event)" class="simple-text">

                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">{{ number_format($data->safety) }}
                            </td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'min_ship')
                        @php
                            $data_target = 'entries_' . $data->id . '_min_ship';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <input type="text" step="any" name="min_ship" id="min_ship"
                                    value="{{ number_format($data->min_ship) }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('min_ship', this.value, event)"
                                    oninput="formatAndPreventNegative(this)" class="simple-text">
                            </td>
                        @else
                            <td class="toggleable-1" id="{{ $data_target }}">{{ number_format($data->min_ship) }}
                            </td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'order_notes')
                        @php
                            $data_target = 'entries_' . $data->id . '_order_notes';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1" id="{{ $data_target }}">
                                <textarea name="order_notes" id="order_notes" value="{{ $data->order_notes }}" data-id="{{ $data->id }}"
                                    onkeyup="sendAjaxRequest('order_notes', this.value, event)">{{ $data->order_notes }}</textarea>
                            </td>
                        @else
                            <td class="toggleable-1 custom-textarea" id="{{ $data_target }}">
                                {{ $data->order_notes }}</td>
                        @endif
                    @elseif($region_2_column_configuration_item->column == 'part_notes')
                        @php
                            $data_target = 'entries_' . $data->id . '_part_notes';
                        @endphp
                        @if (Auth::user()->role == 1)
                            <td class="toggleable-1 custom-textarea" id="{{ $data_target }}">
                                {{-- <textarea name="part_notes" id="part_notes" class="simple-textarea" value="{{ $data->part_notes }}"
                                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('part_notes', this.value, event)">{{ $data->part_notes }}</textarea> --}}
                                {{ $data->part_notes }}
                            </td>
                        @else
                            <td class="toggleable-1 custom-textarea" id="{{ $data_target }}">
                                {{ $data->part_notes }}</td>
                        @endif
                    @endif
                @endif
            @endforeach
        @endif

        @if (Auth::user()->View_3 == 1)
            <td class="vertical-text highlighted">
            </td>

            @php
                $data_target = 'entries_' . $data->id . '_past_due';
            @endphp
            <td class="toggleable-2" id="{{ $data_target }}">
                {{ number_format((float) (isset($data->weeks_months->past_due) ? $data->weeks_months->past_due : 0)) }}
            </td>
            @for ($week = 1; $week <= 16; $week++)
                @php
                    $weekKey = 'week_' . $week;
                    $weekValue = $data->weeks_months->$weekKey ?? '';
                    $formattedWeekValue = is_numeric($weekValue) ? number_format($weekValue) : $weekValue;
                    $data_target = 'entries_' . $data->id . '_week_' . $week;
                @endphp
                <td class="toggleable-2 shipment_date" id="{{ $data_target }}"
                    data-week-change='week_{{ $week }}'>
                    {{ $formattedWeekValue }}
                </td>
            @endfor

            @for ($month = 5; $month <= 12; $month++)
                @php
                    $monthKey = 'month_' . $month;
                    $monthValue = $data->weeks_months->$monthKey ?? '';
                    $formattedMonthValue = is_numeric($monthValue) ? number_format($monthValue) : $monthValue;
                    $data_target = 'entries_' . $data->id . '_month_' . $month;
                @endphp
                <td class="toggleable-2 shipment_date" id="{{ $data_target }}"
                    data-week-change='month_{{ $month }}'>
                    {{ $formattedMonthValue }}
                </td>
            @endfor

            @if (Auth::user()->role == 1)
                @php
                    $data_target = 'entries_' . $data->id . '_future_raw';
                @endphp
                <td class="toggleable-2" id="{{ $data_target }}">
                    <input type="text" step="any" name="future_raw" id="future_raw"
                        value="{{ $data->future_raw ? number_format($data->future_raw) : 0 }}"
                        data-id="{{ $data->id }}" oninput="formatAndPreventNegative(this)" readonly>
                </td>

                @php
                    $data_target = 'entries_' . $data->id . '_price';
                @endphp
                <td class="toggleable-2" id="{{ $data_target }}">
                    <input type="text" step="any" name="price" id="price"
                        value="{{ number_format($data->price) }}" data-id="{{ $data->id }}"
                        onkeyup="sendAjaxRequest('price', this.value, event)" oninput="formatAndPreventNegative(this)"
                        readonly>
                </td>

                @php
                    $data_target = 'entries_' . $data->id . '_notes';
                @endphp
                <td class="toggleable-2" id="{{ $data_target }}">
                    <textarea name="notes" value="{{ $data->notes }}" data-id="{{ $data->id }}"
                        onkeyup="sendAjaxRequest('notes', this.value, event)">{{ $data->notes }}</textarea>
                </td>
            @else
                @php
                    $data_target = 'entries_' . $data->id . '_future_raw';
                @endphp
                <td class="toggleable-2" id="{{ $data_target }}">{{ $data->future_raw }}</td>

                @php
                    $data_target = 'entries_' . $data->id . '_price';
                @endphp
                <td class="toggleable-2" id="{{ $data_target }}">${{ $data->price }}</td>

                @php
                    $data_target = 'entries_' . $data->id . '_notes';
                @endphp
                <td class="toggleable-2 custom-textarea" id="{{ $data_target }}">{{ $data->notes }}</td>
            @endif
        @endif
    </tr>
@endforeach
