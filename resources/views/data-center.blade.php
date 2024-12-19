@extends('layouts.main')

@section('css')
    <style>
        .select2-selection__arrow {
            background-image: unset !important;
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
                            <table class="table table-hover table-bordered">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td scope="col" colspan="2"><strong>Part Number Input</strong></td>
                                        <!-- <td scope="col">

                                                                                                </td> -->
                                    </tr>
                                    <tr>
                                        <td>Part Number</td>
                                        <td>
                                            <select class="form-select js-select21" name="part_number"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Part Number</option>
                                                @foreach ($parts as $item)
                                                    <option value="{{ $item->Part_Number }}"
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
                                                    <option value="{{ $item->CustomerName }}"
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
                                    <tr>
                                        <td>ID</td>
                                        <td>
                                            <input type="text" name="ids" value="{{ old('ids') }}" id="">
                                        </td>
                                    </tr>
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
                                                <option value="COMPRESSION"
                                                    {{ old('department') == 'COMPRESSION' ? 'selected' : '' }}>COMPRESSION
                                                </option>
                                                <option value="EXTENSION"
                                                    {{ old('department') == 'EXTENSION' ? 'selected' : '' }}>EXTENSION
                                                </option>
                                                <option value="MULTI SLIDE"
                                                    {{ old('department') == 'MULTI SLIDE' ? 'selected' : '' }}>MULTI SLIDE
                                                </option>
                                                <option value="PRESS DEPT"
                                                    {{ old('department') == 'PRESS DEPT' ? 'selected' : '' }}>PRESS DEPT
                                                </option>
                                                <option value="PURCHASED"
                                                    {{ old('department') == 'PURCHASED' ? 'selected' : '' }}>PURCHASED
                                                </option>
                                                <option value="SLIDES"
                                                    {{ old('department') == 'SLIDES' ? 'selected' : '' }}>SLIDES</option>
                                                <option value="STOCK"
                                                    {{ old('department') == 'STOCK' ? 'selected' : '' }}>STOCK</option>
                                                <option value="TORSION"
                                                    {{ old('department') == 'TORSION' ? 'selected' : '' }}>TORSION</option>
                                                <option value="WIREFORM"
                                                    {{ old('department') == 'WIREFORM' ? 'selected' : '' }}>WIREFORM
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <tr>
                                            <td>Work Centre {{ $i }}</td>
                                            <td>
                                                <select class="form-select" name="work_centre_{{ $i }}"
                                                    aria-label="Default select example">
                                                    <option selected></option>
                                                    <option value="COM 1"
                                                        {{ old('work_centre_' . $i) == 'COM 1' ? 'selected' : '' }}>COM 1
                                                    </option>
                                                    <option value="COM 2"
                                                        {{ old('work_centre_' . $i) == 'COM 2' ? 'selected' : '' }}>COM 2
                                                    </option>
                                                    <option value="COM 3"
                                                        {{ old('work_centre_' . $i) == 'COM 3' ? 'selected' : '' }}>COM 3
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                    @for ($i = 1; $i <= 4; $i++)
                                        <tr>
                                            <td>Outside Processing {{ $i }}</td>
                                            <td>
                                                <div class="parent-inputs">
                                                    <select class="form-select"
                                                        name="outside_processing_{{ $i }}"
                                                        aria-label="Default select example">
                                                        <option selected></option>
                                                        <option value="OUT 1"
                                                            {{ old('outside_processing_' . $i) == 'OUT 1' ? 'selected' : '' }}>
                                                            OUT 1</option>
                                                        <option value="OUT 2"
                                                            {{ old('outside_processing_' . $i) == 'OUT 2' ? 'selected' : '' }}>
                                                            OUT 2</option>
                                                        <option value="OUT 3"
                                                            {{ old('outside_processing_' . $i) == 'OUT 3' ? 'selected' : '' }}>
                                                            OUT 3</option>
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
                                                    <option value="{{ $item->Package }}"
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
                                            <input type="text" name="rev" id="rev" value="{{ old('rev') }}">
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
                                            <input type="text" name="safety" id="safety" value="{{ old('safety') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Minship</td>
                                        <td>
                                            <input type="number" name="min_ship" id="min_ship" value="{{ old('min_ship') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>WT/PC</td>
                                        <td>
                                            <input type="number" name="wt_pc" id="wt_pc" value="{{ old('wt_pc') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="btn-custom-btn text-ceneter mt-5">
                                <button type="submit" class="btn custom-btn">Submit</button>
                            </div>
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
