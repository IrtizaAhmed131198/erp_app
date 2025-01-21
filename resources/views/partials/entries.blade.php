@foreach ($entries as $index => $data)
    <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
    <tr id="entry_number_{{$data->id}}">
        @if(Auth::user()->View_1 == 1)

        <td class="vertical-text highlighted">
        </td>

        @foreach($region_1_column_configuration as $region_1_column_configuration_item)
            @if($region_1_column_configuration_item->visibility)
                @if($region_1_column_configuration_item->column == 'department')
                    @php
                        $data_target = 'entries_'.$data->id.'_department';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable toggle-department" id="{{$data_target}}">
                            <select name="department" id="department"
                                    data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('department', this.value, event)"
                                    {!! (isset($singleton) && $singleton == true && $index != 0) ? 'hidden' : '' !!}>
                                <option value="" disabled>Select</option>
                                @foreach($department as $dept)
                                    <option value="{{ $dept->id }}" {{ $data->department == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    @else
                        <td class="toggleable toggle-department" id="{{$data_target}}">{{ $data->get_department->name }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'work_center')
                    @php
                        $data_target = 'work_center_'.$data->work_center_one.'_work_center';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable toggle-work-center" id="{{$data_target}}">
                            <select name="work-center" id="work-center"
                                    data-id="{{ $data->work_center_one->id }}"
                                    onchange="sendAjaxRequest2('com', this.value, event)">
                                <option value="" disabled>Select</option>
                                @foreach($work_selector as $val)
                                    <option value="{{ $val->id }}" {{ $data->work_center_one->com == $val->id ? 'selected' : '' }}>
                                        {{ $val->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    @else
                        <td class="toggleable toggle-work-center" id="{{$data_target}}">{{ $data->work_center_one->com ?? 'N/A'}}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'planning_queue')
                    @php
                        $data_target = 'entries_'.$data->id.'_planning_queue';
                    @endphp
                    @if(Auth::user()->status_column == 1)
                        <td class="toggleable toggle-planning" id="{{$data_target}}">
                            <input type="text" name="planning" id="planning" value="{{ number_format((float)$data->planning ?? 0) }}"
                                   data-id="{{ $data->id }}" oninput="formatNumberWithCommas(this)"
                                   onkeyup="sendAjaxRequest('planning', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable toggle-department" id="{{$data_target}}">{{ $data->planning }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'status')
                    @php
                        $data_target = 'entries_'.$data->id.'_status';
                    @endphp
                    @if(Auth::user()->status_column == 1)
                        <td class="toggleable toggle-department" id="{{$data_target}}">
                            <select name="status" id="status"
                                    data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('status', this.value, event)">
                                <option value="" disabled selected>Select</option>
                                <option value="Running" {{ $data->status == 'Running' ? 'selected' : '' }}>Running</option>
                                <option value="Pending Order" {{ $data->status == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                <option value="Pause" {{ $data->status == 'Pause' ? 'selected' : '' }}>Pause</option>
                                <option value="Closed" {{ $data->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </td>
                    @else
                        <td class="toggleable toggle-department" id="{{$data_target}}">{{ $data->status }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'job_number')
                    @php
                        $data_target = 'entries_'.$data->id.'_job_number';
                    @endphp
                    @if(Auth::user()->status_column == 1)
                        <td class="toggleable toggle-department" id="{{$data_target}}">
                            <input type="text" name="job" id="job" value="{{ $data->job ?? '' }}"
                                   data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('job', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable toggle-department" id="{{$data_target}}">{{ $data->job }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'lot_number')
                    @php
                        $data_target = 'entries_'.$data->id.'_lot_number';
                    @endphp
                    @if(Auth::user()->status_column == 1)
                        <td class="toggleable toggle-department" id="{{$data_target}}">
                            <input type="text" name="lot" id="lot" value="{{ $data->lot ?? '' }}"
                                   data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('lot', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable toggle-department" id="{{$data_target}}">{{ $data->lot }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'id')
                    <td class="toggleable">ID# {{ $data->id }}</td>
                @elseif($region_1_column_configuration_item->column == 'part_number')
                    <td class="toggleable custom-toggleable">
                        <div class="custom-dropdown">
                            <button class="custom-dropdown-toggle part-st" type="button">
                                {{ $data->part->Part_Number }}
                            </button>
                            <ul class="custom-dropdown-menu">
                                <li>
                                    <a href="#" class="custom-dropdown-item" data-part="{{ $data->part_number }}" data-url="{{ route('calender') }}">
                                        Shipment & Production
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="custom-dropdown-item" data-part="{{ $data->part_number }}" data-url="{{ route('data_center_edit', ['id' => $data->id]) }}">
                                        Part Number Input
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                @elseif($region_1_column_configuration_item->column == 'customer')
                    @php
                        $data_target = 'entries_'.$data->id.'_customer';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable" id="{{$data_target}}">
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
                        <td class="toggleable" id="{{$data_target}}">{{ $data->get_customer->CustomerName }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'rev')
                    @php
                        $data_target = 'entries_'.$data->id.'_rev';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable" id="{{$data_target}}">
                            <input type="text" name="rev" id="rev" value="{{ $data->revision ?? '' }}" class="text-w"
                                   data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('revision', this.value, event)" class="simple-text">
                        </td>
                    @else
                        <td class="toggleable" id="{{$data_target}}">{{ $data->revision }}</td>
                    @endif
                @elseif($region_1_column_configuration_item->column == 'process')
                    @php
                        $data_target = 'entries_'.$data->id.'_process';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable targetshow" id="{{$data_target}}">
                            <input type="text" name="process" id="process" class="data-w" value="{{ $data->process ?? '' }}"
                                   data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('process', this.value, event)" onmouseover="showTextAbove(this)">
                        </td>
                    @else
                        <td class="toggleable" id="{{$data_target}}">{{ $data->process }}</td>
                    @endif
                @endif
            @endif
        @endforeach

        @endif

        @if(Auth::user()->View_2 == 1)
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

            $live_inventory_finish = \DB::table('inventory')->where('Part_No', $data->part_number)->whereIn('status', ['new', 'returned'])->where('location', '!=', 'WIP')->sum('container_qty');
            $live_inventory_wip = \DB::table('inventory')->where('Part_No', $data->part_number)->whereIn('status', ['new', 'returned'])->where('location', '=', 'WIP')->sum('container_qty');
            $in_stock_live = \DB::table('inventory')->where('Part_No', $data->part_number)->sum('weight');

            $sumWeeks1To6 = $sumWeeks1To6 + ($data->weeks_months->past_due ?? 0)
        @endphp

        @foreach($region_2_column_configuration as $region_2_column_configuration_item)
            @if($region_2_column_configuration_item->visibility)
                @if($region_2_column_configuration_item->column == 'reqd_1_6_weeks')
                    <td class="toggleable-1">{{ number_format($sumWeeks1To6) }}</td>
                @elseif($region_2_column_configuration_item->column == 'reqd_7_12_weeks')
                    <td class="toggleable-1">{{ number_format($sumWeeks7To12) }}</td>
                @elseif($region_2_column_configuration_item->column == 'scheduled_total')
                    <td class="toggleable-1 schedule_total">{{ number_format($sumWeeks1To6 + $sumWeeks7To12) }}</td>
                @elseif($region_2_column_configuration_item->column == 'in_stock_finished')
                    @php
                        $data_target = 'entries_'.$data->id.'_in_stock_finished';
                    @endphp
                    <td class="toggleable-1 in_stock_finish" id="{{$data_target}}">
                        {{-- @if(Auth::user()->stock_finished_column == 1)
                            <input type="number" step="any" name="in_stock_finish" id="in_stock_finish"
                                   value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}"
                                   onkeyup="sendAjaxRequest('in_stock_finish', this.value, event)" class="simple-text">
                        @else --}}
                            {{ number_format($data->in_stock_finish ?? 0) }}
                        {{-- @endif --}}
                    </td>
                @elseif($region_2_column_configuration_item->column == 'live_inventory_finished')
                    @php
                        $data_target = 'entries_'.$data->id.'_live_inventory_finished';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" name="live_inventory_finish" id="live_inventory_finish"
                                   value="{{ number_format($data->live_inventory_finish) }}" data-id="{{ $data->id }}"
                                   onkeyup="sendAjaxRequest('live_inventory_finish', this.value, event)"
                                   oninput="formatAndPreventNegative(this)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ number_format($data->live_inventory_finish) }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'live_inventory_wip')
                    @php
                        $data_target = 'entries_'.$data->id.'_live_inventory_wip';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" step="any" name="live_inventory_wip" id="live_inventory_wip"
                                   value="{{ number_format($data->live_inventory_wip) }}" data-id="{{ $data->id }}"
                                   onkeyup="sendAjaxRequest('live_inventory_wip', this.value, event)"
                                   oninput="formatAndPreventNegative(this)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ number_format($data->live_inventory_wip) }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'in_process_out_side')
                    @php
                        $data_target = 'outsource_'.$data->out_source_one->id.'_in_process_out_side';
                    @endphp
                    @if(Auth::user()->stock_finished_column == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" name="in_process_outside" id="in_process_outside"
                                   value="{{ $data->out_source_one->in_process_outside ?? '' }}" data-id="{{ $data->out_source_one->id ?? ''}}"
                                   onkeyup="sendAjaxRequest3('in_process_outside', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->out_source_one->in_process_outside }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'on_order_raw_matl')
                    @php
                        $data_target = 'entries_'.$data->id.'_on_order_raw_matl';
                    @endphp
                    @if(Auth::user()->stock_finished_column == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}"
                                   data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->raw_mat }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'in_stock_live')
                    @php
                        $data_target = 'entries_'.$data->id.'_in_stock_live';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" step="any" name="in_stock_live" id="in_stock_live"
                                value="{{ number_format($data->in_stock_live) }}" data-id="{{ $data->id }}"
                                onkeyup="sendAjaxRequest('in_stock_live', this.value, event)"
                                oninput="formatAndPreventNegative(this)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ number_format($data->in_stock_live) }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'wt_pc')
                    @php
                        $data_target = 'entries_'.$data->id.'_wt_pc';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" step="any" name="wt_pc" id="wt_pc"
                                value="{{ number_format($data->wt_pc, 3, '.', ',') }}" data-id="{{ $data->id }}"
                                oninput="formatAndPreventNegative(this)" class="text-w"
                                onkeyup="sendAjaxRequest('wt_pc', this.value, event)">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ number_format($data->wt_pc, 3, '.', ',') }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'material_sort')
                    @php
                        $data_target = 'entries_'.$data->id.'_material_sort';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <select name="material" id="material"
                                    data-id="{{ $data->id }}"
                                    onchange="sendAjaxRequest('material', this.value, event)">
                                <option value="" disabled>Select</option>
                                @foreach ($materials as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->material == $item->id ? 'selected' : '' }}>
                                        {{ $item->Package }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->get_material->Package }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'wt_reqd_1_12_weeks')
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>
                    @else
                        <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'safety')
                    @php
                        $data_target = 'entries_'.$data->id.'_safety';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="number" step="any" name="safety" id="safety"
                                value="{{ $data->safety }}" data-id="{{ $data->id }}"
                                onkeyup="sendAjaxRequest('safety', this.value, event)" class="simple-text">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->safety }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'min_ship')
                    @php
                        $data_target = 'entries_'.$data->id.'_min_ship';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <input type="text" step="any" name="min_ship" id="min_ship"
                                value="{{ number_format($data->min_ship) }}" data-id="{{ $data->id }}"
                                onkeyup="sendAjaxRequest('min_ship', this.value, event)"
                                oninput="formatAndPreventNegative(this)" class="simple-text">
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ number_format($data->min_ship) }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'order_notes')
                    @php
                        $data_target = 'entries_'.$data->id.'_order_notes';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <textarea name="order_notes" id="order_notes" class="text-w"
                                value="{{ $data->order_notes }}" data-id="{{ $data->id }}"
                                onkeyup="sendAjaxRequest('order_notes', this.value, event)">{{ $data->order_notes }}</textarea>
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->order_notes }}</td>
                    @endif
                @elseif($region_2_column_configuration_item->column == 'part_notes')
                    @php
                        $data_target = 'entries_'.$data->id.'_part_notes';
                    @endphp
                    @if(Auth::user()->role == 1)
                        <td class="toggleable-1" id="{{$data_target}}">
                            <textarea name="part_notes" id="part_notes" class="simple-textarea text-w"
                                value="{{ $data->part_notes }}" data-id="{{ $data->id }}"
                                onkeyup="sendAjaxRequest('part_notes', this.value, event)">{{ $data->part_notes }}</textarea>
                        </td>
                    @else
                        <td class="toggleable-1" id="{{$data_target}}">{{ $data->part_notes }}</td>
                    @endif
                @endif
            @endif
        @endforeach

        @endif

