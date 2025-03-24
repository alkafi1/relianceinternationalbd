<form action="{{ route('terminal.expense.update', $terminalExpense->uid) }}" id="terminalExpenseEditForm" method="POST">
    @csrf <!-- Add CSRF token for security -->

    <div class="row">
        <!-- Title -->
        <div class="col-md-12">
            <div class="form-group mt-3">
                <label for="title" class="required">Expense Fields Title</label>
                <input type="text" id="title" name="title" class="form-control mt-3" required
                    value="{{ $terminalExpense->title }}">
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
                        <option value="{{ $terminal->uid }}"
                            {{ $terminalExpense->terminal_id == $terminal->uid ? 'selected' : '' }}>
                            {{ $terminal->terminal_name }}</option>
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
                    <option value="import" {{ $terminalExpense->job_type == 'import' ? 'selected' : '' }}>Import
                    </option>
                    <option value="export" {{ $terminalExpense->job_type == 'export' ? 'selected' : '' }}>Export
                    </option>
                    <option value="both" {{ $terminalExpense->job_type == 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Comission Rate -->
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="comission_rate">Commission Rate Rate</label>
                <input type="number" step="0.01" id="comission_rate" name="comission_rate" class="form-control mt-3"
                    value="{{ $terminalExpense->comission_rate }}">
            </div>
        </div>

        <!-- Minimum Comission -->
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="minimum_comission">Minimum Commission Rate</label>
                <input type="number" id="minimum_comission" name="minimum_comission" class="form-control mt-3 minimum_comission"
                    value="{{ $terminalExpense->minimum_comission }}">
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Status -->
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="status" class="required">Status</label>
                <select id="status" name="status" class="form-control mt-3" required>
                    <option value="active" {{ $terminalExpense->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ $terminalExpense->status == 'deactive' ? 'selected' : '' }}>Deactive
                    </option>
                </select>
            </div>
        </div>
    </div>

    <!-- Dynamic Job Job Expense Fieldss -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <label for="job_expenditure_fields_edit" class="required">Job Expense Fields</label>
                <div class="job_expenditure_fields_edit">
                    @foreach ($terminalExpense->jobExpense as $expense)
                        <div class="row mb-3 job-field">
                            <div class="col-md-5">
                                <input type="text" name="job_expend_field[]" class="form-control"
                                    placeholder="Job Expense Fields" required value="{{ $expense->job_expend_field }}">
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="amount[]" class="form-control" placeholder="Amount" required
                                    value="{{ $expense->amount }}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-field">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="" class="btn btn-success mt-3 add_field_modal">
                    <i class="fas fa-plus"></i> Add Field
                </button>
            </div>
        </div>
    </div>
    <!-- Submit Button -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <button type="submit" id="update" class=" update btn btn-primary mt-4">
                    <span id="spinner-update" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <i class="fas fa-wrench"></i> Update
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('.update').on('click', function(e) {
            alert('hello');
            e.preventDefault();
            $('#spinner-update').removeClass('d-none');
            $(this).prop('disabled', true);

            // Now create FormData with the updated form (after removal)
            let formData = new FormData($('#terminalExpenseEditForm')[0]);
            let url = $('#terminalExpenseEditForm').attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#spinner-update').addClass('d-none');
                    $('.update').prop('disabled', false);
                    $('#exampleModalEdit').modal('hide');
                    $('#terminal-expense-data').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    $('#spinner-update').addClass('d-none');
                    $('.update').prop('disabled', false);
                    var errors = xhr.responseJSON.errors;
                    // Iterate through each error and display it
                    $.each(errors, function(key, value) {
                        toastr.error(value); // Displaying each error message
                    });
                }
            });

        });

        // Add new fields dynamically
        $('.add_field_modal').click(function() {
            const newField = `
            <div class="row mb-3 job-field">
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
            $('.job_expenditure_fields_edit').append(newField);
        });

        // Remove row (completely remove from DOM)
        $(document).on('click', '.remove-field', function() {

            $(this).closest('.job-field').detach(); // Detach the row from DOM
        });
    });
</script>
