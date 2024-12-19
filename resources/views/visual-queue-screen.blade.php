@extends('layouts.main')

@section('content')
    <section class="visual-queue-screen">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table all-one-tables">
                        @foreach ($visuals as $status => $entries)
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
                                            <td>{{ $entry->part_number }}</td>
                                            <td>{{ $entry->quantity }}</td>
                                            <td>{{ $entry->job }}</td>
                                            <td>{{ $entry->lot }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
