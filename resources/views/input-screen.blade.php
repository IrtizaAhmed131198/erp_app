@extends('layouts.main')

@section('content')
    <section class="visual-queue-screen">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <div class="accordion" id="accordionExample">
                            @if (!empty($com1))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <strong>
                                                COPM 01
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com1 as $entry)
                                                        @php
                                                            $status = $entry['entries']['status'] ?? null;
                                                            $customer = $entry['entries']['customer'] ?? null;
                                                            $part_number = $entry['entries']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries']['job'] ?? null;
                                                            $lot = $entry['entries']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>Pause
                                                                        </option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">COM 1</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-1-one">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($com2))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <strong>
                                                COPM 02
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com2 as $entry)
                                                        @php
                                                            $status = $entry['entries']['status'] ?? null;
                                                            $customer = $entry['entries']['customer'] ?? null;
                                                            $part_number = $entry['entries']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries']['job'] ?? null;
                                                            $lot = $entry['entries']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">COM 2</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-1-two">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($com3))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <strong>
                                                COPM 03
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com3 as $entry)
                                                        @php
                                                            $status = $entry['entries']['status'] ?? null;
                                                            $customer = $entry['entries']['customer'] ?? null;
                                                            $part_number = $entry['entries']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries']['job'] ?? null;
                                                            $lot = $entry['entries']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">COM 3</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-1-three">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($out1))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            <strong>
                                                OUT 1
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out1 as $entry)
                                                        @php
                                                            $status = $entry['entries_data']['status'] ?? null;
                                                            $customer = $entry['entries_data']['customer'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries_data']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries_data']['job'] ?? null;
                                                            $lot = $entry['entries_data']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">OUT 1</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-2-one">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($out2))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFifth">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFifth"
                                            aria-expanded="false" aria-controls="collapseFifth">
                                            <strong>
                                                OUT 2
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseFifth" class="accordion-collapse collapse"
                                        aria-labelledby="headingFifth" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out2 as $entry)
                                                        @php
                                                            $status = $entry['entries_data']['status'] ?? null;
                                                            $customer = $entry['entries_data']['customer'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries_data']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries_data']['job'] ?? null;
                                                            $lot = $entry['entries_data']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">OUT 2</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-2-two">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($out3))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                            <strong>
                                                OUT 3
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Customer</th>
                                                        <th>Part Number</th>
                                                        <th>Quantity</th>
                                                        <th>Job #</th>
                                                        <th>LOT #</th>
                                                        <th style="display: none">type #</th>
                                                        <th style="display: none">ID #</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out3 as $entry)
                                                        @php
                                                            $status = $entry['entries_data']['status'] ?? null;
                                                            $customer = $entry['entries_data']['customer'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part_number'] ?? null;
                                                            $in_stock_finish =
                                                                $entry['entries_data']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries_data']['job'] ?? null;
                                                            $lot = $entry['entries_data']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running"
                                                                            {{ $status == 'Running' ? 'selected' : '' }}>
                                                                            Running</option>
                                                                        <option value="Pending Order"
                                                                            {{ $status == 'Pending Order' ? 'selected' : '' }}>
                                                                            Pending Order</option>
                                                                        <option value="Pause"
                                                                            {{ $status == 'Pause' ? 'selected' : '' }}>
                                                                            Pause</option>
                                                                        <option value="Closed"
                                                                            {{ $status == 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>{{ $customer }}</td>
                                                                <td>{{ $part_number }}</td>
                                                                <td>{{ $in_stock_finish }}</td>
                                                                <td>{{ $job }}</td>
                                                                <td>{{ $lot }}</td>
                                                                <td style="display: none">OUT 3</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-2-three">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.submit-table-data-1-one').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseOne tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data') }}",
                    method: "POST",
                    data: {
                        entries: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseOne').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });

            $('.submit-table-data-1-two').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseTwo tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data') }}",
                    method: "POST",
                    data: {
                        entries: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseTwo').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });

            $('.submit-table-data-1-three').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseThree tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data') }}",
                    method: "POST",
                    data: {
                        entries: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseThree').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });


            $('.submit-table-data-2-one').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseFour tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data_2') }}",
                    method: "POST",
                    data: {
                        entries_data: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseFour').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });

            $('.submit-table-data-2-two').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseFifth tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data_2') }}",
                    method: "POST",
                    data: {
                        entries_data: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseFifth').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });

            $('.submit-table-data-2-three').on('click', function(e) {
                e.preventDefault();

                let tableData = [];
                $('#collapseSix tbody tr').each(function() {
                    let row = $(this);
                    let entry = {
                        status: row.find('select[name="status"]').val(),
                        customer: row.find('td:eq(1)').text().trim(),
                        part_number: row.find('td:eq(2)').text().trim(),
                        quantity: row.find('td:eq(3)').text().trim(),
                        job: row.find('td:eq(4)').text().trim(),
                        lot: row.find('td:eq(5)').text().trim(),
                        type: row.find('td:eq(6)').text().trim(),
                        type_id: row.find('td:eq(7)').text().trim()
                    };
                    tableData.push(entry);
                });

                $.ajax({
                    url: "{{ route('save_table_data_2') }}",
                    method: "POST",
                    data: {
                        entries_data: tableData
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#collapseSix').collapse('hide');
                        } else {
                            // Handle failure case
                            console.error('fails');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                    }
                });
            });
        });
    </script>
@endsection
