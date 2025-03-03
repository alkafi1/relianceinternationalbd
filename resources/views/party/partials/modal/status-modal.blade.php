<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agent Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agentStatusUpdateForm">
                    @csrf
                    <select id="status" name="status" class="form-control">
                        <option value="approved">APPROVED</option>
                        <option value="unapproved">UNAPPROVED</option>
                        <option value="deleted">DELETED</option>
                        <option value="lock">LOCK</option>
                        <option value="suspended">SUSPENDED</option>
                    </select>
            </div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="hidden" id="uid" name="uid">
            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
</div>