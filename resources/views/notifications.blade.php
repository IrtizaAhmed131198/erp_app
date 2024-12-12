@extends('layouts.main')

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
                        <div class="p-0 card-body"><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">🔍</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Anthony Hopkins</strong> Followed <strong>Massachusetts
                                            Institute of Technology</strong></p><span class="notification-time">Just
                                        Now</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">📌</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Anthony Hopkins</strong> Save a <strong>Life Event</strong>
                                    </p>
                                    <span class="notification-time">Yesterday</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">🏷️</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Rowan Atkinson</strong> Tagged <strong>Anthony
                                            Hopkins</strong>
                                        in a live video</p><span class="notification-time">December 1, 8:00 PM</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">💬</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Robert Downey</strong> mention <strong>Anthony
                                            Hopkins</strong>
                                        in a comment</p><span class="notification-time">November 27, 12:00 AM</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">😂</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Anthony Hopkins</strong> reacted to a comment of <strong>Anna
                                            Karinina</strong></p><span class="notification-time">November 20, 8:00 Am</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">🎁</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Jennifer Kent</strong> Congratulated <strong>Anthony
                                            Hopkins</strong></p><span class="notification-time">November 13, 5:00 Am</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">🏷️</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>California Institute of Technology</strong> tagged
                                        <strong>Anthony Hopkins</strong> in a post.
                                    </p><span class="notification-time">November 8, 5:00 PM</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">📋️</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Anthony Hopkins</strong> joined <strong>Victory day cultural
                                            Program</strong> with <strong>Tony Stark</strong></p><span
                                        class="notification-time">November 01, 11:30 AM</span>
                                </div>
                            </a><a class="notification border-x-0 border-bottom-0 border-300 rounded-top-0"
                                href="/social/activity-log#!">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <div class="avatar-emoji rounded-circle "><span role="img"
                                                aria-label="Emoji">📅️</span></div>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1"><strong>Massachusetts Institute of Technology</strong> invited
                                        <strong>Anthony Hopkin</strong> to an event
                                    </p><span class="notification-time">October 28, 12:00 PM</span>
                                </div>
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
