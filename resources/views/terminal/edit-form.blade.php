<form action="{{ route('terminal.update.post', $terminal->uid) }}" id="terminalEditForm" method="POST" enctype="multipart/form-data">
    @csrf <!-- Add CSRF token for security -->

    <div class="row">
        <!-- First Name -->
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="terminal_name" class="required">Terminal Name</label>
                <input type="text" id="terminal_name" name="terminal_name" class="form-control mt-3" required
                    value="{{ $terminal->terminal_name }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="age">Terminal Short Form</label>
                <input type="text" id="terminal_short_form" name="terminal_short_form"
                    value="{{ $terminal->terminal_short_form }}" class="form-control mt-3">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="terminal_type" class="required">Terminal Type</label>
                <select id="terminal_type" name="terminal_type" class="form-control mt-3">
                    <option value="">Select Terminal Type</option>
                    <option value="import" {{ $terminal->terminal_type == 'import' ? 'selected' : '' }}>Import</option>
                    <option value="export" {{ $terminal->terminal_type == 'export' ? 'selected' : '' }}>Export</option>
                    <option value="both" {{ $terminal->terminal_type == 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="status" class="required">Status</label>
                <select id="status" name="status" class="form-control mt-3">
                    <option value="active" {{ $terminal->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ $terminal->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Address -->
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="address" class="required">Address</label>
                <textarea id="address" name="address" class="form-control mt-3" rows="3">{{ $terminal->address }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="description" class="required">About Terminal</label>
                <textarea id="description" name="description" class="form-control mt-3" rows="3" required>{{ $terminal->description }}</textarea>
            </div>
        </div>
    </div>
    <!-- Submit Button -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <button type="submit" id="update" class="btn btn-primary mt-4">
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

        $('#update').on('click', function(e) {
            e.preventDefault();
            $('#spinner-update').removeClass('d-none');
            $(this).prop('disabled', true);
            let formData = new FormData($('#terminalEditForm')[0]);
            let url = $('#terminalEditForm').attr('action');
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
                    $('#update').prop('disabled', false);
                    $('#exampleModal').modal('hide');
                    $('#terminal-data').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    $('#spinner-update').addClass('d-none');
                    $('#update').prop('disabled', false);
                    var errors = xhr.responseJSON.errors;
                    // Iterate through each error and display it
                    $.each(errors, function(key, value) {
                        toastr.error(value); // Displaying each error message
                    });
                }
            });

        });
    });
</script>
