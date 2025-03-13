<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="role-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">{{ __('Serial') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">{{ __('Role Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Permissions') }}
                </th>
                <th class="text-end min-w-140px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                    {{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>


@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#role-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "",
                    type: 'GET',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        searchable: true,
                        data: null,
                        render: function(data, type, row, meta) {
                            // Use meta.row + 1 to get the actual row number starting from 1
                            return meta.row + 1;
                        },
                        name: 'serial_number'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            if (!data) return ''; // Return early if data is null or undefined

                            // Capitalize the first letter of role
                            let roleText = data.charAt(0).toUpperCase() + data.slice(1);
                            return `${roleText}`;
                            // Return formatted badge span
                            return `<span class="badge badge-primary" style="display: inline-block; text-align: center;">${roleText}</span>`;
                        }
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'permissions',
                        name: 'permissions',
                        render: function(data, type, row) {
                            if (!data) return ''; // Return early if data is null or undefined

                            // Split the comma-separated string into an array
                            let permissionsArray = data.split(',');

                            // Array of possible Bootstrap badge classes
                            let badgeClasses = ['badge-primary', 'badge-success', 'badge-danger',
                                'badge-warning', 'badge-info', 'badge-dark'
                            ];

                            // Initialize a counter to cycle through badge classes
                            let badgeIndex = 0;

                            // Create a comma-separated list of permission badges with cycling colors
                            let permissionsHtml = permissionsArray.map(permission => {
                                // Trim, replace hyphens with spaces, and capitalize the first letter of each word in permission
                                let permissionText = permission.trim().replace(/-/g, ' ')
                                    .replace(/\b\w/g, char => char.toUpperCase());
                                // Get the next badge class in the cycle
                                let badgeClass = badgeClasses[badgeIndex % badgeClasses
                                    .length];
                                // Increment the badge index
                                badgeIndex++;
                                // Return formatted badge span with cycling color
                                return `<span class="badge ${badgeClass} mt-2 me-2">${permissionText}</span>`;
                            }).join('');

                            return permissionsHtml;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Determine if the role is admin
                            let isAdmin = (row.name === 'super_admin');

                            // Render edit button
                            let editButtonHtml = `<a href="javascript:void(0)" class="edit text-primary me-2" data-id="${row.id}">
                                <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                            </a>`;

                            // Render delete button if not admin
                            let deleteButtonHtml = isAdmin ? '' : `<a href="javascript:void(0)" class="text-danger delete" data-id="${row.id}">
                                    <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                                </a>`;

                            // Combine buttons and return
                            return editButtonHtml + deleteButtonHtml;
                        }
                    }

                ],
                lengthMenu: [
                    [5, 30, 50, -1],
                    [5, 30, 50, "All"]
                ], // Add 'All' option
                pageLength: 5, // Set default page length
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                    // Page length, buttons, and search
                    "<'row'<'col-sm-12'tr>>" + // Table rows
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Information and pagination
                buttons: [{
                        extend: 'colvis',
                        columns: ':not(:first-child)' // Exclude first column (serial)
                    },
                    // 'excel', 'print', 'copy'
                ],
                language: {
                    search: '<div class="input-group">' +
                        '<span class="input-group-text">' +
                        '<i class="fas fa-search"></i>' +
                        '</span>' +
                        '_INPUT_' +
                        '</div>'
                },
                columnDefs: [{
                        targets: '_all',
                        searchable: true
                    },
                    {
                        targets: -1, // Target the last column (actions column)
                        className: 'text-center', // Optional: Center align the content in this column
                    },
                    {
                        targets: '_all',
                        searchable: true,
                        orderable: true
                    }
                ],
                // responsive: true,

            });

            $(document).on('click', '.edit', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).attr('data-id');
                var url = "{{ route('role.edit') }}";
                $.ajax({
                    url: url,
                    type: 'POST', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    }, // You can send additional data if needed
                    success: function(response) {
                        console.log(response);
                        var role = response.perm;
                        $('#add-header').text('Update Role');
                        $('#name').val(role.name);
                        // Uncheck all checkboxes initially
                        $('input[type="checkbox"][name="permissions[]"]').prop('checked',
                            false);

                        // Check checkboxes based on role.permissions array
                        role.permissions.forEach(permission => {
                            let permissionId = permission.id;

                            // Check the checkbox corresponding to the permission ID
                            $(`input[type="checkbox"][name="permissions[]"][value="${permissionId}"]`)
                                .prop('checked', true);
                        });
                        $('#role-update').removeClass('d-none');
                        $('#role-update').attr('data-id', role.id);
                        $('#role-submit').addClass('d-none');
                        $('#page-refresh').removeClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            });
            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).attr('data-id');
                var url = "{{ route('role.destroy') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will delete this role!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status = null, url);
                    }
                });
            });

            function sendAjaxReq(id, status, url) {
                var requestData = {
                    id: id,
                    // Optionally include status if it's provided
                };

                // Check if status is defined and not null
                if (typeof status !== 'undefined' && status !== null) {
                    requestData.status = status;
                }
                $.ajax({
                    url: url,
                    type: 'POST', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: requestData, // You can send additional data if needed
                    success: function(response) {

                        $('#role-data').DataTable().ajax.reload(null, false);
                        // Swal.fire('Success!', response.success,
                        //     'success');
                        toastr.success(response.success);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }
        });
    </script>
@endpush
