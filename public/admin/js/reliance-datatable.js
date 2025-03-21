

// Function to initialize DataTable with filtering
function initializeDataTable(tableId, columns, ajaxUrl, filters = {}) {
    // Initialize DataTable
    var table = $(`#${tableId}`).DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: {
            url: ajaxUrl,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                // Add filter data dynamically
                Object.keys(filters).forEach(filterKey => {
                    const filterId = filters[filterKey];
                    d[filterKey] = $(`#${filterId}`).val(); // Get the filter value
                });
            }
        },
        order: [], // Default sorting (can be overridden)
        columnDefs: [{
            targets: [5], // Disable sorting on Action column (adjust as needed)
            orderable: false
        },
        {
            targets: '_all', // Enable sorting & searching for all columns
            searchable: true,
            orderable: true
        }
        ],
        columns: columns, // Use the columns array passed to the function
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "All"]
        ],
        pageLength: 10,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'colvis', // Show/hide columns
                text: '<i class="fas fa-columns"></i>',
            },
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i>',
                title: tableId.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                title: tableId.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                title: tableId.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                exportOptions: {
                    columns: ':visible' // Ensure only visible columns are exported
                },
                orientation: 'landscape', // Use landscape for more space
                pageSize: 'A4', // Use A3 for more width (or 'legal')
                customize: function (doc) {
                    doc.pageOrientation = 'landscape'; // Set PDF to landscape mode
                    doc.pageMargins = [0, 0, 0, 0]; // Remove margins
                    doc.defaultStyle.fontSize = 8; // Reduce font size
                    doc.styles.tableHeader.fontSize = 8; // Adjust header font size
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split(''); // Dynamic column width
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                title: tableId.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    }
                }
            },
        ],
        scrollX: true, // Enable horizontal scrolling
        language: {
            search: '<div class="input-group">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-search"></i>' +
                '</span>' +
                '_INPUT_' +
                '</div>'
        }
    });

    // Add change event listeners for filters
    Object.keys(filters).forEach(filterKey => {
        const filterId = filters[filterKey];
        $(`#${filterId}`).on('change', function () {
            $(`#${tableId}`).DataTable().ajax.reload(null, false); // Reload table without resetting paging
        });
    });

    return table;
}





