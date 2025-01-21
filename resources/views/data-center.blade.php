@extends('layouts.main')

@section('css')
    <style>
        .select2-selection__arrow {
            background-image: unset !important;
        }

        .side_btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .side_btn .custom-btn {
            margin: unset;
        }

        .weekly-section.data-center .parent-table {
            padding-right: 0;
            height: unset;
        }

        .parent-table table input,
        .parent-table table textarea {
            height: 22px;
        }

        .select2.select2-container .select2-selection {
            height: 25px;
            margin-bottom: 5px;
        }

        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 25px;
            font-size: 14px;
        }

        .weekly-section.data-center .parent-table tr td:nth-child(01) {
            line-height: 30px;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
            height: 22px;
        }
    </style>
@endsection


@section('content')
    <section class="weekly-section data-center">
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
                                Part Number Input
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="parent-table">
                        <form action="{{ route('post_data_center') }}" method="POST">
                            @csrf
                            <div class="btn-custom-btn text-center mb-3 side_btn">
                                <button type="submit" class="btn custom-btn">Submit</button>
                                <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                            </div>
                            <div class="parent-table parent-table-calender full-view-port mt-4">


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
                                                            {{ old('part_number') == $item->id ? 'selected' : '' }}>
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
                                                            {{ old('customer') == $item->id ? 'selected' : '' }}>
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
                                                            {{ old('department') == $dept->id ? 'selected' : '' }}>
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
                                        <tr>
                                            <td>Part Notes</td>
                                            <td>
                                                <textarea name="part_notes" id="">{{ old('part_notes') }}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
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
                                                            value="{{ old('outside_processing_text_' . $i) }}"
                                                            id="">
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
                                                            {{ old('customer') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->Package }}
                                                        </option>
                                                    @endforeach
                                                    {{-- <input type="text" name="material" value="{{ old('material') }}"
                                                    id=""> --}}
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                        <td>Pc Weight</td>
                                        <td>
                                            <input type="number" step="any" name="pc_weight"
                                                value="{{ old('pc_weight') }}" id="">
                                        </td>
                                    </tr> --}}
                                        {{-- <tr>
                                        <td>Safety Stock</td>
                                        <td>
                                            <input type="number" step="any" name="safety_stock"
                                                value="{{ old('safety_stock') }}" id="">
                                        </td>
                                    </tr> --}}
                                        <tr>
                                            <td>MOQ</td>
                                            <td>
                                                <input type="number" step="any" name="moq"
                                                    value="{{ old('moq') }}" id="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Order Notes</td>
                                            <td>
                                                <textarea name="order_notes" id="">{{ old('order_notes') }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Future Raw</td>
                                            <td>
                                                <input type="number" name="future_raw" value="{{ old('future_raw') }}"
                                                    id="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>
                                                {{--                                            <input type="number" step="any" name="price" value="{{ old('price') }}" --}}
                                                {{--                                                id=""> --}}

                                                <input type="text" step="any" name="price" id="price"
                                                    value="{{ old('price') }}" oninput="decimalPlacesFour(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>
                                                <select class="form-select js-select21" name="currency"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Select Currency</option>
                                                    <option value="USD"
                                                        {{ old('currency') == 'USD' ? 'selected' : '' }}>
                                                        USD
                                                    </option>
                                                    <option value="CDN"
                                                        {{ old('currency') == 'CDN' ? 'selected' : '' }}>
                                                        CDN
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                        <td>REV</td>
                                        <td>
                                            <input type="text" name="rev" id="rev"
                                                value="{{ old('rev') }}">
                                        </td>
                                    </tr> --}}
                                        {{-- <tr>
                                        <td>Wt Req'd</td>
                                        <td>
                                            <input type="number" step="any" name="wet_reqd" id="wet_reqd" value="{{ old('wet_reqd') }}">
                                        </td>
                                    </tr> --}}
                                        <tr>
                                            <td>Safety Stock</td>
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
                                                {{--                                            <input type="number" name="wt_pc" id="wt_pc" --}}
                                                {{--                                                value="{{ old('wt_pc') }}"> --}}
                                                <input type="text" step="any" name="wt_pc" id="wt_pc"
                                                    value="{{ old('wt_pc') }}" oninput="decimalPlaces(this)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function decimalPlaces(element) {
            let value = element.value;
            value = value.replace(/[^0-9.]/g, '');

            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1].slice(0, 3);
            } else if (parts.length === 2 && parts[1].length > 3) {
                value = parts[0] + '.' + parts[1].slice(0, 3);
            }

            element.value = value;
        }

        function decimalPlacesFour(element) {
            let value = element.value;
            value = value.replace(/[^0-9.]/g, ''); // Remove non-numeric and non-period characters

            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1].slice(0, 4); // Limit to 4 decimal places
            } else if (parts.length === 2 && parts[1].length > 4) {
                value = parts[0] + '.' + parts[1].slice(0, 4); // Limit to 4 decimal places
            }

            element.value = value;
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
