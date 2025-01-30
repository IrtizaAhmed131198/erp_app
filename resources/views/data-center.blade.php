@extends('layouts.main')

@section('css')
    <style>
        .select2-selection__arrow {
            background-image: unset !important;
        }

        .side_btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .side_btn .custom-btn {
            margin: unset;
        }

        .weekly-section.data-center .parent-table {
            padding-right: 0;
            height: unset;
        }

        .parent-table table input,
        .parent-table table textarea {
            height: 22px;
        }

        .select2.select2-container .select2-selection {
            height: 25px;
            margin-bottom: 5px;
        }

        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 25px;
            font-size: 14px;
        }

        .weekly-section.data-center .parent-table tr td:nth-child(01) {
            line-height: 30px;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
            height: 22px;
        }
    </style>
@endsection


@section('content')
    <section class="weekly-section data-center">
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
                                Part Number Input
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <form action="{{ route('post_data_center') }}" method="POST">
                            @csrf
                            <div class="btn-custom-btn text-center mb-3 side_btn">
                                <button type="submit" class="btn custom-btn">Submit</button>
                                <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                            </div>
                            <div class="parent-table parent-table-calender full-view-port mt-4">


                                <table class="table table-hover table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td scope="col" colspan="2"><strong>Part Number Input</strong></td>
                                        </tr>
                                        <tr>
                                            @if (Auth::user()->role == 1)
                                                <td data-bs-toggle="modal" data-bs-target="#partNumber">Part Number <span
                                                        class="badge badge-sm bg-success bg-add-new">Add new</span></td>
                                            @else
                                                <td>Part Number</td>
                                            @endif
                                            <td>
                                                <select class="form-select js-select21" id="part_number" name="part_number"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Select Part Number</option>
                                                    @foreach ($parts as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('part_number') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->Part_Number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            @if (Auth::user()->role == 1)
                                                <td data-bs-toggle="modal" data-bs-target="#customerModal">Customer <span
                                                        class="badge badge-sm bg-success bg-add-new">Add new</span></td>
                                            @else
                                                <td>Customer</td>
                                            @endif
                                            <td>
                                                <select class="form-select js-select21" id="customer_id" name="customer"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Select Customer</option>
                                                    @foreach ($customer as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('customer') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->CustomerName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <input type="text" name="customer" value="{{ old('customer') }}"
                                                id=""> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Revision</td>
                                            <td>
                                                <input type="text" name="revision" value="{{ old('revision') }}"
                                                    oninput="this.value = this.value.toUpperCase();" id="">
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                        <td>ID</td>
                                        <td>
                                            <input type="text" name="ids" value="{{ old('ids') }}" id="">
                                        </td>
                                    </tr> --}}
                                        <tr>
                                            <td>Process</td>
                                            <td>
                                                <input type="text" name="process" value="{{ old('process') }}"
                                                    oninput="this.value = this.value.toUpperCase();" id="">
                                            </td>
                                        </tr>
                                        <tr>
                                            @if (Auth::user()->role == 1)
                                                <td data-bs-toggle="modal" data-bs-target="#departmentModal">Department <span class="badge badge-sm bg-success bg-add-new">Add new</span></td>
                                            @else
                                                <td>Department</td>
                                            @endif
                                            <td>
                                                <select class="js-select2 select2-hidden-accessible" id="department_id"
                                                    name="department" tabindex="-1">
                                                    <option selected disabled>Select DEPARTMENT</option>
                                                    @foreach ($department as $dept)
                                                        <option value="{{ $dept->id }}"
                                                            {{ old('department') == $dept->id ? 'selected' : '' }}>
                                                            {{ $dept->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @for ($i = 1; $i <= 7; $i++)
                                        <tr>
                                            @if (Auth::user()->role == 1)
                                                <td data-bs-toggle="modal" data-bs-target="{{ $i == 1 ? '#workCenterModal' : '' }}" data-work-id="{{ $i }}">
                                                    Work Centre {{ $i }}
                                                    @if ($i == 1) <!-- Show "Add new" only for the first row -->
                                                        <span class="badge badge-sm bg-success bg-add-new">Add new</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td>Work Centre {{ $i }}</td>
                                            @endif
                                            <td>
                                                <select class="js-select2 select2-hidden-accessible work_centre_select"
                                                    name="work_centre_{{ $i }}"
                                                    aria-label="Default select example">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($work_center_select as $center)
                                                        <option value="{{ $center['id'] }}"
                                                            {{ old('work_centre_' . $i) == $center['id'] ? 'selected' : '' }}>
                                                            {{ $center['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endfor
                                        <tr>
                                            <td>Part Notes</td>
                                            <td>
                                                <textarea name="part_notes" id="">{{ old('part_notes') }}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= 4; $i++)
                                        <tr>
                                            @if (Auth::user()->role == 1)
                                                <td data-bs-toggle="modal" data-bs-target="{{ $i == 1 ? '#outsideProcessingModal' : '' }}" data-outside-id="{{ $i }}">
                                                    Outside Processing {{ $i }}
                                                    @if ($i == 1) <!-- Show "Add new" only for the first row -->
                                                        <span class="badge badge-sm bg-success bg-add-new">Add new</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td>Outside Processing {{ $i }}</td>
                                            @endif
                                            <td>
                                                <div class="parent-inputs">
                                                    <select class="js-select2 select2-hidden-accessible outside_select"
                                                        name="outside_processing_{{ $i }}"
                                                        aria-label="Default select example">
                                                        <option value="" selected>Select</option>
                                                        @foreach ($vendor as $v)
                                                            <option value="{{ $v->id }}"
                                                                {{ old('outside_processing_' . $i) == $v->id ? 'selected' : '' }}>
                                                                {{ $v->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text"
                                                        name="outside_processing_text_{{ $i }}"
                                                        value="{{ old('outside_processing_text_' . $i) }}"
                                                        id="">
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor

                                        <tr>
                                            <td data-bs-toggle="modal" data-bs-target="#materialModal">Material <span
                                                    class="badge badge-sm bg-success bg-add-new">Add new</span></td>
                                            <td>
                                                <select class="form-select js-select21" id="material_id" name="material"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Select Material</option>
                                                    @foreach ($material as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('customer') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->Package }}
                                                        </option>
                                                    @endforeach
                                                    {{-- <input type="text" name="material" value="{{ old('material') }}"
                                                    id=""> --}}
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                        <td>Pc Weight</td>
                                        <td>
                                            <input type="number" step="any" name="pc_weight"
                                                value="{{ old('pc_weight') }}" id="">
                                        </td>
                                    </tr> --}}
                                        {{-- <tr>
                                        <td>Safety Stock</td>
                                        <td>
                                            <input type="number" step="any" name="safety_stock"
                                                value="{{ old('safety_stock') }}" id="">
                                        </td>
                                    </tr> --}}
                                        <tr>
                                            <td>MOQ</td>
                                            <td>
                                                <input type="text" step="any" name="moq"
                                                    value="{{ old('moq') }}" oninput="formatAndPreventNegative(this)"
                                                    id="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Order Notes</td>
                                            <td>
                                                <textarea name="order_notes" id="">{{ old('order_notes') }}</textarea>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td>Future Raw</td>
                                            <td>
                                                <input type="number" name="future_raw" value="{{ old('future_raw') }}"
                                                    id="">
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td>Price</td>
                                            <td>
                                                {{--                                            <input type="number" step="any" name="price" value="{{ old('price') }}" --}}
                                                {{--                                                id=""> --}}

                                                <input type="text" step="any" name="price" id="price"
                                                    value="{{ old('price') }}" oninput="decimalPlacesFour(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>
                                                <select class="form-select js-select21" name="currency"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Select Currency</option>
                                                    <option value="USD"
                                                        {{ old('currency') == 'USD' ? 'selected' : '' }}>
                                                        USD
                                                    </option>
                                                    <option value="CDN"
                                                        {{ old('currency') == 'CDN' ? 'selected' : '' }}>
                                                        CDN
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                        <td>REV</td>
                                        <td>
                                            <input type="text" name="rev" id="rev"
                                                value="{{ old('rev') }}">
                                        </td>
                                    </tr> --}}
                                        {{-- <tr>
                                        <td>Wt Req'd</td>
                                        <td>
                                            <input type="number" step="any" name="wet_reqd" id="wet_reqd" value="{{ old('wet_reqd') }}">
                                        </td>
                                    </tr> --}}
                                        <tr>
                                            <td>Safety Stock</td>
                                            <td>
                                                <input type="text" name="safety" id="safety"
                                                    value="{{ old('safety') }}" oninput="formatAndPreventNegative(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Minship</td>
                                            <td>
                                                <input type="text" name="min_ship" id="min_ship"
                                                    value="{{ old('min_ship') }}"
                                                    oninput="formatAndPreventNegative(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>WT/PC</td>
                                            <td>
                                                {{--                                            <input type="number" name="wt_pc" id="wt_pc" --}}
                                                {{--                                                value="{{ old('wt_pc') }}"> --}}
                                                <input type="text" step="any" name="wt_pc" id="wt_pc"
                                                    value="{{ old('wt_pc') }}" oninput="decimalPlaces(this)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="partNumber" tabindex="-1" aria-labelledby="partNumberLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partNumberLabel">Add Part Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="partNumberForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="partNumberInput" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="partNumberInput"
                                placeholder="Enter part number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Part Number</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customerForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customerInput" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customerInput"
                                placeholder="Enter customer name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="departmentModalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="departmentForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="departmentInput" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="departmentInput"
                                placeholder="Enter department name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialModalLabel">Add Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="materialForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="materialInput" class="form-label">Package</label>
                            <input type="text" class="form-control" id="materialInput"
                                placeholder="Enter package name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="workCenterModal" tabindex="-1" aria-labelledby="workCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workCenterModalLabel">Add Work Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="workCenterForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="workCenterInput" class="form-label">Work Center Name</label>
                            <input type="text" class="form-control" id="workCenterInput" placeholder="Enter work center name" required>
                            <input type="hidden" id="workCenterId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Work Center</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="outsideProcessingModal" tabindex="-1" aria-labelledby="outsideProcessingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outsideProcessingModalLabel">Add Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="outsideProcessingForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="outsideProcessingInput" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="outsideProcessingInput" placeholder="Enter outside processing name" required>
                            <input type="hidden" id="outsideProcessingId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Vendor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
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

        function decimalPlacesFour(element) {
            let value = element.value;
            value = value.replace(/[^0-9.]/g, ''); // Remove non-numeric and non-period characters

            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1].slice(0, 4); // Limit to 4 decimal places
            } else if (parts.length === 2 && parts[1].length > 4) {
                value = parts[0] + '.' + parts[1].slice(0, 4); // Limit to 4 decimal places
            }

            element.value = value;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#partNumberForm').submit(function(event) {
                event.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const partNumberInput = $('#partNumberInput').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.part.number') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        part_number: partNumberInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new part number to the table
                            const selectDropdown = $('#part_number');
                            const newOption =
                                `<option value="${response.part_number.id}">${response.part_number.part_number}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            $('#partNumberForm')[0].reset();
                            $('#partNumber').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Part Number Added',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Part Number Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Part Number Failed',
                            text: 'An error occurred while adding the part number.',
                        });
                    }
                });
            });

            $('#customerForm').submit(function(event) {
                event.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const customerInput = $('#customerInput').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.customer') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        customer_name: customerInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new customer to the dropdown
                            const selectDropdown = $('#customer_id');
                            const newOption =
                                `<option value="${response.customer.id}">${response.customer.CustomerName}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            $('#customerForm')[0].reset();
                            $('#customerModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Customer Added',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Add Customer Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Add Customer Failed',
                            text: 'An error occurred while adding the customer.',
                        });
                    }
                });
            });

            $('#departmentForm').submit(function(event) {
                event.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const departmentInput = $('#departmentInput').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.department') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        name: departmentInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new department to the dropdown
                            const selectDropdown = $('#department_id');
                            const newOption =
                                `<option value="${response.department.id}">${response.department.name}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            $('#departmentForm')[0].reset();
                            $('#departmentModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Department Added',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Add Department Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Add Department Failed',
                            text: 'An error occurred while adding the department.',
                        });
                    }
                });
            });

            $('#materialForm').submit(function(event) {
                event.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const materialInput = $('#materialInput').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.material') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        package: materialInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new material to the dropdown
                            const selectDropdown = $('#material_id');
                            const newOption =
                                `<option value="${response.material.id}">${response.material.Package}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            $('#materialForm')[0].reset();
                            $('#materialModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Material Added',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Add Material Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Add Material Failed',
                            text: 'An error occurred while adding the material.',
                        });
                    }
                });
            });

            $('.workCenterForm').submit(function(event) {
                event.preventDefault();

                const form = $(this);
                const selectId = form.data('select-id');
                const token = $('meta[name="csrf-token"]').attr('content');
                const workCenterInput = form.find('input[type="text"]').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.work.center') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        name: workCenterInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new work center to the relevant dropdown
                            const selectDropdown = $(`.work_centre_select`);
                            const newOption =
                                `<option value="${response.workCenter.id}">${response.workCenter.name}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            form[0].reset();
                            form.closest('.modal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Work Center Added',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Add Work Center Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Add Work Center Failed',
                            text: 'An error occurred while adding the work center.',
                        });
                    }
                });
            });

            $('.outsideProcessingForm').submit(function(event) {
                event.preventDefault();

                const form = $(this);
                const selectId = form.data('select-id');
                const token = $('meta[name="csrf-token"]').attr('content');
                const outsideProcessingInput = form.find('input[type="text"]').val();

                // AJAX request
                $.ajax({
                    url: '{{ route('add.outside.processing') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        name: outsideProcessingInput
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new outside processing to the relevant dropdown
                            const selectDropdown = $(`.outside_select`);
                            const newOption =
                                `<option value="${response.outsideProcessing.id}">${response.outsideProcessing.name}</option>`;
                            selectDropdown.append(newOption);

                            // Reset the form and close the modal
                            form[0].reset();
                            form.closest('.modal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Outside Processing Added',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Add Outside Processing Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Add Outside Processing Failed',
                            text: 'An error occurred while adding the outside processing.',
                        });
                    }
                });
            });
        });
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                title: 'Validation Errors!',
                html: `
                <ul style="text-align: left; margin-left: 40px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
