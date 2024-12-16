@foreach ($entries as $index => $data)
    <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
    <tr>
        @if ($loop->first)
            <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                <div class="parent-hightlighted">
                    <span>Details</span>
                </div>
            </td>
        @endif
        <td class="toggleable toggle-department">{{ $data->department }}</td>
        <td class="toggleable toggle-work-center">COM 1</td>
        <td class="toggleable toggle-planning">
            <input type="text" name="planning" id="planning" value="{{ $data->planning ?? '' }}"
                data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('planning', this.value)">
        </td>
        <td class="toggleable">
            <input type="text" name="status" id="status" value="{{ $data->status ?? '' }}"
                data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('status', this.value)">
        </td>
        <td class="toggleable">
            <input type="text" name="job" id="job" value="{{ $data->job ?? '' }}"
                data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('job', this.value)">
        </td>
        <td class="toggleable">
            <input type="text" name="lot" id="lot" value="{{ $data->lot ?? '' }}"
                data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('lot', this.value)">
        </td>
        <td class="toggleable"></td>
        <td class="toggleable">{{ $data->part_number }}</td>
        <td class="toggleable">{{ $data->customer }}</td>
        <td class="toggleable">A00</td>
        <td class="toggleable">C (Superior)</td>
        @if ($loop->first)
            <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                <div class="parent-hightlighted">
                    <span>INVENTORY</span>
                </div>
            </td>
        @endif
        <td class="toggleable-1">0</td>
        <td class="toggleable-1">30,000 </td>
        <td class="toggleable-1">30,000 </td>
        <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
        <td class="toggleable-1"></td>
        <td class="toggleable-1">
            <input type="text" name="in_stock_finish" id="in_stock_finish"
                value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}"
                onkeyup="sendAjaxRequest('in_stock_finish', this.value)">
        </td>
        <td class="toggleable-1">
            <input type="text" name="in_process_outside" id="in_process_outside"
                value="{{ $data->in_process_outside ?? '' }}" data-id="{{ $data->id }}"
                onkeyup="sendAjaxRequest('in_process_outside', this.value)">
        </td>
        <td class="toggleable-1">
            <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}"
                data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value)">
        </td>
        <td class="toggleable-1"></td>
        <td class="toggleable-1">8.000</td>
        <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
        <td class="toggleable-1">0</td>
        <td class="toggleable-1"></td>
        <td class="toggleable-1">25,000</td>
        <td class="toggleable-1">{{ $data->order_notes }}</td>
        <td class="toggleable-1">{{ $data->part_notes }}</td>
        @if ($loop->first)
            <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                <div class="parent-hightlighted">
                    <span>CALENDER</span>
                </div>
            </td>
        @endif
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2">30,000</td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2"></td>
        <td class="toggleable-2">${{ $data->price }}</td>
        <td class="toggleable-2">{{ $data->notes }}</td>
    </tr>
@endforeach
