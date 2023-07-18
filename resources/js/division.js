var table;

const initTable = () => {
    let createRoute = app_url + '/master/division/create';
    table = $('#table-division').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: {
            url: app_url + '/master/division/ajax',
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: i18n.global.create,
                className: 'btn bg-primary btn-sm btn-create-unit',
                action: function (e, dt, node, config) {
                    openGlobalModal(createRoute, i18n.global.create + ' ' + i18n.global.unit, {footer: true, target: `target-division-action`})
                }
            }
        ],
        columns: [
            {data: 'key',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                width: '5%',
                className: 'text-center'
            },
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', className: 'text-center', orderable: false, width: '10%'},
        ],
        order: [[1, 'desc']],
    });
}

const saveData = () => {
    let form = $('#form-units').serialize();

    $.ajax({
        type: "POST",
        url: app_url + '/master/division',
        data: form,
        beforeSend: function () {
            findFormElement($('#form-units'));
            toggleLoading(true);
        },
        success: function (res) {
            toggleLoading(false);
            handleSuccess(res.message);
            closeGlobalModal();
            table.ajax.reload();
        },
        error: function (err) {
            toggleLoading(false);
            handleError(err, 'form-units')
        }
    })
}

const updateData = (id) => {
    let form = $('#form-units').serialize();

    $.ajax({
        type: "PUT",
        url: app_url + '/master/division/' + id,
        data: form,
        beforeSend: function () {
            findFormElement($('#form-units'));
            toggleLoading(true);
        },
        success: function (res) {
            toggleLoading(false);
            handleSuccess(res.message);
            closeGlobalModal();
            table.ajax.reload();
        },
        error: function (err) {
            toggleLoading(false);
            handleError(err, 'form-units')
        }
    })
}

const confirmDelete = (id) => {
    Confirm.show(
        i18n.global.delete_item,
        i18n.global.delete_item_confirmation,
        i18n.global.yes,
        i18n.global.no,
        () => {
            deleteItem(id);
        },
    )
}

const deleteItem = (id) => [
    $.ajax({
        type: "DELETE",
        url: app_url + '/master/division/' + id,
        beforeSend: function () {
            toggleLoading(true);
        },
        success: function (res) {
            toggleLoading(false);
            handleSuccess(res.message);
            table.ajax.reload();
        },
        error: function (err) {
            toggleLoading(false);
            handleError(err, 'form-units')
        }
    })
]

window.initTable = initTable
window.table = table
window.saveData = saveData
window.updateData = updateData
window.confirmDelete = confirmDelete

initTable();
