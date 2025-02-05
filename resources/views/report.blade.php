@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .report_sec {
            padding: 50px 200px;
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
    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All" selected>ALL SCHEDULE</option>
                            <option value="All">CUSTOMER</option>
                            <option value="All">DEPARTMENT</option>
                            <option value="All">PART NUMBER</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <input type="text" name="daterange" value="" />
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
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th>
                                            {{ $month5StartDate }}</th>
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
                            <tfoot>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>CUSTOMER</th>
                                    <th>PART NUMBER </th>
                                    <th>DATE <br> SEARCH</th>
                                    <th>IN STOCK</th>
                                    <th>PAST<br> Due</th>
                                    @for ($week = 1; $week <= 16; $week++)
                                        <th>
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th>
                                            {{ $month5StartDate }}</th>
                                        @php
                                            $month5StartDate = date(
                                                'j-M',
                                                strtotime('+31 days', strtotime($month5StartDate)),
                                            );
                                        @endphp
                                    @endfor
                                    <th>Balance of <br> Schedule </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All">ALL DEPARTMENT</option>
                            <option value="All">RFM</option>
                            <option value="All">EXTENSION</option>
                            <option value="All">WIREFORM&lt;.200</option>
                            <option value="All"> WIREFORM&gt;.200</option>
                            <option value="All"> MULTI-SLIDE</option>
                            <option value="All"> PRESS</option>
                            <option value="All"> OUTSOURCED</option>
                            <option value="All"> TORSION</option>
                            <option value="All"> ASSEMBL</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>WORK CENTER</th>
                                    <th>REV</th>
                                    <th>PROCESS </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>WORK CENTER</th>
                                    <th>REV</th>
                                    <th>PROCESS </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="report_sec">
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
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                ajax: "{{ route('getReportData') }}",
                columns: [
                    { data: 'department', name: 'department' },
                    { data: 'customer', name: 'customer' },
                    { data: 'part_number', name: 'part_number' },
                    { data: 'date_search', name: 'date_search' },
                    { data: 'in_stock', name: 'in_stock' },
                    { data: 'past_due', name: 'past_due' },

                    // Dynamically generate weeks
                    @for ($week = 1; $week <= 16; $week++)
                        { data: 'week_values.week_{{ $week }}', name: 'week_{{ $week }}' },
                    @endfor

                    // Dynamically generate months
                    @for ($month = 5; $month <= 12; $month++)
                        { data: 'week_values.month_{{ $month }}', name: 'month_{{ $month }}' },
                    @endfor

                    { data: 'balance_schedule', name: 'balance_schedule' }
                ],
                paging: true, // Keep pagination enabled
                info: true
            });
        });
    </script>
@endsection
