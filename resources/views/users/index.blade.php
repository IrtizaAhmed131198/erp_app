@extends('layouts.main')

@section('pg-title', 'Users List')

@section('css')
    <style>
        .select2-selection__arrow {
            background-image: unset !important;
        }

        .vertical-text {
            writing-mode: unset;
        }

        .btn-all-user {
            text-align: right;
            padding: 0 0 10px 0;
        }
    </style>
@endsection


@section('content')
    <section class="users-data">
        <div class="container">
            <div class="row align-items-center mb-2">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-all-user">
                        <a class="btn btn-primary" href="{{ route('add_user') }}">Add Users</a>
                    </div>
                    <div class="all-user">
                        <table class="table table-hover table-bordered" id="myTable">
                            <thead>
                                <tr class="colored-table-row">
                                    <th class="highlighted toggle-header">ID</th>
                                    <th class="toggleable toggle-header-department">Name</th>
                                    <th class="toggleable toggle-header-work-center">Email </th>
                                    <th class="toggleable toggle-header-planning">Department </th>
                                    <th class="toggleable toggle-header-planning">Phone Number </th>
                                    <th class="toggleable toggle-header-planning">Action </th>
                                </tr>
                            </thead>
                            <tbody id="entries-table-body">

                                @foreach ($data as $val)
                                    <tr>
                                        <td class="vertical-text highlighted">{{ $val->id }}</td>
                                        <td class="toggleable toggle-department">{{ $val->name }}</td>
                                        <td class="toggleable toggle-work-center">{{ $val->email }}</td>
                                        <td class="toggleable toggle-work-center">{{ $val->department }}</td>
                                        <td class="toggleable toggle-work-center">{{ $val->phone }}</td>
                                        <td class="toggleable toggle-planning">
                                            <div class="d-inline">
                                                <a href="{{ route('users.edit', ['id' => $val->id]) }}"
                                                    class="btn btn-success">Edit</a>
                                                <form action="{{ route('users.destroy', $val->id) }}" method="POST"
                                                    class="d-inline" id="deleteID{{ $val->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="deleted({{ $val->id }})">Delete</button>
                                                </form>
                                                <a href="{{ route('report', ['userId' => $val->id]) }}"
                                                    class="btn btn-warning">Report</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection






@section('js')
    <script>
        function deleted(id) {
            Swal.fire({
                text: "Do you want to delete this user",
                icon: "warning",
                confirmButtonText: "Ok",
                showCancelButton: true,
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteID' + id).submit();
                }
            })
        }
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                title: 'Validation Errors!',
                html: `
                <ul style="text-align: left; margin-left: 40px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
