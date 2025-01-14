@extends('layouts.main')

@section('css')
    <style>
        .select2-selection__arrow {
            background-image: unset !important;
        }

        .side_btn {
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 20px;
        }

        .side_btn .custom-btn {
            margin: unset;
        }
    </style>
@endsection


@section('content')
    <section class="weekly-section data-center">
        <div class="container bg-colored">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <form action="{{ route('post_data_center') }}" method="POST">
                            @csrf
                            <div class="btn-custom-btn text-center mb-3 side_btn">
                                <button type="submit" class="btn custom-btn">Submit</button>
                                <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                            </div>
                            <table class="table table-hover table-bordered">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td scope="col" colspan="2"><strong>Part Number Input</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Part Number</td>
                                        <td>
                                            <select class="form-select js-select21" name="part_number"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Part Number</option>
                                                @foreach ($parts as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('part_number') == $item->Part_Number ? 'selected' : '' }}>
                                                        {{ $item->Part_Number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td>
                                            <select class="form-select js-select21" name="customer"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Customer</option>
                                                @foreach ($customer as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('customer') == $item->CustomerName ? 'selected' : '' }}>
                                                        {{ $item->CustomerName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="customer" value="{{ old('customer') }}"
                                                id=""> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Revision</td>
                                        <td>
                                            <input type="text" name="revision" value="{{ old('revision') }}"
                                                id="">
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>ID</td>
                                        <td>
                                            <input type="text" name="ids" value="{{ old('ids') }}" id="">
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>Process</td>
                                        <td>
                                            <input type="text" name="process" value="{{ old('process') }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>
                                            <select class="js-select2 select2-hidden-accessible" name="department"
                                                tabindex="-1" aria-hidden="true">
                                                <option selected disabled>Select DEPARTMENT</option>
                                                @foreach ($department as $dept)
                                                    <option value="{{ $dept->id }}"
                                                        {{ old('department') == $dept->name ? 'selected' : '' }}>
                                                        {{ $dept->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <tr>
                                            <td>Work Centre {{ $i }}</td>
                                            <td>
                                                <select class="js-select2 select2-hidden-accessible"
                                                    name="work_centre_{{ $i }}"
                                                    aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    @foreach ($work_center_select as $center)
                                                        <option value="{{ $center['id'] }}"
                                                            {{ old('work_centre_' . $i) == $center['id'] ? 'selected' : '' }}>
                                                            {{ $center['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                    @for ($i = 1; $i <= 4; $i++)
                                        <tr>
                                            <td>Outside Processing {{ $i }}</td>
                                            <td>
                                                <div class="parent-inputs">
                                                    <select class="js-select2 select2-hidden-accessible"
                                                        name="outside_processing_{{ $i }}"
                                                        aria-label="Default select example">
                                                        <option selected>Select</option>
                                                        @foreach ($vendor as $v)
                                                            <option value="{{ $v->id }}"
                                                                {{ old('outside_processing_' . $i) == $v->id ? 'selected' : '' }}>
                                                                {{ $v->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text"
                                                        name="outside_processing_text_{{ $i }}"
                                                        value="{{ old('outside_processing_text_' . $i) }}" id="">
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                    <tr>
                                        <td>Material</td>
                                        <td>
                                            <select class="form-select js-select21" name="material"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Material</option>
                                                @foreach ($material as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('customer') == $item->Package ? 'selected' : '' }}>
                                                        {{ $item->Package }}
                                                    </option>
                                                @endforeach
                                                {{-- <input type="text" name="material" value="{{ old('material') }}"
                                                    id=""> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pc Weight</td>
                                        <td>
                                            <input type="number" step="any" name="pc_weight"
                                                value="{{ old('pc_weight') }}" id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Safety Stock</td>
                                        <td>
                                            <input type="number" step="any" name="safety_stock"
                                                value="{{ old('safety_stock') }}" id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MOQ</td>
                                        <td>
                                            <input type="number" step="any" name="moq" value="{{ old('moq') }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Order Notes</td>
                                        <td>
                                            <textarea name="order_notes" id="">{{ old('order_notes') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Part Notes</td>
                                        <td>
                                            <textarea name="part_notes" id="">{{ old('part_notes') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Future Raw</td>
                                        <td>
                                            <input type="text" name="future_raw" value="{{ old('future_raw') }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>
                                            <input type="number" step="any" name="price" value="{{ old('price') }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>REV</td>
                                        <td>
                                            <input type="text" name="rev" id="rev"
                                                value="{{ old('rev') }}">
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Wt Req'd</td>
                                        <td>
                                            <input type="number" step="any" name="wet_reqd" id="wet_reqd" value="{{ old('wet_reqd') }}">
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>Safety</td>
                                        <td>
                                            <input type="text" name="safety" id="safety"
                                                value="{{ old('safety') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Minship</td>
                                        <td>
                                            <input type="number" name="min_ship" id="min_ship"
                                                value="{{ old('min_ship') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>WT/PC</td>
                                        <td>
                                            <input type="number" name="wt_pc" id="wt_pc"
                                                value="{{ old('wt_pc') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
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
