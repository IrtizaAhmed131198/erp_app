@extends('layouts.main')

@section('css')
    <style>
        .profile-img-container {
            display: inline-block;
            width: 35px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .admin-img {
            border: 2px solid #ff6600;
            /* Optional: specific border color for admin */
        }

        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            list-style: none;
            display: flex;
            gap: 10px;
        }

        .pagination a {
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #f8f9fa;
        }

        .container.bg-colored {
            padding: 5rem;
            margin: auto;
            width: 75%;
        }

        .notification {
            margin: 8px;
            border-radius: 12px !important;
            box-shadow: 0 0 14px 1px #00000029 !important;
            gap: 20px;
        }

        .notification-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .notification-avatar_icon {
            display: flex;
            width: 83%;
            flex-direction: column-reverse;
        }

        .notification_icons i {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 10px 1px #00000040;
            border-radius: 5px;
            font-size: 16px;
        }

        .avatar.avatar-xl {
            margin-top: 8px;
        }

        .avatar.avatar-xl img {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flex-notification {
            display: flex;
            align-items: end;
        }

        .bg-success-soft {
            background-color: #d1e7dd;
        }

        .bg-warning-soft {
            background-color: #fff3cd;
        }

        .bg-info-soft {
            background-color: #cff4fc;
        }

        .filter_search {
            border: 2px solid rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 0;
            border-radius: 10px;
            width: 50%;
        }

        .filter_search .i_font {
            position: absolute;
            z-index: 0;
            left: 2px;
            top: 12px;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
        }

        .filter_search input {
            padding: 10px 30px;
        }

        .filter_btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px 10px;
        }

        .parent-filter {
            margin: 0;
        }

        .select2.select2-container .select2-selection {
            margin: 0;
        }

        .select2.select2-container .select2-selection .select2-selection__rendered {
            padding-right: 50px;
        }

        .notification_today {
            margin: 25px 8px;
        }

        .notification_today h2 {
            font-size: 30px;
            font-weight: 700;
            color: black;
        }
    </style>
@endsection

@section('content')
    <section class="weekly-section">
        <div class="container bg-colored">
            <div class="row align-items-base justify-content-between master-data-filter invoice-listing-select-bar">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                    <!-- Account page navigation-->
                    <nav class="nav nav-borders">
                        <a class="nav-link active ms-0" href="{{ route('add_user') }}">Profile</a>
                        <a class="nav-link" href="{{ route('notifications') }}">Notifications</a>
                    </nav>
                </div>
                {{-- <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="userFilter">
                            <option value="all" selected="">Select Users</option>
                            @foreach ($users as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
            </div>

            <hr class="mt-0 mb-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="bg-body-tertiary card-header highlighted">
                            <h5 class="mb-1 mb-md-0">Activity log</h5>
                        </div>
                        <div class="card-body" id="notificationContainer">
                            <div class="filter_btn">
                                <div class="filter_search">
                                    <form action="">
                                        <button class="i_font" type="submit">
                                            <i class="fas fa-search text-muted me-2"></i>
                                        </button>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="border-0 w-100" placeholder="Search activities...">
                                    </form>
                                </div>
                                <div class="filter_all_btn">
                                    <button class="btn btn-primary">All</button>
                                    <button class="btn btn-primary">User</button>
                                    <button class="btn btn-primary">System</button>
                                    <button class="btn btn-primary">Error</button>
                                </div>
                                <div class="parent-filter">
                                    <select class="js-select2" id="userFilter">
                                        <option value="all" selected="">Select Users</option>
                                        @foreach ($users as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @include('partials.notification-ajax', ['notifications' => $notifications])
                        </div>
                        <div class="pagination-container">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('#userFilter').on('change', function() {
            const userId = $(this).val();
            const container = $('#notificationContainer');

            $.ajax({
                url: "{{ route('notifications') }}",
                type: 'GET',
                data: {
                    user_id: userId
                },
                success: function(response) {
                    container.html(response.html); // Replace container content
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching notifications:', error);
                    container.html(
                        '<p class="text-center p-3 text-danger">Failed to load notifications.</p>');
                }
            });
        });
    </script>
@endsection
