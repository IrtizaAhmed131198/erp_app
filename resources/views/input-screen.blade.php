@extends('layouts.main')

@section('content')
    <section class="visual-queue-screen">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <div class="accordion" id="accordionExample">
                            @if(!empty($com1) && $com1->isNotEmpty())
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <strong>
                                                COPM 01
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com1 as $entry)
                                                    @if ($entry['entries']['status'] !== null && $entry['entries']['job'] !== null && $entry['entries']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries']['customer'] }}</td>
                                                        <td>{{ $entry['entries']['part_number'] }}</td>
                                                        <td>{{ $entry['entries']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries']['job'] }}</td>
                                                        <td>{{ $entry['entries']['lot']}}</td>
                                                        <td style="display: none">COM 1</td>
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
                            @if(!empty($com2) && $com2->isNotEmpty())
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com2 as $entry)
                                                    @if ($entry['entries']['status'] !== null && $entry['entries']['job'] !== null && $entry['entries']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries']['customer'] }}</td>
                                                        <td>{{ $entry['entries']['part_number'] }}</td>
                                                        <td>{{ $entry['entries']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries']['job'] }}</td>
                                                        <td>{{ $entry['entries']['lot']}}</td>
                                                        <td style="display: none">COM 2</td>
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
                            @if(!empty($com3) && $com3->isNotEmpty())
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($com3 as $entry)
                                                    @if ($entry['entries']['status'] !== null && $entry['entries']['job'] !== null && $entry['entries']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries']['customer'] }}</td>
                                                        <td>{{ $entry['entries']['part_number'] }}</td>
                                                        <td>{{ $entry['entries']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries']['job'] }}</td>
                                                        <td>{{ $entry['entries']['lot']}}</td>
                                                        <td style="display: none">COM 3</td>
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

                            @if(!empty($out1) && $out1->isNotEmpty())
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out1 as $entry)
                                                    @if ($entry['entries_data']['status'] !== null && $entry['entries_data']['job'] !== null && $entry['entries_data']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries_data']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries_data']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries_data']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries_data']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries_data']['customer'] }}</td>
                                                        <td>{{ $entry['entries_data']['part_number'] }}</td>
                                                        <td>{{ $entry['entries_data']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries_data']['job'] }}</td>
                                                        <td>{{ $entry['entries_data']['lot']}}</td>
                                                        <td style="display: none">OUT 1</td>
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
                            @if(!empty($out2) && $out2->isNotEmpty())
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFifth">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
                                            <strong>
                                                OUT 2
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseFifth" class="accordion-collapse collapse" aria-labelledby="headingFifth"
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out2 as $entry)
                                                    @if ($entry['entries_data']['status'] !== null && $entry['entries_data']['job'] !== null && $entry['entries_data']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries_data']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries_data']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries_data']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries_data']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries_data']['customer'] }}</td>
                                                        <td>{{ $entry['entries_data']['part_number'] }}</td>
                                                        <td>{{ $entry['entries_data']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries_data']['job'] }}</td>
                                                        <td>{{ $entry['entries_data']['lot']}}</td>
                                                        <td style="display: none">OUT 2</td>
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
                            @if(!empty($out3) && $out3->isNotEmpty())
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <strong>
                                                OUT 3
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out3 as $entry)
                                                    @if ($entry['entries_data']['status'] !== null && $entry['entries_data']['job'] !== null && $entry['entries_data']['lot'] !== null)
                                                    <tr>
                                                        <td>
                                                            <select name="status" id="status">
                                                                <option value="Running" {{ $entry['entries_data']['status'] == 'Running' ? 'selected' : '' }}>Running</option>
                                                                <option value="Pending Order" {{ $entry['entries_data']['status'] == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                <option value="Pause" {{ $entry['entries_data']['status'] == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                <option value="Closed" {{ $entry['entries_data']['status'] == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                            </select>
                                                        </td>
                                                        <td>{{ $entry['entries_data']['customer'] }}</td>
                                                        <td>{{ $entry['entries_data']['part_number'] }}</td>
                                                        <td>{{ $entry['entries_data']['in_stock_finish'] }}</td>
                                                        <td>{{ $entry['entries_data']['job'] }}</td>
                                                        <td>{{ $entry['entries_data']['lot']}}</td>
                                                        <td style="display: none">OUT 3</td>
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
    $(document).ready(function () {
        $('.submit-table-data-1-one').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseOne tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data') }}",
                method: "POST",
                data: {
                    entries: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });

        $('.submit-table-data-1-two').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseTwo tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data') }}",
                method: "POST",
                data: {
                    entries: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });

        $('.submit-table-data-1-three').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseThree tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data') }}",
                method: "POST",
                data: {
                    entries: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });


        $('.submit-table-data-2-one').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseFour tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data_2') }}",
                method: "POST",
                data: {
                    entries_data: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });

        $('.submit-table-data-2-two').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseFifth tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data_2') }}",
                method: "POST",
                data: {
                    entries_data: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });

        $('.submit-table-data-2-three').on('click', function (e) {
            e.preventDefault();

            let tableData = [];
            $('#collapseSix tbody tr').each(function () {
                let row = $(this);
                let entry = {
                    status: row.find('select[name="status"]').val(),
                    customer: row.find('td:eq(1)').text().trim(),
                    part_number: row.find('td:eq(2)').text().trim(),
                    quantity: row.find('td:eq(3)').text().trim(),
                    job: row.find('td:eq(4)').text().trim(),
                    lot: row.find('td:eq(5)').text().trim(),
                    type: row.find('td:eq(6)').text().trim()
                };
                tableData.push(entry);
            });

            $.ajax({
                url: "{{ route('save_table_data_2') }}",
                method: "POST",
                data: {
                    entries_data: tableData
                },
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to save data.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while saving data.');
                }
            });
        });
    });
</script>
@endsection
