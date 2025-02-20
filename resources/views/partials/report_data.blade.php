<div class="row align-items-center">
    <div class="col-lg-12">
        <div class="parent-table">
            <div class="accordion" id="accordionExample">
                @forelse ($activity_by_user as $user_id => $notifications)
                    @php
                        $user = $notifications->first()->user;
                        $isFirst = $loop->first;
                    @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $user_id }}">
                            <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $user_id }}" aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $user_id }}">
                                <strong>{{ $user ? $user->name : 'Unknown User' }}</strong>
                            </button>
                        </h2>
                        <div id="collapse{{ $user_id }}" class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                            aria-labelledby="heading{{ $user_id }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Info</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>{{ $notification->info }}</td>
                                                <td>{{ \Carbon\Carbon::parse($notification->created_at)->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No records found for the selected date range.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
