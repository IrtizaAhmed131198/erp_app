@extends('layouts.main')

@section('content')
    <section class="weekly-section">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="parent-filter">
                        <select class="js-select2">
                            <option selected disabled>DEPARTMENT</option>
                            <option>COMPRESSION</option>
                            <option>EXTENSION</option>
                            <option>MULTI SLIDE</option>
                            <option>PRESS DEPT</option>
                            <option>PURCHASED</option>
                            <option>SLIDES</option>
                            <option>STOCK</option>
                            <option>TORSION</option>
                            <option>WIREFORM</option>
                        </select>
                        <!-- <div class="profile-details-save-btn">
                                <button class="btn custom-btn blue">
                                    Filter
                                </button>
                            </div> -->
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
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
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
                                <div class="parent-table">
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
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
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
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="weekdays-parent">
                                                        <span>Week 1 </span> <span>01-Oct-2024</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="" id=""></td>
                                                <td>
                                                    <input type="text" name="" id="">
                                                </td>
                                            </tr>


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
