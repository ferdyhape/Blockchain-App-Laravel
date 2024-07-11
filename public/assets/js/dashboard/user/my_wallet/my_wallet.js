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
        data: "description",
        name: "description",
        render: function (data) {
            // Check if data is null or undefined
            if (data) {
                // return data.length > 50 ? data.substr(0, 10) + "..." : data;
                // append to div and add eye icon, and execute swalShowDescription(data) function
                return (
                    "<div onclick='swalShowDescription(`" +
                    data +
                    "`)' class='cursor-pointer'>" +
                    (data.length > 50 ? data.substr(0, 20) + "..." : data) +
                    "</div>"
                );
            } else {
                return "";
            }
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
            if (data == "-") {
                return "-";
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
