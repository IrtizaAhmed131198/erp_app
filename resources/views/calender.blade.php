@extends('layouts.main')

@section('css')
<style>
    div#collapseTwo table {
        width: 30%;
    }
</style>
@endsection

@section('content')
    <section class="weekly-section">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="parent-filter">
                        <select class="js-select2" id="partNumberSelect">
                            <option selected disabled>Select Part Number</option>
                            @foreach ($parts as $item)
                                <option value="{{ $item->Part_Number }}"
                                    {{ old('part_number') == $item->Part_Number ? 'selected' : '' }}>
                                    {{ $item->Part_Number }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="part_no" id="part_no" value="">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex justify-content-start mb-3 custom-data">
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Create Order
                        </button>
                        <button class="btn btn-primary me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Add Production
                        </button>
                        <button class="btn btn-primary" id="btn-add-shipment" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Add Shipment
                        </button>
                    </div>

                    <div class="accordion" id="mainAccordion">
                        <!-- First Collapsible Content -->
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="parent-table">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Weekly 1-18 weeks</th>
                                                <th scope="col">Add amount of shipment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($week = 1; $week <= 16; $week++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='shipment-input' data-week='week_{{ $week }}' name='shipment[week_{{ $week }}]' id='week_{{ $week }}'>
                                                    </td>
                                                </tr>
                                            @endfor

                                            @for($month = 5; $month <= 12; $month++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Month {{ $month }} </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='shipment-input' data-week='month_{{ $month }}' name='shipment[month_{{ $month }}]' id='month_{{ $month }}'>
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
                                <div class="parent-table">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col">Existing Amount</th>
                                                <td> <input type="text" name="existing_amount" id="existing_amount" readonly></td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Add Production</td>
                                                <td> <input type="text" name="add_production" id="add_production" min="0"></td>

                                            </tr>
                                            <tr>
                                                <td>New Total</td>

                                                <td><input type="text" name="new_total" id="new_total" readonly></td>

                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Third Collapsible Content -->
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="parent-table">
                                    <div class="add-shipment-amount">
                                        <input type="number" name="" id="" placeholder="Add Shipment Amount">
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
                                                <td></td>
                                                <td>
                                                <input type="text" name="past_due" id="past_due">
                                                </td>
                                            </tr>
                                            {{-- @php
                                                $data = App\Models\Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
                                            @endphp --}}
                                            @php
                                            $datesArray = [];

                                            // Calculate the start date of week 16
                                            $today = '2024-12-22';
                                            $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                                            $mondayOfWeek = date('Y-m-d', strtotime('-'.$dayOfWeek.' days', strtotime($today)));
                                            $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

                                            // Calculate the end date of week 16
                                            $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

                                            // Calculate the start date of month 5 (the day after week 16 ends)
                                            $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));

                                            @endphp

                                            @for ($week = 1; $week <= 16; $week++)
                                                @php
                                                    $startOfWeek = date('Y-m-d', strtotime('+'.(($week - 1) * 7).' days', strtotime($mondayOfWeek)));
                                                    $endOfWeek = date('Y-m-d', strtotime('+6 days', strtotime($startOfWeek)));
                                                    $datesArray["week_$week"] = $startOfWeek;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} ({{ $startOfWeek }} - {{ $endOfWeek }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='edit_existing' name='edit_existing[week_{{ $week }}]' id='edit_week_{{ $week }}'>
                                                    </td>
                                                    <td>
                                                        <input type="number" class='change-amount' data-week-change='week_{{ $week }}' name="change_amount[week_{{ $week }}]" id="change_week_{{ $week }}">
                                                    </td>
                                                </tr>
                                            @endfor

                                            @for ($month = 5; $month <= 12; $month++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Month {{ $month }} ({{ $month5StartDate }} - {{ date('Y-m-d', strtotime('+30 days', strtotime($month5StartDate))) }})</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='edit_existing' name='edit_existing[month_{{ $month }}]' id='edit_month_{{ $month }}'>
                                                    </td>
                                                    <td>
                                                        <input type="number" class='change-amount' data-week-change='month_{{ $month }}' name="change_amount[month_{{ $month }}]" id="change_month_{{ $month }}">
                                                    </td>
                                                </tr>
                                                @php
                                                    $datesArray["month_$month"] = $month5StartDate;
                                                    $month5StartDate = date('Y-m-d', strtotime('+31 days', strtotime($month5StartDate)));
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
        $('#btn-add-shipment').on('click', function() {
            let partNumber = $('#part_no').val();
            $.ajax({
                url: "{{ route('get_weeks') }}", // Replace with your backend route
                method: 'POST',
                data: {
                    part_number: partNumber
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
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

                        $('#past_due').val(response.in_stock_finish);



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
                                current_date: '2024-12-22',
                                dates_array: temp
                            },
                            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                            success: function (response) {
                                console.log('Total Past Value:', response.totalPastValue);
                                alert(response.message);
                            },
                            error: function (xhr) {
                                console.error("Error updating shipment: ", xhr.responseText);
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
                        data: { part_number: selectedPartNumber }, // Send part number as data
                        success: function(response) {
                            if (response.existing_amount) {
                                $('input[name="existing_amount"]').val(response.existing_amount);
                                $('.btn[data-bs-toggle="collapse"]').prop('disabled', false);
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Data Found',
                                    text: response.message ?? 'No entry found for the provided part number.',
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

            $('#add_production').on('input', function() {
                const existingAmount = parseFloat($('#existing_amount').val()) || 0;
                const addProduction = parseFloat($(this).val()) || 0;

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
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        if(response.error){

                            Swal.fire({
                                icon: 'error',
                                title: 'Shipment Order',
                                text: response.message,
                            });

                        }else{
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
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        if(response.error){

                            Swal.fire({
                                icon: 'error',
                                title: 'Shipment Order',
                                text: response.message,
                            });

                        }else{
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

            $(document).on('click', '.add-shipment-amount .btn', function () {
                let shippedAmount = parseFloat($('.add-shipment-amount input').val()); // Get the shipment amount entered
                if (isNaN(shippedAmount) || shippedAmount <= 0) {
                    alert("Please enter a valid shipment amount.");
                    return;
                }

                // Select only the input fields with names starting with 'edit_existing'
                let fields = $("input[name^='edit_existing']");

                fields.each(function () {
                    if (shippedAmount <= 0) return false; // Stop iteration if shipment amount is distributed

                    let $field = $(this);
                    let currentValue = parseFloat($field.val()) || 0; // Get the current value of the field (default to 0)

                    if (currentValue > 0) {
                        if (currentValue >= shippedAmount) {
                            $field.val(currentValue - shippedAmount); // Deduct shippedAmount from current field
                            shippedAmount = 0; // Fully distributed
                        } else {
                            $field.val(0); // Zero out the current field
                            shippedAmount -= currentValue; // Deduct current field value from shippedAmount
                        }
                    }
                });

                // If any amount remains undistributed, alert the user
                if (shippedAmount > 0) {
                    alert("Remaining shipment amount: " + shippedAmount);
                } else {
                    alert("Shipment amount distributed successfully.");
                }
            });

            // function updatePastDue(week) {
            //     let changeAmount = $(`#change_${week}`).val();
            //     let pastDueField = $('#past_due'); // Past Due total input field
            //     let partNumber = $('#part_no').val();

            //     if (changeAmount > 0) {
            //         pastDueValue += parseInt(changeAmount);
            //         pastDueInput.value = pastDueValue;

            //         // Send AJAX request to update the past due in Laravel
            //         $.ajax({
            //             url: "{{ route('update_past_due') }}", // Replace with your backend route
            //             method: 'POST',
            //             data: {
            //                 week: week,
            //                 pastDue: pastDueValue,
            //                 part_number: partNumber
            //             },
            //             headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            //             success: function(response) {

            //                 if (response.success) {
            //                     alert(response.message);

            //                     // Update the Past Due field
            //                     pastDueField.val(response.past_due_total);
            //                 } else {
            //                     alert(response.message);
            //                 }

            //             },
            //             error: function(xhr) {
            //                 console.error("Error updating shipment: ", xhr.responseText);
            //             }
            //         });
            //     }
            // }

        });

        $(document).ready(function () {

        });

    </script>
@endsection
