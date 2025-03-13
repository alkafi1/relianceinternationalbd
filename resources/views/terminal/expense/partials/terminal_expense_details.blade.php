<div class="d-flex flex-column mb-5">
    <div class="d-flex align-items-center">
        <div class="text-gray-800 fw-bold">{{ $terminalExpense->terminal->terminal_name }}</div>
        <div class="badge badge-light-primary ms-5">Primary</div>
    </div>
    <div class="text-muted">Commission {{ $terminalExpense->comission_rate }}</div>
</div>

<div class="table-responsive table-container">
    <table
        class="terminal-jobField-data table relance-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="terminal-jobField-table">
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #690f0f;">
                <th class="min-w-30px fw-bold text-dark" style="font-weight: 900">{{ __('english.title') }}</th>
                <th class="text-end min-w-100px fw-bold text-dark " style="font-weight: 900">
                    {{ __('english.amount') }}</th>
                <th class="text-end min-w-100px fw-bold text-dark " style="font-weight: 900">
                    {{ __('english.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($terminalExpense->jobExpense as $key => $expense)
                <tr>
                    <td>{{ $expense->job_expend_field ?? 'N/A' }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" class="delete text-danger" data-id="{{ $expense->uid }}"
                            data-url="{{ route('terminal.expense.destroy',['terminalExpense' => $expense->uid]) }}">
                            <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