{{--        <td class="toggleable-1">{{ $sumWeeks1To6 }}</td>--}}
{{--        <td class="toggleable-1">{{ $sumWeeks7To12 }}</td>--}}
{{--        <td class="toggleable-1 schedule_total">{{ $sumWeeks1To6 + $sumWeeks7To12 }}</td>--}}
{{--        <td class="toggleable-1 in_stock_finish">--}}
{{--            @if(Auth::user()->stock_finished_column == 1)--}}
{{--                <input type="number" step="any" name="in_stock_finish" id="in_stock_finish"--}}
{{--                    value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('in_stock_finish', this.value, event)">--}}
{{--            @else--}}
{{--                {{ $data->in_stock_finish ?? '' }}--}}
{{--            @endif--}}
{{--        </td>--}}

{{--        @if(Auth::user()->role == 1)--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" name="live_inventory_finish" id="live_inventory_finish"--}}
{{--                    value="{{ $data->live_inventory_finish }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('live_inventory_finish', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" step="any" name="live_inventory_wip" id="live_inventory_wip"--}}
{{--                    value="{{ $data->live_inventory_wip }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('live_inventory_wip', this.value, event)">--}}
{{--            </td>--}}
{{--        @else--}}
{{--            <td class="toggleable-1">{{ $data->live_inventory_finish }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->live_inventory_wip }}</td>--}}
{{--        @endif--}}

{{--        @if(Auth::user()->stock_finished_column == 1)--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" name="in_process_outside" id="in_process_outside"--}}
{{--                    value="{{ $data->out_source_one->in_process_outside ?? '' }}" data-id="{{ $data->out_source_one->id ?? ''}}"--}}
{{--                    onkeyup="sendAjaxRequest3('in_process_outside', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}"--}}
{{--                    data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value, event)">--}}
{{--            </td>--}}
{{--        @else--}}
{{--            <td class="toggleable-1">{{ $data->out_source_one->in_process_outside }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->raw_mat }}</td>--}}
{{--        @endif--}}

        @if(Auth::user()->role == 1)
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" step="any" name="in_stock_live" id="in_stock_live"--}}
{{--                    value="{{ $data->in_stock_live }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('in_stock_live', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" step="any" name="wt_pc" id="wt_pc"--}}
{{--                    value="{{ $data->wt_pc }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('wt_pc', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <select name="material" id="material"--}}
{{--                        data-id="{{ $data->id }}"--}}
{{--                        onchange="sendAjaxRequest('material', this.value, event)">--}}
{{--                    <option value="" disabled>Select</option>--}}
{{--                    @foreach ($materials as $item)--}}
{{--                        <option value="{{ $item->id }}"--}}
{{--                            {{ $data->material == $item->id ? 'selected' : '' }}>--}}
{{--                            {{ $item->Package }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" step="any" name="safety" id="safety"--}}
{{--                    value="{{ $data->safety }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('safety', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <input type="number" step="any" name="min_ship" id="min_ship"--}}
{{--                    value="{{ $data->min_ship }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('min_ship', this.value, event)">--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <textarea name="part_notes" id="order_notes"--}}
{{--                    value="{{ $data->order_notes }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('order_notes', this.value, event)">{{ $data->order_notes }}</textarea>--}}
{{--            </td>--}}
{{--            <td class="toggleable-1">--}}
{{--                <textarea name="part_notes" id="part_notes"--}}
{{--                    value="{{ $data->part_notes }}" data-id="{{ $data->id }}"--}}
{{--                    onkeyup="sendAjaxRequest('part_notes', this.value, event)">{{ $data->part_notes }}</textarea>--}}
{{--            </td>--}}
        @else
{{--            <td class="toggleable-1">{{ $data->in_stock_live }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->wt_pc }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->get_material->Package }}</td>--}}
{{--            <td class="toggleable-1">{{ (($data->wt_pc / 1000) * $sum1_12) }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->safety }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->min_ship }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->order_notes }}</td>--}}
{{--            <td class="toggleable-1">{{ $data->part_notes }}</td>--}}
        @endif

        @if(Auth::user()->View_3 == 1)

        <td  class="vertical-text highlighted">
        </td>
        <td class="toggleable-2">{{ number_format($data->weeks_months->past_due) }}</td>
        @for ($week = 1; $week <= 16; $week++)
            @php
                $weekKey = 'week_' . $week;
                $weekValue = $data->weeks_months->$weekKey ?? '';
                $formattedWeekValue = is_numeric($weekValue) ? number_format($weekValue) : $weekValue;
            @endphp
            <td class="toggleable-2 shipment_date" data-week-change='week_{{ $week }}'>
                {{ $formattedWeekValue }}
            </td>
        @endfor
        @for ($month = 5; $month <= 12; $month++)
            @php
                $monthKey = 'month_' . $month;
                $monthValue = $data->weeks_months->$monthKey ?? '';
                $formattedMonthValue = is_numeric($monthValue) ? number_format($monthValue) : $monthValue;
            @endphp
            <td class="toggleable-2 shipment_date" data-week-change='month_{{ $month }}'>
                {{ $formattedMonthValue }}
            </td>
        @endfor
        @if(Auth::user()->role == 1)
            <td class="toggleable-2">
                <input type="text" step="any" name="future_raw" id="future_raw"
                    value="{{ number_format($data->future_raw) }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('future_raw', this.value, event)"
                    oninput="formatAndPreventNegative(this)">
            </td>
            <td class="toggleable-2">
                <input type="text" step="any" name="price" id="price"
                    value="{{ number_format($data->price) }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('price', this.value, event)"
                    oninput="formatAndPreventNegative(this)">
            </td>
            <td class="toggleable-2">
                <textarea name="notes" id="notes" class="text-w"
                    value="{{ $data->notes }}" data-id="{{ $data->id }}"
                    onkeyup="sendAjaxRequest('notes', this.value, event)">{{ $data->notes }}</textarea>
            </td>
        @else
            @php
                $data_target = 'entries_'.$data->id.'_future_raw';
            @endphp
            <td class="toggleable-2" id="{{$data_target}}">{{ $data->future_raw }}</td>

            @php
                $data_target = 'entries_'.$data->id.'_price';
            @endphp
            <td class="toggleable-2" id="{{$data_target}}">${{ $data->price }}</td>

            @php
                $data_target = 'entries_'.$data->id.'_notes';
            @endphp
            <td class="toggleable-2" id="{{$data_target}}">{{ $data->notes }}</td>
        @endif
        @endif
    </tr>
@endforeach
