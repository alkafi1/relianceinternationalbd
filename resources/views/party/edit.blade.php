<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Party Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{ route('party.update', ['party' => $party->uid]) }}" id="partyForm" method="POST"
            enctype="multipart/form-data">
            @csrf <!-- Add CSRF token for security -->
            @method('PUT')
            <div class="row">
                <!-- Party Name -->
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="Party_name" class="required">Party Name</label>
                        <input type="text" id="party_name" name="party_name" class="form-control mt-3" required
                            value="{{ $party->party_name }}">
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email" name="email" class="form-control mt-3" required
                            value="{{ $party->email }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Phone -->
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control mt-3"
                            value="{{ $party->phone }}">
                    </div>
                </div>
                <!-- Status -->
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="status" class="required">Status</label>
                        <select id="status" name="status" class="form-control mt-3" required>
                            <option value="approved" {{ $party->status == 'approved' ? 'selected' : '' }}>
                                Approved</option>
                            <option value="unapproved" {{ $party->status == 'unapproved' ? 'selected' : '' }}>
                                Unapproved</option>
                            <option value="deleted" {{ $party->status == 'deleted' ? 'selected' : '' }}>Deleted
                            </option>
                            <option value="lock" {{ $party->status == 'lock' ? 'selected' : '' }}>Lock
                            </option>
                            <option value="suspended" {{ $party->status == 'suspended' ? 'selected' : '' }}>
                                Suspended</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Address -->
                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <label for="address" class="required">Address</label>
                        <textarea id="address" name="address" class="form-control mt-3" rows="3" required>{{ $party->address }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <button type="submit" id="update" class=" update btn btn-primary mt-4">
                            <span id="spinner-update" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="fas fa-wrench"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.update').on('click', function(e) {
            e.preventDefault();
            $('#spinner-update').removeClass('d-none');
            $(this).prop('disabled', true);

            // Now create FormData with the updated form (after removal)
            let formData = new FormData($('#partyForm')[0]);
            let url = $('#partyForm').attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#spinner-update').addClass('d-none');
                    $('.update').prop('disabled', false);
                    $('#exampleModal').modal('hide');
                    $('#party-data').DataTable().ajax.reload(null, false);
                    console.log(response);
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    $('#spinner-update').addClass('d-none');
                    $('.update').prop('disabled', false);
                    var errors = xhr.responseJSON.errors;
                    // Iterate through each error and display it
                    $.each(errors, function(key, value) {
                        toastr.error(value); // Displaying each error message
                    });
                }
            });

        });
    });
</script>
