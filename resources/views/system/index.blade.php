@extends('layouts.layout')
@section('breadcame')
    System Management
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('system.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-3xl required">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') ?? $global['website_name'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fileInput" class="text-3xl">Logo</label>
                                    <input type="file" class="form-control" id="fileInput" name="logo"
                                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="pp" width="100" class="float-start mt-3"
                                        src="{{ asset('public/frontend/images/' . $global['logo']) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="favicon" class="text-3xl">Favicon</label>
                                    <input type="file" class="form-control" id="favicon" name="favicon"
                                        oninput="ppp.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="ppp" width="100" class="float-start mt-3"
                                        src="{{ asset('public/frontend/images/' . $global['favicon']) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="text-3xl required">Short Content</label>
                                    <textarea class="form-control" id="content" name="short_content" rows="4" cols="50">{{ old('short_content') ?? $global['short_content'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="text-3xl required">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') ?? $global['address'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_embaded" class="text-3xl required">Address Emaded Code</label>
                                    <input type="text" class="form-control" id="address_embaded" name="address_embaded"
                                        value="{{ old('address_embaded') ?? $global['address_embaded'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="text-3xl">Email</label>
                                    <input type="text" class="form-control" id="facebook" name="email"
                                        value="{{ old('email') ?? $global['email'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="text-3xl">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone') ?? $global['phone'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook" class="text-3xl">Facebook URL</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook"
                                        value="{{ old('facebook') ?? $global['facebook'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin" class="text-3xl">LinkedIn URL</label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin"
                                        value="{{ old('linkedin') ?? $global['linkedin'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube" class="text-3xl">YouTube URL</label>
                                    <input type="text" class="form-control" id="youtube" name="youtube"
                                        value="{{ old('youtube') ?? $global['youtube'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter" class="text-3xl">Twitter URL</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter"
                                        value="{{ old('twitter') ?? $global['twitter'] }}">
                                </div>
                            </div>
                        </div>
                        <button id="system-submit" type="submit" class="btn btn-primary mt-3">
                            <span id="spinner-system-submit" class="spinner-border spinner-border-sm me-2 d-none"
                                role="status" aria-hidden="true"></span>
                            <i class="fas fa-upload"></i> Submit
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
        <script>
            $(document).ready(function() {
                $('#system-submit').on('click', function(e) {
                    e.preventDefault();

                    let form = $('#myForm')[0]; // Get the raw DOM element
                    let formData = new FormData(form); // Create FormData object

                    let url = $('#myForm').attr('action');

                    console.log([...formData.entries()]); // Debugging: Check the data being sent

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting content type
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                console.log(key, value);
                                toastr.error(value); // Display error message
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection

@push('custom-js')
@endpush
