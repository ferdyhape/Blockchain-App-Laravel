console.log("walletTransactionManagement.js loaded");

tableName = "#walletTransactionTable";
columnsDatatable = [
    {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
        width: "5%",
    },
    {
        data: "code",
        name: "code",
    },
    {
        data: "amount",
        name: "amount",
        render: function (data) {
            return toRupiahCurrency(data);
        },
    },
    {
        data: "status",
        name: "status",
        render: function (data) {
            if (data == "pending") {
                return '<div class="btn btn-sm btn-warning">Pending</div>';
            } else if (data == "accepted") {
                return '<div class="btn btn-sm btn-success">Accepted</div>';
            } else {
                return '<div class="btn btn-sm btn-danger">Rejected</div>';
            }
        },
    },
    {
        data: null,
        name: "walletable.name",
        render: function (data, type, row) {
            if (row.walletable_type === "App\\Models\\Campaign") {
                return row.walletable.project
                    ? row.walletable.project.title
                    : "-";
            } else if (row.walletable_type === "App\\Models\\User") {
                return row.walletable.name;
            } else {
                return "-";
            }
        },
    },
    {
        data: "payment_proof",
        name: "payment_proof",
        render: function (data) {
            if (data == null) {
                return '<div class="btn btn-sm btn-danger">Proof Not Uploaded</div>';
            }
            return (
                '<a href="' +
                baseUrl +
                "/" +
                data +
                '" target="_blank">Lihat Bukti Pembayaran</a>'
            );
        },
    },
    {
        data: "type",
        name: "type",
        render: function (data) {
            if (data == "topup") {
                return "Top Up";
            } else if (data == "withdraw") {
                return "Withdraw";
            } else if (data == "withdraw_campaign") {
                return "Withdraw Campaign";
            } else if (data == "donation") {
                return "Donation";
            } else if (data == "profit_sharing_payment") {
                return "Profit Sharing & Refund";
            } else {
                return "-";
            }
        },
    },
    {
        data: "created_at",
        name: "created_at",
        render: function (data) {
            return moment(data).format("DD/MM/YYYY HH:mm:ss");
        },
    },
];
