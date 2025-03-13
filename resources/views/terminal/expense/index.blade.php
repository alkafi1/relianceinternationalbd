@extends('layouts.layout')
@section('breadcame', 'Terminal Expense List')
@section('content')
    <div class="row">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-body">
                    @include('terminal.expense.datatables.terminal-expense-data-table')
                </div>
            </div>
        </div>
    </div>
    
   @include('terminal.expense.modal.show-modal')
    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'terminal_name', // Corresponds to the 'terminal_name' field in your data
                    name: 'terminal_name', // Name for server-side processing
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn', // Add classes for styling
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
                    data: 'action', // Corresponds to the 'action' field in your data
                    name: 'action',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: false, // Action column is not sortable
                    searchable: false // Action column is not searchable
                }
            ];
            // Initialize DataTable
            initializeDataTable('terminal-expense-data', "{{ route('terminal.expense.datatable') }}", columns);

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
            $(document).on('click', '.show', function(e) {
                e.preventDefault(); // Prevent default link behavior
                const url = $(this).data('url');

                // Send AJAX request
                sendShowAjaxReq(url, 'PUT');

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

            function sendShowAjaxReq(url, type) {
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
                        toastr.success(response.message);
                    }
                });
            }
        </script>
    @endpush
@endsection
