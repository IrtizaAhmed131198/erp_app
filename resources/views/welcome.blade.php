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

    </style>
@endsection


@section('content')
    <section class="master-data-section">
        <div class="container bg-colored">
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
                        {{-- <button type="button" class="btn btn-primary ml-4" data-bs-toggle="modal" data-bs-target="#exampleModal" width="100%">
                            Open Modal
                            </button> --}}
                    </div>
                </div>
            </div>

            @php
                $datesArray = [];

                // Calculate the start date of week 16
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                $mondayOfWeek = date('Y-m-d', strtotime('-' . $dayOfWeek . ' days', strtotime($today)));
                $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

                // Calculate the end date of week 16
                $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

                // Calculate the start date of month 5 (the day after week 16 ends)
                $month5StartDate = date('j-M', strtotime('+1 day', strtotime($week16EndDate)));

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


            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="colored-table-row">
                                    <th scope="col" class="highlighted toggle-header">
                                        <span class="icon">▼</span>
                                    </th>

                                    @foreach($region_1_column_configuration as $region_1_column_configuration_item)
                                        <th scope="col" id="column-department" class="toggleable toggle-header-department" {!! $region_1_column_configuration_item->visibility ? '' : 'hidden' !!}>
                                            {{strtoupper(get_column_label($region_1_column_configuration_item->column))}}
                                            <span class="icon">▼</span>
                                        </th>
                                    @endforeach
{{--                                    <th scope="col" id="column-department" class="toggleable toggle-header-department">--}}
{{--                                        DEPARTMENT--}}
{{--                                        <span class="icon">▼</span>--}}
{{--                                    </th>--}}
{{--                                    <th scope="col" id="column-work-center" class="toggleable toggle-header-department toggle-header-work-center">WORK CENTER <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" id="column-status" class="toggleable toggle-header-department toggle-header-status">PLANNING (QUEUE) <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">STATUS <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">JOB # <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">LOT # <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">ID <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">PART NO. <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">CUSTOMER <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">REV <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable toggle-header-department">PROCESS <span--}}
{{--                                            class="icon">▼</span></th>--}}
                                    <th scope="col" class="highlighted toggle-header-1">
                                        <span class="icon">▼
                                        </span>
                                    </th>

                                    @foreach($region_2_column_configuration as $region_2_column_configuration_item)
                                        <th scope="col" id="column-department" class="toggleable-1 toggle-header-department" {!! $region_2_column_configuration_item->visibility ? '' : 'hidden' !!}>
                                            {{strtoupper(get_column_label($region_2_column_configuration_item->column))}}
                                            <span class="icon">▼</span>
                                        </th>
                                    @endforeach
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department">REQ 1-6 WEEKS <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department">REQ 7-12 WEEKS <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department">SCHED'L TOTAL <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department">IN STOCK FINISHED <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> LIVE INVENTORY F <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> LIVE INVENTORY WIP--}}
{{--                                        <span class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> IN PROCESS OUT SIDE--}}
{{--                                        <span class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> ON ORDER RAW MAT'L--}}
{{--                                        <span class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> IN STOCK LIVE <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> WT/PC <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> MATERIAL (SORT) <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> Wt Req'd 1-12--}}
{{--                                        Weeks<span class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> SAFTY <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> Min Ship <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> Order Notes <span--}}
{{--                                            class="icon">▼</span></th>--}}
{{--                                    <th scope="col" class="toggleable-1 toggle-header-department"> Part Notes <span--}}
{{--                                            class="icon">▼</span></th>--}}
                                    <th scope="col" class="highlighted toggle-header-2">
                                        <span class="icon">▼
                                        </span>
                                    </th>

                                    <th scope="col" class="toggleable-2 toggle-header-department">PAST DUE <span
                                            class="icon">▼</span></th>
                                    @for ($week = 1; $week <= 16; $week++)
                                        <th scope="col" class="toggleable-2 toggle-header-department">
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th scope="col" class="toggleable-2 toggle-header-department">
                                            {{ $month5StartDate }}</th>
                                        @php
                                            $month5StartDate = date(
                                                'j-M',
                                                strtotime('+31 days', strtotime($month5StartDate)),
                                            );
                                        @endphp
                                    @endfor
                                    <th scope="col" class="toggleable-2 toggle-header-department">FUTURE RAW <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-2 toggle-header-department">PRICE <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-2 toggle-header-department">NOTES <span
                                            class="icon">▼</span></th>
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
    <div class="modal fade" id="filter3" tabindex="-1" aria-labelledby="filter3Label" >
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
                                        @foreach($region_1_column_configuration as $region_1_column_configuration_item)
                                            <div class="col-md-12 div_column_item" data-column="{{$region_1_column_configuration_item->column}}">
                                                <div class="row">
                                                    <div class="col-md-11 text-left" style="cursor: pointer;">
                                                        <span>{{get_column_label($region_1_column_configuration_item->column)}}</span>
                                                    </div>
                                                    <div class="col-md-1 text-center" style="cursor: pointer;">
                                                        @php
                                                            $color = $region_1_column_configuration_item->visibility ? 'rgb(0, 0, 0)' : 'red';
                                                            $class = $region_1_column_configuration_item->visibility ? 'fa-eye' : 'fa-eye-slash';
                                                        @endphp
                                                        <i class="fas {{$class}} anchor_column_visibility_toggle" style="color: {{$color}}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row px-2" id="region_2_columns_container">
                                        @foreach($region_2_column_configuration as $region_2_column_configuration_item)
                                            <div class="col-md-12 div_column_item" data-column="{{$region_2_column_configuration_item->column}}">
                                                <div class="row">
                                                    <div class="col-md-11 text-left" style="cursor: pointer;">
                                                        <span>{{get_column_label($region_2_column_configuration_item->column)}}</span>
                                                    </div>
                                                    <div class="col-md-1 text-center" style="cursor: pointer;">
                                                        @php
                                                            $color = $region_2_column_configuration_item->visibility ? 'rgb(0, 0, 0)' : 'red';
                                                            $class = $region_2_column_configuration_item->visibility ? 'fa-eye' : 'fa-eye-slash';
                                                        @endphp
                                                        <i class="fas {{$class}} anchor_column_visibility_toggle_2" style="color: {{$color}}"></i>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary" id="save-columns">Save Changes</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
{{--    <script>--}}
{{--        introJs().start();--}}
{{--    </script>--}}

    <script>
        $(document).ready(function () {
            //Region 1 & 2 column configuration
            let region_1_column_configuration = '';
            let region_2_column_configuration = '';

            $('.anchor_column_visibility_toggle').on('click', function () {
                $(this).addClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye-slash' : 'fa-eye');
                $(this).removeClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye' : 'fa-eye-slash');
                $(this).css('color', ($(this).css('color') == 'rgb(0, 0, 0)' ? 'red' : 'black'));

                saveRegion1ColumnConfiguration();
            });

            $('.anchor_column_visibility_toggle_2').on('click', function () {
                $(this).addClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye-slash' : 'fa-eye');
                $(this).removeClass($(this).css('color') == 'rgb(0, 0, 0)' ? 'fa-eye' : 'fa-eye-slash');
                $(this).css('color', ($(this).css('color') == 'rgb(0, 0, 0)' ? 'red' : 'black'));

                saveRegion2ColumnConfiguration();
            });

            const stack1 = document.getElementById('region_1_columns_container');
            const stack2 = document.getElementById('region_2_columns_container');

            new Sortable(stack1, {
                animation: 150,
                onEnd: function (evt) {
                    saveRegion1ColumnConfiguration();
                },
            });
            new Sortable(stack2, {
                animation: 150,
                onEnd: function (evt) {
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
                        visibility: $(item).find('.anchor_column_visibility_toggle').css('color') == 'rgb(0, 0, 0)' ? true : false
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
                        visibility: $(item).find('.anchor_column_visibility_toggle_2').css('color') == 'rgb(0, 0, 0)' ? true : false
                    });
                });

                region_2_column_configuration = JSON.stringify(column_configuration);
            }

            //save changes - ajax request
            $('#save-columns').on('click', function () {
                if (region_1_column_configuration != '') {
                    $.ajax({
                        url: '{{route("save.user.configuration")}}',
                        method: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            key: 'master_screen_region_1_column_configuration',
                            value: region_1_column_configuration,
                        }
                    });
                }

                if (region_2_column_configuration != '') {
                    $.ajax({
                        url: '{{route("save.user.configuration")}}',
                        method: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            key: 'master_screen_region_2_column_configuration',
                            value: region_2_column_configuration,
                        },
                        // success: (data) => {
                        //     if (data.success) {
                        //         Swal.fire({
                        //             icon: 'success',
                        //             title: 'Success',
                        //             text: data.message,
                        //         });
                        //
                        //         $('#filter3').modal('hide');
                        //
                        //         window.location.reload();
                        //     } else {
                        //         Swal.fire({
                        //             icon: 'error',
                        //             title: 'Error',
                        //             text: data.message,
                        //         });
                        //
                        //         $('#filter3').modal('hide');
                        //     }
                        // },
                        // error: (e) => {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Error',
                        //         text: e.message,
                        //     });
                        //
                        //     $('#filter3').modal('hide');
                        // }
                    });
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Changes saved!',
                });

                $('#filter3').modal('hide');

                window.location.reload();

            });

            //target cell feature
            let target_cell_id = '#' + '{{$target_cell_id}}';
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
                var scrollTop = container.scrollTop() + cellPosition.top - container.offset().top - (containerHeight / 2) + (cellHeight / 2);
                var scrollLeft = container.scrollLeft() + cellPosition.left - container.offset().left - (containerWidth / 2) + (cellWidth / 2);

                // Scroll the container to bring the target cell into the center
                container.scrollTop(scrollTop);
                container.scrollLeft(scrollLeft);

                // Highlight the cell with an animation
                targetCell.css('background-color', 'yellow');
                setTimeout(function () {
                    targetCell.css('background-color', '');
                }, 4000); // Remove highlight after 2 seconds
            }

            //target row feature
            let target_row_id = '#entry_number_' + '{{$target_row_id}}';
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
                var scrollTop = container.scrollTop() + rowPosition.top - container.offset().top - (containerHeight / 2) + (rowHeight / 2);
                // var scrollLeft = container.scrollLeft() + rowPosition.left - container.offset().left - (containerWidth / 2) + (rowWidth / 2);

                // Scroll the container to bring the target row into the center
                container.scrollTop(scrollTop);
                // container.scrollLeft(scrollLeft);

                // Highlight the row with an animation
                targetCell.css('background-color', 'yellow');
                setTimeout(function () {
                    targetCell.css('background-color', '');
                }, 4000); // Remove highlight after 2 seconds
            }
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
        const typingTimeout = 1500; // 2 seconds of no typing

        function sendAjaxRequest(field, value, event) {
            const inputElement = event.target;
            const dataId = inputElement.getAttribute('data-id');

            const isDropdown = inputElement.tagName === 'SELECT';

            if (field === 'planning') {
                const isNumeric = /^-?\d+(,\d{3})*(\.\d+)?$/.test(value);

                if (isNumeric) {
                    value = value.replace(/,/g, '');
                }
            }

            const data = {
                id: dataId,
                field: field,
                value: value
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
            const dataId = inputElement.getAttribute('data-id');

            const data = {
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

                // Send AJAX request
                $.ajax({
                    url: '{{ route('index') }}',
                    type: 'GET',
                    data: {
                        department: department,
                        filter: filter
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

        $('body').on('click', '.custom-dropdown-item', function(e) {
            e.preventDefault();

            const partNumber = $(this).data('part');
            const url = $(this).data('url');

            if (url && partNumber) {
                const fullUrl = `${url}?part_number=${partNumber}`;
                window.open(fullUrl, '_blank');
            }
        });


        function formatNumberWithCommas(element) {
            console.log(element,'1');
            const value = element.value.replace(/[^0-9]/g, '');
            element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
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

    </script>

@endsection
