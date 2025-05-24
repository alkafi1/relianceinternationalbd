@extends('layouts.layout')
@section('breadcame', 'Reliance International Terminal Expense Fields')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h2 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add Expense Fields</span>
                    </h2>
                    <div class="card-toolbar">
                        <a href="{{ route('terminal.expense.index') }}" class="btn btn-sm btn-light-primary">
                            <i class="fas fa-list"></i> Expense List
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('terminal.expense.store') }}" id="terminalExpenseForm" method="POST">
                        @csrf <!-- Add CSRF token for security -->

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="title" class="required">Expense Fields Title</label>
                                    <input type="text" id="title" name="title" class="form-control mt-3" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Terminal ID (Dropdown) -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="terminal_id" class="required">Terminal</label>
                                    <select id="terminal_id" name="terminal_id" class="form-control mt-3" required>
                                        <option value="">Select Terminal</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->uid }}">{{ $terminal->terminal_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Status -->
                            <!-- Job Type -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="job_type" class="required">Job Type</label>
                                    <select id="job_type" name="job_type" class="form-control mt-3" required>
                                        <option value="">Select Job Type</option>
                                        <option value="import">Import</option>
                                        <option value="export">Export</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Comission Rate -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="comission_rate">Commission Rate Rate</label>
                                    <input type="number" step="0.01" id="comission_rate" name="comission_rate"
                                        class="form-control mt-3">
                                </div>
                            </div>

                            <!-- Minimum Comission -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="minimum_comission">Minimum Commission Rate</label>
                                    <input type="number" id="minimum_comission" name="minimum_comission"
                                        class="form-control mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="status" class="required">Status</label>
                                    <select id="status" name="status" class="form-control mt-3" required>
                                        <option value="active">Active</option>
                                        <option value="deactive">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Job Job Expense Fieldss -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="job_expend_field" class="required">Job Expense Fields</label>
                                    <div id="job_expenditure_fields">
                                        <div class="row mb-3">
                                            <div class="col-md-5">
                                                <input type="text" name="job_expend_field[]" class="form-control"
                                                    placeholder="Job Expense Fields" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" name="amount[]" class="form-control"
                                                    placeholder="Amount" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-field">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add_field" class="btn btn-success mt-3">
                                        <i class="fas fa-plus"></i> Add Field
                                    </button>
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
            $('#terminalExpenseForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show loading spinner
                $('#spinner').removeClass('d-none');

                // Create a FormData object to handle file uploads
                const formData = new FormData(this);

                // Send the AJAX request
                $.ajax({
                    url: '{{ route('terminal.expense.store') }}', // URL to submit the form data
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');
                        if (response.success) {
                            $('#terminalExpenseForm')[0].reset();
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
                                toastr.error(errors[
                                    field]); // Display field-specific error messages
                            }
                        }
                    }
                });
            });

            $('#add_field').click(function() {
                const newField = `
                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" name="job_expend_field[]" class="form-control" placeholder="Job Expense Fields" required>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
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

            // get job tpeterminal_id
            $('#terminal_id').change(function() {
                let terminalId = $(this).val();
                let url = '{{ route('terminal.expense.getTerminalJobType', ':id') }}';
                url = url.replace(':id', terminalId); // Replace the placeholder with actual ID

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#job_type').val(response.data);
                    }
                });
            });

        });
    </script>
@endpush
