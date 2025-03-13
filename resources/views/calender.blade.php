@extends('layouts.main')

@section('pg-title', 'Shipment & Production')

@section('css')
    <style>
        div#collapseTwo table {
            /* width: 30%; */
        }

        .remove-width input {
            width: auto !important;
        }

        .add-btn-close .custom-btn {
            display: inline-block;
            margin: 30px 10px 30px 0;
        }

        .add-production-table {
            width: 30% !important;
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

        .weekly-section .parent-table {
            padding-right: 20px;
            width: 21%;
        }

        .parent-table.parent-table-calender.full-view-port.mt-4 {
            width: 100%;
        }

        .weekly-section .parent-table tr th {
            font-size: 12px !important;
            padding: 2px 15px !important;
        }

        .weekly-section .parent-table tr td:first-child {
            font-size: 12px !important;
            padding: 2px 15px !important;
        }

        .parent-table table input,
        .parent-table table textarea {
            font-size: 12px !important;
        }

        .parent-table-calender.full-view-port td {
            padding: 2px 16px !important;
        }

        .weekly-section .parent-table {
            margin-top: 10px !important;
        }


        .select2.select2-container .select2-selection {
            margin: 0;
        }

        .custom-data button {
            font-size: 13px;
            padding: 3px 5px;
        }

        .custom-data {
            margin: 0 !important;
        }

        .custom-data {
            gap: 10px;
        }

        table.master-data-to-screen.table.table-hover.table-striped {
            width: unset;
        }

        div#lastUpdateOrder {
            /* height: 100%; */
        }

        .collaps-count-show {
            display: flex;
            width: 95%;
            gap: 10px;
            align-items: flex-start;
        }

        .parent-button {
            width: 31%;
        }
    </style>
@endsection

