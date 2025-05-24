@extends('layouts.layout')
@section('breadcame', 'Job Report')
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
                                {{-- @forelse ($terminals as $terminal)
                                    <option value="{{ $terminal->uid }}">{{ $terminal->terminal_name }}</option>
                                @empty
                                    <option value="">There is no terminal</option>
                                @endforelse --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="party-filter" class="form-label">Party</label>
                            <select class="form-select form-select-solid" id="party-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                {{-- @forelse ($parties as $party)
                                    <option value="{{ $party->uid }}">{{ $party->party_name }}</option>
                                @empty
                                    <option value="">There is no party</option>
                                @endforelse --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="agnet-filter" class="form-label">Agent</label>
                            <select class="form-select form-select-solid" id="agent-filter"
                                data-placeholder="Select option">
                                <option value="">All</option>
                                {{-- @forelse ($agents as $agent)
                                    <option value="{{ $agent->uid }}">{{ $agent->display_name }}</option>
                                @empty
                                    <option value="">There is no agent</option>
                                @endforelse --}}
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
@endsection
