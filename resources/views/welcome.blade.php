@extends('layouts.main')



@section('content')
    <section class="master-data-section">
        <div class="container bg-colored">
            <div class="row align-items-base justify-content-end master-data-filter invoice-listing-select-bar">
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option selected disabled>DEPARTMENT</option>
                            <option value="COMPRESSION">COMPRESSION</option>
                            <option value="EXTENSION">EXTENSION</option>
                            <option value="MULTI SLIDE">MULTI SLIDE</option>
                            <option value="PRESS DEPT">PRESS DEPT</option>
                            <option value="PURCHASED">PURCHASED</option>
                            <option value="SLIDES">SLIDES</option>
                            <option value="STOCK">STOCK</option>
                            <option value="TORSION">TORSION</option>
                            <option value="WIREFORM">WIREFORM</option>
                        </select>
                        <!-- <div class="profile-details-save-btn">
                                    <button class="btn custom-btn blue">
                                        Filter
                                    </button>
                                </div> -->
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option selected="">All</option>
                            <option value="1">Filter Option 1</option>
                            <option value="2">Filter Option 2</option>
                            <option value="3">Filter Option 3</option>
                        </select>
                        <!-- <div class="profile-details-save-btn">
                                    <button class="btn custom-btn blue">
                                        Filter
                                    </button>
                                </div> -->
                    </div>
                </div>
            </div>


            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="colored-table-row">
                                    <th scope="col" class="highlighted toggle-header">
                                        <span class="icon">▼</span>
                                    </th>
                                    <th scope="col" class="toggleable toggle-header-department">DEPARTMENT <span
                                            class="icon">▼</span></th>
                                    <th scope="col" class="toggleable toggle-header-work-center">WORK CENTER </th>
                                    <th scope="col" class="toggleable toggle-header-planning">PLANNING (QUEUE) </th>
                                    <th scope="col" class="toggleable">STATUS</th>
                                    <th scope="col" class="toggleable">JOB #</th>
                                    <th scope="col" class="toggleable">LOT #</th>
                                    <th scope="col" class="toggleable">ID</th>
                                    <th scope="col" class="toggleable">PART NO.</th>
                                    <th scope="col" class="toggleable">CUSTOMER</th>
                                    <th scope="col" class="toggleable">REV</th>
                                    <th scope="col" class="toggleable">PROCESS</th>
                                    <th scope="col" class="highlighted toggle-header-1">
                                        <span class="icon">▼
                                        </span>
                                    </th>
                                    <th scope="col" class="toggleable-1">REQ 1-6 WEEKS</th>
                                    <th scope="col" class="toggleable-1">REQ 7-12 WEEKS</th>
                                    <th scope="col" class="toggleable-1">SCHED'L TOTAL</th>
                                    <th scope="col" class="toggleable-1">IN STOCK FINISHED</th>
                                    <th scope="col" class="toggleable-1"> LIVE INVENTORY F</th>
                                    <th scope="col" class="toggleable-1"> LIVE INVENTORY WIP</th>
                                    <th scope="col" class="toggleable-1"> IN PROCESS OUT SIDE</th>
                                    <th scope="col" class="toggleable-1"> ON ORDER RAW MAT'L</th>
                                    <th scope="col" class="toggleable-1"> IN STOCK LIVE</th>
                                    <th scope="col" class="toggleable-1"> WT/PC</th>
                                    <th scope="col" class="toggleable-1"> MATERIAL (SORT)</th>
                                    <th scope="col" class="toggleable-1"> Wt Req'd</th>
                                    <th scope="col" class="toggleable-1"> SAFTY</th>
                                    <th scope="col" class="toggleable-1"> Min Ship</th>
                                    <th scope="col" class="toggleable-1"> Order Notes</th>
                                    <th scope="col" class="toggleable-1"> Part Notes </th>
                                    <th scope="col" class="highlighted toggle-header-2">
                                        <span class="icon">▼
                                        </span>
                                    </th>
                                    <th scope="col" class="toggleable-2">PAST DUE</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">3-Jun</th>
                                    <th scope="col" class="toggleable-2">10-Jun</th>
                                    <th scope="col" class="toggleable-2">FUTURE RAW</th>
                                    <th scope="col" class="toggleable-2">PRICE</th>
                                    <th scope="col" class="toggleable-2">NOTES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $index => $data)
                                <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                                            <div class="parent-hightlighted">
                                                <span>Details</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="toggleable toggle-department">{{ $data->department }}</td>
                                    <td class="toggleable toggle-work-center">COM 1</td>
                                    <td class="toggleable toggle-planning">
                                        <input type="text" name="planning" id="planning" value="{{ $data->planning ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('planning', this.value)">
                                    </td>
                                    <td class="toggleable">
                                        <input type="text" name="status" id="status" value="{{ $data->status ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('status', this.value)">
                                    </td>
                                    <td class="toggleable">
                                        <input type="text" name="job" id="job" value="{{ $data->job ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('job', this.value)">
                                    </td>
                                    <td class="toggleable">
                                        <input type="text" name="lot" id="lot" value="{{ $data->lot ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('lot', this.value)">
                                    </td>
                                    <td class="toggleable"></td>
                                    <td class="toggleable">{{ $data->part_number }}</td>
                                    <td class="toggleable">{{ $data->customer }}</td>
                                    <td class="toggleable">A00</td>
                                    <td class="toggleable">C (Superior)</td>
                                    @if($loop->first)
                                        <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                                            <div class="parent-hightlighted">
                                                <span>INVENTORY</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">
                                        <input type="text" name="in_stock_finish" id="in_stock_finish" value="{{ $data->in_stock_finish ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('in_stock_finish', this.value)">
                                    </td>
                                    <td class="toggleable-1">
                                        <input type="text" name="in_process_outside" id="in_process_outside" value="{{ $data->in_process_outside ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('in_process_outside', this.value)">
                                    </td>
                                    <td class="toggleable-1">
                                        <input type="text" name="raw_mat" id="raw_mat" value="{{ $data->raw_mat ?? '' }}" data-id="{{ $data->id }}" onkeyup="sendAjaxRequest('raw_mat', this.value)">
                                    </td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">8.000</td>
                                    <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">25,000</td>
                                    <td class="toggleable-1">{{ $data->order_notes }}</td>
                                    <td class="toggleable-1">{{ $data->part_notes }}</td>
                                    @if($loop->first)
                                        <td rowspan="{{ count($entries) }}" class="vertical-text highlighted">
                                            <div class="parent-hightlighted">
                                                <span>CALENDER</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2">30,000</td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2">${{ $data->price }}</td>
                                    <td class="toggleable-2">{{ $data->notes }}</td>
                                </tr>
                                @endforeach


                                <?php

                                // for ($i = 1; $i <= 100; $i++) {
                                //     echo '
                                //                                                                                                 <tr>
                                //                                                                                                     <td class="toggleable toggle-department">COMPRESSION</td>
                                //                                                                                                     <td class="toggleable toggle-work-center">COM 1</td>
                                //                                                                                                     <td class="toggleable toggle-planning"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable"></td>
                                //                                                                                                     <td class="toggleable">DRESDEN - RG</td>
                                //                                                                                                     <td class="toggleable">1000460</td>
                                //                                                                                                     <td class="toggleable">A00</td>
                                //                                                                                                     <td class="toggleable">C (Superior)</td>
                                //                                                                                                     <!-- <td rowspan="1000" class="vertical-text highlighted"><span>INVENTORY</span> <span>INVENTORY</span> <span>INVENTORY</span></td> -->
                                //                                                                                                     <td class="toggleable-1">0</td>
                                //                                                                                                     <td class="toggleable-1">30,000 </td>
                                //                                                                                                     <td class="toggleable-1">30,000 </td>
                                //                                                                                                     <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable-1"></td>
                                //                                                                                                     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //                                                                                                     <td class="toggleable-1"></td>
                                //                                                                                                     <td class="toggleable-1">8.000</td>
                                //                                                                                                     <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                //                                                                                                     <td class="toggleable-1">0</td>
                                //                                                                                                     <td class="toggleable-1"></td>
                                //                                                                                                     <td class="toggleable-1">25,000</td>
                                //                                                                                                     <td class="toggleable-1"></td>
                                //                                                                                                     <td class="toggleable-1">SUPERIOR .025EACH - MIN $200, CERT $20</td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2">30,000</td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2"></td>
                                //                                                                                                     <td class="toggleable-2">$0.1404</td>
                                //                                                                                                     <td class="toggleable-2">SUPERIOR PLATINGS: .025EACH - MIN $200, CERT $20</td>
                                //                                                                                                 </tr>
                                //                                                                                                 ';
                                // } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
    function sendAjaxRequest(field, value) {
        // Prepare the data to send via AJAX
        var inputElement = event.target; // Use the event object to access the target
    var dataId = inputElement.getAttribute('data-id'); // Get the data-id attribute
    var data = {
        id: dataId,
        field: field,
        value: value
    };

        // Perform the AJAX request
        $.ajax({
            url: "{{ route('manual_imput') }}", // Replace with your actual endpoint
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
            },
            success: function(response) {
                console.log('Success:', response);
                // Handle the response
            },
            error: function(error) {
                console.error('Error:', error);
                // Handle any errors
            }
        });
    }

</script>
@endsection
