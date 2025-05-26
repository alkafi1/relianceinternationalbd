<div class="modal fade" id="audited_amount_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Audited Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="audited_amount_form">
                    @csrf
                    <div class="form-group">
                        <label for="audited_amount" class="form-label">Audited Amount</label>
                        <input type="number" class="form-control" id="audited_amount" name="audited_amount" required>
                    </div>
                    
            
            </div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="hidden" id="job_id" name="uid">
            <button type="submit" id="submit-audited-amount" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
</div>