@extends('layouts.layout')
@section('breadcame', 'Reliance International Job Edit')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('job.update', ['job' => $job->uid] ?? '') }}" id="jobForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf <!-- Add CSRF token for security -->
                        <div class="row">
                            <!-- Voucher Amount -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="voucher_amount" class="required">Voucher Amount</label>
                                    <input type="number" id="voucher_amount" name="voucher_amount"
                                        class="form-control mt-3" required style="-moz-appearance: textfield;"
                                        value="{{ $job->voucher_amount }}">

                                </div>
                            </div>

                            <!-- Job No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_no" class="required">Job No</label>
                                    <input type="text" id="job_no" name="job_no" class="form-control mt-3" required
                                        value="{{ $job->job_no }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Terminal -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="terminal_id" class="required">Terminal</label>
                                    <select id="terminal_id" name="terminal_id" class="form-control mt-3" required>
                                        <option value="">Select Terminal</option>
                                        @forelse ($terminals as $terminal)
                                            <option value="{{ $terminal->uid }}"
                                                {{ $job->terminal_id == $terminal->uid ? 'selected' : '' }}>
                                                {{ $terminal->terminal_name }}</option>
                                        @empty
                                            <option value="" disabled>No terminal found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <!-- Bill To -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="party_id" class="required">Bill to</label>
                                    <select id="party_id" name="party_id" class="form-control mt-3" required>
                                        <option value="">Select Bill To</option>
                                        @forelse ($parties as $party)
                                            <option value="{{ $party->uid }}"
                                                {{ $job->party_id == $party->uid ? 'selected' : '' }}>
                                                {{ $party->party_name }}</option>
                                        @empty
                                            <option value="" disabled>No party found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Buyer Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="buyer_name" class="required">Buyer Name</label>
                                    <input type="text" id="buyer_name" name="buyer_name" class="form-control mt-3"
                                        required value="{{ $job->buyer_name }}">
                                </div>
                            </div>

                            <!-- Invoice No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="invoice_no" class="required">Invoice No</label>
                                    <input type="text" id="invoice_no" name="invoice_no" class="form-control mt-3"
                                        required value="{{ $job->invoice_no }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Value (USD) -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="value_usd" class="required">Value (USD)</label>
                                    <input type="number" id="value_usd" name="value_usd" class="form-control mt-3" required
                                        value="{{ $job->value_usd }}">
                                </div>
                            </div>

                            <!-- USD Rate (in BDT) -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="usd_rate" class="required">USD Rate (in BDT)</label>
                                    <input type="number" id="usd_rate" name="usd_rate" class="form-control mt-3" required
                                        value="{{ $job->usd_rate }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Item -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="item" class="required">Item</label>
                                    <input type="text" id="item" name="item" class="form-control mt-3" required
                                        value="{{ $job->item }}">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <!-- L/C No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="lc_no" class="">L/C No</label>
                                    <input type="text" id="lc_no" name="lc_no" class="form-control mt-3"
                                        value="{{ $job->lc_no }}">
                                </div>
                            </div>

                            <!-- B/E No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="be_no" class="required">B/E No</label>
                                    <input type="text" id="be_no" name="be_no" class="form-control mt-3"
                                        required value="{{ $job->be_no }}">
                                </div>
                            </div>
                            <!-- Sales Contact-->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="sales_contact" class="">Sales Contact</label>
                                    <input type="text" id="sales_contact" name="sales_contact"
                                        class="form-control mt-3" value="{{ $job->sales_contact }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- U/D No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="ud_no" class="">U/D No</label>
                                    <input type="text" id="ud_no" name="ud_no" class="form-control mt-3"
                                        value="{{ $job->ud_no }}">
                                </div>
                            </div>

                            <!-- U/D Amendment No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="ud_amendment_no" class="">U/D Amendment No</label>
                                    <input type="text" id="ud_amendment_no" name="ud_amendment_no"
                                        class="form-control mt-3" value="{{ $job->ud_amendment_no }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Job Type -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_type" class="required">Job Type</label>
                                    <select id="job_type" name="job_type" class="form-control mt-3" required>
                                        <option value="">Select Job Type</option>
                                        <option value="export" {{ $job->job_type == 'export' ? 'selected' : '' }}>Export
                                        </option>
                                        <option value="import" {{ $job->job_type == 'import' ? 'selected' : '' }}>Import
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Air Import Checkbox -->
                            <div class="col-md-6 {{ $job->job_type == 'import' ? '' : 'd-none' }}"
                                id="air_import_container">
                                <div class="form-group mt-16">
                                    <input type="checkbox" id="air_import" name="air_import"
                                        {{ $job->job_type == 'import' ? 'checked' : '' }}>
                                    <label for="air_import">Air Import</label>
                                </div>
                            </div>
                        </div>

                        <div class="row {{ $job->job_type == 'import' ? '' : 'd-none' }}" id="bl_numbers_container">
                            <!-- Master Air Way Bill / BL Number -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="master_bl_number">Master Air Way Bill / BL Number</label>
                                    <input type="text" id="master_bl_number" name="master_bl_number"
                                        class="form-control mt-3" value="{{ $job->master_bl_number }}">
                                </div>
                            </div>

                            <!-- House Air Way Bill -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="house_bl_number">House Air Way Bill</label>
                                    <input type="text" id="house_bl_number" name="house_bl_number"
                                        class="form-control mt-3" value="{{ $job->house_bl_number }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Quantity -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="quantity" class="required">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control mt-3"
                                        required value="{{ $job->quantity }}">
                                </div>
                            </div>

                            <!-- CTNS Pieces -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="ctns_pieces" class="">CTNS Pieces</label>
                                    <input type="number" id="ctns_pieces" name="ctns_pieces" class="form-control mt-3"
                                        value="{{ $job->ctns_pieces }}">
                                </div>
                            </div>

                            <!-- Weight -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="weight" class="">Weight</label>
                                    <input type="number" id="weight" name="weight" class="form-control mt-3"
                                        value="{{ $job->weight }}">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="job_expend_field" class="required">Terminal Expense</label>
                                    <div id="job_expenditure_fields">
                                        @forelse ($terminalExpense as $expense)
                                            <div class="row mb-3">
                                                <div class="col-md-5">
                                                    <input type="text" name="job_expend_field[]" class="form-control"
                                                        value="{{ $expense->job_expend_field ?? '' }}"
                                                        placeholder="Expenditure Field" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="amount[]" class="form-control text-end"
                                                        value="{{ $expense->amount ?? '' }}" placeholder="Amount"
                                                        required>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-danger remove-field">Remove</button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row mb-3">
                                                <div class="col-md-5">
                                                    <input type="text" name="job_expend_field[]" class="form-control"
                                                        placeholder="Expenditure Field" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="amount[]" class="form-control"
                                                        placeholder="Amount" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-field"><i
                                                            class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <button type="button" id="add_field" class="btn btn-success mt-3">
                                        <i class="fas fa-plus"></i> Add Field
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4 shadow-sm">
                            <div class="card-body">
                                <div class="row summary-section">
                                    <div class="col-md-4 mt-5 text-end">
                                        <h6>AGENCY COMMISSION</h6>
                                    </div>
                                    @php

                                        $commission_by_rate =
                                            $job->value_usd *
                                                $job->usd_rate *
                                                $job->terminal->terminalExpense
                                                    ->where('job_type', $job->job_type)
                                                    ->first()->comission_rate ??
                                            0;
                                        $agency_commission = max(
                                            $commission_by_rate,
                                            $job->terminal->terminalExpense->where('job_type', $job->job_type)->first()
                                                ->minimum_comission,
                                        );
                                    @endphp
                                    <div class="col-md-6 mt-2 text-end">
                                        <input type="number" id="agency_commission" name="agency_commission"
                                            value="{{ $agency_commission ?? 0.0 }}" class="form-control  text-end" />
                                    </div>

                                    <div class="col-md-4 mt-5 text-end">
                                        <h6>TOTAL EXPENSES</h6>
                                    </div>
                                    <div class="col-md-6 mt-2 text-end">
                                        <input type="number" id="total_expenses" name="total_expenses"
                                            value="{{ $terminalExpense->sum('amount') ?? 0.0 }}"
                                            class="form-control  text-end" readonly />
                                    </div>

                                    <div class="col-md-4 mt-5 text-end">
                                        <h6>ADVANCED RECEIVED</h6>
                                    </div>
                                    <div class="col-md-6 mt-2 text-end">
                                        <input type="number" id="advanced_received" name="advanced_received"
                                            value="0.00" class="form-control  text-end" />
                                    </div>

                                    <div class="col-md-4 mt-5 text-end">
                                        <h6>DUE</h6>
                                    </div>
                                    <div class="col-md-6 mt-2 text-end">
                                        <input type="number" id="due" name="due" value="0.00"
                                            class="form-control  text-end" readonly />
                                    </div>

                                    <div class="col-md-4 mt-5 text-end">
                                        <h5 class="fw-bold">GRAND TOTAL</h5>
                                    </div>
                                    <div class="col-md-6 mt-2 text-end">
                                        <input type="number" id="grand_total" name="grand_total"
                                            value="{{ $job->terminal->terminalExpense->where('job_type', $job->job_type)->first()->minimum_comission +
                                                $job->terminal->terminalExpense->where('job_type', $job->job_type)->sum('amount') }}"
                                            class="form-control fw-bold text-end" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4 shadow-sm">
                            <h2>Comment</h2>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea name="comment" id="comment" name="comment" class="form-control" rows="5" placeholder="Comment">B/E NO: {{ $job->be_no }} DTD {{ $job->dtd_date ?? '' }} {{ $job->dtd_no }} LC NO: {{ $job->lc_no }} DTD {{ $job->dtd_date ?? '' }} </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Date -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_date" class="required">Date</label>
                                    <input type="date" id="job_date" name="job_date" class="form-control mt-3"
                                        required value="{{ old('job_date', date('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="status" class="required">Status</label>
                                    <select id="status" name="status" class="form-control mt-3" required>
                                        <option value="initialized_by_agent"
                                            {{ $job->status == 'initialized_by_agent' ? 'selected' : '' }}>Initialized By
                                            Agent</option>
                                        <option value="processing" {{ $job->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="completed" {{ $job->status == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="" id="submit" class="btn btn-primary mt-4">
                                        <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"
                                            role="status" aria-hidden="true"></span>
                                        <i class="fas fa-upload"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#jobForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show loading spinner
                $('#spinner').removeClass('d-none');

                // Create a FormData object to handle file uploads
                const formData = new FormData(this);

                // Send the AJAX request
                $.ajax({
                    url: '{{ route('job.update', ['job' => $job->uid]) }}', // URL to submit the form data
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');
                        if (response.success) {
                            $('#jobForm')[0].reset();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            for (var field in errors) {
                                const $this = $(`[name="${field}"]`);
                                $this.addClass('is-invalid');
                                toastr.error(errors[
                                    field]); // Display field-specific error messages
                            }
                            setTimeout(() => {
                                $("[name]").removeClass('is-invalid');
                            }, 50000);
                        }
                    }
                });
            });

            $("#job_type").change(function() {
                let isImport = $(this).val() === "import";
                $("#air_import_container").toggleClass("d-none", !isImport);
                $("#bl_numbers_container").toggleClass("d-none", true);
                $("#air_import").prop("checked", false);
            });

            $("#air_import").change(function() {
                $("#bl_numbers_container").toggleClass("d-none", !this.checked);
            });

            $('#add_field').click(function() {
                const newField = `
                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" name="job_expend_field[]" class="form-control" placeholder="Expenditure Field" required>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="amount[]" class="form-control text-end" placeholder="Amount" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-field">Remove</button>
                    </div>
                </div>
            `;
                $('#job_expenditure_fields').append(newField);
            });

            // Remove field
            $(document).on('click', '.remove-field', function() {
                $(this).closest('.row').remove();
            });


            function calculateGrandTotal() {
                let agencyCommission = parseFloat($('#agency_commission').val()) || 0;
                let totalExpenses = parseFloat($('#total_expenses').val()) || 0;
                let advancedReceived = parseFloat($('#advanced_received').val()) || 0;
                let due = parseFloat($('#due').val()) || 0;

                let grandTotal = (agencyCommission + totalExpenses);
                let dueAmount = grandTotal - advancedReceived;
                $('#grand_total').val(grandTotal.toFixed(2));
                $('#due').val(dueAmount.toFixed(2));
            }

            // Trigger calculation on input changes
            $('#agency_commission, #advanced_received, #total_expenses, #due').on('input', function() {
                calculateGrandTotal();
            });

            // Run on page load to set initial values
            calculateGrandTotal();

            $(document).on('input', 'input[name="amount[]"]', function() {
                calculateTotalExpense();
            });

            function calculateTotalExpense() {
                let total = 0;
                $('input[name="amount[]"]').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                let grandTotal = total + parseFloat($('#agency_commission').val()) || 0;
                let due = total + parseFloat($('#advanced_received').val()) || 0;
                $('#grand_total').val(grandTotal.toFixed(2));
                $('#due').val(grandTotal.toFixed(2));
                $('#total_expenses').val(total.toFixed(2));
            }

        });
    </script>
@endpush
