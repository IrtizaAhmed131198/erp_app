@extends('layouts.main')

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
                                                        onclick="deleted({{ $val->id }})">Delete</a>
                                                </form>
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
