@extends('layouts.layout')
@section('breadcame', 'Admin List')
@section('content')
    <div class="row">
        <div class="col-md-12 event-list-col">

            <div class="card">
                <div class="card-body">
                    @include('admin.partials.datatables.admin-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.modal.status-modal')

    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'display_name', // Corresponds to the 'admin_name' field in your data
                    name: 'display_name',
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email', // Corresponds to the 'email' field in your data
                    name: 'email',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status', // Corresponds to the 'status' field in your data
                    name: 'status',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'last_updated', // Corresponds to the 'last_updated' field in your data
                    name: 'last_updated',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        // Format the date if needed
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: 'created_at', // Corresponds to the 'created_at' field in your data
                    name: 'created_at',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        // Format the date if needed
                        return new Date(data).toLocaleDateString();
                    }
                },

                {
                    data: 'action', // Corresponds to the 'status' field in your data
                    name: 'action',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true,
                },
            ];
            // Initialize DataTable
            initializeDataTable('admin-data', "{{ route('admin.datatable') }}", columns);

            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var uid = $(this).attr('data-id');
                var url = `{{ route('admin.destroy', ':admin') }}`.replace(':admin', uid);
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will delete this admin!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(uid, status = null, url, type = 'DELETE');
                    }
                });
            });
            $(document).on('click', '.status', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var uid = $(this).attr('data-id'); // Get the URL from the href attribute
                var status = $(this).attr('data-status');
                $('#exampleModal').modal('show');
                var url = `{{ route('admin.status', ':admin') }}`.replace(':admin', uid);
                sendAjaxReq(uid, status, url, 'PUT');
            });

            function sendAjaxReq(uid, status, url, type) {
                $.ajax({
                    url: url,
                    type: type, // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // You can send additional data if needed
                    success: function(response) {
                        $('#admin-data').DataTable().ajax.reload(null, false);
                        if (response.success) {
                            if (response.data && response.data.status) {
                                $('#status').val(response.data.status);
                                $('#uid').val(response.data.uid);
                            } else {
                                toastr.success(response.message);
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        toastr.error(response.message);
                    }
                });
            }
            $(document).ready(function() {
                // Handle form submission
                $('#adminStatusUpdateForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission
                    // Show loading spinner
                    $('#spinner').removeClass('d-none');
                    // Create a FormData object to handle file uploads
                    const formData = new FormData(this);
                    // Send the AJAX request
                    $.ajax({
                        url: '{{ route('admin.status.update') }}', // URL to submit the form data
                        type: 'POST',
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting the content type
                        success: function(response) {
                            // Hide loading spinner
                            $('#spinner').addClass('d-none');
                            if (response.success) {
                                toastr.success(response.message);
                                $('#exampleModal').modal('hide');
                                $('#adminStatusUpdateForm')[0].reset();
                                $('#admin-data').DataTable().ajax.reload(null, false);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            $('#spinner').addClass('d-none');
                            alert('An error occurred while submitting the form.');
                        }
                    });
                });
            });

            $('#toggle-filters-container').on('click', function() {
                $('#filter-section').slideToggle(300); // Slide up/down animation
                $('#toggle-filters').fadeOut(150, function() { // Fade out the icon before switching
                    $(this).toggleClass('fa-filter fa-times').fadeIn(150); // Switch icon with fade effect
                });
            });
        </script>
    @endpush
@endsection
