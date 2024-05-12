console.log("userManagement.js loaded");

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
        data: "roles.0.name",
        name: "roles.0.name",
    },
    {
        data: "email",
        name: "email",
    },
    {
        data: "phone",
        name: "phone",
    },
    {
        data: "date_of_birth",
        name: "date_of_birth",
    },
    {
        data: "place_of_birth",
        name: "place_of_birth",
    },
    {
        data: "created_at",
        name: "created_at",
        render: function (data) {
            return convertCratedAt(data);
        },
    },
];
