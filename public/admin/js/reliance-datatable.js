function initializeDataTable(tableId, columns, ajaxUrl, filters = {}, autoReload = false) {
    console.log(filters);

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
                Object.keys(filters).forEach(filterKey => {
                    const filterId = filters[filterKey];
                    d[filterKey] = $(`#${filterId}`).val();
                });
            }
        },
        order: [],
        columnDefs: [
            {
                targets: [5],
                orderable: false
            },
            {
                targets: '_all',
                searchable: true,
                orderable: true
            }
        ],
        columns: columns,
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
                extend: 'colvis',
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
                    columns: ':visible'
                },
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function (doc) {
                    doc.pageOrientation = 'landscape';
                    doc.pageMargins = [0, 0, 0, 0];
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 8;
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
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
            {
                text: '<i class="fas fa-sync-alt"></i>',
                action: function (e, dt, node, config) {
                    dt.ajax.reload(null, false);
                }
            },
        ],
        scrollX: true,
        language: {
            search: '<div class="input-group">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-search"></i>' +
                '</span>' +
                '_INPUT_' +
                '</div>'
        }
    });

    // ✅ Auto reload on filter change if enabled
    if (autoReload) {
        Object.values(filters).forEach(filterId => {
            $(`#${filterId}`).on('change', function () {
                table.ajax.reload();
            });
        });
    }

    return table;
}
