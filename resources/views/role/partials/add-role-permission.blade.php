<form id="roleForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl required">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl required mb-3">Permission Name</label>
                <div class="form-check form-check-custom form-check-solid form-check-success form-switch">
                    <div class="row mb-3">
                        @foreach ($groupedPermissions as $module => $permissions)
                            <div class="card mb-5">
                                <div class="card-header">
                                    <h3 class="card-title text-capitalize">{{ $module }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-4 mb-3">
                                                <div
                                                    class="form-check form-check-custom form-check-solid form-check-success form-switch">
                                                    <input class="form-check-input w-45px h-30px" type="checkbox"
                                                        value="{{ $permission->id }}" name="permissions[]"
                                                        id="permission-switch-{{ $permission->id }}">

                                                    <!--begin::Label-->
                                                    <label class="form-check-label text-gray-700 fw-bold"
                                                        for="permission-switch-{{ $permission->id }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Enable Permission"
                                                        data-kt-initialized="1">
                                                        {{ str_replace('-', ' ', ucwords(collect(explode('.', $permission->name, 2))->last(), '-')) }}

                                                    </label>
                                                    <!--end::Label-->
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
    <button id="role-submit" type="submit" class="btn btn-primary mt-3">
        <span id="spinner-role-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-upload"></i> Submit
    </button>

    <button id="role-update" type="submit" class="btn btn-primary mt-3 d-none">
        <span id="spinner-role-update" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-wrench"></i> Update
    </button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#role-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-role-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('role.store') }}";
                let form = $('#roleForm')[0];
                let formData = new FormData(form);
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
                        $('#spinner-role-submit').addClass('d-none'); // hide the spinner
                        $('#role-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#roleForm')[0].reset();
                        $('#role-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-role-submit').addClass('d-none'); // hide the spinner
                        $('#role-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#role-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-role-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('role.update') }}";
                let id = $(this).attr('data-id');
                let form = $('#roleForm')[0];
                let formData = new FormData(form);
                formData.append('id', id);
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
                        $('#spinner-role-update').addClass('d-none'); // hide the spinner
                        $('#role-update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Role & Permission');
                        $('#roleForm')[0].reset();
                        $('#role-data').DataTable().ajax.reload(null, false);
                        $('#role-submit').removeClass('d-none');
                        $('#role-update ').addClass('d-none');
                        $('#page-refresh ').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner-role-update').addClass('d-none'); // hide the spinner
                        $('#role-update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });

            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#add-header').text('Add Role & Permission');
                $('#roleForm')[0].reset();
                $('#role-submit').removeClass('d-none');
                $('#role-update ').addClass('d-none');
                $('#page-refresh ').addClass('d-none');
            });
        });
    </script>
@endpush
