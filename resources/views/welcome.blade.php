@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css" rel="stylesheet">
    <style>
        .custom-dropdown-menu {
            display: none;
            /* position: absolute; */
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            list-style: none;
            z-index: 1000;
            /* Ensure it stays above other elements */
        }

        .custom-dropdown:hover .custom-dropdown-menu {
            display: block;
        }

        .custom-dropdown-item {
            padding: 5px 10px;
            text-decoration: none;
            color: black;
            cursor: pointer;
        }

        .custom-dropdown-item:hover {
            background-color: #f0f0f0;
        }

        #filter-3 {
            width: 10%;
        }

        /*column config css*/

        .div_column_item {
            border: 1px solid #504343;
            border-radius: 4px;
            padding: 6px 18px 6px 12px;
            margin: 5px 0px 5px 0px;
            background-color: #e6e6e6;
            font-size: 12px;
        }

        .anchor_column_visibility_toggle {
            cursor: pointer;
        }

        /*column config css*/

        .simple-text,
        .simple-text[type="number"] {
            border: none;
            background: transparent;
            padding: 0;
            font-family: inherit;
            font-size: inherit;
            color: inherit;
            text-align: left;
            width: auto;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            pointer-events: none;
            cursor: default;
        }

        .simple-text[type="number"]::-webkit-outer-spin-button,
        .simple-text[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .simple-text:focus,
        .simple-text[type="number"]:focus {
            outline: none;
        }


        .simple-select {
            border: none;
            background: transparent;
            padding: 0;
            font-family: inherit;
            font-size: inherit;
            color: inherit;
            text-align: left;
            width: auto;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            pointer-events: none;
            cursor: default;
        }

        .simple-select:focus {
            outline: none;
        }

        .simple-textarea {
            border: none;
            background: transparent;
            padding: 0;
            font-family: inherit;
            font-size: inherit;
            color: inherit;
            text-align: left;
            width: auto;
            height: auto;
            resize: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            pointer-events: none;
            cursor: default;
        }

        .simple-textarea:focus {
            outline: none;
        }


        .custom-custom-picker {
            position: relative;
            z-index: 0;
            width: 65px;
        }

        .custom-custom-picker button {
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            z-index: -1;
        }

        .custom-custom-picker select#highlight_color {
            background: transparent;
            opacity: 0;
        }

        .custom-custom-picker select option:nth-child(01) {
            background: rgb(255, 255, 255);
        }

        .custom-custom-picker select option:nth-child(02) {
            background: rgb(255, 0, 0);
        }

        .custom-custom-picker select option:nth-child(03) {
            background: rgb(82, 82, 255);
        }

        .custom-custom-picker select option:nth-child(04) {
            background: rgb(0, 128, 0);
        }

        .custom-custom-picker select option:nth-child(05) {
            background: rgb(255, 193, 7);
        }

        #btn_highlight_cell {
            background-color: rgb(255, 255, 255);
        }

        .parent-table table thead {
            position: relative;
            z-index: 100;
        }

        .parent-table table tr.colored-table-row {
            position: sticky;
            top: 0;
            z-index: 9;
        }

        .parent-table table {
            overflow: unset;
        }

        #department {
            font-size: 12px;
        }

        select#work-center {
            font-size: 12px;
        }

        tbody#entries-table-body select {
            font-size: 12px;
            width: 80px;
        }

        table.table tr th {
            font-size: 12px;
            width: 100px !important;
            display: inline-block;
            overflow: auto;
            height: 35px;

        }

        .parent-table table input,
        .parent-table table textarea {}

        tbody#entries-table-body td {
            font-size: 12px;
        }

        .part-st {
            font-size: 12px;
            display: contents;
            white-space: normal;
        }

        table#entries-table td {
            height: 40px !important;
            display: inline-block;
            width: 100px;
            overflow: auto;
            position: relative;
        }

        table#entries-table td::-webkit-scrollbar {
            height: 1px;
        }

        .parent-table table textarea::-webkit-scrollbar {
            width: 1px;
        }

        .highlighted.toggle-header {
            width: 40px !important;

        }

        td.vertical-text.highlighted {
            width: 40px !important;
        }

        .highlighted.toggle-header-1 {
            width: 40px !important;

        }

        .highlighted.toggle-header-2 {
            width: 40px !important;
        }

        table.table tr th::-webkit-scrollbar {
            height: 1px;
        }

        .custom-toggleable {
            overflow: unset !important;
            /* width: 150px !important; */
        }

        .custom-dropdown-menu {
            position: absolute;
            left: 95px;
            top: 0;
        }

        .parent-table .table #column-part_number {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 99999;
        }

        #entries-table-body .entries_part_number {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 5;
            padding: 0;
        }
    </style>
