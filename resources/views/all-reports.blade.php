@extends('layouts.main')

@section('content')
    <section class="visual-queue-screen">
        <div class="container bg-colored">
            <div class="row align-items-center mb-5">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="parent-pagination">
                        <div class="pagination">
                            <a href="{{ route('index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0d6efd"
                                    class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z" />
                                </svg>
                                <span class="pagination-heading">
                                    Return To Master Data
                                </span>
                            </a>
                        </div>
                        <div class="title">
                            <h1 class="heading-1">
                                All Users Report
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="parent-filter mb-3">
                <input type="text" name="daterange" id="daterange" class="form-control" />
                <button id="filterBtn" class="btn btn-primary mt-2">Filter</button>
            </div>
            <div id="reportContainer">
                {{-- The collapsible data will be loaded here --}}
                @include('partials.report_data', ['activity_by_user' => $activity_by_user ?? collect()])
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
    $(function () {
        // Initialize daterangepicker
        $('#daterange').daterangepicker({
            locale: { format: 'YYYY-MM-DD' },
            startDate: moment(),
            endDate: moment()
        });
        // When the filter button is clicked, send an AJAX request.
        $('#filterBtn').on('click', function(e){
            e.preventDefault();

            // Get the daterange value
            let daterange = $('#daterange').val();

            // Send AJAX request to the route that returns the filtered view
            $.ajax({
                url: "{{ route('ajax_report') }}", // Define this route in your web.php
                method: 'GET',
                data: { daterange: daterange },
                beforeSend: function(){
                    // Optionally, show a loading indicator
                },
                success: function(response){
                    // Replace the content of reportContainer with the response data
                    $('#reportContainer').html(response);
                },
                error: function(){
                    alert('There was an error processing your request.');
                }
            });
        });
    });
</script>
@endsection
