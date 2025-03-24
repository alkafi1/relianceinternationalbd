@extends('layouts.layout')
@section('breadcame', 'Reliance International Terminal Expense Fields')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label mb-2" for="terminal-status-filter">Status</label>
                            <select class="form-select form-select-solid" id="terminal-expense-status-filter"
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
                            <select class="form-select form-select-solid" id="terminal-expense-type-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
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
    <div class="row">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h2 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Expense List</span>
                    </h2>
                    <div class="card-toolbar">
                        <a href="{{ route('terminal.expense.create') }}" class="btn btn-sm btn-light-primary">
                            <i class="fas fa-plus-circle"></i> Add Expense
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    @include('terminal.expense.datatables.terminal-expense-data-table')
                </div>
            </div>
        </div>
    </div>

    @include('terminal.expense.modal.show-modal')
    @include('terminal.expense.modal.edit-modal')
    @push('custom-js')
        <script>
            // Define columns
            const columns = [
                {
                    data: 'serial', // Corresponds to the 'terminal_name' field in your data
                    name: 'serial', // Name for server-side processing
                    className: 'text-center min-w-50px fw-bold text-dark', // Add classes for styling
                    orderable: true, // Allow sorting
                    searchable: true // Allow searching
                },
                
                {
                    data: 'title', // Corresponds to the 'title' field in your data
                    name: 'title',
                    className: 'min-w-30px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'terminal_name', // Corresponds to the 'terminal_name' field in your data
                    name: 'terminal_name', // Name for server-side processing
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn', // Add classes for styling
                    orderable: true, // Allow sorting
                    searchable: true // Allow searching
                },
                {
                    data: 'job_type', // Corresponds to the 'job_type' field in your data
                    name: 'job_type',
                    className: 'min-w-150px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'comission_rate', // Corresponds to the 'comission_rate' field in your data
                    name: 'comission_rate',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'minimum_comission', // Corresponds to the 'minimum_comission' field in your data
                    name: 'minimum_comission',
                    className: 'party min-w-100px fw-bold text-dark party',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status', // Corresponds to the 'status' field in your data
                    name: 'status',
                    className: 'party min-w-100px fw-bold text-dark party',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action', // Corresponds to the 'action' field in your data
                    name: 'action',
                    className: 'party min-w-100px fw-bold text-dark party',
                    orderable: false, // Action column is not sortable
                    searchable: false // Action column is not searchable
                }
            ];
            const tableId = 'terminal-expense-data';
            const ajaxUrl = '{{ route('terminal.expense.datatable') }}';
            const filters = {
                status: 'terminal-expense-status-filter', // Key: 'status', Value: ID of the status filter element
                type: 'terminal-expense-type-filter',
            };
            // Initialize DataTable
            initializeDataTable(tableId, columns, ajaxUrl, filters);
            $('#reset-filter').on('click', function() {
                $('#terminal-expense-status-filter, #terminal-expense-type-filter').val('')
                    .trigger('change');
            });
            $(document).on('click', '.status', function(e) {
                e.preventDefault(); // Prevent default link behavior
                const url = $(this).data('url');
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will change status of this terminal expense!',
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
                        $('#terminal-expense-data').DataTable().ajax.reload(null, false);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }


            $(document).on('click', '.details', function(e) {
                e.preventDefault(); // Prevent default link behavior
                const url = $(this).data('url');
                // Send AJAX request
                sendDetailsAjaxReq(url, 'PUT');
            });

            function sendDetailsAjaxReq(url, type) {
                $.ajax({
                    url: url,
                    type: type, // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // You can send additional data if needed
                    success: function(response) {
                        $('#exampleModal').modal('show');
                        $('.modal-body').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        // toastr.success(response.message);
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
                        $('#exampleModalEdit').modal('show');
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
