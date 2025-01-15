@extends('layouts.main')

@section('css')
    <style>
        div#collapseTwo table {
            width: 30%;
        }

        .remove-width input {
            width: auto !important;
        }

        .add-btn-close .custom-btn {
            display: inline-block;
            margin: 30px 10px 30px 0;
        }
    </style>
@endsection

@section('content')
    <section class="weekly-section">
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
                                Shipment & Production
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3">
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
                </div>
                <div class="col-lg-12">
                    <div class="d-flex justify-content-start mb-3 custom-data">
                        @if (Auth::user()->create_order == 1)
                            <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                                    onclick="updateHeadingText(this)">
                                Create Order
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
                            <button class="btn btn-primary" id="btn-add-shipment" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                                    onclick="updateHeadingText(this)">
                                Add Shipment
                            </button>
                        @endif
                    </div>

                    <div class="accordion" id="mainAccordion">
                        <!-- First Collapsible Content -->
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="alert alert-success" role="alert" id="lastUpdateOrder">
                                    Last updated information (date & user)
                                </div>
                                <div class="col-lg-12">
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
                                </div>
                                <div class="parent-table">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Weekly 1-18 weeks</th>
                                                <th scope="col">Add amount of shipment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($week = 1; $week <= 16; $week++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='shipment-input'
                                                            data-week='week_{{ $week }}'
                                                            name='shipment[week_{{ $week }}]'
                                                            id='week_{{ $week }}'>
                                                    </td>
                                                </tr>
                                            @endfor

                                            @for ($month = 5; $month <= 12; $month++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Month {{ $month }} </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='shipment-input'
                                                            data-week='month_{{ $month }}'
                                                            name='shipment[month_{{ $month }}]'
                                                            id='month_{{ $month }}'>
                                                    </td>
                                                </tr>
                                            @endfor

                                        </tbody>
                                    </table>
                                    <div class="btn-custom-btn text-ceneter mt-5">
                                        <button type="button" id="create-order" class="btn custom-btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Collapsible Content -->
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="alert alert-success" role="alert" id="lastUpdateProduction">
                                    Last updated information (date & user)
                                </div>
                                <div class="col-lg-12">
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
                                </div>
                                <div class="parent-table">
                                    <div class="btn-custom-btn add-btn-close text-ceneter">
                                        <button type="button" id="submit-production" class="btn custom-btn">Submit</button>
                                        <button type="button" class="btn custom-btn"
                                            onclick="window.location.href='{{ route('calender') }}'">Cancel</button>
                                    </div>
                                    <table class="table table-hover remove-width">
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
                                                        min="0" oninput="formatNumberWithCommas(this)"></td>

                                            </tr>
                                            <tr>
                                                <td>New Total</td>

                                                <td><input type="text" name="new_total" id="new_total" readonly oninput="formatNumberWithCommas(this)"></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Third Collapsible Content -->
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="alert alert-success" role="alert" id="lastUpdateShipment">
                                    Last updated information (date & user)
                                </div>
                                <div class="col-lg-12">
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
                                </div>
                                <div class="parent-table">
                                    <div class="add-shipment-amount">
                                        <input type="number" name="" id=""
                                            placeholder="Add Shipment Amount">
                                        <button class="btn btn-primary">Add</button>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Weekly 1-18 weeks</th>
                                                <th scope="col">Existing</th>
                                                <th scope="col">Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Past Due</td>
                                                <td id="past_due_val"></td>
                                                <td>
                                                    <input type="text" name="past_due" id="past_due">
                                                    <button type="button" id="change_past_due" style="display: none;"><i
                                                            class="fa-regular fa-pen-to-square"></i></button>
                                                </td>
                                            </tr>
                                            {{-- @php
                                                $data = App\Models\Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
                                            @endphp --}}
                                            @php
                                                $datesArray = [];

                                                // Calculate the start date of week 16
                                                $today = date('Y-m-d');
                                                $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                                                $mondayOfWeek = date(
                                                    'Y-m-d',
                                                    strtotime('-' . $dayOfWeek . ' days', strtotime($today)),
                                                );
                                                $week16StartDate = date(
                                                    'Y-m-d',
                                                    strtotime('+15 weeks', strtotime($mondayOfWeek)),
                                                );

                                                // Calculate the end date of week 16
                                                $week16EndDate = date(
                                                    'Y-m-d',
                                                    strtotime('+6 days', strtotime($week16StartDate)),
                                                );

                                                // Calculate the start date of month 5 (the day after week 16 ends)
                                                $month5StartDate = date(
                                                    'Y-m-d',
                                                    strtotime('+1 day', strtotime($week16EndDate)),
                                                );

                                            @endphp

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
                                                        <input type='number' class='edit_existing'
                                                            data-edit-week-change='week_{{ $week }}'
                                                            name='edit_existing[week_{{ $week }}]'
                                                            id='edit_week_{{ $week }}'>
                                                    </td>
                                                    <td>
                                                        <input type="number" class='change-amount'
                                                            data-week-change='week_{{ $week }}'
                                                            name="change_amount[week_{{ $week }}]"
                                                            id="change_week_{{ $week }}">
                                                    </td>
                                                </tr>
                                            @endfor

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
                                                    <td>
                                                        <input type="number" class='change-amount'
                                                            data-week-change='month_{{ $month }}'
                                                            name="change_amount[month_{{ $month }}]"
                                                            id="change_month_{{ $month }}">
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
                                            {{-- @dump($datesArray); --}}


                                        </tbody>
                                    </table>
                                    <div class="btn-custom-btn text-ceneter mt-5">
                                        <button type="button" id="add-shipment" class="btn custom-btn">Submit</button>
                                    </div>
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

        $('#btn-add-shipment').on('click', function() {
            console.log(123);
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
                        let weeksData = {};
                        let data = response.data;
                        let temp = @json($datesArray);
                        let temp1 = @json($datesArray);
                        // Iterate through the response data object
                        for (let key in data) {
                            let value = data[key];

                            $(`#edit_${key}`).val(value);
                            weeksData[`${key}`] = value;
                            temp[`${key}`] = value;
                            temp[`${key}_date`] = temp1[`${key}`];
                        }

                        // $('#past_due').val(response.in_stock_finish);



                        // $('.change-amount').each(function () {
                        //     const weekKey = $(this).data('week-change');
                        //     const weekValue = $(this).val();
                        //     console.log(weekKey, weekValue);
                        //     weeksData[`${weekKey}`] = weekValue;
                        // });

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
                                console.log('Total Past Value:', response.totalPastValue);
                                // alert(response.message);
                                let data = response.data;
                                $('#past_due_val').text(response.past_due_val);
                                // Iterate through the response data object
                                for (let key in data) {
                                    let value = data[key];

                                    $(`#edit_${key}`).val(value);
                                }
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
                const selectedPartNumber = $(this).val(); // Get selected part number
                console.log("Selected Part Number: ", selectedPartNumber);

                $('#part_no').val(selectedPartNumber);

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
                            if (response.existing_amount) {
                                $('input[name="existing_amount"]').val(
                                    parseFloat(response.existing_amount).toLocaleString()
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
                } else {
                    $('.btn[data-bs-toggle="collapse"]').prop('disabled', true);
                }
            });

            const urlParams = new URLSearchParams(window.location.search);
            const partNumberFromUrl = urlParams.get('part_number');
            if (partNumberFromUrl) {
                $('#partNumberSelect').val(partNumberFromUrl).trigger('change');
            }

            $('#submit-production').on('click', function() {
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
                    },
                    error: function(xhr) {
                        console.error("Error updating total: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'An error occurred while updating the total. Please try again.',
                        });
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
                let weeksData = {};

                $('.shipment-input').each(function() {
                    const weekKey = $(this).data('week');
                    const weekValue = $(this).val();
                    weeksData[`${weekKey}`] = weekValue;
                });

                let partNumber = $('#part_no').val();

                // Optionally, send updated data to the server via AJAX
                $.ajax({
                    url: "{{ route('create_order') }}", // Replace with your backend route
                    method: 'POST',
                    data: {
                        weeks: weeksData,
                        part_number: partNumber
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.error) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Shipment Order',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Shipment Order Created',
                                text: response.message ?? 'Shipment Order Created.',
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error updating shipment: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Shipment Order Failed',
                            text: 'An error occurred while updating the shipment amount. Please try again.',
                        });
                    }
                });
            });



            $('#add-shipment').on('click', function() {
                let weeksData = {};

                $('.change-amount').each(function() {
                    const weekKey = $(this).data('week-change');
                    const weekValue = $(this).val();
                    weeksData[`${weekKey}`] = weekValue;
                });

                let partNumber = $('#part_no').val();

                // Optionally, send updated data to the server via AJAX
                $.ajax({
                    url: "{{ route('add_shipment') }}", // Replace with your backend route
                    method: 'POST',
                    data: {
                        weeks: weeksData,
                        part_number: partNumber
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.error) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Shipment Order',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Shipment Order Change',
                                text: response.message ?? 'Shipment Order Change.',
                            });

                            let data = response.data;
                            // Iterate through the response data object
                            for (let key in data) {
                                let value = data[key];

                                $(`#edit_${key}`).val(value);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error("Error updating shipment: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Shipment Order Failed',
                            text: 'An error occurred while updating the shipment amount. Please try again.',
                        });
                    }
                });
            });

            $(document).on('click', '.add-shipment-amount .btn', function() {
                let partNumber = $('#part_no').val();
                let shippedAmount = parseFloat($('.add-shipment-amount input')
                    .val()); // Get the shipment amount entered
                if (isNaN(shippedAmount) || shippedAmount <= 0) {
                    alert("Please enter a valid shipment amount.");
                    return;
                }

                // Collect values from input fields with names starting with 'edit_existing'
                let fieldsData = [];
                $("input[name^='edit_existing']").each(function() {
                    let $field = $(this);
                    let currentValue = parseFloat($field.val()) ||
                        0; // Get the current value of the field (default to 0)
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
                    alert("Remaining shipment amount: " + shippedAmount);
                } else {
                    alert("Shipment amount distributed successfully.");

                    // Send data to server-side script for saving in database
                    $.ajax({
                        url: "{{ route('save_shipment_data') }}", // Endpoint to handle data storage
                        method: 'POST',
                        data: {
                            shipmentData: fieldsData,
                            part_number: partNumber
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Data saved successfully:', response);
                            let data = response.data;
                            // Iterate through the response data object
                            for (let key in data) {
                                let value = data[key];

                                $(`#edit_${key}`).val(value);
                            }
                        },
                        error: function(error) {
                            console.error('Error saving data:', error);
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

            $('#past_due').on('keyup', function() {
                $('#change_past_due').show();
            });


            $('#change_past_due').on('click', function() {
                let value = $('#past_due').val();
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
                        $('#past_due_val').text(response.past_due ?? '');
                    },
                    error: function(error) {
                        console.error('Error saving data:', error);
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
@endsection
