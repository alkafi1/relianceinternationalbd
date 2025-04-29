<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Party Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-3">
            <label class="col-sm-4 fw-bold">{{ __('english.serial') }}:</label>
            <div class="col-sm-8 text-muted">{{ $party->uid }}</div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-4 fw-bold">{{ __('english.party_name') }}:</label>
            <div class="col-sm-8 text-muted">{{ $party->party_name }}/div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.phone') }}:</label>
                <div class="col-sm-8 text-muted">{{ $party->phone }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.email') }}:</label>
                <div class="col-sm-8 text-muted">{{ $party->email }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.full_address') }}:</label>
                <div class="col-sm-8 text-muted">{{ $party->address }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.status') }}:</label>
                <div class="col-sm-8">
                    <span
                        class="badge {{ $party->status == 'approved' ? 'bg-success' : ($party->status == 'unapproved' ? 'bg-warning' : ($party->status == 'deleted' ? 'bg-danger' : 'bg-secondary')) }}">
                        {{ ucfirst($party->status) }}
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.last_updated') }}:</label>
                <div class="col-sm-8 text-muted">
                    {{ \Carbon\Carbon::parse($party->updated_at)->format('d-m-Y H:i:s') }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 fw-bold">{{ __('english.created_at') }}:</label>
                <div class="col-sm-8 text-muted">
                    {{ \Carbon\Carbon::parse($party->created_at)->format('d-m-Y H:i:s') }}</div>
            </div>
        </div>

    </div>
