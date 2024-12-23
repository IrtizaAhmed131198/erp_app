@extends('layouts.main')

@section('css')
<style>
    .profile-img-container {
        display: inline-block;
        width: 50px;
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
        border: 2px solid #ff6600; /* Optional: specific border color for admin */
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
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-12">
                    <div class="parent-filter">
                        <select class="js-select2" id="userFilter">
                            <option value="all" selected="">All</option>
                            @foreach($users as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr class="mt-0 mb-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="bg-body-tertiary card-header highlighted">
                            <h5 class="mb-1 mb-md-0">Activity log</h5>
                        </div>
                        <div class="p-0 card-body" id="notificationContainer">
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
    $('#userFilter').on('change', function () {
        const userId = $(this).val();
        const container = $('#notificationContainer');

        $.ajax({
            url: "{{ route('notifications') }}",
            type: 'GET',
            data: { user_id: userId },
            success: function (response) {
                container.html(response.html); // Replace container content
            },
            error: function (xhr, status, error) {
                console.error('Error fetching notifications:', error);
                container.html('<p class="text-center p-3 text-danger">Failed to load notifications.</p>');
            }
        });
    });

</script>
@endsection
