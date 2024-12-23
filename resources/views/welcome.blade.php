@extends('layouts.main')

@section('css')
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
    </style>
@endsection


@section('content')
    <section class="master-data-section">
        <div class="container bg-colored">
            <div class="row align-items-base justify-content-end master-data-filter invoice-listing-select-bar">
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="filter1">
                            @foreach ($department as $dept)
                                <option value="All">ALL DEPARTMENT</option>
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
                                    <th scope="col" id="column-department" class="toggleable toggle-header-department ">DEPARTMENT <span
                                            class="icon">▼</span></th>
                                    <th scope="col" id="column-work-center" class="toggleable toggle-header-department toggle-header-work-center">WORK CENTER <span
                                            class="icon">▼</span></th>
                                    <th scope="col" id="column-status" class="toggleable toggle-header-department toggle-header-status">PLANNING (QUEUE) <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">STATUS <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">JOB # <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">LOT # <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">ID <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">PART NO. <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">CUSTOMER <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">REV <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-department">PROCESS <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="highlighted toggle-header-1">
                                        <span class="icon">▼
                                        </span>
                                    </th>
                                    <th scope="col" class="toggleable-1 toggle-header-department">REQ 1-6 WEEKS <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department">REQ 7-12 WEEKS <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department">SCHED'L TOTAL <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department">IN STOCK FINISHED <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> LIVE INVENTORY F <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> LIVE INVENTORY WIP
                                        <span class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> IN PROCESS OUT SIDE
                                        <span class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> ON ORDER RAW MAT'L
                                        <span class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> IN STOCK LIVE <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> WT/PC <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> MATERIAL (SORT) <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> Wt Req'd 1-12
                                        Weeks<span class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> SAFTY <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> Min Ship <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> Order Notes <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable-1 toggle-header-department"> Part Notes <span
                                            class="icon">▼</span></th>
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
    <div class="modal fade" id="filter3" tabindex="-1" aria-labelledby="filter3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filter3Label">Show/Hide Columns</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="column-toggle-form">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="column-department" checked>
                            <label class="form-check-label" for="column-department">DEPARTMENT</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="column-work-center" checked>
                            <label class="form-check-label" for="column-work-center">WORK CENTER</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="column-status" checked>
                            <label class="form-check-label" for="column-status">STATUS</label>
                        </div>
                        <!-- Add more columns as needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-columns">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // $(document).ready(function () {
        //     $('#myTable').DataTable({
        //         // Configuration options
        //         paging: false,         // Enable pagination
        //         searching: false,      // Enable searching
        //         ordering: true,       // Enable sorting
        //         order: [[0, 'asc']],  // Default sorting on the first column
        //         responsive: true,     // Make table responsive
        //         "aoColumnDefs": [
        //             { "bSortable": false, "aTargets": [ 0, 12, 29 ] },
        //         ]
        //     });

        // });
        function sendAjaxRequest(field, value) {
            var inputElement = event.target;
            var dataId = inputElement.getAttribute('data-id');
            var data = {
                id: dataId,
                field: field,
                value: value
            };

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
        }

        function sendAjaxRequest2(field, value) {
            var inputElement = event.target;
            var dataId = inputElement.getAttribute('data-id');
            var data = {
                id: dataId,
                field: field,
                value: value
            };

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
        }

        function sendAjaxRequest3(field, value) {
            var inputElement = event.target;
            var dataId = inputElement.getAttribute('data-id');
            var data = {
                id: dataId,
                field: field,
                value: value
            };

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
        }

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

        document.addEventListener('DOMContentLoaded', () => {
            const dropdownItems = document.querySelectorAll('.custom-dropdown-item');

            dropdownItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Retrieve the part number and URL from the clicked item
                    const partNumber = e.target.getAttribute('data-part');
                    const url = e.target.getAttribute('data-url');

                    // Redirect if the URL is valid
                    if (url && partNumber) {
                        const fullUrl = `${url}?part_number=${partNumber}`;
                        window.open(fullUrl, '_blank');
                    }
                });
            });
        });

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
