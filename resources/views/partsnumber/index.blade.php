@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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

        .select2-selection__arrow {
            background-image: none !important;
            display: none !important;
        }

        .select2.select2-container {
            width: 60% !important;
            margin-top: 18px !important;
        }

        .custom-btn-restore {
            display: flex;
            align-items: start;
            flex-direction: column;
            gap: 11px;
        }

        .deletedRecordWork li,
        .deletedRecordOut li,
        .deletedRecorddata li,
        .deletedRecorddepart li,
        .deletedRecordCus li,
        .deletedRecordPart li {
            margin-bottom: 9px;
        }

        table.dataTable thead .sorting_asc {
            background-image: none !important;
        }

        .cus-table {
            width: 100% !important;
        }

        .custom-btn-restore {
            margin: 2rem 0;
        }

        .dataTables_length {
            margin-bottom: 2rem;
        }

        table.dataTable thead .sorting_asc {
            background-image: none !important;
        }

        table.dataTable th,
        table.dataTable td {
            border: 1px solid #000000;
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
                                Tables
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
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(1)">
                            Part Number
                        </button>
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(2)">
                            Customers
                        </button>
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(3)">
                            Department
                        </button>
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(4)">
                            Work Centre
                        </button>
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(5)">
                            Outside Processing
                        </button>
                        <button class="btn btn-primary me-2" type="button" onclick="toggleDiv(6)">
                            Material
                        </button>
                    </div>
                </div>
                <div class="accordion" id="mainAccordion">
                    <div id="div1" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow">Add
                                            Parts Number</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal6">
                                            Restore Deleted Rec
                                        </button>
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <table class="table table-hover table-bordered" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <!-- <th class="highlighted toggle-header">ID</th> -->
                                            <th class="toggleable toggle-header-planning">Part Name </th>
                                            <th class="toggleable toggle-header-planning">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="entries-table-body">
                                        @foreach ($parts as $val)
                                            <tr>
                                                <!-- <td>{{ $val->id }}</td> -->
                                                <td>{{ $val->Part_Number }}</td>
                                                <td class="toggleable toggle-planning">
                                                    <div class="d-inline">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                                            data-column="{{ $val->Part_Number }}"
                                                            data-id="{{ $val->id }}">Edit</a>
                                                            <button type="button" class="btn btn-danger" id="delete-part"
                                                            data-id="{{ $val->id }}">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <div class="pagination-all">
                                    {{ $parts->links() }}
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="myTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Part Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="div2" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow1">Add
                                            Customer</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal5">
                                            Restore Deleted Rec
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="customerTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Customer</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="div3" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow2">Add
                                            Department</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal4">
                                            Restore Deleted Rec
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="departmentTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Department</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="div4" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow3">
                                            Add Work
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal1">
                                            Restore Deleted Rec
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="workTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Work Centre</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="div5" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow4">
                                            Add Out Source
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal2">
                                            Restore Deleted Rec
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="outTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Out Source</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="div6" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                        <div class="accordion-body px-0">
                            <div class="col-lg-12">
                                <div class="top-btn custom-btn-restore">
                                    <div>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formpartshow5">Add
                                            Material</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#restoreModal3">
                                            Restore Deleted Rec
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-hover cus-table" id="materialTable">
                                    <thead>
                                        <tr class="colored-table-row">
                                            <th>Material</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- edit data modal --}}


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
                        <button type="submit" class="btn btn-primary" id="hidebtn">Update Part</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="customer1" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm1">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId1" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="partNumberInput1" name="CustomerName"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn1">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="partNumber2" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm2">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId2" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Department</label>
                            <input type="text" class="form-control" id="partNumberInput2" name="name"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn2">Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="partNumber3" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Work Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm3">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId3" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Work Center</label>
                            <input type="text" class="form-control" id="partNumberInput3" name="name"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn3">Update Work Center</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="partNumber4" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm4">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId4" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="partNumberInput4" name="name"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn4">Update Vendor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="partNumber5" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Edit Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm5">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="partNumberId5" value="">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Material</label>
                            <input type="text" class="form-control" id="partNumberInput5" name="Package"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn5">Update Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit data modal --}}

    {{-- add data modal --}}

    <div class="modal fade" id="formpartshow" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Part Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="addparts" placeholder="Enter part number"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn">Add Part Number</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal6" tabindex="-1" aria-labelledby="restoreModal6Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecordPart"></ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formpartshow1" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform1">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts1" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="addparts1" placeholder="Enter customer"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn1">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal5" tabindex="-1" aria-labelledby="restoreModal5Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecordCus"></ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formpartshow2" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform2">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts1" class="form-label">Department</label>
                            <input type="text" class="form-control" id="addparts2" placeholder="Enter Department"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn2">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal4" tabindex="-1" aria-labelledby="restoreModal4Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecorddepart"></ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formpartshow3" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Work Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform3">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts1" class="form-label">Work Center</label>
                            <input type="text" class="form-control" id="addparts3" placeholder="Enter Work Center"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn3">Add Work Center</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal1" tabindex="-1" aria-labelledby="restoreModal1Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecordWork"></ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formpartshow4" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform4">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts1" class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="addparts4" placeholder="Enter Vendor"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn4">Add Vendor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal2" tabindex="-1" aria-labelledby="restoreModal2Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecordOut"></ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formpartshow5" tabindex="-1" aria-labelledby="formpartshowLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formpartshowLabel">Add Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partshowform5">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addparts1" class="form-label">Material</label>
                            <input type="text" class="form-control" id="addparts5" placeholder="Enter Material"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="hidebtn5">Add Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal3" tabindex="-1" aria-labelledby="restoreModal3Label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Deleted Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="deletedRecorddata"></ul>
                </div>
            </div>
        </div>
    </div>

    {{-- add data modal --}}
