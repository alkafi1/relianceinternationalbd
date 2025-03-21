
function initializeDataTable(tableId, ajaxUrl, columns) {
    var table = $(`#${tableId}`).DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: {
            url: ajaxUrl,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        order: [[4, "desc"]], // Default sorting by Created At (descending)
        columnDefs: [
            { targets: [5], orderable: false }, // Disable sorting on Action column
            { targets: '_all', searchable: true, orderable: true } // Enable sorting & searching for all columns
        ],
        columns: columns, // Use the columns array passed to the function
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "All"]
        ],
        pageLength: 10,
        dom:
            "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'colvis', // Show/hide columns
                text: '<i class="fas fa-columns"></i>',
                columns: ':not(:first-child)' // Exclude first column from hiding
            },
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i>',
                title: 'Data Export',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                title: tableId + ' Export',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                title: tableId + ' Export',
                exportOptions: { modifier: { search: 'applied', order: 'applied' } },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 12;
                    doc.styles.title.fontSize = 14;
                }
            }
        ],
        // paging: false,
        scrollCollapse: true,
        scrollY: '200px',
        language: {
            search: '<div class="input-group">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-search"></i>' +
                '</span>' +
                '_INPUT_' +
                '</div>'
        }
    });
}


function initializeWithColumnDataTable(tableId, columns) {
    var table = $(`#${tableId}`).DataTable({
        processing: true,
        responsive: false,
        searching: true,
        order: [[0, 'desc']], // Default sorting by the first column in descending order
        columns: columns, // Use the columns array passed to the function
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "All"]
        ],
        pageLength: 5, // Default number of rows per page
        dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'colvis', // Column visibility button
                columns: ':not(:first-child)' // Exclude the first column
            },
            {
                extend: 'copy', // Copy to clipboard button
                text: '<i class="fas fa-copy"></i> Copy', // Add icon and text
                title: 'Data Export', // Optional: Set a title for the copied data
                exportOptions: {
                    columns: ':visible' // Copy only visible columns
                }
            },
            {
                extend: 'excel', // Excel export button
                text: '<i class="fas fa-file-excel"></i> Excel', // Add icon and text
                title: 'Data Export', // Optional: Set a title for the Excel file
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                }
            },
            {
                extend: 'pdf', // PDF export button
                text: '<i class="fas fa-file-pdf"></i> PDF', // Add icon and text
                title: 'Data Export', // Optional: Set a title for the PDF file
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                },
                customize: function (doc) {
                    // Customize the PDF document (optional)
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 12;
                    doc.styles.title.fontSize = 14;
                }
            }
        ],
        language: {
            search: '<div class="input-group">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-search"></i>' +
                '</span>' +
                '_INPUT_' +
                '</div>'
        },
        columnDefs: [
            {
                targets: '_all', // Apply to all columns
                searchable: true, // Allow searching
                orderable: true, // Allow ordering
            },
            {
                targets: -1, // Target the last column (actions column)
                className: '', // Optional: Add custom class
                orderable: false, // Disable ordering for the actions column
            }
        ],
    });
}