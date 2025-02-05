@foreach ($notifications as $notification)
    @php
        $role = $notification['user']['role'] ?? null;
        $user_img = $notification['user']['user_img'] ?? null;
        $name = $notification['user']['name'] ?? null;
        $notificationData = json_decode($notification->data, true);
        $message = $notificationData['message'] ?? 'No message available';
        $avatar =
            $role == 1
                ? asset('images/admin-image.jpg')
                : ($user_img
                    ? asset($user_img)
                    : asset('images/profile-pic.jpg'));
    @endphp

    @if ($notification->target_cell)
        @php
            $href = route('index') . '?target_cell=' . $notification->target_cell->id;
        @endphp
    @elseif ($notification->target_row)
        @php
            $href = route('index') . '?target_row=' . $notification->target_row->ref_id;
        @endphp
    @else
        @php
            $href = '';
        @endphp
    @endif
    <div class="notification_day_by_day">
        <p>{{ $notification->created_at }}</p>
    </div>
    <a class="notification border-x-0 border-bottom-0 border-300 rounded-0" href="{{ $href }}">
        <div class="notification_icons">
            <div class="activity-icon bg-success-soft text-success">
                <i class="fas fa-user-check"></i>
            </div>
            {{-- <div class="activity-icon bg-warning-soft text-warning">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="activity-icon bg-info-soft text-info">
                <i class="fas fa-cog"></i>
            </div> --}}
        </div>
        <div class="notification-avatar_icon">
            <div class="flex-notification">
                <div class="notification-avatar">
                    <div class="avatar avatar-xl me-3">
                        <div class="avatar-emoji rounded-circle">
                            <span role="img" aria-label="Emoji" class="profile-img-container">
                                <img src="{{ $avatar }}" alt="Profile Image" class="profile-img">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="notification-body">
                    <p class="mb-1">
                        <strong>{{ $name }}</strong>
                        {{ $message }}
                    </p>
                </div>
            </div>
            <div class="notification_show">
                <h5>User Login Successful</h5>
            </div>
        </div>
        <div class="notifiaction_time">
            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
        </div>
    </a>
@endforeach
