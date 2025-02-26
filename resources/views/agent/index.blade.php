@extends('layouts.layout')
@section('breadcame', 'Agent List')
@section('content')
    <div class="row">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-body">
                    @include('agent.partials.datatables.agent-data-table')
                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'agent_id', // Corresponds to the 'agent_id' field in your data
                    name: 'agent_id', // Name for server-side processing
                    className: 'fw-bold text-dark', // Add classes for styling
                    orderable: true, // Allow sorting
                    searchable: true // Allow searching
                },
                {
                    data: 'agent_name', // Corresponds to the 'agent_name' field in your data
                    name: 'agent_name',
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'todays_job', // Corresponds to the "today's_job" field in your data
                    name: 'todays_job',
                    className: 'min-w-150px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'phone', // Corresponds to the 'phone' field in your data
                    name: 'phone',
                    className: 'min-w-50px fw-bold text-dark',
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
                    data: 'age', // Corresponds to the 'age' field in your data
                    name: 'age',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'full_address', // Corresponds to the 'full_address' field in your data
                    name: 'full_address',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
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
                    data: 'action', // Corresponds to the 'status' field in your data
                    name: 'action',
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
                }
            ];
            // Initialize DataTable
            initializeDataTable('agent-data', "{{ route('agent.datatable') }}", columns);

            $(document).on('click', '.edit', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).attr('data-id');
                var url = "{{ route('dashboard') }}";
                $.ajax({
                    url: url,
                    type: 'POST', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    }, // You can send additional data if needed
                    success: function(response) {
                        console.log(response.event);

                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            });
            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).attr('data-id');
                var url = `{{ route('agent.destroy', ':agent') }}`.replace(':agent', id);
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will delete this agent!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status = null, url, type = 'DELETE');
                    }
                });
            });
            $(document).on('click', '.status', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).attr('data-id'); // Get the URL from the href attribute
                var status = $(this).attr('data-status');
                var url = "";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will change status of this agent!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status, url);
                    }
                });
            });

            function sendAjaxReq(id, status, url, type) {
                var requestData = {
                    id: id,
                    // Optionally include status if it's provided
                };

                // Check if status is defined and not null
                if (typeof status !== 'undefined' && status !== null) {
                    requestData.status = status;
                }
                $.ajax({
                    url: url,
                    type: type, // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: requestData, // You can send additional data if needed
                    success: function(response) {
                        $('#agent-data').DataTable().ajax.reload(null, false);
                        // Swal.fire('Success!', response.success,
                        //     'success');
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }
        </script>
    @endpush
@endsection
