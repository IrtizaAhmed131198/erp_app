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
    <section class="report_sec">
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
                    {{-- <div class="title">
                        <h1 class="heading-1">
                            {{ App\Models\User::find($userId)->name ?? 'User' }} Report
                        </h1>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="report_sec">
        <div class="container">
            <div class="row">
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
                                    <th>PART NO.</th>
                                    <th>CUSTOMER</th>
                                    <th>REV</th>
                                    <th>PROCESS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $query->department }}</td>
                                    <td>{{ $query->work_center_one->com }}</td>
                                    <td>{{ $query->planning }}</td>
                                    <td>{{ $query->status }}</td>
                                    <td>{{ $query->job }}</td>
                                    <td>{{ $query->lot }}</td>
                                    <td>{{ $query->ids }}</td>
                                    <td>{{ $query->part_number }}</td>
                                    <td>{{ $query->customer }}</td>
                                    <td>{{ $query->rev }}</td>
                                    <td>{{ $query->process }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endsection
