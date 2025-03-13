@extends('layouts.main')

@section('pg-title', ' Input Screen')

@section('content')
    <section class="visual-queue-screen">
        <div class="container bg-colored">
            <div class="row align-items-center mb-5">
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
                                    Return To Master Data
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <div class="accordion" id="accordionExample">
                            <h3 class="text-center mb-3">Work Center</h3>
                            @php
                                // Group entries by 'work_select.name'
                                $groupedEntries = collect($com1)->groupBy('work_select.name');
                            @endphp

                            @foreach ($groupedEntries as $workCenterName => $entries)
                                @php
                                    // Filter entries that meet the condition
                                    $validEntries = collect($entries)->filter(function ($entry) {
                                        return isset($entry['entries']['status'], $entry['entries']['planning']);
                                    });
                                @endphp

                                @if ($validEntries->isNotEmpty())
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ Str::slug($workCenterName) }}">
                                            <button class="accordion-button {{ $loop->first ? 'collapsed' : 'show' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ Str::slug($workCenterName) }}"
                                                aria-expanded="{{ $loop->first ? 'false' : 'true' }}"
                                                aria-controls="collapse{{ Str::slug($workCenterName) }}">
                                                <strong>
                                                    {{ $workCenterName }}
                                                </strong>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ Str::slug($workCenterName) }}"
                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                            aria-labelledby="heading{{ Str::slug($workCenterName) }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th>Customer</th>
                                                            <th>Part Number</th>
                                                            <th>Quantity</th>
                                                            <th>Job #</th>
                                                            <th>LOT #</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($validEntries as $entry)
                                                            @php
                                                                $status = $entry['entries']['status'];
                                                                $customer =
                                                                    $entry['entries']['get_customer']['CustomerName'] ??
                                                                    null;
                                                                $part_number =
                                                                    $entry['entries']['part']['Part_Number'] ?? null;
                                                                $planning = $entry['entries']['planning'] ?? null;
                                                                $job = $entry['entries']['job'];
                                                                $lot = $entry['entries']['lot'];
                                                                $id = $entry['id'] ?? null;
                                                                $work_select = $entry['work_select']['name'] ?? null;
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <select name="status" class="status"
                                                                        data-id="{{ $id }}">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                        {{-- <option value="Neutral"
                                                                            {{ $status == 'Neutral' ? 'selected' : '' }}>
                                                                            Neutral</option>
                                                                        <option value="Remove"
                                                                            {{ $status == 'Remove' ? 'selected' : '' }}>
                                                                            Remove</option> --}}
                                                                    </select>
                                                                </td>
                                                                <td class="customer_val">{{ $customer }}</td>
                                                                <td class="part_number_val"><a
                                                                        href="{{ route('get_qa', $entry['entries']['part_number']) }}"><input
                                                                            type="hidden" name="part"
                                                                            value="{{ $entry['entries']['part_number'] }}">{{ $part_number }}</a>
                                                                </td>
                                                                <td class="quantity_val">{{ $planning }}</td>
                                                                <td>
                                                                    {{-- @if (Auth::user()->role == 1) --}}
                                                                    <input type="text" name="job" class="job job_val"
                                                                        value="{{ $job }}">
                                                                    {{-- @else
                                                                    {{ $job }}
                                                                @endif --}}
                                                                </td>
                                                                <td>
                                                                    {{-- @if (Auth::user()->role == 1) --}}
                                                                    <input type="text" name="lot" class="lot lot_val"
                                                                        value="{{ $lot }}">
                                                                    {{-- @else
                                                                    {{ $lot }}
                                                                @endif --}}
                                                                </td>
                                                                <td style="display: none" class="type">
                                                                    {{ $work_select }}</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="btn-custom-btn text-center mt-3 mb-3">
                                                <button class="btn custom-btn submit-table-data"
                                                    data-id="collapse{{ Str::slug($workCenterName) }}">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        @if (!empty($out1) && count($out1) > 0)
                            <div class="accordion" id="accordionExample1">
                                <h3 class="text-center mb-3 mt-5">Out Source Processing</h3>

                                @php
                                    $groupedEntriesOut = collect($out1)->groupBy('out_source.name');
                                @endphp
                                @foreach ($groupedEntriesOut as $outSourceName => $entries)
                                    @php
                                        $hasValidEntry = false;
                                        foreach ($entries as $entry) {
                                            $status = $entry['entries_data']['status'] ?? null;
                                            $job = $entry['entries_data']['job'] ?? null;
                                            $lot = $entry['entries_data']['lot'] ?? null;
                                            $planning = $entry['entries_data']['planning'] ?? null;

                                            if ($status !== null && $planning !== null) {
                                                $hasValidEntry = true;
                                                break; // No need to check further if at least one entry is valid
                                            }
                                        }
                                    @endphp

                                    @if ($hasValidEntry)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ \Str::slug($outSourceName) }}">
                                                <button class="accordion-button {{ $loop->first ? 'collapsed' : 'show' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ \Str::slug($outSourceName) }}"
                                                    aria-expanded="{{ $loop->first ? 'false' : 'true' }}"
                                                    aria-controls="collapse{{ \Str::slug($outSourceName) }}">
                                                    <strong>
                                                        {{ $outSourceName }}
                                                    </strong>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ \Str::slug($outSourceName) }}"
                                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                aria-labelledby="heading{{ \Str::slug($outSourceName) }}"
                                                data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Status</th>
                                                                <th>Customer</th>
                                                                <th>Part Number</th>
                                                                <th>Quantity</th>
                                                                <th>Job #</th>
                                                                <th>LOT #</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($entries as $entry)
                                                                @php
                                                                    $status = $entry['entries_data']['status'] ?? null;
                                                                    $customer =
                                                                        $entry['entries_data']['get_customer'][
                                                                            'CustomerName'
                                                                        ] ?? null;
                                                                    $customer_id =
                                                                        $entry['entries_data']['get_customer']['id'] ??
                                                                        null;
                                                                    $part_number =
                                                                        $entry['entries_data']['part']['Part_Number'] ??
                                                                        null;
                                                                    $part_number_id =
                                                                        $entry['entries_data']['part']['id'] ?? null;
                                                                    $planning =
                                                                        $entry['entries_data']['planning'] ?? null;
                                                                    $job = $entry['entries_data']['job'] ?? null;
                                                                    $lot = $entry['entries_data']['lot'] ?? null;
                                                                    $id = $entry['id'] ?? null;
                                                                    $out_source = $entry['out_source']['name'] ?? null;
                                                                @endphp
                                                                @if ($status !== null && $planning !== null)
                                                                    <tr>
                                                                        <td>
                                                                            <select name="status" id="status"
                                                                                data-id="{{ $id }}">
                                                                                <option value="Running"
                                                                                    {{ $status == 'Running' ? 'selected' : '' }}>
                                                                                    Running</option>
                                                                                <option value="Pending Order"
                                                                                    {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                                    Pending Order</option>
                                                                                <option value="Pause"
                                                                                    {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                                    Pause</option>
                                                                                <option value="Closed"
                                                                                    {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                                    Closed</option>
                                                                                {{-- <option value="Neutral"
                                                                                    {{ $status == 'Neutral' ? 'selected' : '' }}>
                                                                                    Neutral</option>
                                                                                <option value="Remove"
                                                                                    {{ $status == 'Remove' ? 'selected' : '' }}>
                                                                                    Remove</option> --}}
                                                                            </select>
                                                                        </td>
                                                                        <td class="customer_val">
                                                                            {{ $customer }}
                                                                        </td>
                                                                        <td class="part_number_val">
                                                                            <a
                                                                                href="{{ route('get_qa', $entry['entries_data']['part_number']) }}">
                                                                                <input type="hidden" name="part"
                                                                                    value="{{ $entry['entries_data']['part_number'] }}">
                                                                                {{ $part_number }}
                                                                            </a>
                                                                        </td>
                                                                        <td class="quantity_val">
                                                                            {{ $planning }}
                                                                        </td>
                                                                        <td>
                                                                            {{-- @if (Auth::user()->role == 1) --}}
                                                                            <input type="text" name="job"
                                                                                class="job job_val"
                                                                                value="{{ $job }}">
                                                                            {{-- @else
                                                                                {{ $job }}
                                                                            @endif --}}
                                                                        </td>
                                                                        <td>
                                                                            {{-- @if (Auth::user()->role == 1) --}}
                                                                            <input type="text" name="lot"
                                                                                class="lot lot_val"
                                                                                value="{{ $lot }}">
                                                                            {{-- @else
                                                                                {{ $lot }}
                                                                            @endif --}}
                                                                        </td>
                                                                        <td style="display: none" class="type">
                                                                            {{ $out_source }}</td>
                                                                        <td style="display: none">{{ $id }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="btn-custom-btn text-center mt-3 mb-3">
                                                    <button class="btn custom-btn submit-table-data-2"
                                                        data-id="collapse{{ Str::slug($outSourceName) }}">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                        @endif
                    </div>
                    <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                        <a href="{{ route('visual_screen') }}" class="btn custom-btn" target="_blank">Visual Screen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.submit-table-data').click(function() {
                let $button = $(this);
                $button.prop('disabled', true);
                // e.preventDefault();
                var dataId = $(this).data('id');
                console.log(dataId);

                let tableData = [];
                let target = $(this).data('id'); // Use `data-target` attribute directly
                if (dataId) {
                    let collapseId = dataId; // Assign directly if target is available
                    $('#' + collapseId + ' tbody tr').each(function() {
                        let row = $(this);
                        let entry = {
                            status: row.find('select[name="status"]').val(),
                            customer: row.find('.customer_val').text() ?? null,
                            part_number: row.find('[name="part"]').val() ?? null,
                            quantity: row.find('.quantity_val').text() ?? null,
                            job: row.find('.job_val').val() ?? null,
                            lot: row.find('.lot_val').val() ?? null,
                            type: row.find('td:eq(6)').text().trim(),
                            type_id: row.find('td:eq(7)').text().trim()
                        };
                        tableData.push(entry);
                    });
                    // console.log(tableData);
                    // return tableData;

                    $.ajax({
                        url: "{{ route('save_table_data') }}",
                        method: "POST",
                        data: {
                            entries: tableData
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#' + collapseId).collapse('hide');
                            } else {
                                // Handle failure case
                                console.error('fails');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        },
                        complete: function() {
                            $button.prop('disabled', false);
                        }
                    });
                } else {
                    console.error('No target specified for collapse.');
                    $button.prop('disabled', false);
                }
            });

            $('.submit-table-data-2').click(function() {
                let $button = $(this);
                $button.prop('disabled', true);
                // e.preventDefault();
                var dataId = $(this).data('id');
                console.log(dataId);

                let tableData = [];
                if (dataId) {
                    let collapseId = dataId; // Assign directly if target is available
                    $('#' + collapseId + ' tbody tr').each(function() {
                        let row = $(this);
                        let entry = {
                            status: row.find('select[name="status"]').val(),
                            customer: row.find('.customer_val').text() ?? null,
                            part_number: row.find('[name="part"]').val() ?? null,
                            quantity: row.find('.quantity_val').text() ?? null,
                            job: row.find('.job_val').val() ?? null,
                            lot: row.find('.lot_val').val() ?? null,
                            type: row.find('td:eq(6)').text().trim(),
                            type_id: row.find('td:eq(7)').text().trim()
                        };
                        tableData.push(entry);
                    });
                    // console.log(tableData);
                    // return tableData;

                    $.ajax({
                        url: "{{ route('save_table_data_2') }}",
                        method: "POST",
                        data: {
                            entries_data: tableData
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#' + collapseId).collapse('hide');
                            } else {
                                // Handle failure case
                                console.error('fails');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        },
                        complete: function() {
                            $button.prop('disabled', false);
                        }
                    });
                } else {
                    console.error('No target specified for collapse.');
                    $button.prop('disabled', false);
                }
            });
        });

        $(document).ready(function() {
            $('.status').on('change', function() {
                let selectedValue = $(this).val();
                let selectElement = $(this);
                let id = $(this).data('id');

                if (selectedValue === 'Remove') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action will delete the record permanently!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send an AJAX request to delete the data
                            $.ajax({
                                url: "{{ route('remove_input_screen') }}", // Change this to your delete route
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}', // Laravel CSRF token
                                    id: id // Pass the record ID dynamically
                                },
                                success: function(response) {
                                    Swal.fire('Deleted!',
                                        'The record has been deleted.', 'success');
                                    selectElement.closest('tr')
                                        .remove(); // Remove row from table if applicable
                                },
                                error: function() {
                                    Swal.fire('Error!', 'Something went wrong.',
                                        'error');
                                }
                            });
                        } else {
                            // Reset to the previous value if cancel is clicked
                            selectElement.val(selectElement.data('previousValue'));
                        }
                    });
                } else {
                    // Store previous value before change
                    $(this).data('previousValue', selectedValue);
                }
            });
        });


        // $(document).ready(function() {
        //     $('.submit-table-data-1-one').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseOne tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseOne').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-1-two').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseTwo tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseTwo').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-1-three').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseThree tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseThree').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });


        //     $('.submit-table-data-2-one').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseFour tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseFour').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-2-two').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseFifth tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseFifth').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-2-three').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseSix tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseSix').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });
        // });
    </script>
@endsection