@endsection


@section('js')
    {{-- add data ajax --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        function initializeDataTable(tableId, source, columns) {
            $(tableId).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('partsnumber.index') }}",
                    data: {
                        source: source // Pass the source dynamically (e.g., parts, customer, vendor, etc.)
                    }
                },
                columns: columns
            });
        }

        $(document).ready(function() {
            var partColumns = [{
                    data: 'Part_Number',
                    name: 'Part_Number'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            var customerColumns = [{
                    data: 'CustomerName',
                    name: 'CustomerName'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            var departmentColumns = [{
                    data: 'name',
                    name: 'name'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            var workColumns = [{
                    data: 'name',
                    name: 'name'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            var outColumns = [{
                    data: 'name',
                    name: 'name'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            var materialColumns = [{
                    data: 'Package',
                    name: 'Package'
                }, // Specific to Parts
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Action buttons
            ];
            initializeDataTable('#myTable', 'parts', partColumns);
            initializeDataTable('#customerTable', 'customer', customerColumns);
            initializeDataTable('#departmentTable', 'department', departmentColumns);
            initializeDataTable('#workTable', 'work', workColumns);
            initializeDataTable('#outTable', 'out', outColumns);
            initializeDataTable('#materialTable', 'material', materialColumns);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#restoreModal1').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_work') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecordWork');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                list.append(`
                                    <li>
                                        ${record.name}
                                        <button class="btn btn-sm btn-success restore-btn-work" data-id="${record.id}">Restore</button>
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-work', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/work') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal1').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });

            $('#restoreModal2').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_out') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecordOut');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                list.append(`
                                    <li>
                                        ${record.name}
                                        <button class="btn btn-sm btn-success restore-btn-out" data-id="${record.id}">Restore</button>
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-out', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/out') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal2').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });


            // record-deleted-data

            $('#restoreModal3').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_data') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecorddata');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                console.log(record)
                                list.append(`
                                    <li>
                                        ${record.Package}
                                        <button class="btn btn-sm btn-success restore-btn-data" data-id="${record.id}">Restore</button>
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-data', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/data') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal3').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });

            // record-deleted-data


            // record-delete-depart

            $('#restoreModal4').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_depart') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecorddepart');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                list.append(`
                                    <li>
                                        ${record.name}
                                        <button class="btn btn-sm btn-success restore-btn-depart" data-id="${record.id}">Restore</button>
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-depart', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/depart') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal4').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });

            // record-delete-depart


            // record-delete-customer

            $('#restoreModal5').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_cus') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecordCus');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                console.log(record)
                                list.append(`
                                <li>
                                    ${record.CustomerName}
                                    <button class="btn btn-sm btn-success restore-btn-cus" data-id="${record.id}">Restore</button>
                                </li>
                            `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-cus', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/cus') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal5').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });

            // record-delete-customer

            $('#restoreModal6').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('deleted_records_part') }}', // Correct route name
                    type: 'GET',
                    success: function(response) {
                        let data = response;
                        let list = $('.deletedRecordPart');
                        list.empty();
                        if (data.length === 0) {
                            list.append('<li>No records found.</li>');
                        } else {
                            data.forEach(function(record) {
                                list.append(`
                            <li>
                                ${record.Part_Number}
                                <button class="btn btn-sm btn-success restore-btn-part" data-id="${record.id}">Restore</button>
                            </li>
                        `);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetch records: ", xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.restore-btn-part', function() {
                let id = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('restore/part') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Restored',
                            text: 'Data Restored Successfully',
                        }).then(() => {
                            location.reload(); // Refresh page
                        });
                        $('#restoreModal6').modal('hide');
                    },
                    error: function() {
                        alert('Failed to restore the record.');
                    }
                });
            });

        });



        $('#partshowform').submit(function(event) {
            event.preventDefault();

            $('#hidebtn').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput = $('#addparts').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.part.number') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    part_number: partNumberInput
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Part Number Failed',
                            text: response.message,
                        });
                        $('#hidebtn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Part Number Failed',
                        text: 'An error occurred while adding the part number.',
                    });
                }
            });
        });


        $('#partshowform1').submit(function(event) {
            event.preventDefault();

            $('#hidebtn1').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#addparts1').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.customer') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    customer_name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn1').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Customer Failed',
                            text: response.message,
                        });
                        $('#hidebtn1').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn1').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Customer Failed',
                        text: 'An error occurred while adding the customer.',
                    });
                }
            });
        });


        $('#partshowform2').submit(function(event) {
            event.preventDefault();

            $('#hidebtn2').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#addparts2').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.department') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn2').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Department Failed',
                            text: response.message,
                        });
                        $('#hidebtn2').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn2').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Customer Failed',
                        text: 'An error occurred while adding the Department.',
                    });
                }
            });
        });


        $('#partshowform3').submit(function(event) {
            event.preventDefault();

            $('#hidebtn3').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#addparts3').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.work.center') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn3').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Work Center Failed',
                            text: response.message,
                        });
                        $('#hidebtn3').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn3').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Customer Failed',
                        text: 'An error occurred while adding the Work Center.',
                    });
                }
            });
        });


        $('#partshowform4').submit(function(event) {
            event.preventDefault();

            $('#hidebtn4').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#addparts4').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.outside.processing') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn4').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Vendor Failed',
                            text: response.message,
                        });
                        $('#hidebtn4').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn4').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Vendor Failed',
                        text: 'An error occurred while adding the Vendor.',
                    });
                }
            });
        });


        $('#partshowform5').submit(function(event) {
            event.preventDefault();

            $('#hidebtn5').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#addparts5').val();

            // AJAX request
            $.ajax({
                url: '{{ route('add.material') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    package: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {

                        $('#hidebtn5').prop('disabled', false);
                        window.location.reload();
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Part Number Added',
                        //     text: response.message,
                        // });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Material Failed',
                            text: response.message,
                        });
                        $('#hidebtn5').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $('#hidebtn5').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Material Failed',
                        text: 'An error occurred while adding the Material.',
                    });
                }
            });
        });
    </script>

    {{-- add data ajax --}}

    {{-- edit data ajax --}}

    <script>
        $(document).on('click', '.opendata', function() {
            $('#partNumberId').val($(this).data('id'));
            $('#partNumberInput').val($(this).data('column'));
            $('#partNumber').show();
        });

        $('#partNumberForm').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput = $('#partNumberInput').val();
            const partId = $('#partNumberId').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('partsnumber.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    part_number: partNumberInput
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Part Number Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Part Number Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Part Number Update Failed',
                        text: 'An error occurred while updating the part number.',
                    });
                }
            });
        });

        $(document).on('click', '.opendata1', function() {
            $('#partNumberId1').val($(this).data('id'));
            $('#partNumberInput1').val($(this).data('column'));
            $('#partshowform1').show();
        });

        $('#partNumberForm1').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn1').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#partNumberInput1').val();
            const partId = $('#partNumberId1').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('customer.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    CustomerName: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn1').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Customer Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn1').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn1').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Customer Update Failed',
                        text: 'An error occurred while updating the customer.',
                    });
                }
            });
        });


        $(document).on('click', '.opendata2', function() {
            $('#partNumberId2').val($(this).data('id'));
            $('#partNumberInput2').val($(this).data('column'));
            $('#partshowform2').show();
        });

        $('#partNumberForm2').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn2').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#partNumberInput2').val();
            const partId = $('#partNumberId2').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('department.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn2').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Department Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Department Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn2').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn2').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Department Update Failed',
                        text: 'An error occurred while updating the Department.',
                    });
                }
            });
        });


        $(document).on('click', '.opendata3', function() {
            $('#partNumberId3').val($(this).data('id'));
            $('#partNumberInput3').val($(this).data('column'));
            $('#partshowform3').show();
        });

        $('#partNumberForm3').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn3').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#partNumberInput3').val();
            const partId = $('#partNumberId3').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('work.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn3').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Work Center Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Work Center Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn3').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn3').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Work Center Update Failed',
                        text: 'An error occurred while updating the Work Center.',
                    });
                }
            });
        });


        $(document).on('click', '.opendata4', function() {
            $('#partNumberId4').val($(this).data('id'));
            $('#partNumberInput4').val($(this).data('column'));
            $('#partshowform4').show();
        });

        $('#partNumberForm4').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn4').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#partNumberInput4').val();
            const partId = $('#partNumberId4').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('vendor.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    name: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn4').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Vendor Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Vendor Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn4').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn4').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Vendor Update Failed',
                        text: 'An error occurred while updating the Vendor.',
                    });
                }
            });
        });

        $(document).on('click', '.opendata5', function() {
            $('#partNumberId5').val($(this).data('id'));
            $('#partNumberInput5').val($(this).data('column'));
            $('#partshowform5').show();
        });

        $('#partNumberForm5').submit(function(event) {
            event.preventDefault();
            console.log('gksapgkps');
            // Disable the button to prevent multiple submissions
            $('#hidebtn5').prop('disabled', true);

            const token = $('meta[name="csrf-token"]').attr('content');
            const partNumberInput1 = $('#partNumberInput5').val();
            const partId = $('#partNumberId5').val(); // Get the ID from the hidden input

            // AJAX request
            $.ajax({
                url: '{{ route('material.update') }}', // Correct route name
                type: 'POST',
                data: {
                    _token: token,
                    id: partId, // Pass the part ID
                    Package: partNumberInput1
                },
                success: function(response) {
                    if (response.success) {
                        console.log('gksapgkps');

                        // Re-enable the button after successful request
                        $('#hidebtn5').prop('disabled', false);
                        window.location.reload(); // Reload the page after success
                        Swal.fire({
                            icon: 'success',
                            title: 'Material Updated',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Material Update Failed',
                            text: response.message,
                        });
                        // Re-enable the button after failure
                        $('#hidebtn5').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    // Re-enable the button in case of an error
                    $('#hidebtn5').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Material Update Failed',
                        text: 'An error occurred while updating the Material.',
                    });
                }
            });
        });
    </script>

    {{-- edit data ajax --}}


    {{-- pagination script --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let openDiv = localStorage.getItem("openDiv");

            if (openDiv) {
                let selectedDiv = document.getElementById("div" + openDiv);
                if (selectedDiv) {
                    selectedDiv.classList.add("show"); // Bootstrap class to keep it open
                }
            }
        });

        function toggleDiv(num) {
            let allDivs = document.querySelectorAll(".accordion-collapse");
            let selectedDiv = document.getElementById("div" + num);
            let openDiv = localStorage.getItem("openDiv");

            if (openDiv == num) {
                // Close same div if clicked again
                selectedDiv.classList.remove("show");
                localStorage.removeItem("openDiv");
            } else {
                // Close all other divs
                allDivs.forEach(div => div.classList.remove("show"));

                // Open new div
                selectedDiv.classList.add("show");
                localStorage.setItem("openDiv", num);
            }
        }

        $(document).on('click', '#delete-data', function() {
            let id = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-data') }}/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The work center has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while deleting the work center.',
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-cus', function() {
            let id = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-cus') }}/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The work center has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while deleting the work center.',
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-depart', function() {
            let id = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-depart') }}/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The work center has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while deleting the work center.',
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-work', function() {
            let id = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-work') }}/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The work center has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while deleting the work center.',
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-out', function() {
            let id = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-out') }}/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The outsource processing has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while deleting the work center.',
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.delete-part', function() {
            let partId = $(this).data('id'); // Get the selected part ID

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('delete-part') }}/" + partId,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The part has been deleted.',
                            }).then(() => {
                                location.reload(); // Refresh page
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON?.error ||
                                'Something went wrong!';

                            if (xhr.status === 400 && xhr.responseJSON.parts) {
                                // Show a dropdown with available parts for replacement
                                let partOptions = xhr.responseJSON.parts.map(part =>
                                    `<option value="${part.id}">${part.Part_Number}</option>`
                                ).join('');

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Cannot Delete!',
                                    html: `
                                        <p>${errorMessage}</p>
                                        <label for="replacement-part">Select a replacement part:</label>
                                        <select id="replacement-part" class="swal2-select js-select2-custom">
                                            <option value="">--Select a Part--</option>
                                            ${partOptions}
                                        </select>
                                    `,
                                    showCancelButton: true,
                                    confirmButtonText: 'Replace & Delete',
                                    cancelButtonText: 'Cancel',
                                    showDenyButton: true,
                                    denyButtonText: 'Delete Completely',
                                    didOpen: () => {
                                        // Initialize Select2 after modal is opened
                                        $('.js-select2-custom').select2({
                                            dropdownParent: $(
                                                '.swal2-popup'),
                                            width: '100%',
                                            placeholder: "Select a Part",
                                            allowClear: true
                                        });
                                    },
                                    preConfirm: () => {
                                        let selectedPart = document.getElementById(
                                            'replacement-part').value;
                                        if (!selectedPart) {
                                            Swal.showValidationMessage(
                                                'Please select a replacement part!'
                                            );
                                        }
                                        return selectedPart;
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let newPartId = result.value;
                                        $.ajax({
                                            url: "{{ url('replace-part') }}",
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                            },
                                            data: {
                                                old_part_id: partId,
                                                new_part_id: newPartId
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Updated!',
                                                    text: 'Entries updated, and the part has been deleted.',
                                                }).then(() => {
                                                    location
                                                        .reload(); // Refresh page
                                                });
                                            },
                                            error: function(error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error!',
                                                    text: 'Failed to update entries.',
                                                });
                                            }
                                        });
                                    } else if (result.isDenied) {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "This will permanently delete the part and may cause data inconsistencies!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes, delete it!',
                                            cancelButtonText: 'Cancel',
                                            confirmButtonColor: '#d33',
                                        }).then((confirmDelete) => {
                                            if (confirmDelete.isConfirmed) {
                                                $.ajax({
                                                    url: "{{ url('force-delete-part') }}/" +
                                                        partId,
                                                    method: 'DELETE',
                                                    headers: {
                                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                    },
                                                    success: function(
                                                        response) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Deleted!',
                                                            text: 'The part has been deleted permanently.',
                                                        }).then(
                                                            () => {
                                                                location
                                                                    .reload(); // Refresh page
                                                            });
                                                    },
                                                    error: function(
                                                        error) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error!',
                                                            text: 'Failed to delete the part.',
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage,
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>

    {{-- pagination script --}}
@endsection
