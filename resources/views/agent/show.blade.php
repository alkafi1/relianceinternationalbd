<div class="modal-content rounded-3 shadow">
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="agentInfoModalLabel">Agent Profile: {{ $agent->display_name }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>First Name:</strong> {{ $agent->first_name }}
            </div>
            <div class="col-md-6">
                <strong>Last Name:</strong> {{ $agent->last_name }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Age:</strong> {{ $agent->age }}
            </div>

            <div class="col-md-6">
                <strong>Agent ID:</strong> {{ $agent->agent_id }}
            </div>
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            @php
                $statusClasses = [
                    'approved' => 'success',
                    'unapproved' => 'warning',
                    'deleted' => 'danger',
                    'lock' => 'secondary',
                    'suspended' => 'info',
                ];

                $class = $statusClasses[$agent->status] ?? 'primary';
            @endphp

            <span class="badge bg-{{ $class }} text-uppercase">{{ $agent->status }}</span>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Email:</strong> <a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a><br>
            </div>

            <div class="col-md-6">
                <strong>Phone:</strong> <a href="tel:{{ $agent->phone }}">{{ $agent->phone }}</a>
            </div>
        </div>

        <div class="mb-3">
            <strong>Address:</strong> {{ $agent->address }}
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><strong>Division ID:</strong> {{ $agent?->division->name }}</div>
            <div class="col-md-4"><strong>District ID:</strong> {{ $agent?->district->name }}</div>
            <div class="col-md-4"><strong>Thana ID:</strong> {{ $agent?->thana->name }}</div>
        </div>

        {{-- <div class="row mb-3">
            <div class="col-md-6">
                <strong>Created By:</strong> {{$agent->created_by->first_name}}
            </div>
            <div class="col-md-6">
                <strong>Created At:</strong> {{\Carbon\Carbon::parse($agent->created_at)->format('d-m-Y')}}
            </div>
        </div> --}}

        {{-- Optional image preview --}}
        {{-- @if ($image)
            <div class="mb-3 text-center">
                <img src="{{ asset('storage/agent_images/' . $image) }}" alt="Agent Image" class="img-thumbnail"
                    width="150">
            </div>
        @endif --}}
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
