@extends('layouts.main')



@section('content')
    <section class="master-data-section">
        <div class="container bg-colored">
            <div class="row align-items-base justify-content-end master-data-filter invoice-listing-select-bar">
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="filter1">
                            <option value="All" selected>ALL DEPARTMENT</option>
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
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="filter2">
                            <option selected="">All</option>
                            <option value="pending_orders">Pending orders</option>
                            <option value="prd">Parets req PRD</option>
                        </select>
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
                                <tbody id="entries-table-body">
                                    @include('partials.entries', ['entries' => $entries])
                                </tbody>

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
        var inputElement = event.target;
        var dataId = inputElement.getAttribute('data-id');
        var data = {
            id: dataId,
            field: field,
            value: value
        };

        $.ajax({
            url: "{{ route('manual_imput') }}",
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Success:', response);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    $(document).ready(function () {
        // Handle filter changes
        $('#filter1, #filter2').on('change', function () {
            let department = $('#filter1').val();
            let status = $('#filter2').val();

            // Send AJAX request
            $.ajax({
                url: '{{ route("index") }}',
                type: 'GET',
                data: {
                    department: department,
                    status: status
                },
                success: function (response) {
                    // Replace table content with new data
                    $('#entries-table-body').html(response.html);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

</script>
@endsection
