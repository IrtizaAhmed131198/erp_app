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

        .control-table #reports-table_wrapper {
            overflow: auto;
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
                        <div class="title">
                            <h1 class="heading-1">
                                All Users Report
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="parent-filter mb-3">
                <input type="text" name="daterange" id="daterange" class="form-control" />
                <button id="filterBtn" class="btn btn-primary mt-2">Filter</button>
            </div>
            <div id="reportContainer">
                @include('partials.report_data', ['activity_by_user' => $activity_by_user ?? collect()])
            </div> --}}
        </div>
    </section>
    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="parent-filter">
                        <input type="text" name="daterange" id="daterange" class="form-control" placeholder="Select date range" />
                    </div>
                </div>
                <div class="col-lg-2">
                    <button id="filter" class="btn btn-primary">Filter</button>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="reports-table" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Part Number</th>
                                    <th>Department</th>
                                    <th>Work Center</th>
                                    <th>Planning</th>
                                    <th>Status</th>
                                    <th>Job</th>
                                    <th>Lot</th>
                                    <th>ID's</th>
                                    <th>Customer</th>
                                    <th>Rev</th>
                                    <th>Process</th>
                                    <th>In Process Outside</th>
                                    <th>On Order Raw Mat</th>
                                    <th>WT/PC</th>
                                    <th>Material</th>
                                    <th>Safety</th>
                                    <th>Order Notes</th>
                                    <th>Part Notes</th>
                                    <th>Future Raw</th>
                                    <th>Price</th>
                                    <th>Notes</th>
                                    <th>Min Ship</th>
                                    <th>Currency</th>
                                    <th>MOQ</th>
                                    <th>In Stock Finish</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function() {
            // Get today's date formatted as YYYY-MM-DD
            var today = moment().format('YYYY-MM-DD');

            // Initialize daterangepicker with default values for today.
            $('#daterange').daterangepicker({
                autoUpdateInput: true,
                startDate: today,
                endDate: today,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            });

            var table = $('#reports-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ajax_report') }}",
                    data: function(d) {
                        // If the date range input is empty, default to today's date.
                        var dateRange = $('#daterange').val();
                        if (dateRange) {
                            var dates = dateRange.split(' - ');
                            d.start_date = dates[0];
                            d.end_date = dates[1];
                        } else {
                            d.start_date = today;
                            d.end_date = today;
                        }
                    }
                },
                columns: [{
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'part_number_name',
                        name: 'part_number_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'work_center_name',
                        name: 'work_center_name'
                    },
                    {
                        data: 'planning',
                        name: 'planning'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'job',
                        name: 'job'
                    },
                    {
                        data: 'lot',
                        name: 'lot'
                    },
                    {
                        data: 'ids',
                        name: 'ids'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'rev',
                        name: 'rev'
                    },
                    {
                        data: 'process',
                        name: 'process'
                    },
                    {
                        data: 'in_process_outside',
                        name: 'in_process_outside'
                    },
                    {
                        data: 'raw_mat',
                        name: 'raw_mat'
                    },
                    {
                        data: 'wt_pc',
                        name: 'wt_pc'
                    },
                    {
                        data: 'material_name',
                        name: 'material_name'
                    },
                    {
                        data: 'safety',
                        name: 'safety'
                    },
                    {
                        data: 'order_notes',
                        name: 'order_notes'
                    },
                    {
                        data: 'part_notes',
                        name: 'part_notes'
                    },
                    {
                        data: 'future_raw',
                        name: 'future_raw'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'notes',
                        name: 'notes'
                    },
                    {
                        data: 'min_ship',
                        name: 'min_ship'
                    },
                    {
                        data: 'currency',
                        name: 'currency'
                    },
                    {
                        data: 'moq',
                        name: 'moq'
                    },
                    {
                        data: 'in_stock_finish',
                        name: 'in_stock_finish'
                    }
                ]
            });

            $('#filter').click(function () {
                table.draw();
            });
        });
        // $(function () {
        //     // Initialize daterangepicker
        //     $('#daterange').daterangepicker({
        //         locale: { format: 'YYYY-MM-DD' },
        //         startDate: moment(),
        //         endDate: moment()
        //     });
        //     // When the filter button is clicked, send an AJAX request.
        //     $('#filterBtn').on('click', function(e){
        //         e.preventDefault();

        //         // Get the daterange value
        //         let daterange = $('#daterange').val();

        //         // Send AJAX request to the route that returns the filtered view
        //         $.ajax({
        //             url: "{{ route('ajax_report') }}", // Define this route in your web.php
        //             method: 'GET',
        //             data: { daterange: daterange },
        //             beforeSend: function(){
        //                 // Optionally, show a loading indicator
        //             },
        //             success: function(response){
        //                 // Replace the content of reportContainer with the response data
        //                 $('#reportContainer').html(response);
        //             },
        //             error: function(){
        //                 alert('There was an error processing your request.');
        //             }
        //         });
        //     });
        // });
    </script>
@endsection
