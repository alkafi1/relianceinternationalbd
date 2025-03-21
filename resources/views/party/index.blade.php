@extends('layouts.layout')
@section('breadcame', 'Party List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="party-status-filter" class="form-label">Status</label>
                            <select class="form-select form-select-solid" id="party-status-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                <option value="approved">Approved</option>
                                <option value="unapproved">Unapproved</option>
                                <option value="deleted">Deleted</option>
                                <option value="lock">Lock</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-3">
                    <button type="button" id="reset-filter" class="btn btn-icon btn-light-primary me-3">
                        <i class="fas fa-undo-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-body">
                    @include('party.partials.datatables.party-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('party.partials.modal.status-modal')

    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'party_id', // Corresponds to the 'party_id' field in your data
                    name: 'party_id', // Name for server-side processing
                    className: 'fw-bold text-dark', // Add classes for styling
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'party_name', // Corresponds to the 'party_name' field in your data
                    name: 'party_name',
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
                    data: 'phone', // Corresponds to the 'phone' field in your data
                    name: 'phone',
                    className: 'min-w-150px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'address', // Corresponds to the 'full_address' field in your data
                    name: 'address',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status', // Corresponds to the 'status' field in your data
                    name: 'status',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
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
                    data: 'action', // Corresponds to the 'action' field in your data
                    name: 'action',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: false, // Action columns are usually not orderable
                    searchable: false, // Action columns are usually not searchable
                },
            ];

            const tableId = 'party-data';
            const ajaxUrl = '{{ route('party.datatable') }}';
            const filters = {
                status: 'party-status-filter', // Key: 'status', Value: ID of the status filter element
            };
            initializeDataTable(tableId, columns, ajaxUrl, filters);
            $('#reset-filter').on('click', function() {
                $('#party-status-filter').val('').trigger('change');
            });
            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var uid = $(this).attr('data-id');
                var url = `{{ route('party.destroy', ':party') }}`.replace(':party', uid);
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will delete this party!',
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
                var url = `{{ route('party.status', ':party') }}`.replace(':party', uid);
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
                        $('#party-data').DataTable().ajax.reload(null, false);
                        if (response.success) {
                            console.log(response);
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
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }
            $(document).ready(function() {
                // Handle form submission
                $('#partyStatusUpdateForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission
                    // Show loading spinner
                    $('#spinner').removeClass('d-none');
                    // Create a FormData object to handle file uploads
                    const formData = new FormData(this);
                    // Send the AJAX request
                    $.ajax({
                        url: '{{ route('party.status.update') }}', // URL to submit the form data
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
                                $('#partyStatusUpdateForm')[0].reset();
                                $('#party-data').DataTable().ajax.reload(null, false);
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
        </script>
    @endpush
@endsection
