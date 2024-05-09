console.log("dashboard.js loaded");

tableName = "#transactionTable";
isDatatableWithoutActionColumn = true;
columns = [
    {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
        width: "5%",
    },
    {
        data: "transactionCode",
        name: "transactionCode",
    },
    {
        data: "from",
        name: "from",
    },
    {
        data: "fromId",
        name: "fromId",
    },
    {
        data: "to",
        name: "to",
    },
    {
        data: "toId",
        name: "toId",
    },
    {
        data: "orderType",
        name: "orderType",
    },
    {
        data: "paymentStatus",
        name: "paymentStatus",
    },
    {
        data: "createdAt",
        name: "createdAt",
    },
];
