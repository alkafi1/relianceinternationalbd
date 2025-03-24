@extends('layouts.layout')
@section('breadcame', 'Terminal List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label mb-2" for="terminal-status-filter">Status</label>
                            <select class="form-select form-select-solid" id="terminal-status-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label mb-2" for="terminal-type-filter">Terminal Type</label>
                            <select class="form-select form-select-solid" id="terminal-type-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                <option value="both">Both</option>
                                <option value="import">Import</option>
                                <option value="export">Export</option>
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
                    @include('terminal.datatables.terminal-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('terminal.modal.edit-modal')
    @include('terminal.modal.show-modal')
    @push('custom-js')
        <script>
            // Define columns
            const columns = [
                {
                    data: 'serial', // Corresponds to the 'terminal_name' field in your data
                    name: 'serial',
                    className: 'text-center min-w-50px fw-bold text-dark firstTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'terminal_name', // Corresponds to the 'terminal_name' field in your data
                    name: 'terminal_name',
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'terminal_type', // Corresponds to the 'email' field in your data
                    name: 'terminal_type',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'address', // Corresponds to the 'age' field in your data
                    name: 'address',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'description', // Corresponds to the 'phone' field in your data
                    name: 'description',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                
                {
                    data: 'status', // Corresponds to the 'full_address' field in your data
                    name: 'status',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                
                {
                    data: 'action', // Corresponds to the 'last_updated' field in your data
                    name: 'action',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'last_updated', // Corresponds to the 'status' field in your data
                    name: 'last_updated',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'created_at', // Corresponds to the 'status' field in your data
                    name: 'created_at',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true,
                },

            ];
            const tableId = 'terminal-data';
            const ajaxUrl = '{{ route('terminal.datatable') }}';
            const filters = {
                status: 'terminal-status-filter', // Key: 'status', Value: ID of the status filter element
                type: 'terminal-type-filter'
            };
            initializeDataTable(tableId, columns, ajaxUrl, filters);
            $('#reset-filter').on('click', function() {
                $('#terminal-status-filter, #terminal-type-filter').val('')
                    .trigger('change');
            });
            $(document).on('click', '.status', function(e) {
                e.preventDefault(); // Prevent default link behavior
                const url = $(this).data('url');
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will change status of this terminal!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(url, 'PUT');
                    }
                });
            });
            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default link behavior

                const url = $(this).data('url');
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will delete of this terminal!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        sendAjaxReq(url, 'DELETE');
                    }
                });
            });

            function sendAjaxReq(url, type) {
                $.ajax({
                    url: url,
                    type: type, // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // You can send additional data if needed
                    success: function(response) {
                        $('#terminal-data').DataTable().ajax.reload(null, false);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        toastr.success('An error occurred.');
                        // Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }

            $(document).on('click', '.edit', function(e) {
                e.preventDefault(); // Prevent default link behavior

                const url = $(this).data('url');
                // Show SweetAlert confirmation dialog
                
                $.ajax({
                    url: url,
                    type: 'GET', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // You can send additional data if needed
                    success: function(response) {
                        $('#exampleModal').modal('show');
                        $('.modal-body').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        toastr.error('An error occurred.');
                        // Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            });

            // 
            $(document).on('click', '.detils', function(e) {
                e.preventDefault(); // Prevent default link behavior

                const url = $(this).data('url');
                // Show SweetAlert confirmation dialog
                
                $.ajax({
                    url: url,
                    type: 'GET', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // You can send additional data if needed
                    success: function(response) {
                        $('#exampleModalShow').modal('show');
                        $('.modal-body').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        toastr.error('An error occurred.');
                        // Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            });
        </script>
    @endpush
@endsection
