console.log("paymentMethod.js loaded");

$(document).ready(function () {
    $(document).on("click", "#createModalButton", function () {
        changeTextAreaToCKEditor("description");
        clearingInstanceCKEditor();
    });
});

tableName = "#paymentMethodTable";
columnsDatatable = [
    {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
        width: "5%",
    },
    {
        data: "name",
        name: "name",
    },
    {
        data: "payment_method.name",
        name: "payment_method.name",
    },
    {
        data: "logo",
        name: "logo",
        render: function (data) {
            var documents = "";
            if (data.length > 0) {
                data.forEach(function (document) {
                    documents +=
                        '<img src="' +
                        document.original_url +
                        '" width="100" height="100" />';
                });
            }
            return documents;
        },
    },
];
