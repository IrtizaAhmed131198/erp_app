@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.dataTables.min.css">
    <style>
        .report_sec {
            padding: 50px 0px;
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
    <section class="report_sec">
        <div class="container-fluid">
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
                                    Return To Master Data
                                </span>
                            </a>
                        </div>
                        <div class="title">
                            <h1 class="heading-1">
                                {{ App\Models\User::find($userId)->name ?? 'User' }} Report
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    @endphp
    <input type="hidden" id="user_id" name="user_id" value="{{ $userId ?? '' }}">
    <section class="report_sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <select class="js-select2" id="filter">
                            <option value="All" selected>ALL SCHEDULE</option>
                            <option value="customer">CUSTOMER</option>
                            <option value="department">DEPARTMENT</option>
                            <option value="part_number">PART NUMBER</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <input type="text" name="daterange" value="" id="daterange" />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>CUSTOMER</th>
                                    <th>PART NUMBER </th>
                                    <th>DATE <br> SEARCH</th>
                                    <th>IN STOCK</th>
                                    <th>PAST<br> Due</th>
                                    @for ($week = 1; $week <= 16; $week++)
                                        <th>
                                            {{ 'Week ' . $week }} <br>
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th>
                                            @if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $month5StartDate))
                                                {{ 'Month ' . $month }} <br> {{ date('j-M', strtotime($month5StartDate)) }}
                                            @else
                                                {{ 'Month ' . $month }} <br>{{ $month5StartDate }}
                                            @endif
                                        </th>
                                        @php
                                            $month5StartDate = date(
                                                'j-M',
                                                strtotime('+31 days', strtotime($month5StartDate)),
                                            );
                                        @endphp
                                    @endfor
                                    <th>Balance of <br> Schedule </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <select class="js-select2" id="part">
                            @foreach ($parts as $part)
                                <option value="{{ $part->id }}">{{ $part->Part_Number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <input type="text" name="daterange" value="" id="daterange_entries" />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>WORK CENTER</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>LOT</th>
                                    <th>ID</th>
                                    <th>CUSTOMER</th>
                                    <th>REV</th>
                                    <th>PROCESS</th>
                                    <th>IN PROCESS OUTSIDE</th>
                                    <th>ON ORDER RAW MAT`L</th>
                                    <th>WT/PC</th>
                                    <th>MATERIAL</th>
                                    <th>SAFETY</th>
                                    <th>ORDER NOTES</th>
                                    <th>PART NOTES</th>
                                    <th>FUTURE RAW</th>
                                    <th>NOTES</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All"> Part Name</option>
                            <option value="All"> Customer</option>
                            <option value="All">Department</option>
                            <option value="All">Work Centre</option>
                            <option value="All"> Vendor</option>
                            <option value="All"> Material</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example3" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>User Login Successful</td>
                                </tr>
                                <tr>
                                    <td>New User Registered</td>
                                </tr>
                                <tr>
                                    <td>System Update Completed</td>
                                </tr>
                                <tr>
                                    <td>Admin Approved Your Request</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD' // Customize date format as needed
                },
                minDate: moment().startOf('day'),
                // Optionally, specify any other configuration options you need
            });
        });
        const userId = $('#user_id').val();
        // Get current date
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        // Format dates in yyyy-mm-dd format
        const formatDate = (date) => date.toISOString().split('T')[0];

        // Set the input value to "start date - end date"
        document.getElementById('daterange').value = `${formatDate(today)} - ${formatDate(tomorrow)}`;

        document.getElementById('daterange').setAttribute('min', formatDate(today));


        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                ajax: {
                    url: "{{ route('getReportData') }}",
                    data: function(d) {
                        var daterange = $('input[name="daterange"]').val();
                        if (daterange) {
                            var dates = daterange.split(' - ');
                            d.start_date = dates[0]; // Start date
                            d.end_date = dates[1]; // End date
                        }

                        var filter = $('#filter').val();
                        if (filter) {
                            d.filter = filter;
                        }

                        d.userId = userId;

                    }
                },
                columns: [{
                        data: 'department',
                        name: 'department',
                        className: "department-column"
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: "customer-column"
                    },
                    {
                        data: 'part_number',
                        name: 'part_number',
                        className: "part-number-column"
                    },
                    {
                        data: 'date_search',
                        name: 'date_search'
                    },
                    {
                        data: 'in_stock',
                        name: 'in_stock'
                    },
                    {
                        data: 'past_due',
                        name: 'past_due'
                    },
                    @for ($week = 1; $week <= 16; $week++)
                        {
                            data: 'week_values.week_{{ $week }}',
                            name: 'week_{{ $week }}'
                        },
                    @endfor
                    @for ($month = 5; $month <= 12; $month++)
                        {
                            data: 'week_values.month_{{ $month }}',
                            name: 'month_{{ $month }}'
                        },
                    @endfor {
                        data: 'balance_schedule',
                        name: 'balance_schedule'
                    }
                ],
                paging: false,
                info: false,
                rowGroup: {
                    dataSrc: null, // Default: No grouping
                    startRender: function(rows, group) {
                        if (typeof group === 'object') {
                            return $('<tr></tr>');
                        }
                        var groupValue =
                        group; // Default to the group value (e.g., 'customer' or 'department')

                        var colspan = $('#example thead tr th').length; // Full column span

                        return $('<tr class="group"><td colspan="' + colspan + '"><strong>' +
                            groupValue + '</strong></td></tr>');
                    }
                }
            });

            // Handle filter change
            $('#filter').change(function() {
                var selectedFilter = $(this).val();

                // Disable row grouping by default
                table.rowGroup().dataSrc(null);

                if (selectedFilter === "All") {
                    // No grouping
                    table.column('.department-column').visible(true);
                    table.column('.customer-column').visible(true);
                    table.column('.part-number-column').visible(true);
                } else if (selectedFilter === "customer") {
                    // Group by customer
                    table.rowGroup().dataSrc('customer');
                    table.column('.department-column').visible(false);
                    table.column('.customer-column').visible(true);
                    table.column('.part-number-column').visible(true);

                } else if (selectedFilter === "department") {
                    // Group by department
                    table.rowGroup().dataSrc('department');
                    table.column('.department-column').visible(true);
                    table.column('.customer-column').visible(false);
                    table.column('.part-number-column').visible(true);
                } else if (selectedFilter === "part_number") {
                    // Group by part number
                    table.rowGroup().dataSrc('part_number');
                    table.column('.department-column').visible(false);
                    table.column('.customer-column').visible(false);
                    table.column('.part-number-column').visible(true);
                }

                table.draw(); // Redraw table to apply changes
            });

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                table.draw();
            });

            $('select.js-select2').change(function() {
                table.draw();
            });
        });
    </script>
@endsection
