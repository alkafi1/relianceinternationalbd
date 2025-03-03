@extends('layouts.layout')
@section('breadcame', $party->display_name . ' Party Edit')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('party.update', ['party' => $party->uid]) }}" id="partyForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf <!-- Add CSRF token for security -->
                        @method('PUT')
                        <div class="row">
                            <!-- Party Name -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="Party_name" class="required">Party Name</label>
                                    <input type="text" id="party_name" name="party_name" class="form-control mt-3"
                                        required value="{{$party->party_name}}">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="email" class="required">Email</label>
                                    <input type="email" id="email" name="email" class="form-control mt-3" required value="{{$party->email}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control mt-3" value="{{$party->phone}}">
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="status" class="required">Status</label>
                                    <select id="status" name="status" class="form-control mt-3" required>
                                        <option value="approved" {{ $party->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="unapproved" {{ $party->status == 'unapproved' ? 'selected' : '' }}>Unapproved</option>
                                        <option value="deleted" {{ $party->status == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                        <option value="lock" {{ $party->status == 'lock' ? 'selected' : '' }}>Lock</option>
                                        <option value="suspended" {{ $party->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="address" class="required">Address</label>
                                    <textarea id="address" name="address" class="form-control mt-3" rows="3" required>{{$party->address}}</textarea>
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
            // $('#partyForm').on('submit', function(e) {
            //     e.preventDefault(); // Prevent the default form submission

            //     // Show loading spinner
            //     $('#spinner').removeClass('d-none');

            //     // Create a FormData object to handle file uploads
            //     const formData = new FormData(this);

            //     // Send the AJAX request
            //     $.ajax({
            //         url: '{{ route('party.store') }}', // URL to submit the form data
            //         type: 'POST',
            //         data: formData,
            //         processData: false, // Prevent jQuery from processing the data
            //         contentType: false, // Prevent jQuery from setting the content type
            //         success: function(response) {
            //             // Hide loading spinner
            //             $('#spinner').addClass('d-none');

            //             if (response.success) {
            //                 alert('Form submitted successfully!');
            //                 // Optionally, reset the form
            //                 $('#partyForm')[0].reset();
            //             } else {
            //                 alert('Error: ' + response.message);
            //             }
            //         },
            //         error: function(xhr) {
            //             // Hide loading spinner
            //             $('#spinner').addClass('d-none');

            //             alert('An error occurred while submitting the form.');
            //         }
            //     });
            // });
        });
    </script>
@endpush
