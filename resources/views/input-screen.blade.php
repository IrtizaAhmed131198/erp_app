@extends('layouts.main')

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
                                Input Screen
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <div class="accordion" id="accordionExample">
                            <h3 class="text-center mb-3">Work Center</h3>
                            @php
                                // Group entries by 'work_select.name'
                                $groupedEntries = collect($com1)->groupBy('work_select.name');
                            @endphp

                            @foreach ($groupedEntries as $workCenterName => $entries)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ Str::slug($workCenterName) }}">
                                        <button class="accordion-button {{ $loop->first ? 'collapsed' : 'show' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ Str::slug($workCenterName) }}" aria-expanded="{{ $loop->first ? 'false' : 'true' }}" aria-controls="collapse{{ Str::slug($workCenterName) }}">
                                            <strong>
                                                {{ $workCenterName }}
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ Str::slug($workCenterName) }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ Str::slug($workCenterName) }}"
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($entries as $entry)
                                                        @php
                                                            $status = $entry['entries']['status'] ?? null;
                                                            $customer = $entry['entries']['get_customer']['CustomerName'] ?? null;
                                                            $customer_id = $entry['entries']['get_customer']['id'] ?? null;
                                                            $part_number = $entry['entries']['part']['Part_Number'] ?? null;
                                                            $part_number_id = $entry['entries']['part']['id'] ?? null;
                                                            $in_stock_finish = $entry['entries']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries']['job'] ?? null;
                                                            $lot = $entry['entries']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                            $work_select = $entry['work_select']['name']  ?? null;
                                                        @endphp

                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" class="status">
                                                                        <option value="Running" {{ $status == 'Running' ? 'selected' : '' }}>Running</option>
                                                                        <option value="Pending Order" {{ $status == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                        <option value="Pause" {{ $status == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                        <option value="Closed" {{ $status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <select name="customer" class="customer">
                                                                            @foreach ($customers as $item)
                                                                                <option value="{{ $item->CustomerName }}" {{ $customer_id == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->CustomerName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $customer }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <select name="part_number" class="part_number">
                                                                            @foreach ($parts as $item)
                                                                                <option value="{{ $item->Part_Number }}" {{ $part_number_id == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->Part_Number }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $part_number }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="number" name="quantity" class="quantity" value="{{ $in_stock_finish }}">
                                                                    @else
                                                                        {{ $in_stock_finish }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="text" name="job" class="job" value="{{ $job }}">
                                                                    @else
                                                                        {{ $job }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="text" name="lot" class="lot" value="{{ $lot }}">
                                                                    @else
                                                                        {{ $lot }}
                                                                    @endif
                                                                </td>
                                                                <td style="display: none" class="type">{{ $work_select }}</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-center mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data" data-id="collapse{{ Str::slug($workCenterName) }}">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            {{-- @if (!empty($com1))
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
                                                            $customer = $entry['entries']['get_customer']['CustomerName'] ?? null;
                                                            $part_number = $entry['entries']['part']['Part_Number'] ?? null;
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
                                                            $customer = $entry['entries']['get_customer']['CustomerName'] ?? null;
                                                            $part_number = $entry['entries']['part']['Part_Number'] ?? null;
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
                                                            $customer = $entry['entries']['get_customer']['CustomerName'] ?? null;
                                                            $part_number = $entry['entries']['part']['Part_Number'] ?? null;
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
                                                            $customer = $entry['entries_data']['get_customer']['CustomerName'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part']['Part_Number'] ?? null;
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
                                                            $customer = $entry['entries_data']['get_customer']['CustomerName'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part']['Part_Number'] ?? null;
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
                                                            $customer = $entry['entries_data']['get_customer']['CustomerName'] ?? null;
                                                            $part_number =
                                                                $entry['entries_data']['part']['Part_Number'] ?? null;
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
                            @endif --}}
                        </div>
                        <div class="accordion" id="accordionExample1">
                            <h3 class="text-center mb-3 mt-5">Out Source Processing</h3>

                            @php
                                $groupedEntriesOut= collect($out1)->groupBy('out_source.name');
                            @endphp
                            @foreach ($groupedEntriesOut as $outSourceName => $entries)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ \Str::slug($outSourceName) }}">
                                        <button class="accordion-button {{ $loop->first ? 'collapsed' : 'show' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ \Str::slug($outSourceName) }}" aria-expanded="{{ $loop->first ? 'false' : 'true' }}" aria-controls="collapse{{ \Str::slug($outSourceName) }}">
                                            <strong>
                                                {{ $outSourceName }}
                                            </strong>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ \Str::slug($outSourceName) }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ \Str::slug($outSourceName) }}"
                                        data-bs-parent="#accordionExample1">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($entries as $entry)
                                                        @php
                                                            $status = $entry['entries_data']['status'] ?? null;
                                                            $customer = $entry['entries_data']['get_customer']['CustomerName'] ?? null;
                                                            $customer_id = $entry['entries_data']['get_customer']['id'] ?? null;
                                                            $part_number = $entry['entries_data']['part']['Part_Number'] ?? null;
                                                            $part_number_id = $entry['entries_data']['part']['id'] ?? null;
                                                            $in_stock_finish = $entry['entries_data']['in_stock_finish'] ?? null;
                                                            $job = $entry['entries_data']['job'] ?? null;
                                                            $lot = $entry['entries_data']['lot'] ?? null;
                                                            $id = $entry['id'] ?? null;
                                                            $out_source = $entry['out_source']['name']  ?? null;
                                                        @endphp
                                                        @if ($status !== null && $job !== null && $lot !== null)
                                                            <tr>
                                                                <td>
                                                                    <select name="status" id="status">
                                                                        <option value="Running" {{ $status == 'Running' ? 'selected' : '' }}>Running</option>
                                                                        <option value="Pending Order" {{ $status == 'Pending Order' ? 'selected' : '' }}>Pending Order</option>
                                                                        <option value="Pause" {{ $status == 'Pause' ? 'selected' : '' }}>Pause</option>
                                                                        <option value="Closed" {{ $status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <select name="customer" class="customer">
                                                                            @foreach ($customers as $item)
                                                                                <option value="{{ $item->CustomerName }}" {{ $customer_id == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->CustomerName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $customer }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <select name="part_number" class="part_number">
                                                                            @foreach ($parts as $item)
                                                                                <option value="{{ $item->Part_Number }}" {{ $part_number_id == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->Part_Number }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $part_number }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="number" name="quantity" class="quantity" value="{{ $in_stock_finish }}">
                                                                    @else
                                                                        {{ $in_stock_finish }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="text" name="job" class="job" value="{{ $job }}">
                                                                    @else
                                                                        {{ $job }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(Auth::user()->role == 1)
                                                                        <input type="text" name="lot" class="lot" value="{{ $lot }}">
                                                                    @else
                                                                        {{ $lot }}
                                                                    @endif
                                                                </td>
                                                                <td style="display: none" class="type">{{ $out_source }}</td>
                                                                <td style="display: none">{{ $id }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="btn-custom-btn text-center mt-3 mb-3">
                                            <button class="btn custom-btn submit-table-data-2" data-id="collapse{{ Str::slug($outSourceName) }}">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="btn-custom-btn text-ceneter mt-3 mb-3">
                        <a href="{{ route('visual_screen') }}" class="btn custom-btn" target="_blank">Visual Screen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>

        $(document).ready(function() {
            $('.submit-table-data').click(function() {
                // e.preventDefault();
                var dataId = $(this).data('id');
                console.log(dataId);

                let tableData = [];
                let target = $(this).data('id'); // Use `data-target` attribute directly
                if (dataId) {
                    let collapseId = dataId; // Assign directly if target is available
                    $('#'+collapseId+' tbody tr').each(function() {
                        console.log(123);
                        let row = $(this);
                        let entry = {
                            status: row.find('select[name="status"]').val(),
                            customer: row.find('select[name="customer"]').val(),
                            part_number: row.find('select[name="part_number"]').val(),
                            quantity: row.find('.quantity').val(),
                            job: row.find('.job').val(),
                            lot: row.find('.lot').val(),
                            type: row.find('td:eq(6)').text().trim(),
                            type_id: row.find('td:eq(7)').text().trim()
                        };
                        tableData.push(entry);
                    });
                    // console.log(tableData);
                    // return tableData;

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
                                $('#'+collapseId).collapse('hide');
                            } else {
                                // Handle failure case
                                console.error('fails');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    console.error('No target specified for collapse.');
                }
            });

            $('.submit-table-data-2').click(function() {
                // e.preventDefault();
                var dataId = $(this).data('id');
                console.log(dataId);

                let tableData = [];
                if (dataId) {
                    let collapseId = dataId; // Assign directly if target is available
                    $('#'+collapseId+' tbody tr').each(function() {
                        let row = $(this);
                        let entry = {
                            status: row.find('select[name="status"]').val(),
                            customer: row.find('select[name="customer"]').val(),
                            part_number: row.find('select[name="part_number"]').val(),
                            quantity: row.find('.quantity').val(),
                            job: row.find('.job').val(),
                            lot: row.find('.lot').val(),
                            type: row.find('td:eq(6)').text().trim(),
                            type_id: row.find('td:eq(7)').text().trim()
                        };
                        tableData.push(entry);
                    });
                    // console.log(tableData);
                    // return tableData;

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
                                $('#'+collapseId).collapse('hide');
                            } else {
                                // Handle failure case
                                console.error('fails');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    console.error('No target specified for collapse.');
                }
            });
        });


        // $(document).ready(function() {
        //     $('.submit-table-data-1-one').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseOne tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseOne').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-1-two').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseTwo tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseTwo').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-1-three').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseThree tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data') }}",
        //             method: "POST",
        //             data: {
        //                 entries: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseThree').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });


        //     $('.submit-table-data-2-one').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseFour tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseFour').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-2-two').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseFifth tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseFifth').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });

        //     $('.submit-table-data-2-three').on('click', function(e) {
        //         e.preventDefault();

        //         let tableData = [];
        //         $('#collapseSix tbody tr').each(function() {
        //             let row = $(this);
        //             let entry = {
        //                 status: row.find('select[name="status"]').val(),
        //                 customer: row.find('td:eq(1)').text().trim(),
        //                 part_number: row.find('td:eq(2)').text().trim(),
        //                 quantity: row.find('td:eq(3)').text().trim(),
        //                 job: row.find('td:eq(4)').text().trim(),
        //                 lot: row.find('td:eq(5)').text().trim(),
        //                 type: row.find('td:eq(6)').text().trim(),
        //                 type_id: row.find('td:eq(7)').text().trim()
        //             };
        //             tableData.push(entry);
        //         });

        //         $.ajax({
        //             url: "{{ route('save_table_data_2') }}",
        //             method: "POST",
        //             data: {
        //                 entries_data: tableData
        //             },
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $('#collapseSix').collapse('hide');
        //                 } else {
        //                     // Handle failure case
        //                     console.error('fails');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error(xhr.responseText);

        //             }
        //         });
        //     });
        // });
    </script>
@endsection
