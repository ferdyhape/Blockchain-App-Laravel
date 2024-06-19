console.log("projectManagement.js loaded");

tableName = "#projectManagementTable";

columnsDatatable = [
    {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
        width: "5%",
    },
    {
        data: "user.name",
        name: "user.name",
    },
    {
        data: "title",
        name: "title",
    },
    {
        data: "category.name",
        name: "category.name",
    },
    {
        data: "category_project_submission_status.name",
        name: "category_project_submission_status.name",
    },
];
