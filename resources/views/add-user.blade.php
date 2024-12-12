@extends('layouts.main')

@section('content')
    <section class="weekly-section">
        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="{{ route('add_user') }}">Profile</a>
                <a class="nav-link" href="{{ route('notifications') }}">Notifications</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header highlighted">Profile Picture</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('images/profile-1.png') }}"
                                alt="">
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->
                            <button class="btn btn-primary" type="button">Upload new image</button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header highlighted">Account Details</div>
                        <div class="card-body">
                            <form>
                                <!-- Form Group (username)-->

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputUsername">Username (how your name will appear to
                                            other users on the site)</label>
                                        <input class="form-control" id="inputUsername" type="text"
                                            placeholder="Enter your username" value="">
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputUID">User Id</label>
                                        <input class="form-control" id="inputUID" type="text" name="UID"
                                            placeholder="Enter your UID" value="">
                                    </div>
                                </div>

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputFirstName">First name</label>
                                        <input class="form-control" id="inputFirstName" type="text"
                                            placeholder="Enter your first name" value="">
                                    </div>
                                    <!-- Form Group (last name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputLastName">Last name</label>
                                        <input class="form-control" id="inputLastName" type="text"
                                            placeholder="Enter your last name" value="">
                                    </div>
                                </div>
                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputOrgName">Department</label>
                                        <select class="custom-select form-control">
                                            <option selected disabled>Select Department</option>
                                            <option value="1">EXTENSION</option>
                                            <option value="2">MULTI SLIDE</option>
                                            <option value="3">PRESS DEPT</option>
                                            <option value="3">PURCHASED</option>
                                            <option value="3">SLIDES</option>
                                            <option value="3">STOCK</option>
                                            <option value="3">TORSION</option>
                                            <option value="3">WIREFORM</option>
                                        </select>
                                    </div>
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputPhone">Phone number</label>
                                        <input class="form-control" id="inputPhone" type="tel"
                                            placeholder="Enter your phone number" value="">
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email"
                                            placeholder="Enter your email address" value="">
                                    </div>
                                    <!-- Form Row-->



                                    <!-- Form Group (location)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputpassword">Password</label>
                                        <input class="form-control" id="inputpassword" type="text"
                                            placeholder="Enter your password" value="">
                                    </div>
                                </div>
                                <!-- Save changes button-->

                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputOrgName">Roles</label>
                                        <select class="custom-select form-control">
                                            <option selected disabled>Select User Roles</option>
                                            <option value="1">Manager</option>
                                            <option value="2">Admin</option>
                                            <option value="3">Reporter</option>
                                        </select>
                                    </div>
                                    <!-- Form Group (phone number)-->
                                </div>

                                <div class="card-body border-top px-9 py-9">
                                    <h5>
                                        User Permissions
                                    </h5>
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Successful Payments</span>
                                            <span class="text-muted fs-6">Receive a notification for every successful
                                                payment.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            checked="checked" value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Payouts</span>
                                            <span class="text-muted fs-6">Receive a notification for every initiated
                                                payout.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Fee Collection</span>
                                            <span class="text-muted fs-6">Receive a notification each time you collect a
                                                fee
                                                from sales</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            checked="checked" value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Customer Payment Dispute</span>
                                            <span class="text-muted fs-6">Receive a notification if a payment is disputed
                                                by
                                                a customer and for dispute purposes.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Refund Alerts</span>
                                            <span class="text-muted fs-6">Receive a notification if a payment is stated as
                                                risk by the Finance Department.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            checked="checked" value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Invoice Payments</span>
                                            <span class="text-muted fs-6">Receive a notification if a customer sends an
                                                incorrect amount to pay their invoice.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <div class="separator separator-dashed my-6"></div>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Webhook API Endpoints</span>
                                            <span class="text-muted fs-6">Receive notifications for consistently failing
                                                webhook API endpoints.</span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                </div>

                                <button class="btn btn-primary" type="button">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
