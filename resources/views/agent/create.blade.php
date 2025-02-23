@extends('layouts.layout')
@section('breadcame', 'Agent')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="route('agent.store')" id="agentForm" method="POST" enctype="multipart/form-data">
                        @csrf <!-- Add CSRF token for security -->

                        <div class="row">
                            <!-- Agent -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="agent_id" class="required">Agent ID</label>
                                    <input type="text" id="agent_id" name="agent_id" class="form-control mt-3" required>
                                </div>
                            </div>
                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="first_name" class="required">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="last_name" class="required">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Age -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="age">Age</label>
                                    <input type="number" id="age" name="age" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="email" class="required">Email</label>
                                    <input type="email" id="email" name="email" class="form-control mt-3" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="phone" class="required">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="password" class="required">Password</label>
                                    <input type="password" id="password" name="password" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="address" class="required">Address</label>
                                    <textarea id="address" name="address" class="form-control mt-3" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Town ID -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="division_id" class="required">Division ID</label>
                                    <input type="number" id="division_id" name="division_id" class="form-control mt-3">
                                </div>
                            </div>

                            <!-- City ID -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="district_id" class="required">District ID</label>
                                    <input type="number" id="district_id" name="district_id" class="form-control mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- State ID -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="thana_id">Thana ID</label>
                                    <input type="number" id="thana_id" name="thana_id" class="form-control mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="status" class="required">Agent Status</label>
                                    <select id="status" name="status" class="form-control mt-3" required>
                                        <option value="approved">Approved</option>
                                        <option value="unapproved">Unapproved</option>
                                        <option value="deleted">Deleted</option>
                                        <option value="lock">Lock</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image">Profile Image</label>
                                    <input type="file" id="image" name="image" class="form-control mt-3"
                                        oninput="previewImage.src=window.URL.createObjectURL(this.files[0])">
                                    <p class="text-danger">Image must be in JPEG, PNG, or GIF format</p>
                                    <img id="previewImage" width="200" class="float-start mt-3" src=""
                                        alt="Image Preview">
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
            $('#agentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show loading spinner
                $('#spinner').removeClass('d-none');

                // Create a FormData object to handle file uploads
                const formData = new FormData(this);

                // Send the AJAX request
                $.ajax({
                    url: '{{ route('agent.store') }}', // URL to submit the form data
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');

                        if (response.success) {
                            alert('Form submitted successfully!');
                            // Optionally, reset the form
                            $('#agentForm')[0].reset();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        // Hide loading spinner
                        $('#spinner').addClass('d-none');

                        alert('An error occurred while submitting the form.');
                    }
                });
            });
        });
    </script>
@endpush
