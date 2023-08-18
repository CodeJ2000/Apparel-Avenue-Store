//Reusable function for datatable
function initializedDataTable(tableId, ajaxUrl, columnsConfig) {
    $(tableId).DataTable({
        serverSide: true,
        ajax: ajaxUrl,
        processData: false,
        contentType: false,
        columns: columnsConfig,
    });
}

// Reusable function for adding data
function add(openModal, form, addUrl, btn) {
    $(openModal).click(function () {
        $(form)[0].reset();
        $("#add-btn").html(btn);
    });

    $(form).submit(function (e) {
        e.preventDefault();
        $("#add-btn").html("Adding...");
        $(".error-msg").html("");
        let formData = new FormData(this);
        $.ajax({
            url: addUrl,
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#add-btn").html(btn);
                $("#add-form").modal("hide");
                Swal.fire({
                    title: "Successful!",
                    text: response.message,
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                $(".error-msg").html("");
            },
            error: function (xhr) {
                $(".error-msg").html("");
                $("#add-btn").html(btn);

                // console.log(xhr.responseJSON.errors);
                let errors = xhr.responseJSON.errors;
                // console.log(errors);
                $.each(errors, function (field, error) {
                    $("." + field + "-error").html(error);
                });
            },
        });
    });
}

// reusable function for updating the data
function edit(form, updateUrl, editUrl, table, btn, csrf_token) {
    let id;
    $(table).on("click", ".edit-button", function () {
        id = $(this).data("id");
        // Make an AJAX request to get the product data
        console.log(id);
        $("#edit-form").modal("show");

        $.ajax({
            url: editUrl.replace(":id", id),
            method: "GET",
            dataType: "json",
            data: {
                id: id,
                _token: csrf_token,
            },
            success: function (response) {
                $.each(response, function (index, value) {
                    $("#" + index).val(value);
                    // console.log(index);
                    if (index != "") {
                        console.log("Category exist");
                        $("." + index).val(value);
                    }
                });
                console.log(response);

                console.log(response);
            },
            error: function () {
                console.log("error edit");
            },
        });
    });

    $(form).submit(function (e) {
        e.preventDefault();
        $("#update-btn").html("Updating...");
        let fd = new FormData(this);
        $.ajax({
            url: updateUrl.replace(":id", id),
            method: "POST",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#edit-form").modal("hide");
                $("#update-btn").html(btn);
                Swal.fire({
                    title: "Successful!",
                    text: response.message,
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                $(".error-msg").html("");

                $(form)[0].reset();
            },
            error: function (xhr) {
                $(".error-msg").html("");
                $("#update-btn").html(btn);
                // console.log(xhr.responseJSON.errors);
                let errors = xhr.responseJSON.errors;
                // console.log(errors);
                $.each(errors, function (field, error) {
                    $("." + field + "-error").html(error);
                });
            },
        });
    });
}

// reusable function for deleting data
function deleteData(table, deleteUrl) {
    $(table).on("click", ".delete-button", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
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
                    url: deleteUrl.replace(":id", id),
                    method: "POST",
                    cache: false,
                    proccessData: false,
                    contentType: false,
                    success: function (response) {
                        console.log("deleted successfully.");
                        Swal.fire(
                            "Deleted!",
                            "The " +
                                response.data +
                                " has successfuly deleted!",
                            "success"
                        );
                        $(table).DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log("error delete");
                    },
                });
            }
        });
    });
}
