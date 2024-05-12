console.log("datatableInitializer.js loaded");

// apabila document sudah siap
$(document).ready(function () {
    if (typeof initDatatable === "function") {
        initDatatable();
    }
});

function initDatatable() {
    if (isDatatableWithoutActionColumn) {
        buildDatatable(tableName, currentUrl, columns, false);
    } else {
        buildDatatable(tableName, currentUrl, columns);
    }
}

function reinitTable() {
    $(tableName).DataTable().destroy();
    initDatatable();
}

function buildDatatable(
    tableName,
    url,
    columns,
    actionColumn = true,
    data = null,
    method = "GET"
) {
    let datatableColumns = columns;

    if (actionColumn) {
        let action = actionColumnDatatable();
        datatableColumns.push(action);
    }

    if (data) {
        datatable = $(tableName).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: method,
                data: data,
            },
            columns: datatableColumns,
        });
    } else {
        datatable = $(tableName).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: method,
            },
            columns: datatableColumns,
        });
    }

    return datatable;
}

function actionColumnDatatable() {
    let actionColumn = {
        data: "action",
        name: "action",
        orderable: false,
        searchable: false,
        width: "10%",
    };

    return actionColumn;
}
