<div class="">
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="form-group">
                <label for="admin-status-filter" class="form-label">Status</label>
                <select class="form-select form-select-solid" id="admin-status-filter" data-placeholder="Select option">
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
    <!--begin::Table-->
    <table class="table align-middle table-bordered fs-6 gy-5 m-auto display"
        id="bill-register-data">
        <!--begin::Table head-->
        <thead class="px-2">
            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.bill_date') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.job_no') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.bill_no') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.bill_amount') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.received_amount') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.due_balance') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.remarks') }}
                </th>
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('english.action') }}
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>

        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>

