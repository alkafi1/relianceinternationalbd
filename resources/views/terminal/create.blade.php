@extends('layouts.layout')
@section('breadcame', 'Terminal Create')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('terminal.store') }}" id="terminalForm" method="POST">
                        @csrf <!-- Add CSRF token for security -->

                        <div class="row">
                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="terminal_name" class="required">Terminal Name</label>
                                    <input type="text" id="terminal_name" name="terminal_name" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="age">Terminal Short Form</label>
                                    <input type="text" id="terminal_short_form" name="terminal_short_form"
                                        class="form-control mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="terminal_type" class="required">Terminal Type</label>
                                    <select id="terminal_type" name="terminal_type" class="form-control mt-3">
                                        <option value="">Select Terminal Type</option>
                                        <option value="import">Import</option>
                                        <option value="export">Export</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="status" class="required">Status</label>
                                    <select id="status" name="status" class="form-control mt-3">
                                        <option value="active">Active</option>
                                        <option value="deactive">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="address" class="required">Address</label>
                                    <textarea id="address" name="address" class="form-control mt-3" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="description" class="required">About Terminal</label>
                                    <textarea id="description" name="description" class="form-control mt-3" rows="3" required></textarea>
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
            $('#terminalForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show loading spinner
                $('#spinner').removeClass('d-none');

                // Create a FormData object to handle file uploads
                const formData = new FormData(this);

                // Send the AJAX request
                $.ajax({
                    url: '{{ route('terminal.store') }}', // URL to submit the form data
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');
                        if (response.success) {
                            $('#terminalForm')[0].reset();
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
        });
    </script>

    <script>
        function getDistricts(division_id) {
            $.ajax({
                url: '{{ route('get.districts') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    division_id: division_id
                },
                success: function(response) {
                    $('#district_id').html(response.option);
                }
            });
        }
    </script>
@endpush
