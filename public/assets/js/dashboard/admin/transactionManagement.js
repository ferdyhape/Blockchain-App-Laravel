console.log("transactionManagement.js loaded");

tableName = "#transactionManagementTable";
console.log(baseUrl);
columnsDatatable = [
    {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
        width: "5%",
    },
    {
        data: "transaction_code",
        name: "transaction_code",
    },
    {
        data: "campaign_name",
        name: "campaign_name",
    },
    {
        data: "from_to_user_name",
        name: "from_to_user_name",
    },
    {
        data: "order_type",
        name: "order_type",
        render: function (data) {
            if (data == "buy") {
                return '<div class="btn btn-sm text-center btn-success">Buy</div>';
            } else if (data == "sell") {
                return '<div class="btn btn-sm text-center btn-danger">Sell</div>';
            }
        },
    },
    // {
    //     data: "payment_status",
    //     name: "payment_status",
    // },
    {
        data: "status",
        name: "status",
        render: function (data) {
            if (data == "pending") {
                return '<div class="btn btn-sm btn-warning">Pending</div>';
            } else if (data == "success") {
                return '<div class="btn btn-sm btn-success">Success</div>';
            } else {
                return '<div class="btn btn-sm btn-danger">Failed</div>';
            }
        },
    },
    // {
    //     data: "payment_proof",
    //     name: "payment_proof",
    //     render: function (data) {
    //         if (data == "null") {
    //             return '<div class="btn btn-sm btn-danger">No Proof</div>';
    //         }

    //         return (
    //             '<a href="' +
    //             baseUrl +
    //             "/" +
    //             data +
    //             '" target="_blank">Lihat Bukti Pembayaran</a>'
    //         );
    //     },
    // },
    {
        data: "total_price",
        name: "total_price",
        render: function (data) {
            return toRupiahCurrency(data);
        },
    },
];
