@extends('layouts.main')

@section('css')
    <style>
        .report_sec {
            padding: 50px 200px;
        }

        .control-table {
            overflow: hidden;
        }

        .report_sec #example_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .report_sec #example2_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .report_sec #example3_wrapper {
            background: white;
            border: 1px solid #0000005e;
            padding: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px 1px #00000045;
        }

        .control-table #example_wrapper {
            white-space: nowrap;
            overflow: auto;
        }

        .control-table #example2_wrapper {
            white-space: nowrap;
            overflow: auto;
        }

        .control-table #example3_wrapper {
            white-space: nowrap;
            overflow: auto;
        }
    </style>
@endsection


@section('content')
    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All">ALL DEPARTMENT</option>
                            <option value="All">RFM</option>
                            <option value="All">EXTENSION</option>
                            <option value="All">WIREFORM&lt;.200</option>
                            <option value="All"> WIREFORM&gt;.200</option>
                            <option value="All"> MULTI-SLIDE</option>
                            <option value="All"> PRESS</option>
                            <option value="All"> OUTSOURCED</option>
                            <option value="All"> TORSION</option>
                            <option value="All"> ASSEMBL</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PART NUMBER </th>
                                    <th>DATE <br> SEARCH</th>
                                    <th>IN STOCK</th>
                                    <th>PAST<br> Due</th>
                                    <th>Wk 1<br> 27-Jan</th>
                                    <th>Wk 2<br> 3-Feb </th>
                                    <th>Wk 3<br> 10-Feb </th>
                                    <th>Wk 4<br> 17-Feb </th>
                                    <th>Wk 5<br> 24-Feb</th>
                                    <th>Wk 6<br> 3-Mar </th>
                                    <th>Wk 7<br> 10-Mar</th>
                                    <th>Wk 8<br> 17-Mar </th>
                                    <th>Wk 9<br> 24-Mar</th>
                                    <th>Wk 10<br> 31-Mar </th>
                                    <th>Wk 11<br> 7-Apr</th>
                                    <th>Wk 12<br> 14-Apr </th>
                                    <th>Wk 13<br> 21-Apr</th>
                                    <th>Wk 14<br> 28-Apr </th>
                                    <th>Wk 15<br> 5-May </th>
                                    <th>Wk 16<br> 12-May</th>
                                    <th>Balance of <br> Schedule </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PART NUMBER </th>
                                    <th>DATE <br> SEARCH</th>
                                    <th>IN STOCK</th>
                                    <th>PAST<br> Due</th>
                                    <th>Wk 1<br> 27-Jan</th>
                                    <th>Wk 2<br> 3-Feb </th>
                                    <th>Wk 3<br> 10-Feb </th>
                                    <th>Wk 4<br> 17-Feb </th>
                                    <th>Wk 5<br> 24-Feb</th>
                                    <th>Wk 6<br> 3-Mar </th>
                                    <th>Wk 7<br> 10-Mar</th>
                                    <th>Wk 8<br> 17-Mar </th>
                                    <th>Wk 9<br> 24-Mar</th>
                                    <th>Wk 10<br> 31-Mar </th>
                                    <th>Wk 11<br> 7-Apr</th>
                                    <th>Wk 12<br> 14-Apr </th>
                                    <th>Wk 13<br> 21-Apr</th>
                                    <th>Wk 14<br> 28-Apr </th>
                                    <th>Wk 15<br> 5-May </th>
                                    <th>Wk 16<br> 12-May</th>
                                    <th>Balance of <br> Schedule </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All">ALL DEPARTMENT</option>
                            <option value="All">RFM</option>
                            <option value="All">EXTENSION</option>
                            <option value="All">WIREFORM&lt;.200</option>
                            <option value="All"> WIREFORM&gt;.200</option>
                            <option value="All"> MULTI-SLIDE</option>
                            <option value="All"> PRESS</option>
                            <option value="All"> OUTSOURCED</option>
                            <option value="All"> TORSION</option>
                            <option value="All"> ASSEMBL</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example2" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>WORK CENTER</th>
                                    <th>REV</th>
                                    <th>PROCESS </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <th>PLANNING QUEUE </th>
                                    <th>STATUS</th>
                                    <th>JOB</th>
                                    <th>WORK CENTER</th>
                                    <th>REV</th>
                                    <th>PROCESS </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="report_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option value="All"> Part Name</option>
                            <option value="All"> Customer</option>
                            <option value="All">Department</option>
                            <option value="All">Work Centre</option>
                            <option value="All"> Vendor</option>
                            <option value="All"> Material</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="control-table">
                        <table id="example3" class="table table-striped report-data-show">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>

                                </tr>
                                <tr>

                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')
    <script>
        new DataTable('#example');
        new DataTable('#example2');
        new DataTable('#example3');
    </script>
@endsection
