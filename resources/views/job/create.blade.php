@extends('layouts.layout')
@section('breadcame', 'Job')
@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('job.store') }}" id="jobForm" method="POST" enctype="multipart/form-data">
                        @csrf <!-- Add CSRF token for security -->

                        <div class="row">
                            <!-- Buyer Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="buyer_name" class="required">Buyer Name</label>
                                    <input type="text" id="buyer_name" name="buyer_name" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                            <!-- Invoice No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="invoice_no" class="required">Invoice No</label>
                                    <input type="text" id="invoice_no" name="invoice_no" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Value (USD) -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="value_usd" class="required">Value (USD)</label>
                                    <input type="text" id="value_usd" name="value_usd" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                            <!-- USD Rate (in BDT) -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="usd_rate" class="required">USD Rate (in BDT)</label>
                                    <input type="number" id="usd_rate" name="usd_rate" class="form-control mt-3" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Item -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="item" class="required">Item</label>
                                    <input type="text" id="item" name="item" class="form-control mt-3" required>
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
                                            <option value="{{ $terminal->uid }}">{{ $terminal->terminal_name }}</option>
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
                                            <option value="{{ $party->uid }}">{{ $party->party_name }}</option>
                                        @empty
                                            <option value="" disabled>No party found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_type" class="required">Job Type</label>
                                    <select id="job_type" name="job_type" class="form-control mt-3" required>
                                        <option value="">Select Job Type</option>
                                        <option value="export">Export</option>
                                        <option value="import">Import</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Sales Contact-->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="sales_contact" class="">Sales Contact</label>
                                    <input type="text" id="sales_contact" name="sales_contact" class="form-control mt-3">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <!-- Air Import Checkbox -->
                            <div class="col-md-6 d-none" id="air_import_container">
                                <div class="form-group mt-3">
                                    <input type="checkbox" id="air_import" name="air_import">
                                    <label for="air_import">Air Import/ctg import/beanpole/adamjee/DEPZ</label>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none" id="bl_numbers_container">
                            <!-- Master Air Way Bill / BL Number -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="master_bl_number">Master Air Way Bill / BL Number</label>
                                    <input type="text" id="master_bl_number" name="master_bl_number"
                                        class="form-control mt-3">
                                </div>
                            </div>

                            <!-- House Air Way Bill -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="house_bl_number">House Air Way Bill</label>
                                    <input type="text" id="house_bl_number" name="house_bl_number"
                                        class="form-control mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- L/C No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="lc_no" class="">L/C No</label>
                                    <input type="text" id="lc_no" name="lc_no" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- B/E No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="be_no" class="required">B/E No</label>
                                    <input type="text" id="be_no" name="be_no" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <!-- U/D No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="ud_no" class="">U/D No</label>
                                    <input type="text" id="ud_no" name="ud_no" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- U/D Amendment No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="ud_amendment_no" class="">U/D Amendment No</label>
                                    <input type="text" id="ud_amendment_no" name="ud_amendment_no"
                                        class="form-control mt-3">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <!-- Quantity -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="quantity" class="required">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                            <!-- CTNS Pieces -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="ctns_pieces" class="">CTNS Pieces</label>
                                    <input type="number" id="ctns_pieces" name="ctns_pieces" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- Weight -->
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="weight" class="">Weight</label>
                                    <input type="number" id="weight" name="weight" class="form-control mt-3">
                                </div>
                            </div>
                        </div>
                        @if (!Auth::guard('agent')->check())
                            <div class="row">
                                <!-- Truck Agent -->
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="agent_id" class="required"> Agent</label>
                                        <select id="agent_id" name="agent_id" class="form-control mt-3" required>
                                            <option value="">Select Agent</option>
                                            @forelse ($agents as $agent)
                                                <option value="{{ $agent->uid }}">{{ $agent->display_name }}</option>
                                            @empty
                                                <option value="">No agents found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="status" class="required">Status</label>
                                        <select id="status" name="status" class="form-control mt-3" required>
                                            <option value="initialized_by_agent">Initialized By Agent</option>
                                            <option value="processing" disabled>Processing</option>
                                            <option value="completed" disabled>Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Voucher Amount -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="voucher_amount" class="required">Voucher Amount</label>
                                    <input type="number" id="voucher_amount" name="voucher_amount"
                                        class="form-control mt-3" required style="-moz-appearance: textfield;">

                                </div>
                            </div>

                            <!-- Job No -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_no" class="required">Job No</label>
                                    <input type="number" id="job_no" name="job_no" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="submit" id="submit" class="btn btn-primary mt-4">
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

                // Validate form data
                // let isValid = true;
                // $(this).find(':input[required]').each(function() {
                //     if (!this.value.trim()) {
                //         isValid = false;
                //         const $this = $(this);
                //         $('html, body').animate({
                //             scrollTop: $this.offset().top - 100
                //         }, 500, function() {
                //             $this.focus().addClass('is-invalid');
                //             setTimeout(() => $this.removeClass('is-invalid'), 1000);
                //         });
                //         return false; // Break out of the loop
                //     }
                // });

                // if (!isValid) {
                //     // Hide loading spinner if validation fails
                //     $('#spinner').addClass('d-none');
                //     return;
                // }

                // Send the AJAX request
                $.ajax({
                    url: '{{ route('job.store') }}', // URL to submit the form data
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

            // get job tpeterminal_id
            $('#terminal_id').change(function() {
                let terminalId = $(this).val();
                let url = '{{ route('terminal.expense.getTerminalJobType', ':id') }}';
                url = url.replace(':id', terminalId); // Replace the placeholder with actual ID

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.data == 'import') {
                            $("#air_import_container").toggleClass("d-none", false);
                            $("#bl_numbers_container").toggleClass("d-none", true);
                            $("#air_import").prop("checked", false);
                        }
                        $('#job_type').val(response.data);
                    }
                });
            });
        });
    </script>
@endpush
