console.log("base.js loaded");

// init global variable (can be accessed from other js files)
let customEditModalCheck = false;
let ckeditorInstances = {};

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

function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2,
    }).format(number);
}

// CKEditor
function clearingInstanceCKEditor() {
    for (const instance in ckeditorInstances) {
        if (ckeditorInstances[instance]) {
            ckeditorInstances[instance].destroy();
            delete ckeditorInstances[instance];
        }
    }
}

function changeTextAreaToCKEditor(id, data = {}) {
    if (Array.isArray(id)) {
        id.forEach((elementId) => {
            ClassicEditor.create(document.querySelector(`#${elementId}`), {
                removePlugins: ["Resize"],
            })
                .then((editor) => {
                    ckeditorInstances[elementId] = editor;
                    if (data[elementId]) {
                        editor.setData(data[elementId]);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        });
    } else {
        ClassicEditor.create(document.querySelector(`#${id}`), {
            removePlugins: ["Resize"],
        })
            .then((editor) => {
                ckeditorInstances[id] = editor;
                if (data[id]) {
                    editor.setData(data[id]);
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }
}

// CRUD Modal
function showEditModal(id, url, modalId) {
    clearingInstanceCKEditor();

    $.ajax({
        url: url + "/" + id + "/edit",
        type: "GET",
        success: function (response) {
            for (const [key, value] of Object.entries(response)) {
                $(`#editForm #${key}`).val(value);
            }

            if (customEditModalCheck) {
                customEditModalFunc(response);
            }

            editIdAttribute = id;
            $(modalId).modal("show");
        },
    });
}

function handleEditFormSubmit(route) {
    var formData = $("#editForm").serialize();
    for (const instance in ckeditorInstances) {
        if (ckeditorInstances[instance]) {
            formData +=
                "&" + instance + "=" + ckeditorInstances[instance].getData();
        }
    }

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
            // var err = JSON.parse(xhr.responseText);
            // toastr.error(err.message);
            var err = JSON.parse(xhr.responseText);
            // toastr.error(err.message); // Menampilkan pesan umum

            // Loop melalui setiap error dan tampilkan dalam toastr
            for (var key in err.errors) {
                if (err.errors.hasOwnProperty(key)) {
                    err.errors[key].forEach(function (message) {
                        toastr.error(message);
                    });
                }
            }
        },
    });
}

function handleEditFormSubmitUseFile(route) {
    var formElement = document.getElementById("editForm");
    var formData = new FormData(formElement);
    formData.append("_method", "PATCH");

    for (const instance in ckeditorInstances) {
        if (ckeditorInstances[instance]) {
            formData.append(instance, ckeditorInstances[instance].getData());
        }
    }

    $.ajax({
        type: "POST",
        url: route.replace("defaultId", editIdAttribute),
        processData: false, // Important!
        contentType: false, // Important!
        data: formData,
        success: function (response) {
            console.log(response);
            $("#editModal").modal("hide");
            toastr.success(response.message);
            reinitTable();
        },
        error: function (xhr, status, error) {
            // var err = JSON.parse(xhr.responseText);
            // toastr.error(err.message);

            var err = JSON.parse(xhr.responseText);
            // toastr.error(err.message); // Menampilkan pesan umum

            // Loop melalui setiap error dan tampilkan dalam toastr
            for (var key in err.errors) {
                if (err.errors.hasOwnProperty(key)) {
                    err.errors[key].forEach(function (message) {
                        toastr.error(message);
                    });
                }
            }
        },
    });
}

function handleStoreFormSubmitUseFile(route) {
    var formElement = document.getElementById("storeForm");
    var formData = new FormData(formElement);

    for (const instance in ckeditorInstances) {
        if (ckeditorInstances[instance]) {
            formData.append(instance, ckeditorInstances[instance].getData());
        }
    }

    $.ajax({
        type: "POST",
        url: route,
        data: formData,
        processData: false, // Important!
        contentType: false, // Important!
        success: function (response) {
            console.log(response);
            $("#createModal").modal("hide");
            $("#storeForm")[0].reset();
            toastr.success(response.message);
            reinitTable();
        },
        error: function (xhr, status, error) {
            console.log([
                xhr,
                status,
                error,
                xhr.responseText,
                JSON.parse(xhr.responseText),
            ]);

            var err = JSON.parse(xhr.responseText);
            // toastr.error(err.message); // Menampilkan pesan umum

            // Loop melalui setiap error dan tampilkan dalam toastr
            for (var key in err.errors) {
                if (err.errors.hasOwnProperty(key)) {
                    err.errors[key].forEach(function (message) {
                        toastr.error(message);
                    });
                }
            }
        },
    });
}

function handleStoreFormSubmit(route) {
    var formData = $("#storeForm").serialize();
    for (const instance in ckeditorInstances) {
        if (ckeditorInstances[instance]) {
            console.log(ckeditorInstances[instance].getData());
            formData +=
                "&" + instance + "=" + ckeditorInstances[instance].getData();
        }
    }

    // remove instance of ckeditor
    $.ajax({
        type: "POST",
        url: route,
        data: formData,
        success: function (response) {
            console.log(response);
            $("#createModal").modal("hide");
            $("#storeForm")[0].reset();
            toastr.success(response.message);
            reinitTable();
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);

            // Menampilkan pesan umum kesalahan
            // toastr.error(err.message);

            // Loop melalui setiap error dan tampilkan dalam toastr
            for (var key in err.errors) {
                if (err.errors.hasOwnProperty(key)) {
                    err.errors[key].forEach(function (message) {
                        toastr.error(message);
                    });
                }
            }
        },
    });
}

function deleteData(url, csrf_token) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: csrf_token,
                },
                success: function (response) {
                    toastr.success(response.message);
                    reinitTable();
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    toastr.error(err.message);
                },
            });
        }
    });
}

// Alert
function showAlert(message, type) {
    if (type == "error") {
        toastr.error(message);
    }
    if (type == "success") {
        toastr.success(message);
    }
}
