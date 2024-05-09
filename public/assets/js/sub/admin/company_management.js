console.log("company_management.js loaded");

tableName = "#companyManagementTable";
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
        width: "10%",
    },
    {
        data: "address",
        name: "address",
        width: "20%",
        render: function (data) {
            return data.length > 50 ? data.substr(0, 50) + "..." : data;
        },
    },
    {
        data: "logo",
        name: "logo",
        orderable: false,
        render: function (data) {
            return (
                "<img src='" +
                data +
                "' alt='Logo' style='max-width: 100px; max-height: 100px;' />"
            );
        },
    },
    {
        data: "legal_document",
        name: "legal_document",
        render: function (data) {
            return (
                "<a href='" +
                data +
                "' target='_blank' class='badge bg-info text-center text-decoration-none'>View Here</a>"
            );
        },
    },
    {
        data: "owner.name",
        name: "owner.name",
        orderable: false,
    },
    {
        data: "accept_by_id",
        name: "accept_by_id",
        render: function (data) {
            var status = data ? "Accepted" : "Pending";
            return (
                "<span class='badge bg-" +
                (data ? "success" : "warning") +
                "'>" +
                status +
                "</span>"
            );
        },
    },
];
