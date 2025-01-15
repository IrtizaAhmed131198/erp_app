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
                        <form action="{{ route('post_data_center_update', ['id' => $data->id]) }}" method="POST">
                            @csrf
                            <div class="btn-custom-btn text-center mb-3 side_btn">
                                <button type="submit" class="btn custom-btn">Submit</button>
                                <a href="{{ route('index') }}" class="btn custom-btn">Cancel</a>
                            </div>
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <table class="table table-hover table-bordered">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td scope="col" colspan="2"><strong>Part Number Input Edit</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Part Number</td>
                                        <td>
                                            <select class="form-select js-select21" name="part_number"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Part Number</option>
                                                @foreach ($parts as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $data->part_number == $item->id ? 'selected' : '' }}>
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
                                                        {{ $data->customer == $item->id ? 'selected' : '' }}>
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
                                            <input type="text" name="revision" value="{{ $data->revision }}"
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
                                            <input type="text" name="process" value="{{ $data->process }}"
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
                                                        {{ $data->department == $dept->id ? 'selected' : '' }}>
                                                        {{ $dept->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @php
                                        $work_center = $data->work_center->toArray();
                                        $work_center_select_map = collect($work_center_select)->keyBy('id')->toArray();
                                    @endphp

                                    @for ($i = 1; $i <= 7; $i++)
                                        @php
                                            $work_centre_id = 'work_centre_' . $i;
                                            $selected_value = null;
                                            $com_value = null;

                                            if (
                                                in_array($work_centre_id, array_column($work_center, 'work_centre_id'))
                                            ) {
                                                $selected_work_centre = collect($work_center)->firstWhere(
                                                    'work_centre_id',
                                                    $work_centre_id,
                                                );
                                                $selected_value =
                                                    $work_center_select_map[$selected_work_centre['com']] ?? null;
                                            }
                                        @endphp

                                        <tr>
                                            <td>Work Centre {{ $i }}</td>
                                            <td>
                                                <select class="js-select2 select2-hidden-accessible"
                                                    name="{{ $work_centre_id }}" aria-label="Default select example">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($work_center_select as $center)
                                                        <option value="{{ $center['id'] }}"
                                                            {{ $selected_value && $center['id'] == $selected_value['id'] ? 'selected' : '' }}>
                                                            {{ $center['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor




                                    @php
                                        $out_source = $data->out_source->toArray();
                                        $vendor_map = collect($vendor)->keyBy('id')->toArray();
                                    @endphp

                                    @for ($i = 1; $i <= 4; $i++)
                                        @php
                                            $outside_processing_id = 'outside_processing_' . $i;
                                            $selected_value = null;

                                            if (
                                                in_array(
                                                    $outside_processing_id,
                                                    array_column($out_source, 'outside_processing_id'),
                                                )
                                            ) {
                                                $selected_out_source = collect($out_source)->firstWhere(
                                                    'outside_processing_id',
                                                    $outside_processing_id,
                                                );
                                                $selected_value = $vendor_map[$selected_out_source['out']] ?? null;
                                            }
                                        @endphp

                                        <tr>
                                            <td>Outside Processing {{ $i }}</td>
                                            <td>
                                                <div class="parent-inputs">
                                                    <select class="js-select2 select2-hidden-accessible"
                                                        name="{{ $outside_processing_id }}"
                                                        aria-label="Default select example">
                                                        <option value="" selected>Select</option>
                                                        @foreach ($vendor as $v)
                                                            <option value="{{ $v->id }}"
                                                                {{ $selected_value && $v->id == $selected_value['id'] ? 'selected' : '' }}>
                                                                {{ $v->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text"
                                                        name="outside_processing_text_{{ $i }}"
                                                        value="{{ $selected_value ? $selected_out_source['in_process_outside'] : '' }}"
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
                                                        {{ $data->material == $item->id ? 'selected' : '' }}>
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
                                                value="{{ $data->pc_weight }}" id="">
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Safety Stock</td>
                                        <td>
                                            <input type="number" step="any" name="safety_stock"
                                                value="{{ $data->safety_stock }}" id="">
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>MOQ</td>
                                        <td>
                                            <input type="number" step="any" name="moq" value="{{ $data->moq }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Order Notes</td>
                                        <td>
                                            <textarea name="order_notes" id="">{{ $data->order_notes }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Part Notes</td>
                                        <td>
                                            <textarea name="part_notes" id="">{{ $data->part_notes }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Future Raw</td>
                                        <td>
                                            <input type="text" name="future_raw" value="{{ $data->future_raw }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>
                                            <input type="number" step="any" name="price" value="{{ $data->price }}"
                                                id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Currency</td>
                                        <td>
                                            <select class="form-select js-select21" name="currency"
                                                aria-label="Default select example">
                                                <option selected disabled>Select Currency</option>
                                                <option value="USD" {{ $data->currency == 'USD' ? 'selected' : '' }}>
                                                    USD
                                                </option>
                                                <option value="CDN" {{ $data->currency == 'CDN' ? 'selected' : '' }}>
                                                    CDN
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>REV</td>
                                        <td>
                                            <input type="text" name="rev" id="rev"
                                                value="{{ $data->rev }}">
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Wt Req'd</td>
                                        <td>
                                            <input type="number" step="any" name="wet_reqd" id="wet_reqd" value="{{ $data->wet_reqd }}">
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>Safety Stock</td>
                                        <td>
                                            <input type="text" name="safety" id="safety"
                                                value="{{ $data->safety }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Minship</td>
                                        <td>
                                            <input type="number" name="min_ship" id="min_ship"
                                                value="{{ $data->min_ship }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>WT/PC</td>
                                        <td>
                                            <input type="number" name="wt_pc" id="wt_pc"
                                                value="{{ $data->wt_pc }}">
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
