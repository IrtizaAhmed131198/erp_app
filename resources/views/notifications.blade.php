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
</style>
@endsection

@section('content')
    <section class="weekly-section">
        <div class="container bg-colored">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="{{ route('add_user') }}">Profile</a>
                <a class="nav-link" href="{{ route('notifications') }}">Notifications</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="bg-body-tertiary card-header highlighted">
                            <h5 class="mb-1 mb-md-0">Activity log</h5>
                        </div>
                        <div class="p-0 card-body">
                            @foreach($notifications as $notification)
                                <a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                   href="#">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                            <div class="avatar-emoji rounded-circle">
                                                <!-- Here we are using a random emoji from the emoji helper function -->
                                                <span role="img" aria-label="Emoji" class="profile-img-container">
                                                    @if($notification->user->role == 1)
                                                        <img src="{{ asset('images/admin-image.jpg') }}" alt="Admin Profile" class="profile-img admin-img">
                                                    @else
                                                        @if($notification->user->user_img)
                                                            <img src="{{ asset($notification->user->user_img) }}" alt="User Profile" class="profile-img">
                                                        @else
                                                            <img src="{{ asset('images/profile-pic.jpg') }}" alt="Default Profile" class="profile-img">
                                                        @endif
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1">
                                            <strong>{{ $notification->user['name'] }}</strong>
                                            {{ json_decode($notification->data)->message }}
                                        </p>
                                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
