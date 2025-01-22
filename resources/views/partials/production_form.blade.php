<div class="parent-table" style="height: auto">
    {{-- <div class="btn-custom-btn add-btn-close text-ceneter">
        <button type="button" class="btn custom-btn submit-production">Submit</button>
        <button type="button" class="btn custom-btn"
            onclick="window.location.href='{{ route('calender') }}'">Cancel</button>
    </div> --}}
    <table class="table table-hover remove-width add-production-table">
        <thead>
            <tr class="">
                <th scope="col">Existing Amount</th>
                <td> <input type="text" name="existing_amount" id="existing_amount"
                        readonly oninput="formatNumberWithCommas(this)"></td>

            </tr>
        </thead>
        {{-- <tbody>
            <tr>
                <td>Add Production</td>
                <td> <input type="text" name="add_production" id="add_production"
                        min="0" oninput="formatNumberWithCommas(this)"></td>

            </tr>
            <tr>
                <td>New Total</td>

                <td><input type="text" name="new_total" id="new_total" readonly oninput="formatNumberWithCommas(this)"></td>

            </tr>
        </tbody> --}}
    </table>
</div>
