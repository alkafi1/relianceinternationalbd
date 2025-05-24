@extends('layouts.layout')
@section('breadcame', 'Account List')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin-status-filter" class="form-label">Status</label>
                            <select class="form-select form-select-solid" id="admin-status-filter"
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
    <div class="row">
        <div class="col-md-12 event-list-col">
            <div class="card">
                <div class="card-body">
                    @include('account.partials.datatables.account-data-table')
                </div>
            </div>
        </div>
    </div>
    @include('account.partials.modal.status-modal')

    @push('custom-js')
        <script>
            // Define columns
            const columns = [{
                    data: 'account_name', // Corresponds to the 'party_id' field in your data
                    name: 'account_name', // Name for server-side processing
                    className: 'text-center fw-bold text-dark', // Add classes for styling
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'current_balance', // Corresponds to the 'party_name' field in your data
                    name: 'current_balance',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'account_type', // Corresponds to the 'party_name' field in your data
                    name: 'account_type',
                    className: 'min-w-50px fw-bold text-dark ',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'created_at', // Corresponds to the 'created_at' field in your data
                    name: 'created_at',
                    className: ' min-w-100px fw-bold text-dark ',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'action', // Corresponds to the 'action' field in your data
                    name: 'action',
                    className: ' min-w-100px fw-bold text-dark ',
                    orderable: false, // Action columns are usually not orderable
                    searchable: false, // Action columns are usually not searchable
                },
            ];

            // Initialize DataTable
            const tableId = 'account-data-kk';
            const ajaxUrl = '{{ route('account.datatable') }}';
            const filters = {
                status: 'admin-status-filter-kk', // Key: 'status', Value: ID of the status filter element
            };
            initializeDataTable(tableId, columns, ajaxUrl, filters, true);

            $('#reset-filter').on('click', function() {
                alert('reset');
                $('#admin-status-filter-kk').val('').trigger('change');
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
