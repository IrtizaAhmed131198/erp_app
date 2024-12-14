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
            <form action="{{ route('signin') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header highlighted">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2 preview_image img-fluid"
                                    src="{{ asset('images/profile-1.png') }}" alt="">
                                <input id="user_profile_image_path" type="file" name="user_img" class="d-none"
                                    accept="image/*" required>
                                <!-- Custom file label and file name display -->
                                <label for="user_profile_image_path" class="file-label">Upload Image</label>
                                <span id="fileName" class="file-name">No file chosen</span>
                                <!-- Profile picture help block-->
                                {{-- <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div> --}}
                                <!-- Profile picture upload button-->
                                {{-- <button class="btn btn-primary" type="submit"></button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header highlighted">Account Details</div>
                            <div class="card-body">

                                <!-- Form Group (username)-->

                                <!-- Form Row-->
                                {{-- <div class="row gx-3 mb-3">
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
                                </div> --}}

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputFirstName">name</label>
                                        <input class="form-control" id="inputFirstName" type="text" name="name"
                                            placeholder="Enter your first name" value="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email" name="email"
                                            placeholder="Enter your email address" value="" required>
                                    </div>
                                    <!-- Form Group (last name)-->
                                    {{-- <div class="col-md-6">
                                        <label class="mb-1" for="inputLastName">Last name</label>
                                        <input class="form-control" id="inputLastName" type="text"
                                            placeholder="Enter your last name" value="">
                                    </div> --}}
                                </div>
                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputOrgName">Department</label>
                                        <select class="custom-select form-control" name="department" required>
                                            <option selected disabled>Select Department</option>
                                            <option value="EXTENSION"
                                                {{ old('department') == 'EXTENSION' || (isset($department) && $department == 'EXTENSION') ? 'selected' : '' }}>
                                                EXTENSION</option>
                                            <option value="MULTI SLIDE"
                                                {{ old('department') == 'MULTI SLIDE' || (isset($department) && $department == 'MULTI SLIDE') ? 'selected' : '' }}>
                                                MULTI SLIDE</option>
                                            <option value="PRESS DEPT"
                                                {{ old('department') == 'PRESS DEPT' || (isset($department) && $department == 'PRESS DEPT') ? 'selected' : '' }}>
                                                PRESS DEPT</option>
                                            <option value="PURCHASED"
                                                {{ old('department') == 'PURCHASED' || (isset($department) && $department == 'PURCHASED') ? 'selected' : '' }}>
                                                PURCHASED</option>
                                            <option value="SLIDES"
                                                {{ old('department') == 'SLIDES' || (isset($department) && $department == 'SLIDES') ? 'selected' : '' }}>
                                                SLIDES</option>
                                            <option value="STOCK"
                                                {{ old('department') == 'STOCK' || (isset($department) && $department == 'STOCK') ? 'selected' : '' }}>
                                                STOCK</option>
                                            <option value="TORSION"
                                                {{ old('department') == 'TORSION' || (isset($department) && $department == 'TORSION') ? 'selected' : '' }}>
                                                TORSION</option>
                                            <option value="WIREFORM"
                                                {{ old('department') == 'WIREFORM' || (isset($department) && $department == 'WIREFORM') ? 'selected' : '' }}>
                                                WIREFORM</option>
                                        </select>
                                    </div>
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputPhone">Phone number</label>
                                        <input class="form-control" id="inputPhone" type="tel" name="phone"
                                            placeholder="Enter your phone number" value="" required>
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="row gx-3 mb-3">

                                    <!-- Form Row-->
                                    <!-- Form Group (location)-->
                                    <div class="col-md-6">
                                        <label class="mb-1" for="inputpassword">Password</label>
                                        <input class="form-control" id="inputpassword" type="text" name="password"
                                            placeholder="Enter your password" value="" required>
                                    </div>
                                </div>
                                <!-- Save changes button-->

                                <!-- Form Row        -->
                                {{-- <div class="row gx-3 mb-3">
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
                                </div> --}}

                                <div class="card-body border-top px-9 py-9">
                                    <h5>
                                        User Permissions
                                    </h5>
                                    <!--begin::Option-->
                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" type="checkbox" name="status_column"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Status Coulmns</span>
                                            {{-- <span class="text-muted fs-6">Receive a notification for every successful
                                                payment.</span> --}}
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
                                        <input class="form-check-input me-3" type="checkbox" name="stock_finished_column" value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Stock Finished Column</span>
                                            {{-- <span class="text-muted fs-6">Receive a notification for every initiated
                                                payout.</span> --}}
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
                                        <input class="form-check-input me-3" type="checkbox" name="part_number_column"
                                            value="1">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Part Number Section</span>
                                            {{-- <span class="text-muted fs-6">Receive a notification each time you collect a
                                                fee
                                                from sales</span> --}}
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
                                        <input class="form-check-input me-3" type="checkbox"
                                            name="calendar_column" value="0">
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fs-6 mb-0">Calendar Section</span>
                                            {{-- <span class="text-muted fs-6">Receive a notification if a payment is disputed
                                                by
                                                a customer and for dispute purposes.</span> --}}
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->



                                </div>

                                <button class="btn btn-primary" type="submit">Save changes</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