@endsection


@section('content')
    @php
        $highlighted_cell_identifiers = auth()->user()->highlighted_cell_identifiers();
        $highlighted_cell_colors = auth()->user()->highlighted_cell_colors();

        $highlight_map = [];
        foreach ($highlighted_cell_identifiers as $key => $item) {
            $highlight_map[$item] = $highlighted_cell_colors[$key];
        }
    @endphp
    <section class="master-data-section">
        <div class="container-fluid bg-colored pt-0">
            <div class="row align-items-center custom-row justify-content-center">
                <div class="col-lg-8 col-md-9 col-12">
                    <div class="title">
                        <h1 class="heading-1 text-center">
                            Master Data
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row align-items-base justify-content-end master-data-filter invoice-listing-select-bar">
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter" data-intro='Hello step one!'>
                        <select class="js-select2" id="filter1">
                            <option value="All">ALL DEPARTMENT</option>
                            @foreach ($department as $dept)
                                <option value="{{ $dept->id }}">
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="filter2">
                            <option selected="">All</option>
                            <option value="pending">Pending orders</option>
                            <option value="prd">Parts req for PRD</option>
                        </select>
                        <button type="button" id="filter-3" class="btn btn-primary ml-4" data-bs-toggle="modal"
                            data-bs-target="#filter3" title="Show/Hide Columns">
                            <i class="fas fa-eye"></i>
                        </button>
                        <!-- Color Selection -->
                        <div class="custom-custom-picker">
                            <button type="button" id="btn_highlight_cell" class="btn ml-4"
                                title="Highlight a specific cell">
                                <i class="fas fa-highlighter"></i>
                            </button>
                            <select id="highlight_color" class="form-control">
                                <option value="rgb(255, 255, 255)" selected></option>
                                <option value="rgb(255, 0, 0)"></option>
                                <option value="rgb(82, 82, 255)"></option>
                                <option value="rgb(0, 128, 0)"></option>
                                <option value="rgb(255, 193, 7)"></option>
                            </select>
                        </div>

                        <!-- Highlight Button -->
                        {{-- <button type="button" id="btn_highlight_cell" class="btn btn-warning ml-4" title="Highlight a specific cell">
                            <i class="fas fa-highlighter"></i>
                        </button> --}}
                        {{-- <button type="button" class="btn btn-primary ml-4" data-bs-toggle="modal" data-bs-target="#exampleModal" width="100%">
                            Open Modal
                            </button> --}}
                    </div>
                </div>
            </div>

            @php
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

            <button onclick="exportTableToExcel()">Export to Excel</button>

            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <table class="table table-hover table-bordered" id="entries-table">
                            <thead>
                                <tr class="colored-table-row">
                                    <th style="display: none">Delete</th>
                                    @if (Auth::user()->View_1 == 1)
                                        <th scope="col" class="highlighted toggle-header">
                                            <span class="icon">▼</span>
                                        </th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="toggleable toggle-header-active">Active/InActive</th>
                                        @endif
                                        @foreach ($region_1_column_configuration as $region_1_column_configuration_item)
                                            <th scope="col" id="column-{{ $region_1_column_configuration_item->column }}"
                                                class="toggleable toggle-header-{{ $region_1_column_configuration_item->column }}"
                                                @if (!$region_1_column_configuration_item->visibility) hidden @endif>
                                                {{ strtoupper(get_column_label($region_1_column_configuration_item->column)) }}
                                                {{-- <span class="icon">▼</span> --}}
                                            </th>
                                        @endforeach
                                    @endif
                                    @if (Auth::user()->View_2 == 1)
                                        <th scope="col" class="highlighted toggle-header-1">
                                            <span class="icon">▼</span>
                                        </th>

                                        @foreach ($region_2_column_configuration as $region_2_column_configuration_item)
                                            <th scope="col" id="column-{{ $region_2_column_configuration_item->column }}"
                                                class="toggleable-1 toggle-header-{{ $region_2_column_configuration_item->column }}"
                                                @if (!$region_2_column_configuration_item->visibility) hidden @endif>
                                                {{ strtoupper(get_column_label($region_2_column_configuration_item->column)) }}
                                                {{-- <span class="icon">▼</span> --}}
                                            </th>
                                        @endforeach
                                    @endif
                                    @if (Auth::user()->View_1 == 1)
                                        <th scope="col" class="highlighted toggle-header-2">
                                            <span class="icon">▼</span>
                                        </th>

                                        <th scope="col" class="toggleable-2 toggle-header-department" disabled>PAST DUE
                                            {{-- <span class="icon">▼</span> --}}</th>
                                        @for ($week = 1; $week <= 16; $week++)
                                            <th scope="col" class="toggleable-2 toggle-header-department"
                                                id="head_week_{{ $week }}">
                                                {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                            </th>
                                        @endfor
                                        @for ($month = 5; $month <= 12; $month++)
                                            <th scope="col" class="toggleable-2 toggle-header-department"
                                                id="head_month_{{ $month }}">
                                                @if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $month5StartDate))
                                                    {{ date('j-M', strtotime($month5StartDate)) }}
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
                                        <th scope="col" class="toggleable-2 toggle-header-department" disabled>FUTURE RAW
                                        </th>
                                        <th scope="col" class="toggleable-2 toggle-header-department" disabled>PRICE
                                            {{-- <span class="icon">▼</span> --}}</th>
                                        <th scope="col" class="toggleable-2 toggle-header-department" disabled>NOTES
                                            {{-- <span class="icon">▼</span> --}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="entries-table-body">
                                @include('partials.entries', ['entries' => $entries])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for showing/hiding columns -->
    <div class="modal fade" id="filter3" tabindex="-1" aria-labelledby="filter3Label">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filter3Label">Column configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0px 40px 0px 40px;">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="row">
                                <div class="col-md-12 text-center" style="margin: 15px 0px 0px 0px;">
                                    <h6 style="font-weight: 100;">
                                        <i class="fas fa-info text-primary"></i>
                                        Drag the items to change column order
                                    </h6>
                                </div>
                                <div class="col-md-12 text-center" style="margin: 0px 0px 10px 0px;">
                                    <h6 style="font-weight: 100;">
                                        <i class="fas fa-eye text-primary"></i>
                                        Toggle column visibility
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="row px-2" id="region_1_columns_container">
                                        @foreach ($region_1_column_configuration as $region_1_column_configuration_item)
                                            <div class="col-md-12 div_column_item"
                                                data-column="{{ $region_1_column_configuration_item->column }}">
                                                <div class="row">
                                                    <div class="col-md-11 text-left" style="cursor: pointer;">
                                                        <span>{{ get_column_label($region_1_column_configuration_item->column) }}</span>
                                                    </div>
                                                    <div class="col-md-1 text-center" style="cursor: pointer;">
                                                        @php
                                                            $color = $region_1_column_configuration_item->visibility
                                                                ? 'rgb(0, 0, 0)'
                                                                : 'red';
                                                            $class = $region_1_column_configuration_item->visibility
                                                                ? 'fa-eye'
                                                                : 'fa-eye-slash';
                                                        @endphp
                                                        <i class="fas {{ $class }} anchor_column_visibility_toggle"
                                                            style="color: {{ $color }}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row px-2" id="region_2_columns_container">
                                        @foreach ($region_2_column_configuration as $region_2_column_configuration_item)
                                            <div class="col-md-12 div_column_item"
                                                data-column="{{ $region_2_column_configuration_item->column }}">
                                                <div class="row">
                                                    <div class="col-md-11 text-left" style="cursor: pointer;">
                                                        <span>{{ get_column_label($region_2_column_configuration_item->column) }}</span>
                                                    </div>
                                                    <div class="col-md-1 text-center" style="cursor: pointer;">
                                                        @php
                                                            $color = $region_2_column_configuration_item->visibility
                                                                ? 'rgb(0, 0, 0)'
                                                                : 'red';
                                                            $class = $region_2_column_configuration_item->visibility
                                                                ? 'fa-eye'
                                                                : 'fa-eye-slash';
                                                        @endphp
                                                        <i class="fas {{ $class }} anchor_column_visibility_toggle_2"
                                                            style="color: {{ $color }}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-12 text-center mt-2 mb-4">
                                    <span class="badge bg-success" id="save-columns" style="cursor: pointer;">
                                        <i class="fas fa-floppy-disk text-white"></i>
                                        Save changes
                                    </span>
                                    <span class="badge bg-danger" id="reset-columns" style="cursor: pointer;">
                                        <i class="fas fa-floppy-disk text-white"></i>
                                        Reset changes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="modal-footer"> --}}
                {{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                {{--                    <button type="button" class="btn btn-primary" id="save-columns">Save Changes</button> --}}
                {{--                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
    {{--    <script> --}}
    {{--        introJs().start(); --}}
    {{--    </script> --}}

    <script>
        $(document).ready(function() {
            //Region 1 & 2 column configuration
            let region_1_column_configuration = '';
            let region_2_column_configuration = '';

            $('.anchor_column_visibility_toggle').on('click', function() {
                $(this).addClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye-slash' : 'fa-eye');
                $(this).removeClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye' : 'fa-eye-slash');
                $(this).css('color', ($(this).css('color') == 'rgb(0, 0, 0)' ? 'red' : 'black'));

                saveRegion1ColumnConfiguration();
            });

            $('.anchor_column_visibility_toggle_2').on('click', function() {
                $(this).addClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye-slash' : 'fa-eye');
                $(this).removeClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye' : 'fa-eye-slash');
                $(this).css('color', ($(this).css('color') == 'rgb(0, 0, 0)' ? 'red' : 'black'));

                saveRegion2ColumnConfiguration();
            });

            const stack1 = document.getElementById('region_1_columns_container');
            const stack2 = document.getElementById('region_2_columns_container');

            new Sortable(stack1, {
                animation: 150,
                onEnd: function(evt) {
                    saveRegion1ColumnConfiguration();
                },
            });
            new Sortable(stack2, {
                animation: 150,
                onEnd: function(evt) {
                    saveRegion2ColumnConfiguration();
                },
            });

            // Save Order
            function saveRegion1ColumnConfiguration() {
                let column_configuration = [];
                $('#region_1_columns_container').find('.div_column_item').each((i, item) => {
                    column_configuration.push({
                        column: $(item).data('column'),
                        order: i + 1,
                        visibility: $(item).find('.anchor_column_visibility_toggle').css('color') ==
                            'rgb(0, 0, 0)' ? true : false
                    });
                });

                region_1_column_configuration = JSON.stringify(column_configuration);
            }

            function saveRegion2ColumnConfiguration() {
                let column_configuration = [];
                $('#region_2_columns_container').find('.div_column_item').each((i, item) => {
                    column_configuration.push({
                        column: $(item).data('column'),
                        order: i + 1,
                        visibility: $(item).find('.anchor_column_visibility_toggle_2').css(
                            'color') == 'rgb(0, 0, 0)' ? true : false
                    });
                });

                region_2_column_configuration = JSON.stringify(column_configuration);
            }

            //save changes - ajax request
            $('#save-columns').on('click', function() {
                if (region_1_column_configuration != '') {
                    $.ajax({
                        url: '{{ route('save.user.configuration') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            key: 'master_screen_region_1_column_configuration',
                            value: region_1_column_configuration,
                        }
                    });
                }

                if (region_2_column_configuration != '') {
                    $.ajax({
                        url: '{{ route('save.user.configuration') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            key: 'master_screen_region_2_column_configuration',
                            value: region_2_column_configuration,
                        },
                    });
                }


                // $('#filter3').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Changes saved!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(() => {
                            location.reload(); // Reload the page after 1-second delay
                        }, 1000);
                    }
                });
            });

            //reset changes
            $('#reset-columns').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will reset all column configurations to default!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reset it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('reset.user.configuration') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: (data) => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            setTimeout(() => {
                                                location
                                                    .reload(); // Reload the page after 1-second delay
                                            }, 1000);
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message
                                    });
                                }
                            },
                            error: (e) => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred.'
                                });
                            }
                        });
                    }
                });
            });

            //target cell feature
            let target_cell_id = '#' + '{{ $target_cell_id }}';
            if (target_cell_id != '#0') {
                var container = $('.parent-table');
                var targetCell = $(target_cell_id);

                // Calculate the position of the target cell relative to the container
                var cellPosition = targetCell.position();

                // Get the dimensions of the container and the target cell
                var containerHeight = container.height();
                var containerWidth = container.width();
                var cellHeight = targetCell.outerHeight();
                var cellWidth = targetCell.outerWidth();

                // Adjust the scroll positions to center the cell
                var scrollTop = container.scrollTop() + cellPosition.top - container.offset().top - (
                    containerHeight / 2) + (cellHeight / 2);
                var scrollLeft = container.scrollLeft() + cellPosition.left - container.offset().left - (
                    containerWidth / 2) + (cellWidth / 2);

                // Scroll the container to bring the target cell into the center
                container.scrollTop(scrollTop);
                container.scrollLeft(scrollLeft);

                // Highlight the cell with an animation
                targetCell.css('background-color', 'yellow');
                setTimeout(function() {
                    targetCell.css('background-color', '');
                }, 4000); // Remove highlight after 2 seconds
            }

            //target row feature
            let target_row_id = '#entry_number_' + '{{ $target_row_id }}';
            if (target_row_id != '#entry_number_0') {
                var container = $('.parent-table');
                var targetCell = $(target_row_id);

                // Calculate the position of the target row relative to the container
                var rowPosition = targetCell.position();

                // Get the dimensions of the container and the target row
                var containerHeight = container.height();
                var containerWidth = container.width();
                var rowHeight = targetCell.outerHeight();
                var rowWidth = targetCell.outerWidth();

                // Adjust the scroll positions to center the row
                var scrollTop = container.scrollTop() + rowPosition.top - container.offset().top - (
                    containerHeight / 2) + (rowHeight / 2);
                // var scrollLeft = container.scrollLeft() + rowPosition.left - container.offset().left - (containerWidth / 2) + (rowWidth / 2);

                // Scroll the container to bring the target row into the center
                container.scrollTop(scrollTop);
                // container.scrollLeft(scrollLeft);

                // Highlight the row with an animation
                targetCell.css('background-color', 'yellow');
                setTimeout(function() {
                    targetCell.css('background-color', '');
                }, 4000); // Remove highlight after 2 seconds
            }

            //highligt cell
            let highlight_button_is_clicked = false;
            let highlighted_cell_identifiers = @json($highlighted_cell_identifiers);
            let highlight_map = @json($highlight_map);

            for (const highlighted_cell_identifier of highlighted_cell_identifiers) {
                $('#' + highlighted_cell_identifier).css('background-color', highlight_map[
                    highlighted_cell_identifier]);
            }

            // $('#highlight_color').on('change', function() {
            //     // Get selected color
            //     let selectedColor = $(this).val();

            //     highlight_button_is_clicked = !(highlight_button_is_clicked);

            //     // Change background color of the dropdown
            //     $('#btn_highlight_cell').css('background-color', selectedColor);
            // });

            // $('.toggleable-1, .toggleable, .toggleable-2').on('click', function(event) {
            //     if ($(event.target).is('.custom-dropdown-item')) {
            //         window.open($(event.target).attr('href'), '_blank');
            //     }

            //     if (!highlight_button_is_clicked) {
            //         return false;
            //     }

            //     if ($(this).css('background-color') !== 'rgba(0, 0, 0, 0)') {
            //         $(this).css('background-color', 'rgba(0, 0, 0, 0)');

            //         $.ajax({
            //             url: '',
            //             method: 'POST',
            //             data: {
            //                 _token: '{{ csrf_token() }}',
            //                 identifier: $(this).attr('id'),
            //             },
            //             success: (data) => {
            //                 console.log('un highlighted!');
            //             }
            //         });

            //         // highlight_button_is_clicked = false;
            //         return false;
            //     }

            //     // Get selected color
            //     let color = $('#highlight_color').val();
            //     $(this).css('background-color', color);

            //     $.ajax({
            //         url: '{{ route('highlight_cell_for_me') }}',
            //         method: 'POST',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             identifier: $(this).attr('id'),
            //             color: color
            //         },
            //         success: (data) => {
            //             console.log('highlighted!');
            //         }
            //     });

            //     // highlight_button_is_clicked = false;
            // });
            $(document).ready(function() {
                // Change the button color when selecting a color
                $('#highlight_color').on('change', function() {
                    let selectedColor = $(this).val();
                    $('#btn_highlight_cell').css('background-color', selectedColor);
                });

                // Apply the selected color to the clicked cell
                $('.toggleable-1, .toggleable, .toggleable-2').on('click', function(event) {
                    // if ($(event.target).is('.custom-dropdown-item')) {
                    //     window.open($(event.target).attr('href'), '_blank');
                    // }
                    let color = $('#highlight_color').val();

                    // Functions to handle color conversions
                    function hexToRgb(hex) {
                        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
                        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                            return r + r + g + g + b + b;
                        });
                        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                        return result ? {
                            r: parseInt(result[1], 16),
                            g: parseInt(result[2], 16),
                            b: parseInt(result[3], 16)
                        } : null;
                    }

                    function parseRgb(rgbStr) {
                        var match = rgbStr.match(
                            /^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*[\d.]+)?\)$/);
                        return match ? {
                            r: parseInt(match[1], 10),
                            g: parseInt(match[2], 10),
                            b: parseInt(match[3], 10)
                        } : null;
                    }

                    // Get current background and selected color in RGB format
                    let bgColor = $(this).css('background-color');
                    let selectedRgb = hexToRgb(color);
                    let bgRgb = parseRgb(bgColor);

                    // Check if colors match (RGB comparison)
                    if (selectedRgb && bgRgb &&
                        selectedRgb.r === bgRgb.r &&
                        selectedRgb.g === bgRgb.g &&
                        selectedRgb.b === bgRgb.b) {
                        return; // Colors match, do nothing
                    }

                    // Apply the new color
                    $(this).css('background-color', color);

                    // Send the color update request
                    $.ajax({
                        url: '{{ route('highlight_cell_for_me') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            identifier: $(this).attr('id'),
                            color: color
                        },
                        success: (data) => {
                            console.log('Color updated!');
                        }
                    });
                });
            });

        });

        // function sendAjaxRequest(field, value) {
        //     var inputElement = event.target;
        //     var dataId = inputElement.getAttribute('data-id');
        //     var data = {
        //         id: dataId,
        //         field: field,
        //         value: value
        //     };

        //     $.ajax({
        //         url: "{{ route('manual_imput') }}",
        //         method: 'POST',
        //         data: data,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log('Success:', response);
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //         }
        //     });
        // }

        let typingTimer; // Timer variable
        let typingTimer2;
        let typingTimer3;
        const typingTimeout = 500; // 2 seconds of no typing

        function sendAjaxRequest(field, value, event, text = '') {
            const inputElement = event.target;
            const dataId = inputElement.getAttribute('data-id');

            const isDropdown = inputElement.tagName === 'SELECT';
            console.log(isDropdown);

            if (field === 'planning' || field === 'live_inventory_wip' ||
                field === 'live_inventory_finish' || field === 'in_stock_live' || 'wt_pc' ||
                field === 'min_ship' || 'future_raw' || 'price') {
                const isNumeric = /^-?\d+(,\d{3})*(\.\d+)?$/.test(value);

                if (isNumeric) {
                    value = value.replace(/,/g, '');
                }
            }

            const data = {
                id: dataId,
                field: field,
                value: value,
                text: text
            };

            if (value == "") {
                return false;
            }

            if (isDropdown) {
                // Directly send AJAX request for dropdowns without delay
                $.ajax({
                    url: "{{ route('manual_imput') }}",
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Success:', response);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                clearTimeout(typingTimer);

                typingTimer = setTimeout(() => {
                    $.ajax({
                        url: "{{ route('manual_imput') }}",
                        method: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Success:', response);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }, typingTimeout);
            }
        }

        function sendAjaxRequest2(field, value, event) {
            const inputElement = event.target;
            const dataId = inputElement.getAttribute('data-id');

            const data = {
                id: dataId,
                field: field,
                value: value
            };

            clearTimeout(typingTimer2);

            typingTimer2 = setTimeout(() => {
                $.ajax({
                    url: "{{ route('manual_imput_work') }}",
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Success:', response);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }, typingTimeout);
        }

        function sendAjaxRequest3(field, value, event) {
            const inputElement = event.target;
            const entryId = inputElement.getAttribute('data-entry-id');
            const dataId = inputElement.getAttribute('data-id');

            const data = {
                entry_id: entryId,
                id: dataId,
                field: field,
                value: value
            };

            clearTimeout(typingTimer3);

            typingTimer3 = setTimeout(() => {
                $.ajax({
                    url: "{{ route('manual_imput_out') }}",
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Success:', response);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }, typingTimeout);
        }


        // function sendAjaxRequest2(field, value) {
        //     var inputElement = event.target;
        //     var dataId = inputElement.getAttribute('data-id');
        //     var data = {
        //         id: dataId,
        //         field: field,
        //         value: value
        //     };

        //     $.ajax({
        //         url: "{{ route('manual_imput_work') }}",
        //         method: 'POST',
        //         data: data,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log('Success:', response);
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //         }
        //     });
        // }

        // function sendAjaxRequest3(field, value) {
        //     var inputElement = event.target;
        //     var dataId = inputElement.getAttribute('data-id');
        //     var data = {
        //         id: dataId,
        //         field: field,
        //         value: value
        //     };

        //     $.ajax({
        //         url: "{{ route('manual_imput_out') }}",
        //         method: 'POST',
        //         data: data,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log('Success:', response);
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //         }
        //     });
        // }

        $(document).ready(function() {
            // Handle filter changes
            $('#filter1, #filter2').on('change', function() {
                let department = $('#filter1').val();
                let filter = $('#filter2').val();
                let searchQuery = $('#search-input').val();

                // Send AJAX request
                $.ajax({
                    url: '{{ route('index') }}',
                    type: 'GET',
                    data: {
                        department: department,
                        filter: filter,
                        search: searchQuery
                    },
                    success: function(response) {
                        // Replace table content with new data
                        $('#entries-table-body').html(response.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#search-input').on('keyup', function() {
                let searchQuery = $(this).val();
                let department = $('#filter1').val();
                let filter = $('#filter2').val();

                // Send AJAX request
                $.ajax({
                    url: '{{ route('index') }}',
                    type: 'GET',
                    data: {
                        department: department,
                        filter: filter,
                        search: searchQuery
                    },
                    success: function(response) {
                        // Replace table content with new data
                        $('#entries-table-body').html(response.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>



    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon


                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });
    </script>




    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-1").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable-1"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });
    </script>

    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-2").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable-2"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });

        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-department").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggle-department"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon
                return false;
                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("active-td");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");

                // Add or remove the 'active' class to the header
                this.classList.toggle("active");
            });
        });




        // $('body').on('click', '.custom-dropdown-item', function(e) {
        //     alert();
        //     window.open($(this).attr('href'), '_blank');
        //     // console.log('clicked');
        //     // e.preventDefault();
        //     //
        //     // const partNumber = $(this).data('part');
        //     // const url = $(this).data('url');
        //     //
        //     // if (url && partNumber) {
        //     //     const fullUrl = `${url}?part_number=${partNumber}`;
        //     //     window.open(fullUrl, '_blank');
        //     // }
        // });


        function formatNumberWithCommas(element) {
            const value = element.value.replace(/[^0-9]/g, '');
            element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function decimalPlaces(element) {
            let value = element.value;
            value = value.replace(/[^0-9.]/g, '');

            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1].slice(0, 3);
            } else if (parts.length === 2 && parts[1].length > 3) {
                value = parts[0] + '.' + parts[1].slice(0, 3);
            }

            element.value = value;
        }


        function preventNegativeValue(element) {
            if (element.value < 0) {
                element.value = element.value.replace('-', '');
            }
        }

        // Attach event listener to the save button
        // document.getElementById('save-columns').addEventListener('click', function() {
        //     const columns = [
        //         { id: 'column-department', class: 'toggle-header-department' },
        //         { id: 'column-work_center', class: 'toggle-header-work-center' },
        //         { id: 'column-status', class: 'toggle-header-status' }
        //         // Add more columns as necessary
        //     ];

        //     // Loop through the columns and toggle visibility based on checkbox state
        //     columns.forEach(col => {
        //         const checkbox = document.getElementById(col.id);
        //         const columnHeaders = document.querySelectorAll(`.${col.class}`);

        //         if (checkbox.checked) {
        //             columnHeaders.forEach(header => {
        //                 header.style.display = '';  // Show column
        //             });
        //         } else {
        //             columnHeaders.forEach(header => {
        //                 header.style.display = 'none';  // Hide column
        //             });
        //         }
        //     });

        //     // After toggling columns, save the preferences
        //     saveColumnPreferences(columns);
        // });

        // function saveColumnPreferences(columns) {
        //     const selectedColumns = [];

        //     // Collect the ids of selected columns
        //     columns.forEach(col => {
        //         const checkbox = document.getElementById(col.id);
        //         if (checkbox.checked) {
        //             selectedColumns.push(col.id);  // Push the column id into the array
        //         }
        //     });

        //     console.log('User selected columns: ', selectedColumns);

        //     // Send the selected columns via AJAX to the server
        //     $.ajax({
        //         url: "{{ route('save_columns_preferences') }}",  // Laravel route to save preferences
        //         type: 'POST',
        //         data: {
        //             columns: selectedColumns  // Send the selected column ids to the server
        //         },
        //         headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        //         success: function(response) {
        //             console.log('Column preferences saved successfully');
        //         },
        //         error: function(xhr) {
        //             console.error('Error saving column preferences:', xhr.responseText);
        //         }
        //     });
        // }


        function showTextAbove(element) {
            // Get the parent <td> of the hovered element
            const parentTd = element.closest("td");

            // Remove any existing overlays
            parentTd.querySelectorAll(".text-overlay").forEach(overlay => overlay.remove());

            // Get the input value inside the <td>
            const inputValue = parentTd.querySelector("input").value;

            // Create a new div for the text overlay
            const overlay = document.createElement("div");
            overlay.className = "text-overlay";
            overlay.textContent = inputValue; // Set the input's value as the text

            // Append the overlay to the <td>
            parentTd.appendChild(overlay);

            // Remove the overlay on mouse leave
            parentTd.addEventListener("mouseleave", () => {
                overlay.remove();
            }, {
                once: true
            }); // Use `{ once: true }` to ensure the listener is removed after firing once
        }

        $(document).on('click', '.delete-entry', function() {
            let entryId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-entry') }}/" + entryId,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            $("textarea, .custom-textarea").on("dblclick", function() {
                let currentValue = $(this).val().trim() || $(this).text()
                    .trim(); // Get the current textarea value

                Swal.fire({
                    title: "Order Notes",
                    text: currentValue || "No notes available.",
                    icon: "info",
                    confirmButtonText: "OK"
                });
            });
        });

        function exportTableToExcel() {
            let table = document.getElementById("entries-table");
            let ws = XLSX.utils.table_to_sheet(table);
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Entries");

            // Save the file
            XLSX.writeFile(wb, "table_data.xlsx");
        }


    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        });

        var channel = pusher.subscribe("{{ env('PUSHER_APP_CHANNEL') }}");
        channel.bind('StockUpdate', function(data) {
            console.log("Stock update received:", data);
            console.log(data.stockUpdates);

            Object.keys(data.stockUpdates).forEach((key) => {
                const tdElement = document.getElementById(key);

                if (tdElement) {
                    let value = data.stockUpdates[key];

                    let formattedValue;

                    // Check if value is a valid number
                    if (!isNaN(value) && value !== null && value !== undefined && value !== "") {
                        formattedValue = new Intl.NumberFormat().format(Number(value));
                    } else {
                        // Handle non-numeric values (keep as string or apply specific formatting)
                        formattedValue = value ?? "N/A"; // Default to "N/A" if value is null/undefined
                    }

                    // Look for input, select, or textarea elements inside the <td>
                    let inputElement = tdElement.querySelector("input");
                    let selectElement = tdElement.querySelector("select");
                    let textareaElement = tdElement.querySelector("textarea");

                    if (inputElement) {
                        inputElement.value = formattedValue; // Update input field value
                    } else if (selectElement) {
                        // If it's a select dropdown, find the option and set it as selected
                        let optionExists = Array.from(selectElement.options).some(option => option.value ==
                            data.stockUpdates[key]);
                        if (optionExists) {
                            selectElement.value = data.stockUpdates[key];
                        }
                    } else if (textareaElement) {
                        textareaElement.value = formattedValue; // Update textarea value
                    } else {
                        // If no input/select/textarea found, update the text inside the <td>
                        tdElement.textContent = formattedValue;
                    }
                }
            });
        });
    </script>
@endsection
