console.log("my_wallet.js loaded");

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
];
