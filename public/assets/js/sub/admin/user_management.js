console.log("company_management.js loaded");

tableName = "#userManagementTable";
columns = [
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
        data: "role_name",
        name: "role_name",
    },
    {
        data: "email",
        name: "email",
    },
    {
        data: "created_at",
        name: "created_at",
        render: function (data) {
            return convertCratedAt(data);
        },
    },
];
