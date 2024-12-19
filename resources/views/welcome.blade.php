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
                            <option value="pending">Pending orders</option>
                            <option value="prd">Parets req PRD</option>
                        </select>
                    </div>
                </div>
            </div>

            @php
                $datesArray = [];

                // Calculate the start date of week 16
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
                $mondayOfWeek = date('Y-m-d', strtotime('-' . $dayOfWeek . ' days', strtotime($today)));
                $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

                // Calculate the end date of week 16
                $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

                // Calculate the start date of month 5 (the day after week 16 ends)
                $month5StartDate = date('j-M', strtotime('+1 day', strtotime($week16EndDate)));
            @endphp


            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="colored-table-row">
                                    <th scope="col" class="highlighted toggle-header">
                                        <span class="icon">▼</span>
                                    </th>
                                    <th scope="col" class="toggleable toggle-header-department ">DEPARTMENT <span
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
                                    @for ($week = 1; $week <= 16; $week++)
                                        <th scope="col" class="toggleable-2">
                                            {{ date('j-M', strtotime('+' . ($week - 1) * 7 . ' days', strtotime($mondayOfWeek))) }}
                                        </th>
                                    @endfor
                                    @for ($month = 5; $month <= 12; $month++)
                                        <th scope="col" class="toggleable-2">{{ $month5StartDate }}</th>
                                        @php
                                            $month5StartDate = date(
                                                'j-M',
                                                strtotime('+31 days', strtotime($month5StartDate)),
                                            );
                                        @endphp
                                    @endfor
                                    {{-- <th scope="col" class="toggleable-2">3-Jun</th>
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
                                    <th scope="col" class="toggleable-2">10-Jun</th> --}}
                                    <th scope="col" class="toggleable-2">FUTURE RAW</th>
                                    <th scope="col" class="toggleable-2">PRICE</th>
                                    <th scope="col" class="toggleable-2">NOTES</th>
                                </tr>
                            </thead>
                            <tbody id="entries-table-body">
                                @include('partials.entries', ['entries' => $entries])
                                {{-- <tr>
                                    <td rowspan="1000" class="vertical-text highlighted">
                                        <div class="parent-hightlighted"><span>Details</span> <span>Details</span>
                                            <span>Details</span> <span>Details</span> <span>Details</span>
                                            <span>Details</span>
                                        </div>
                                    </td>
                                    <td class="toggleable toggle-department">COMPRESSION</td>
                                    <td class="toggleable toggle-work-center">COM 1</td>
                                    <td class="toggleable toggle-planning"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"></td>
                                    <td class="toggleable">DRESDEN - RG</td>
                                    <td class="toggleable">1000460</td>
                                    <td class="toggleable">A00</td>
                                    <td class="toggleable">C (Superior)</td>
                                    <td rowspan="1000" class="vertical-text highlighted">
                                        <div class="parent-hightlighted"><span>INVENTORY</span> <span>INVENTORY</span>
                                            <span>INVENTORY</span> <span>INVENTORY</span> <span>INVENTORY</span>
                                            <span>INVENTORY</span>
                                        </div>
                                    </td>
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">8.000</td>
                                    <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">25,000</td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">SUPERIOR .025EACH - MIN $200, CERT $20</td>
                                    <td rowspan="1000" class="vertical-text highlighted">
                                        <div class="parent-hightlighted"><span>CALENDER</span> <span>CALENDER</span>
                                            <span>CALENDER</span> <span>CALENDER</span> <span>CALENDER</span>
                                            <span>CALENDER</span>
                                        </div>
                                    </td>
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
                                    <td class="toggleable-2">$0.1404</td>
                                    <td class="toggleable-2">SUPERIOR PLATINGS: .025EACH - MIN $200, CERT $20</td>
                                </tr> --}}
                                <?php

                                // for($i = 1; $i <= 100; $i++){
                                //     echo '
                                // <tr>
                                //     <td hidden></td>
                                //     <td class="toggleable toggle-department">COMPRESSION</td>
                                //     <td class="toggleable toggle-work-center">COM 1</td>
                                //     <td class="toggleable toggle-planning"><input type="text" name="" id=""></td>
                                //     <td class="toggleable"><input type="text" name="" id=""></td>
                                //     <td class="toggleable"><input type="text" name="" id=""></td>
                                //     <td class="toggleable"><input type="text" name="" id=""></td>
                                //     <td class="toggleable"></td>
                                //     <td class="toggleable">DRESDEN - RG</td>
                                //     <td class="toggleable">1000460</td>
                                //     <td class="toggleable">A00</td>
                                //     <td class="toggleable">C (Superior)</td>
                                //     <td hidden></td>
                                //     <!-- <td rowspan="1000" class="vertical-text highlighted"><span>INVENTORY</span> <span>INVENTORY</span> <span>INVENTORY</span></td> -->
                                //     <td class="toggleable-1">0</td>
                                //     <td class="toggleable-1">30,000 </td>
                                //     <td class="toggleable-1">30,000 </td>
                                //     <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                //     <td class="toggleable-1"></td>
                                //     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //     <td class="toggleable-1"><input type="text" name="" id=""></td>
                                //     <td class="toggleable-1"></td>
                                //     <td class="toggleable-1">8.000</td>
                                //     <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                //     <td class="toggleable-1">0</td>
                                //     <td class="toggleable-1"></td>
                                //     <td class="toggleable-1">25,000</td>
                                //     <td class="toggleable-1"></td>
                                //     <td class="toggleable-1">SUPERIOR .025EACH - MIN $200, CERT $20</td>
                                //     <td hidden></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2">30,000</td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2"></td>
                                //     <td class="toggleable-2">$0.1404</td>
                                //     <td class="toggleable-2">SUPERIOR PLATINGS: .025EACH - MIN $200, CERT $20</td>
                                // </tr>
                                // ';

                                // }
                                ?>
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
        // $(document).ready(function () {
        //     $('#myTable').DataTable({
        //         // Configuration options
        //         paging: false,         // Enable pagination
        //         searching: false,      // Enable searching
        //         ordering: true,       // Enable sorting
        //         order: [[0, 'asc']],  // Default sorting on the first column
        //         responsive: true,     // Make table responsive
        //         "aoColumnDefs": [
        //             { "bSortable": false, "aTargets": [ 0, 12, 29 ] },
        //         ]
        //     });

        // });
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

        $(document).ready(function() {
            // Handle filter changes
            $('#filter1, #filter2').on('change', function() {
                let department = $('#filter1').val();
                let filter = $('#filter2').val();

                // Send AJAX request
                $.ajax({
                    url: '{{ route('index') }}',
                    type: 'GET',
                    data: {
                        department: department,
                        filter: filter
                    },
                    success: function(response) {
                        // Replace table content with new data
                        $('#entries-table-body').html(response.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>



    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });
    </script>

    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-1").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable-1"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });
    </script>

    <script>
        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-2").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggleable-2"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("collapsible");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");
            });
        });

        // Add event listener to the column header
        document.querySelectorAll(".toggle-header-department").forEach(header => {
            header.addEventListener("click", function() {
                const columnClass = "toggle-department"; // Class of the cells in the column
                const icon = this.querySelector(".icon"); // Dropdown icon

                // Toggle the collapsible state of the column
                const cells = document.querySelectorAll(`.${columnClass}`);
                cells.forEach(cell => {
                    cell.classList.toggle("active-td");
                });

                // Toggle the icon's rotation
                icon.classList.toggle("collapsed");

                // Add or remove the 'active' class to the header
                this.classList.toggle("active");
            });
        });
    </script>
@endsection
