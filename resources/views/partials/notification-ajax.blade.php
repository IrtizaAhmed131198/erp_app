@foreach($notifications as $notification)
    @php
        $role = $notification['user']['role'] ?? null;
        $user_img = $notification['user']['user_img'] ?? null;
        $name = $notification['user']['name'] ?? null;
        $notificationData = json_decode($notification->data, true);
        $message = $notificationData['message'] ?? 'No message available';
        $avatar = $role == 1 ? asset('images/admin-image.jpg') : ($user_img ? asset($user_img) : asset('images/profile-pic.jpg'));
    @endphp

    @if($notification->target_cell)
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
    <a class="notification border-x-0 border-bottom-0 border-300 rounded-0" href="{{$href}}">
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
            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
        </div>
    </a>
@endforeach
