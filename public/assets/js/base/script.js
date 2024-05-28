console.log("base.js loaded");

// init global variable (can be accessed from other js files)

// if document is ready
$(document).ready(function () {
    $(document).on("click", ".edit-modal", function () {
        showEditModal($(this).data("id"), currentUrl, "#editModal");
    });
    $(".currency").each(function () {
        var value = $(this).text();
        $(this).text(toRupiahCurrency(value));
    });
});

// some functions
function convertCratedAt(createdAt) {
    return new Date(createdAt).toLocaleDateString();
}

// convert to rupiah
function toRupiahCurrency(value) {
    var parts = value.toString().split(".");
    var beforeDecimal = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    var afterDecimal = parts[1] ? parts[1] : "00";
    if (afterDecimal.length == 1) {
        afterDecimal += "0";
    }
    return "Rp " + beforeDecimal + "," + afterDecimal;
}

function showEditModal(id, url, modalId) {
    $.ajax({
        url: url + "/" + id + "/edit",
        type: "GET",
        success: function (response) {
            for (const [key, value] of Object.entries(response)) {
                $(`#${key}`).val(value);
            }
            editIdAttribute = id;
            $(modalId).modal("show");
        },
    });
}

// Function to handle form submission for edit
function handleEditFormSubmit(route) {
    var formData = $("#editForm").serialize();
    $.ajax({
        type: "PATCH",
        url: route.replace("defaultId", editIdAttribute),
        data: formData,
        success: function (response) {
            console.log(response);
            $("#editModal").modal("hide");
            toastr.success(response.message);
            reinitTable();
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            console.log(err.message);
        },
    });
}

function showAlert(message, type) {
    if (type == "error") {
        toastr.error(message);
    }
    if (type == "success") {
        toastr.success(message);
    }
}

function deleteData(id, url) {
    if (confirm("Are you sure?")) {
        $.ajax({
            url: url + "/" + id,
            type: "DELETE",
            success: function (response) {
                reinitTable();
            },
        });
    }
}
