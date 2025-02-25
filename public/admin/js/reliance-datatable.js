console.log('reliance-datatable');
function initializeDataTable(tableId, ajaxUrl, columns) {
    $(document).ready(function() {
        var table = $(`#${tableId}`).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrl,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: columns, // Use the columns array passed to the function
            lengthMenu: [
                [5, 10, 30, 50, -1],
                [5, 10, 30, 50, "All"]
            ],
            pageLength: 5,
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
                    customize: function(doc) {
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
    });
}