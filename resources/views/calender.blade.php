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
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
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
                                                <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            {{-- @php
                                                $data = App\Models\Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
                                            @endphp --}}
                                            @for($week = 1; $week <= 16; $week++)
                                                <tr>
                                                    <td>
                                                        <div class='weekdays-parent'>
                                                            <span>Week {{ $week }} </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type='number' class='existing' data-week='week_{{ $week }}' name='existing[week_{{ $week }}]' id='week_{{ $week }}'>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="" id="">
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
                                                        <input type='number' class='change-amount' data-week='month_{{ $month }}' name='change_amount[month_{{ $month }}]' id='month_{{ $month }}'>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="" id="">
                                                    </td>
                                                </tr>
                                            @endfor


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
        });
    </script>
@endsection