@section('content')
    <section class="weekly-section">
        <div class="container-fluid bg-colored">
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
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-start mb-3 custom-data">
                        <div class="parent-button">
                            <div class="parent-filter">
                                <select class="js-select2" id="partNumberSelect">
                                    <option selected disabled>Select Part Number</option>
                                    @foreach ($parts as $item)
                                        <option value="{{ $item->part->id }}"
                                            {{ request('part_number') == $item->part->Part_Number ? 'selected' : '' }}>
                                            {{ $item->part->Part_Number }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="part_no" id="part_no" value="">
                            </div>
                            <div class="d-flex justify-content-start mb-3 custom-data">
                                @if (Auth::user()->create_order == 1)
                                    <button class="btn btn-primary me-2" id="btn-create-order" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne" onclick="updateHeadingText(this)">
                                        Create/Update Order
                                    </button>
                                @endif

                                @if (Auth::user()->stock_finished_column == 1)
                                    <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                        onclick="updateHeadingText(this)">
                                        Add Production
                                    </button>
                                @endif

                                @if (Auth::user()->calendar_column == 1)
                                    <button class="btn btn-primary" id="btn-add-shipment" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree" onclick="updateHeadingText(this)">
                                        Add Shipment
                                    </button>
                                @endif
                            </div>
                        </div>
                        <!-- add production form -->
                        @include('partials.production_form')
                        <div class="first_collaps_show" style="display: none">
                            <div class="collaps-count-show">
                                <table class="master-data-to-screen table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">REV</th>
                                            <th scope="col">MOQ & SAFETY</th>
                                            <th scope="col">MIN SHIP</th>
                                            <th scope="col">PART NOTES</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                    </tbody>
                                </table>
                                <div class="alert alert-info" role="alert" id="lastUpdateOrder">
                                    Last updated information:
                                </div>
                            </div>
                        </div>
                        <div class="second_collaps_show" style="display: none">
                            <div class="collaps-count-show">
                                <table class="master-data-to-screen table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">REV</th>
                                            <th scope="col">MOQ & SAFETY</th>
                                            <th scope="col">MIN SHIP</th>
                                            <th scope="col">PART NOTES</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">

                                    </tbody>
                                </table>
                                <div class="alert alert-info" role="alert" id="lastUpdateProduction">
                                    Last updated information:
                                </div>
                            </div>
                        </div>
                        <div class="third_collaps_show" style="display: none">
                            <div class="collaps-count-show">
                                <table class="master-data-to-screen table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">REV</th>
                                            <th scope="col">MOQ & SAFETY</th>
                                            <th scope="col">MIN SHIP</th>
                                            <th scope="col">PART NOTES</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data">
                                    </tbody>
                                </table>
                                <div class="alert alert-info" role="alert" id="lastUpdateShipment">
                                    Last updated information:
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion" id="mainAccordion">
                        <!-- First Collapsible Content -->
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body px-0">

                                @php
                                    $datesArray = [];

                                    // Calculate the start date of the current week (Monday)
                                    $today = date('Y-m-d');
                                    $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                                    $mondayOfWeek =
                                        $dayOfWeek == 0
                                            ? date('Y-m-d', strtotime('-6 days', strtotime($today))) // If Sunday, go back 6 days
                                            : date(
                                                'Y-m-d',
                                                strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today)),
                                            ); // Else, go back to Monday

                                    // Calculate the start date of week 16
                                    $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

                                    // Calculate the end date of week 16
                                    $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

                                    // Calculate the start date of month 5 (the day after week 16 ends)
                                    $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));
                                @endphp



                                <div class="btn-custom-btn text-ceneter mt-5 side_btn">
                                    <button type="button" id="create-order" class="btn custom-btn">Submit</button>
                                    <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                                </div>
                                <div class="parent-table parent-table-calender full-view-port mt-4">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Weekly 1-18 weeks</th>
                                                <th scope="col">Existing Amount</th>
                                                <th scope="col">Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Past Due</td>
                                                <td>
                                                    <input type="text" name="show_past_due" id="show_past_due"
                                                        class="past_due_show" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" name="past_due" id="order_past_due"
                                                        class="">
                                                    <button type="button" id="change_past_due" style="display: none;"><i
                                                            class="fa-regular fa-pen-to-square"></i></button>
                                                </td>
                                            </tr>
                                            @for ($week = 1; $week <= 16; $week++)
                                                @php
                                                    $startOfWeek = date(
                                                        'Y-m-d',
                                                        strtotime(
                                                            '+' . ($week - 1) * 7 . ' days',
                                                            strtotime($mondayOfWeek),
                                                        ),
                                                    );
                                                    $endOfWeek = date(
                                                        'Y-m-d',
                                                        strtotime('+6 days', strtotime($startOfWeek)),
                                                    );
                                                    $datesArray["week_$week"] = $startOfWeek;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} ({{ $startOfWeek }} -
                                                                {{ $endOfWeek }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='shipment-input'
                                                            data-week='week_{{ $week }}'
                                                            name='shipment[week_{{ $week }}]'
                                                            id='week_{{ $week }}'
                                                            oninput="formatNumberWithCommas(this)" disabled readonly>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='shipment-input-two'
                                                            data-week-two='week_{{ $week }}'
                                                            name='shipment[week_two_{{ $week }}]'
                                                            id='week_two_{{ $week }}'
                                                            oninput="formatNumberWithCommas(this)">
                                                    </td>
                                                </tr>
                                            @endfor

                                        </tbody>
                                    </table>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Month 5-12</th>
                                                <th scope="col">Existing Amount</th>
                                                <th scope="col">Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @for ($month = 5; $month <= 12; $month++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Month {{ $month }} ({{ $month5StartDate }} -
                                                                {{ date('Y-m-d', strtotime('+30 days', strtotime($month5StartDate))) }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='shipment-input'
                                                            data-week='month_{{ $month }}'
                                                            name='shipment[month_{{ $month }}]'
                                                            id='month_{{ $month }}'
                                                            oninput="formatNumberWithCommas(this)" disabled readonly>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='shipment-input-two'
                                                            data-week-two='month_{{ $month }}'
                                                            name='shipment[month_two_{{ $month }}]'
                                                            id='month_two_{{ $month }}'
                                                            oninput="formatNumberWithCommas(this)">
                                                    </td>
                                                </tr>
                                                @php
                                                    $datesArray["month_$month"] = $month5StartDate;
                                                    $month5StartDate = date(
                                                        'Y-m-d',
                                                        strtotime('+31 days', strtotime($month5StartDate)),
                                                    );
                                                @endphp
                                            @endfor

                                            <tr>
                                                <td>
                                                    <div class='weekdays-parent'>
                                                        <span>Future Raw</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type='text' class='show_future_raw' disabled>
                                                </td>
                                                <td>
                                                    <input type="text" name="future_raw" class="future_raw"
                                                        oninput="formatNumberWithCommas(this)">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class='weekdays-parent'>
                                                        <span>Total</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="total_shipment" class="total_shipment"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input type='text' class='' disabled>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Second Collapsible Content -->
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <!-- add production form -->
                                <div class="parent-table" style="height: auto">
                                    <div class="btn-custom-btn add-btn-close text-ceneter">
                                        <button type="button" class="btn custom-btn submit-production">Submit</button>
                                        <button type="button" class="btn custom-btn"
                                            onclick="window.location.href='{{ route('calender') }}'">Cancel</button>
                                    </div>
                                    <table class="table table-hover remove-width add-production-table">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Existing Amount</th>
                                                <td> <input type="text" name="existing_amount" id="existing_amount"
                                                        readonly oninput="formatNumberWithCommas(this)"></td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Add Production</td>
                                                <td> <input type="text" name="add_production" id="add_production"
                                                        min="0" oninput="formatNumberWithCommasN(this)"></td>

                                            </tr>
                                            <tr>
                                                <td>New Total</td>

                                                <td><input type="text" name="new_total" id="new_total" readonly
                                                        oninput="formatNumberWithCommas(this)"></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <!-- Third Collapsible Content -->
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">


                                @php
                                    $datesArray1 = [];

                                    // Calculate the start date of the current week (Monday)
                                    $today = date('Y-m-d');
                                    $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                                    $mondayOfWeek =
                                        $dayOfWeek == 0
                                            ? date('Y-m-d', strtotime('-6 days', strtotime($today))) // If Sunday, go back 6 days
                                            : date(
                                                'Y-m-d',
                                                strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today)),
                                            ); // Else, go back to Monday

                                    // Calculate the start date of week 16
                                    $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

                                    // Calculate the end date of week 16
                                    $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

                                    // Calculate the start date of month 5 (the day after week 16 ends)
                                    $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));
                                @endphp

                                <!-- add production form -->
                                @include('partials.production_form')

                                <table class="table table-hover remove-width add-production-table">
                                    <thead>
                                        <tr class="">
                                            <th scope="col">Add Shipment Amount</th>
                                            <td>
                                                <div class="add-shipment-amount"><input type="number" name=""
                                                        id="" placeholder="Add Shipment Amount"></div>
                                            </td>

                                        </tr>
                                    </thead>
                                </table>
                                {{-- <div class="add-shipment-amount">
                                    <input type="number" name="" id=""
                                        placeholder="Add Shipment Amount">
                                    <button class="btn btn-primary">Add</button>
                                </div> --}}

                                <div class="btn-custom-btn text-ceneter mt-5 side_btn">
                                    <button type="button" id="add-shipment" class="btn custom-btn">Submit</button>
                                    <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                                </div>

                                <div class="parent-table parent-table-calender full-view-port mt-4">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Weekly 1-18 weeks</th>
                                                <th scope="col">Existing</th>
                                                {{-- <th scope="col">Change</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Past Due</td>
                                                {{-- <td id="past_due_val"></td> --}}
                                                <td>
                                                    <input type="text" name="past_due" class="past_due_val"
                                                        id="past_due" readonly>
                                                    <button type="button" id="change_past_due" style="display: none;"><i
                                                            class="fa-regular fa-pen-to-square" readonly></i></button>
                                                </td>
                                            </tr>

                                            @for ($week = 1; $week <= 16; $week++)
                                                @php
                                                    $startOfWeek = date(
                                                        'Y-m-d',
                                                        strtotime(
                                                            '+' . ($week - 1) * 7 . ' days',
                                                            strtotime($mondayOfWeek),
                                                        ),
                                                    );
                                                    $endOfWeek = date(
                                                        'Y-m-d',
                                                        strtotime('+6 days', strtotime($startOfWeek)),
                                                    );
                                                    $datesArray1["week_$week"] = $startOfWeek;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} ({{ $startOfWeek }} -
                                                                {{ $endOfWeek }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='edit_existing'
                                                            data-edit-week-change='week_{{ $week }}'
                                                            name='edit_existing[week_{{ $week }}]'
                                                            id='edit_week_{{ $week }}'
                                                            oninput="formatNumberWithCommas(this)" readonly>
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" class='change-amount'
                                                            data-week-change='week_{{ $week }}'
                                                            name="change_amount[week_{{ $week }}]"
                                                            id="change_week_{{ $week }}"
                                                            oninput="formatNumberWithCommas(this)" readonly>
                                                    </td>
                                                </tr>
                                            @endfor
                                            {{-- @dump($datesArray1); --}}


                                        </tbody>
                                    </table>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Month 5-12</th>
                                                <th scope="col">Existing</th>
                                                {{-- <th scope="col">Change</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($month = 5; $month <= 12; $month++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Month {{ $month }} ({{ $month5StartDate }} -
                                                                {{ date('Y-m-d', strtotime('+30 days', strtotime($month5StartDate))) }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='edit_existing'
                                                            data-edit-week-change='month_{{ $month }}'
                                                            name='edit_existing[month_{{ $month }}]'
                                                            id='edit_month_{{ $month }}'>
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="number" class='change-amount'
                                                            data-week-change='month_{{ $month }}'
                                                            name="change_amount[month_{{ $month }}]"
                                                            id="change_month_{{ $month }}">
                                                    </td>
                                                </tr>
                                                @php
                                                    $datesArray1["month_$month"] = $month5StartDate;
                                                    $month5StartDate = date(
                                                        'Y-m-d',
                                                        strtotime('+31 days', strtotime($month5StartDate)),
                                                    );
                                                @endphp
                                            @endfor
                                            {{-- <tr>
                                                <td>
                                                    <div class='weekdays-parent'>
                                                        <span>Total</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="total_shipment" class="total_shipment" readonly>
                                                </td>
                                                <td>
                                                    <input type='text' class='' disabled>
                                                </td>
                                            </tr> --}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (localStorage.getItem("collapseOpen") === "true") {
                let collapseElement = new bootstrap.Collapse(document.getElementById("collapseTwo"), {
                    show: true
                });
                localStorage.removeItem("collapseOpen"); // Remove flag after applying
            }
        });

        function updateHeadingText(button) {
            // Get the heading element
            const heading = document.querySelector('.heading-1');
            // Set the heading text to the button's text
            heading.textContent = button.textContent.trim();
        }

        function formatNumberWithCommas(element) {
            const value = element.value.replace(/[^0-9]/g, '');
            element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function formatNumberWithCommasN(element) {
            let value = element.value.replace(/[^0-9-]/g, ''); // Allow only numbers and a negative sign
            value = value.replace(/(?!^)-/g, ''); // Ensure only one negative sign at the start

            element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        $('#btn-add-shipment, #btn-create-order').on('click', function() {
            let partNumber = $('#part_no').val();
            $.ajax({
                url: "{{ route('get_weeks') }}", // Replace with your backend route
                method: 'POST',
                data: {
                    part_number: partNumber
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.data) {
                        let data = response.data;
                        let temp = @json($datesArray);
                        let temp1 = @json($datesArray);
                        let weeksData = {};

                        // Check if all values are null
                        if (Object.values(data).every(value => value === null)) {
                            console.log("Response contains only null values.");

                            // Set all related fields to null
                            for (let key in data) {
                                $(`#edit_${key}`).val(null).prop('readonly', true);
                                $(`#${key}`).val(null).prop('readonly', true);
                            }

                            $(`.show_future_raw`).val(response.future_raw);
                            $(`input[name='existing_amount']`).val(response.in_stock_finish);
                            $(`.total_shipment`).val('');

                            return false;
                        }

                        // Iterate through the response data object
                        for (let key in data) {
                            let value = data[key];
                            let formattedValue = value !== null ? new Intl.NumberFormat('en-US').format(
                                value) : null;

                            $(`#edit_${key}`).val(formattedValue).prop('readonly', true);
                            $(`#${key}`).val(formattedValue).prop('readonly', true);
                            weeksData[key] = value;
                            temp[key] = value;
                            temp[`${key}_date`] = temp1[key];
                        }

                        $(`.show_future_raw`).val(response.future_raw);
                        $(`input[name='existing_amount']`).val(response.in_stock_finish);

                        let future = parseFloat(response.future_raw) || 0;

                        $.ajax({
                            url: "{{ route('update_past_due') }}",
                            method: 'POST',
                            data: {
                                weeks: weeksData,
                                part_number: partNumber,
                                current_date: "{{ date('Y-m-d') }}",
                                dates_array: temp
                            },
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // alert(response.message);
                                let data = response.data;
                                $('.past_due_val').val(response.past_due_val);
                                $('.past_due_show').val(response.past_due_val);
                                // Iterate through the response data object
                                for (let key in data) {
                                    let value = data[key];

                                    let formattedValue = new Intl.NumberFormat('en-US')
                                        .format(value);

                                    $(`#edit_${key}`).val(formattedValue).prop('readonly',
                                        true);
                                    $(`#${key}`).val(formattedValue).prop('readonly', true);
                                }

                                let sum = Object.keys(data)
                                    .filter(key => !key.includes('_date') && key !==
                                        'past_due') // Exclude date keys and past_due
                                    .reduce((total, key) => total + Number(data[key]),
                                        0); // Sum the numeric values

                                console.log("Total Sum:", sum);
                                sum = isNaN(sum) ? 0 : sum;
                                let past_due_val = parseFloat(response.past_due_val) || 0;
                                $(`.total_shipment`).val(sum + future + past_due_val);
                            },
                            error: function(xhr) {
                                console.error("Error updating shipment: ", xhr
                                    .responseText);
                            }
                        });
                    } else {
                        console.error("No data found in the response");
                    }
                },
                error: function(xhr) {
                    console.error("Error updating shipment: ", xhr.responseText);
                }
            });
        });

        $(document).ready(function() {
            $('.btn[data-bs-toggle="collapse"]').prop('disabled', true);

            $('#partNumberSelect').on('change', function() {
                $('.table-data').html('');
                $('#order_past_due').val('');
                $('#change_past_due').hide();
                $('.shipment-input-two').val('');
                const selectedPartNumber = $(this).val(); // Get selected part number
                console.log("Selected Part Number: ", selectedPartNumber);

                $('#part_no').val(selectedPartNumber);
                $('#add_production').val(``);
                $('#new_total').val(``);

                $('.accordion-collapse').collapse('hide');

                // Check if a valid part number is selected
                if (selectedPartNumber) {

                    $.ajax({
                        url: "{{ route('get_part_no_detail') }}", // Replace with your route URL
                        method: 'GET',
                        data: {
                            part_number: selectedPartNumber
                        }, // Send part number as data
                        success: function(response) {
                            if (response.success) {
                                let existingAmount = parseFloat(response.existing_amount);

                                $('input[name="existing_amount"]').val(
                                    isNaN(existingAmount) ? '0' : existingAmount
                                    .toLocaleString()
                                );
                                $('.btn[data-bs-toggle="collapse"]').prop('disabled', false);
                                $('.table-data').append(`
                                    <tr>
                                        <td>${response.revision}</td>
                                        <td>${response.safety}</td>
                                        <td>${response.min_ship}</td>
                                        <td>${response.part_notes}</td>
                                    </tr>
                                `);
                                // $('.alert-info').text(`Last updated information: ${response.last_update_user} by ${response.last_update_date}`);
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Data Found',
                                    text: response.message ??
                                        'No entry found for the provided part number.',
                                });
                                $('.btn[data-bs-toggle="collapse"]').prop('disabled', true);
                            }
                        },
                        error: function(xhr) {
                            console.error("Error fetching data: ", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch the existing amount. Please try again.',
                            });
                        }
                    });

                    $.ajax({
                        url: "{{ url('create-shipment-order-not') }}/" +
                            selectedPartNumber, // Endpoint to handle data storage
                        method: 'GET',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.last_update_user != null && response
                                .last_update_date != null) {
                                $('#lastUpdateOrder').text(
                                    `Last updated information: ${response.last_update_user} by ${response.last_update_date}`
                                );
                            }
                        },
                        error: function(error) {
                            console.error('Error saving data:', error);
                        }
                    });

                    $.ajax({
                        url: "{{ url('update-production-total-not') }}/" +
                            selectedPartNumber, // Endpoint to handle data storage
                        method: 'GET',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.last_update_user != null && response
                                .last_update_date != null) {
                                $('#lastUpdateProduction').text(
                                    `Last updated information: ${response.last_update_user} by ${response.last_update_date}`
                                );
                            }
                        },
                        error: function(error) {
                            console.error('Error saving data:', error);
                        }
                    });

                    $.ajax({
                        url: "{{ url('add-shipment-not') }}/" +
                            selectedPartNumber, // Endpoint to handle data storage
                        method: 'GET',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.last_update_user != null && response
                                .last_update_date != null) {
                                $('#lastUpdateShipment').text(
                                    `Last updated information: ${response.last_update_user} by ${response.last_update_date}`
                                );
                            }
                        },
                        error: function(error) {
                            console.error('Error saving data:', error);
                        }
                    });

                } else {
                    $('.btn[data-bs-toggle="collapse"]').prop('disabled', true);
                }
            });

            const urlParams = new URLSearchParams(window.location.search);
            const partNumberFromUrl = urlParams.get('part_number');
            if (partNumberFromUrl) {
                $('#partNumberSelect').val(partNumberFromUrl).trigger('change');
            }

            $('.submit-production').on('click', function() {
                let $button = $(this);
                $button.prop('disabled', true);

                const existingAmount = parseFloat($('#existing_amount').val().replace(/,/g, '')) || 0;
                const addProduction = parseFloat($('#add_production').val().replace(/,/g, '')) || 0;

                // Calculate new total
                const newTotal = existingAmount + addProduction;

                let part_no = $('#part_no').val();

                // Send data to server via AJAX
                $.ajax({
                    url: "{{ route('update_production_total') }}", // Replace with your backend route
                    method: 'POST',
                    data: {
                        existing_amount: existingAmount,
                        add_production: addProduction,
                        new_total: newTotal,
                        part_no: part_no,
                        _token: "{{ csrf_token() }}" // CSRF Token for security
                    },
                    success: function(response) {
                        $('#new_total').val(response.new_total);
                        Swal.fire({
                            icon: 'success',
                            title: 'Product Updated',
                            text: 'Product Updated Successfully',
                        });
                        // window.location.reload();
                    },
                    error: function(xhr) {
                        console.error("Error updating total: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'An error occurred while updating the total. Please try again.',
                        });
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            // $('#add_production').on('input', function() {
            //     const existingAmount = parseFloat($('#existing_amount').val()) || 0;
            //     const addProduction = parseFloat($(this).val()) || 0;

            //     // Calculate new total
            //     const newTotal = existingAmount + addProduction;

            //     let part_no = $('#part_no').val();

            //     // Send data to server via AJAX
            //     $.ajax({
            //         url: "{{ route('update_production_total') }}", // Replace with your backend route
            //         method: 'POST',
            //         data: {
            //             existing_amount: existingAmount,
            //             add_production: addProduction,
            //             new_total: newTotal,
            //             part_no: part_no,
            //             _token: "{{ csrf_token() }}" // CSRF Token for security
            //         },
            //         success: function(response) {
            //             $('#new_total').val(response.new_total);
            //         },
            //         error: function(xhr) {
            //             console.error("Error updating total: ", xhr.responseText);
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Update Failed',
            //                 text: 'An error occurred while updating the total. Please try again.',
            //             });
            //         }
            //     });
            // });

            $('#create-order').on('click', function() {
                let $button = $(this);
                $button.prop('disabled', true);

                let weeksData = {};
                let weeksDataEdit = {};

                // $('.shipment-input').each(function() {
                //     const weekKey = $(this).data('week');
                //     const weekValue = $(this).val();
                //     weeksData[`${weekKey}`] = weekValue;
                // });

                $('.shipment-input-two').each(function() {
                    const weekKey = $(this).data('week-two');
                    const weekValue = $(this).val();
                    weeksData[`${weekKey}`] = weekValue;
                });

                $('.shipment-input-two').each(function() {
                    const weekKeyEdit = $(this).data('week-two');
                    const weekValueEdit = $(this).val();
                    weeksDataEdit[`${weekKeyEdit}`] = weekValueEdit;
                });
                // return false;

                let partNumber = $('#part_no').val();

                let past_val = $('#order_past_due').val();

                let futureRaw = $('.future_raw').val() ?? 0;

                let allEmpty = Object.values(weeksData).every(value => value == '');

                // if (allEmpty) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Shipment Order',
                //         text: "Please fill in at least one week's data before submitting.",
                //     });
                //     $button.prop('disabled', false);
                //     return false;
                // }

                // Optionally, send updated data to the server via AJAX
                $.ajax({
                    url: "{{ route('create_order') }}", // Replace with your backend route
                    method: 'POST',
                    data: {
                        weeks: weeksData,
                        weeks_edit: weeksDataEdit,
                        part_number: partNumber,
                        future_raw: futureRaw,
                        past_val: past_val
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.error) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Order',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                text: response.message ?? 'Order Created.',
                            });
                            let data = response.data;
                            for (let key in data) {
                                let value = data[key];

                                let formattedValue = new Intl.NumberFormat('en-US').format(
                                    value);

                                $(`#edit_${key}`).val(formattedValue).prop('readonly', true);
                                $(`#${key}`).val(formattedValue).prop('readonly', true);
                                $(`.show_future_raw`).val(response.future_raw);
                            }
                            $(`.past_due_show`).val(response.past_due);

                            let sum = Object.keys(data)
                                .filter(key =>
                                    !key.includes('_date') &&
                                    key !== 'past_due' &&
                                    key !== 'id' &&
                                    key !== 'user_id' &&
                                    key !== 'part_number' &&
                                    key !== 'created_at' &&
                                    key !== 'updated_at'
                                ) // Exclude unwanted keys
                                .reduce((total, key) => total + Number(data[key] || 0),
                                    0); // Sum the numeric values

                            console.log("Total Sum:", sum);
                            let future = parseFloat(response.future_raw) || 0;
                            let past_due_val = parseFloat(response.past_due) || 0;
                            $(`.total_shipment`).val(sum + future + past_due_val);
                        }
                    },
                    error: function(xhr) {
                        console.error("Error updating order: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Order Failed',
                            text: 'An error occurred while updating the order amount. Please try again.',
                        });
                    },
                    complete: function() {
                        $button.prop('disabled',
                            false); // Re-enable button after AJAX completes
                    }
                });
            });



            // $('#add-shipment').on('click', function() {
            //     let weeksData = {};

            //     $('.edit_existing').each(function() {
            //         const weekKey = $(this).data('edit-week-change');
            //         const weekValue = $(this).val();
            //         weeksData[`${weekKey}`] = weekValue;
            //     });

            //     let partNumber = $('#part_no').val();
            //     const allEmpty = Object.values(weeksData).every(value => value == '');

            //     if (allEmpty) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Shipment Order',
            //             text: "Please fill in at least one week's data before submitting.",
            //         });
            //         return false;
            //     }

            //     // Optionally, send updated data to the server via AJAX
            //     $.ajax({
            //         url: "{{ route('add_shipment') }}", // Replace with your backend route
            //         method: 'POST',
            //         data: {
            //             weeks: weeksData,
            //             part_number: partNumber
            //         },
            //         headers: {
            //             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(response) {
            //             if (response.error) {

            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Shipment Order',
            //                     text: response.message,
            //                 });

            //             } else {
            //                 Swal.fire({
            //                     icon: 'success',
            //                     title: 'Shipment Order Change',
            //                     text: response.message ?? 'Shipment Order Change.',
            //                 });

            //                 let data = response.data;
            //                 // Iterate through the response data object
            //                 for (let key in data) {
            //                     let value = data[key];

            //                     $(`#edit_${key}`).val(value);
            //                 }
            //             }
            //         },
            //         error: function(xhr) {
            //             console.error("Error updating shipment: ", xhr.responseText);
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Shipment Order Failed',
            //                 text: 'An error occurred while updating the shipment amount. Please try again.',
            //             });
            //         }
            //     });
            // });

            $(document).on('click', '#add-shipment', function() {
                let $button = $(this);
                $button.prop('disabled', true);

                let partNumber = $('#part_no').val();
                let shippedAmount = parseFloat($('.add-shipment-amount input').val());
                if (isNaN(shippedAmount) || shippedAmount <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Shipment Amount',
                        text: 'Please enter a valid shipment amount.',
                    });
                    $button.prop('disabled', false);
                    return;
                }

                // Collect values from input fields with names starting with 'edit_existing'
                let fieldsData = [];

                let pastDueField = $('#past_due');
                let pastDueValue = parseFloat(pastDueField.val()) || 0;

                fieldsData.push({
                    weekKey: 'past_due', // Unique key for the past_due field
                    value: pastDueValue
                });

                $("input[name^='edit_existing']").each(function() {
                    let $field = $(this);
                    let currentValue = parseFloat($field.val().replace(/,/g, '')) || 0;
                    let weekKey = $(this).data('edit-week-change');
                    fieldsData.push({
                        weekKey: weekKey,
                        value: currentValue
                    });
                });

                // Distribute shipped amount among the fields
                shippedAmount = distributeShipmentAmount(fieldsData, shippedAmount);
                console.log(fieldsData);

                // If any amount remains undistributed, alert the user
                if (shippedAmount > 0) {
                    console.log('Remaining shipment amount:', shippedAmount);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Shipment amount',
                        text: "Shipment is greater than outstanding orders. Do you want to proceed?",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to another route
                            localStorage.setItem("collapseOpen", "true");
                            window.location.href = "{{ route('calender') }}" + "?part_number=" +
                                encodeURIComponent(partNumber); // Change to your actual route
                        }
                        $button.prop('disabled', false);
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Shipment amount',
                        text: "Shipment amount distributed successfully.",
                    });

                    // Send data to server-side script for saving in database
                    $.ajax({
                        url: "{{ route('save_shipment_data') }}", // Endpoint to handle data storage
                        method: 'POST',
                        data: {
                            shipmentData: fieldsData,
                            part_number: partNumber,
                            shipped_amount: parseFloat($('.add-shipment-amount input').val())
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Data saved successfully:', response);
                            let data = response.data;
                            // Iterate through the response data object
                            $('#past_due').val(data['past_due']);
                            $('input[name="existing_amount"]').val(response.existing_amount);
                            for (let key in data) {
                                let value = data[key];
                                let formattedValue = new Intl.NumberFormat('en-US').format(
                                    value);

                                $(`#edit_${key}`).val(formattedValue);
                            }

                            // let sum = Object.keys(data)
                            //     .filter(key =>
                            //         !key.includes('_date') &&
                            //         key !== 'past_due' &&
                            //         key !== 'id' &&
                            //         key !== 'user_id' &&
                            //         key !== 'part_number' &&
                            //         key !== 'created_at' &&
                            //         key !== 'updated_at'
                            //     ) // Exclude unwanted keys
                            //     .reduce((total, key) => total + Number(data[key] || 0), 0); // Sum the numeric values

                            // console.log("Total Sum:", sum);
                            // let future = parseFloat(response.future_raw) || 0;
                            // let past_due_val = parseFloat(response.past_due) || 0;
                            // $(`.total_shipment`).val(sum + future + past_due_val);
                        },
                        error: function(error) {
                            console.error('Error saving data:', error);
                        },
                        complete: function() {
                            $button.prop('disabled', false);
                        }
                    });
                }
            });

            // Function to distribute shipment amount among fields
            function distributeShipmentAmount(fieldsData, shippedAmount) {
                fieldsData.forEach((field, index) => {
                    if (shippedAmount <= 0) return;

                    if (field.value > 0) {
                        if (field.value >= shippedAmount) {
                            field.value -=
                                shippedAmount; // Deduct shippedAmount from the current field's value
                            shippedAmount = 0; // Fully distributed
                        } else {
                            shippedAmount -= field.value; // Deduct the field's value from shippedAmount
                            field.value = 0; // Zero out the current field's value
                        }
                    }
                });
                return shippedAmount;
            }

            $('#order_past_due').on('keyup', function() {
                $('#change_past_due').show();
            });


            $('#change_past_due').on('click', function() {
                let $button = $(this);
                $button.prop('disabled', true);

                let value = $('#order_past_due').val();
                if (value == '' || value < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Past Due Change',
                        text: 'Please enter a valid past due value.',
                    });
                    $button.prop('disabled', false);
                    return;
                }
                let partNumber = $('#part_no').val();

                $.ajax({
                    url: "{{ route('change_past_due') }}", // Endpoint to handle data storage
                    method: 'POST',
                    data: {
                        past_due: value,
                        part_number: partNumber
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log('Data saved successfully:', response);
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Past Due Change',
                                text: response.message ?? 'Failed to change past due.',
                            });
                            return;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Past Due Changed',
                            text: response.message ?? 'Past Due Changed',
                        });
                        $('.past_due_val').val(response.past_due ?? '');
                        $('.past_due_show').val(response.past_due ?? '');

                    },
                    error: function(error) {
                        console.error('Error saving data:', error);
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            $(document).on('input', '.change-amount', function() {
                const $input = $(this);
                const weekOrMonthId = $input.data('week-change');
                const $button = $(`#change_${weekOrMonthId}_btn`);

                // If value is not empty, show the button; otherwise, hide it
                if ($input.val() !== '') {
                    if ($button.length === 0) {
                        // If button doesn't exist, create and append it
                        const buttonHtml =
                            `<button id="change_${weekOrMonthId}_btn" class="update-btn" data-week-month="${weekOrMonthId}"><i class="fa-regular fa-pen-to-square"></i></button>`;
                        $input.after(buttonHtml);
                    }
                } else {
                    // Remove button if input is empty
                    $button.remove();
                }
            });

            $(document).on('click', '.update-btn', function() {
                let partNumber = $('#part_no').val();
                const $button = $(this);
                const weekOrMonthId = $button.data('week-month');
                const $input = $(`[data-week-change="${weekOrMonthId}"]`);
                const value = $input.val();

                if (value) {
                    $.ajax({
                        url: "{{ route('update_week_or_month') }}", // Replace with your actual route
                        method: 'POST',
                        data: {
                            id: weekOrMonthId,
                            value: value,
                            part_number: partNumber
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            const $editInput = $(`[data-edit-week-change="${weekOrMonthId}"]`);
                            if ($editInput.length > 0) {
                                $editInput.val(value); // Set the value from the input
                            }
                            // alert('Value updated successfully');
                            $button.remove(); // Remove the button on success
                        },
                        error: function(error) {
                            console.error('Error updating value:', error);
                            alert('Failed to update value');
                        }
                    });
                }
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            if ($('#collapseOne')) {
                $('#collapseOne').on('shown.bs.collapse', function() {
                    $('.first_collaps_show').css('display', 'block');
                });

                $('#collapseOne').on('hidden.bs.collapse', function() {
                    $('.first_collaps_show').css('display', 'none');
                });
            }
            if ($('#collapseTwo')) {
                $('#collapseTwo').on('shown.bs.collapse', function() {
                    $('.second_collaps_show').css('display', 'block');
                });

                $('#collapseTwo').on('hidden.bs.collapse', function() {
                    $('.second_collaps_show').css('display', 'none');
                });
            }
            if ($('#collapseThree')) {
                $('#collapseThree').on('shown.bs.collapse', function() {
                    $('.third_collaps_show').css('display', 'block');
                });

                $('#collapseThree').on('hidden.bs.collapse', function() {
                    $('.third_collaps_show').css('display', 'none');
                });
            }
        });
    </script>
@endsection
