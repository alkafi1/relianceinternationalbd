@extends('layouts.layout')
@section('breadcame', 'Party List')
@section('content')
    <div class="row">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-body">
                    @include('bill.partials.datatables.bill-register-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('bill.partials.modal.status-modal')

    @push('custom-js')
        <script>
            // Define columns
            const columns = [
                {
                    data: 'created_at', // Corresponds to the 'status' field in your data
                    name: 'created_at',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'job_no', // Corresponds to the 'status' field in your data
                    name: 'job_no',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'bill_no', // Corresponds to the 'status' field in your data
                    name: 'bill_no',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'bill_amount', // Corresponds to the 'party_name' field in your data
                    name: 'bill_amount',
                    className: 'min-w-50px fw-bold text-dark firstTheadColumn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'received_amount', // Corresponds to the 'party_id' field in your data
                    name: 'received_amount', // Name for server-side processing
                    className: 'fw-bold text-dark', // Add classes for styling
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'due_amount', // Corresponds to the 'email' field in your data
                    name: 'due_amount',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'remarks', // Corresponds to the 'phone' field in your data
                    name: 'remarks',
                    className: 'min-w-150px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action', // Corresponds to the 'status' field in your data
                    name: 'action',
                    className: 'text-end min-w-100px fw-bold text-dark lastTheadColumn',
                    orderable: true,
                    searchable: true
                },

                
            ];

            const tableId = 'bill-register-data';
            const ajaxUrl = '{{ route('bill.register.datatable') }}';
            const filters = {
                status: 'admin-status-filter', // Key: 'status', Value: ID of the status filter element
            };
            initializeDataTable(tableId, columns, ajaxUrl, filters);

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
