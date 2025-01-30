@extends('layouts.main')
@section('css')
    <style>
        .pagination-all ul li a {
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            font-size: 18px;
        }

        .pagination-all ul li span {
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            font-size: 18px;
        }

        .pagination-all ul {
            justify-content: center;
            margin-top: 50px;
        }

        .pagination-all ul li {
            border: 1px solid #dee2e6;
        }

        .table-data-all {
            padding-top: 20px;
            padding-bottom: 50px;
        }

        .table-data-all .table-hover {
            width: 65%;
            margin: auto;
            border: 1px solid black;
        }

        .data-show-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-bottom: 30px;
        }

        .data-show-toggle button {
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
        }
    </style>
@endsection

@section('content')
    <section class="users-data pt-5 ">
        <div class="container">
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
                                Update Data
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="table-data-all">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="data-show-toggle">
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Part Number
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Customers
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Department
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Work Centre
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Outside Processing
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Material
                        </button>
                    </div>
                </div>
                <div class="accordion" id="mainAccordion">
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Part Name </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">
                                        @foreach ($parts as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->Part_Number }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->Part_Number }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <div class="pagination-all">
                                    {!! $parts->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Customer </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">

                                        @foreach ($customer as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->CustomerName }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->CustomerName }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <div class="pagination-all">
                                    {!! $customer->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Department </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">
                                        @foreach ($department as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->name }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Work Centre </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">

                                        @foreach ($work_center_selector as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->name }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-all">
                                    {!! $work_center_selector->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Vendor </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">

                                        @foreach ($vendor as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->name }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-all">
                                    {!! $vendor->links() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th class="highlighted toggle-header">ID</th>
                                            <th class="toggleable toggle-header-planning">Material </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">

                                        @foreach ($package as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->Package }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->Package }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                        {{-- <form action="{{ route('users.destroy', $parts->id) }}" method="POST"
                                                class="d-inline" id="deleteID{{ $parts->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleted({{ $parts->id }})">Delete</a>
                                            </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-all">
                                    {!! $package->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="partNumber" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Part Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="partNumberInput" name="Part_Number"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Part</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('js')
    <script>
        $(document).ready(function() {
            $('.opendata').click(function() {
                $('#partNumberId').val($(this).data('id'));
                $('#partNumberInput').val($(this).data('column'));
                $('#partNumber').show();
            })
        })
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "//pagination?page=" + page,
                    success: function(satwork) {
                        $('.table').html(satwork);
                    }
                });
            }

        });
        }
    </script>
@endsection
@endsection
