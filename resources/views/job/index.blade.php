@extends('layouts.layout')
@section('breadcame', 'Reliance International Job List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="terminal-filter" class="form-label">Terminal</label>
                            <select class="form-select form-select-solid" id="terminal-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                @forelse ($terminals as $terminal)
                                    <option value="{{ $terminal->uid }}">{{ $terminal->terminal_name }}</option>
                                @empty
                                    <option value="">There is no terminal</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="party-filter" class="form-label">Party</label>
                            <select class="form-select form-select-solid" id="party-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                @forelse ($parties as $party)
                                    <option value="{{ $party->uid }}">{{ $party->party_name }}</option>
                                @empty
                                    <option value="">There is no party</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="agnet-filter" class="form-label">Agent</label>
                            <select class="form-select form-select-solid" id="agent-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                @forelse ($agents as $agent)
                                    <option value="{{ $agent->uid }}">{{ $agent->display_name }}</option>
                                @empty
                                    <option value="">There is no agent</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="job-status-filter" class="form-label">Status</label>
                            <select class="form-select form-select-solid" id="job-status-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                <option value="initialized_by_agent">Initialized By Agent</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="date" id="start-date" name="start_date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="date" id="end-date" name="end_date" class="form-control" />
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

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('job.partials.datatables.job-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('job.partials.modal.status-modal')

    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'serial', // Corresponds to the 'status' field in your data
                    name: 'serial',
                    className: 'text-center min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action', // Corresponds to the 'status' field in your data
                    name: 'action',
                    className: 'text-center min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'job_no', // Corresponds to the 'status' field in your data
                    name: 'job_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'bill_no', // Corresponds to the 'status' field in your data
                    name: 'bill_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'invoice_no', // Corresponds to the 'full_address' field in your data
                    name: 'invoice_no',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'be_no', // Corresponds to the 'status' field in your data
                    name: 'be_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status', // Corresponds to the 'status' field in your data
                    name: 'status',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'job_type', // Corresponds to the 'status' field in your data
                    name: 'job_type',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'party_name', // Corresponds to the 'party_name' field in your data
                    name: 'perty_name',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'agent', // Corresponds to the 'email' field in your data
                    name: 'agent',
                    className: 'min-w-50px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'terminal', // Corresponds to the 'party_name' field in your data
                    name: 'terminal',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'total_job_expense', // Corresponds to the 'party_name' field in your data
                    name: 'total_job_expense',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'commissoin', // Corresponds to the 'party_name' field in your data
                    name: 'commissoin',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'advanced_received', // Corresponds to the 'party_name' field in your data
                    name: 'advanced_received',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'total_bill_amount', // Corresponds to the 'party_name' field in your data
                    name: 'total_bill_amount',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'buyer_name', // Corresponds to the 'phone' field in your data
                    name: 'buyer_name',
                    className: 'min-w-150px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'value_usd', // Corresponds to the 'status' field in your data
                    name: 'value_usd',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'usd_rate', // Corresponds to the 'status' field in your data
                    name: 'usd_rate',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'item', // Corresponds to the 'status' field in your data
                    name: 'item',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'lc_no', // Corresponds to the 'status' field in your data
                    name: 'lc_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'ud_no', // Corresponds to the 'status' field in your data
                    name: 'ud_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'ud_amendment_no', // Corresponds to the 'status' field in your data
                    name: 'ud_amendment_no',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'master_bl_number', // Corresponds to the 'status' field in your data
                    name: 'master_bl_number',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'house_bl_number', // Corresponds to the 'status' field in your data
                    name: 'house_bl_number',
                    className: 'min-w-100px fw-bold text-dark',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'quantity', // Corresponds to the 'status' field in your data
                    name: 'quantity',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'ctns_pieces', // Corresponds to the 'status' field in your data
                    name: 'ctns_pieces',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'weight', // Corresponds to the 'status' field in your data
                    name: 'weight',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'voucher_amount', // Corresponds to the 'status' field in your data
                    name: 'voucher_amount',
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'updated_at', // Corresponds to the 'last_updated' field in your data
                    name: 'updated_at',
                    className: 'min-w-100px fw-bold text-dark ',
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
                    className: 'min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        // Format the date if needed
                        return new Date(data).toLocaleDateString();
                    }
                },
            ];

            const tableId = 'job-data';
            const ajaxUrl = '{{ route('job.datatable') }}';
            const filters = {
                status: 'job-status-filter', // Key: 'status', Value: ID of the status filter element
                terminal: 'terminal-filter',
                party: 'party-filter',
                agent: 'agent-filter',
                start_date: 'start-date',
                end_date: 'end-date'
            };
            const table = initializeDataTable(tableId, columns, ajaxUrl, filters, true);
            $('#reset-filter').on('click', function() {
                $('#job-status-filter, #party-filter, #terminal-filter, #agent-filter, #start-date, #end-date').val('')
                    .trigger('change');

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
