@extends('layouts.main')

@section('pg-title', 'Visual Input Screen')

@section('content')
    <section class="visual-queue-screen">
        <div class="container-fluid bg-colored">
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
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table all-one-tables">
                        @foreach ($visuals as $status => $entries)
                            @if ($status != 'Neutral')
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="6">{{ strtoupper($status) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Work Centre</strong></td>
                                            <td><strong>Customer</strong></td>
                                            <td><strong>Part Number</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Job #</strong></td>
                                            <td><strong>LOT #</strong></td>
                                        </tr>
                                        @foreach ($entries as $entry)
                                            <tr>
                                                <td>{{ $entry->type }}</td>
                                                <td>{{ $entry->customer }}</td>
                                                <td>
                                                    {{-- @if ($status === 'Closed')
                                                        <a href="{{ route('get_qa', $entry->part->id) }}">{{ $entry->part->Part_Number }}</a>
                                                    @else --}}
                                                    {{ $entry->part->Part_Number ?? '' }}
                                                    {{-- @endif --}}
                                                </td>
                                                <td>{{ $entry->quantity }}</td>
                                                <td>{{ $entry->job }}</td>
                                                <td>{{ $entry->lot }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
