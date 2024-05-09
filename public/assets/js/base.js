console.log("base.js loaded");

// init global variable (can be accessed from other js files)

// if document is ready
$(document).ready(function () {
    $(document).on("click", ".edit-modal", function () {
        showEditModal($(this).data("id"), currentUrl, "#editModal");
    });
});

// some functions
function convertCratedAt(createdAt) {
    return new Date(createdAt).toLocaleDateString();
}

function showEditModal(id, url, modalId) {
    $.ajax({
        url: url + "/" + id + "/edit",
        type: "GET",
        success: function (response) {
            for (const [key, value] of Object.entries(response)) {
                $(`#${key}`).val(value);
            }
            $(modalId).modal("show");
        },
    });
}
